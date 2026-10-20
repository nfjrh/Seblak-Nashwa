<style>
    /* Gaya bersama: keranjang, checkout, riwayat, detail pesanan */
    .ps-sec { padding: 44px 0 80px; }
    .ps-eyebrow { display: inline-block; font-size: 11px; font-weight: 800; letter-spacing: .1em; color: var(--brand); text-transform: uppercase; margin-bottom: 10px; }
    .ps-h1 { font-size: 34px; line-height: 1.15; font-weight: 800; letter-spacing: -.01em; }
    .ps-sub-t { margin-top: 8px; color: var(--muted); font-size: 15px; }
    .ps-top { display: flex; justify-content: space-between; align-items: flex-end; gap: 16px; flex-wrap: wrap; margin-bottom: 28px; }
    .ps-grid { display: grid; grid-template-columns: 1.6fr 1fr; gap: 24px; align-items: start; }
    .ps-card { background: #fff; border: 1px solid var(--line); border-radius: 18px; padding: 24px; }
    .ps-card + .ps-card { margin-top: 20px; }
    .ps-card h2 { font-size: 16px; font-weight: 800; margin-bottom: 16px; }
    .ps-sum { position: sticky; top: 96px; }
    .ps-line { display: flex; justify-content: space-between; gap: 12px; font-size: 14px; padding: 6px 0; color: var(--muted); }
    .ps-line.total { border-top: 1px solid var(--line); margin-top: 10px; padding-top: 14px; color: var(--ink); font-weight: 800; font-size: 17px; }
    .ps-line.total span:last-child { color: var(--brand); font-size: 20px; }
    .ps-btn-full { width: 100%; margin-top: 18px; }

    .ps-alert { padding: 12px 16px; border-radius: 12px; margin-bottom: 18px; font-size: 14px; font-weight: 600; background: #fdeae4; color: #b42318; border: 1px solid #f3c9c0; }
    .ps-ok { background: #e9f6ec; color: #1d6b34; border-color: #cfe9d6; }

    /* item keranjang */
    .ps-item { display: grid; grid-template-columns: 84px 1fr auto auto auto; gap: 16px; align-items: center; padding: 16px 0; border-bottom: 1px solid var(--line); }
    .ps-item:first-child { padding-top: 0; }
    .ps-item:last-child { border-bottom: 0; padding-bottom: 0; }
    .ps-thumb { width: 84px; height: 66px; border-radius: 12px; overflow: hidden; background: var(--soft); }
    .ps-thumb img, .ps-thumb .ph { width: 100%; height: 100%; object-fit: cover; }
    .ps-thumb .ph span { font-size: 24px; }
    .ps-info strong { display: block; font-size: 15px; }
    .ps-info small { display: block; color: var(--muted); font-size: 12.5px; margin-top: 2px; }
    .ps-unit { display: inline-block; margin-top: 4px; font-size: 12px; color: var(--muted); }
    .ps-qty { display: flex; align-items: center; gap: 6px; }
    .ps-qty input { width: 58px; padding: 8px 6px; border: 1px solid var(--line); border-radius: 10px; font: inherit; text-align: center; background: #fffaf3; }
    .ps-mini { border: 1px solid var(--line); background: #fff; border-radius: 10px; padding: 8px 12px; font-size: 12px; font-weight: 700; color: var(--brand); }
    .ps-mini:hover { border-color: var(--brand); }
    .ps-price { font-weight: 800; min-width: 90px; text-align: right; }
    .ps-del { border: 0; background: none; color: #b42318; font-size: 18px; padding: 6px 8px; border-radius: 8px; }
    .ps-del:hover { background: #fdeae4; }

    .ps-empty { text-align: center; padding: 56px 24px; background: #fff; border: 1px dashed var(--line); border-radius: 18px; color: var(--muted); }
    .ps-empty h2 { color: var(--ink); font-size: 20px; margin-bottom: 8px; }
    .ps-empty .btn { margin-top: 18px; }

    /* checkout */
    .ps-choice { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    .ps-choice label { display: block; cursor: pointer; }
    .ps-choice input { position: absolute; opacity: 0; pointer-events: none; }
    .ps-choice span { display: block; border: 1.5px solid var(--line); border-radius: 14px; padding: 14px 16px; font-weight: 700; font-size: 14px; background: #fff; transition: .15s; }
    .ps-choice span small { display: block; font-weight: 500; color: var(--muted); font-size: 12px; margin-top: 2px; }
    .ps-choice input:checked + span { border-color: var(--brand); background: #fdeae4; }
    .ps-field { margin-top: 16px; }
    .ps-field label { display: block; font-weight: 700; font-size: 13.5px; margin-bottom: 8px; }
    .ps-field textarea, .ps-field input[type=text] { width: 100%; padding: 12px 14px; border: 1px solid var(--line); border-radius: 12px; font: inherit; font-size: 14px; background: #fffaf3; color: var(--ink); }
    .ps-field textarea:focus { outline: none; border-color: var(--brand); }
    .ps-mini-item { display: flex; justify-content: space-between; gap: 12px; font-size: 13.5px; padding: 8px 0; border-bottom: 1px solid #f3e8da; }
    .ps-mini-item small { display: block; color: var(--muted); font-size: 12px; }
    .ps-mini-item:last-of-type { border-bottom: 0; }

    /* badge */
    .ps-badge { display: inline-block; padding: 4px 12px; border-radius: 999px; font-size: 12px; font-weight: 800; background: #efe7df; color: #5a3b2e; }
    .ps-badge.baru { background: #fff1d6; color: #8a5a00; }
    .ps-badge.diproses { background: #dbeafe; color: #1e40af; }
    .ps-badge.siap { background: #dcfce7; color: #166534; }
    .ps-badge.selesai { background: #e5e7eb; color: #374151; }
    .ps-badge.batal { background: #fdeae4; color: #b42318; }
    .ps-badge.menunggu { background: #fff1d6; color: #8a5a00; }
    .ps-badge.lunas, .ps-badge.dibayar { background: #dcfce7; color: #166534; }
    .ps-badge.ditolak { background: #fdeae4; color: #b42318; }

    /* riwayat */
    .ps-order { display: flex; justify-content: space-between; align-items: center; gap: 16px; flex-wrap: wrap; padding: 18px 22px; background: #fff; border: 1px solid var(--line); border-radius: 16px; transition: .15s; }
    .ps-order + .ps-order { margin-top: 12px; }
    .ps-order:hover { border-color: var(--brand); box-shadow: var(--shadow); }
    .ps-order strong { font-size: 15px; }
    .ps-order small { display: block; color: var(--muted); font-size: 12.5px; margin-top: 2px; }
    .ps-order .ps-badges { display: flex; gap: 8px; flex-wrap: wrap; }
    .ps-order .ps-tot { font-weight: 800; color: var(--brand); font-size: 16px; }

    /* pelacak status */
    .ps-track { display: grid; grid-template-columns: repeat(4, 1fr); gap: 8px; margin-bottom: 8px; }
    .ps-step { text-align: center; font-size: 12.5px; color: var(--muted); font-weight: 600; }
    .ps-step i { display: block; height: 6px; border-radius: 99px; background: #efe2d3; margin-bottom: 10px; }
    .ps-step.done { color: var(--ink); }
    .ps-step.done i { background: var(--brand); }
    .ps-step.now { color: var(--brand); font-weight: 800; }
    .ps-kv { display: flex; justify-content: space-between; gap: 14px; font-size: 13.5px; padding: 8px 0; border-bottom: 1px solid #f3e8da; }
    .ps-kv:last-child { border-bottom: 0; }
    .ps-kv span:first-child { color: var(--muted); }
    .ps-kv span:last-child { text-align: right; font-weight: 600; max-width: 62%; }

    @media (max-width: 860px) {
        .ps-grid { grid-template-columns: 1fr; }
        .ps-sum { position: static; }
        .ps-h1 { font-size: 28px; }
        .ps-item { grid-template-columns: 72px 1fr; }
        .ps-item .ps-qty, .ps-item .ps-price, .ps-item form:last-child { grid-column: 2; }
        .ps-price { text-align: left; }
        .ps-track { gap: 4px; }
    }
    @media (max-width: 560px) { .ps-choice { grid-template-columns: 1fr; } }
</style>
