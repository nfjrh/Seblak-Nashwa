<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaturan;
use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    public function index()
    {
        $pengaturan = Pengaturan::firstOrCreate([], [
            'nama_kedai' => 'Seblak Nashwa',
            'tagline' => 'Pedasnya pas, nagihnya jelas.',
            'kedai_buka' => true,
            'jeda_pesanan' => false,
            'biaya_layanan' => 2000,
            'ongkir_tetap' => 8000,
            'qris_aktif' => true,
            'transfer_aktif' => true,
            'cod_aktif' => true,
        ]);

        return view('admin.pengaturan', compact('pengaturan'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_kedai' => 'required|string|max:255',
            'biaya_layanan' => 'required|numeric|min:0',
            'ongkir_tetap' => 'required|numeric|min:0',
        ]);

        $pengaturan = Pengaturan::first();
        
        $pengaturan->update([
            'nama_kedai' => $request->nama_kedai,
            'tagline' => $request->tagline,
            'nomor_whatsapp' => $request->nomor_whatsapp,
            'email_kedai' => $request->email_kedai,
            'alamat_kedai' => $request->alamat_kedai,
            'kedai_buka' => $request->has('kedai_buka'),
            'jeda_pesanan' => $request->has('jeda_pesanan'),
            'biaya_layanan' => $request->biaya_layanan,
            'ongkir_tetap' => $request->ongkir_tetap,
            'qris_aktif' => $request->has('qris_aktif'),
            'transfer_aktif' => $request->has('transfer_aktif'),
            'cod_aktif' => $request->has('cod_aktif'),
        ]);

        return redirect()->route('admin.pengaturan')->with('success', 'Seluruh pengaturan kedai berhasil diperbarui!');
    }
}