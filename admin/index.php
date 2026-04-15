<?php
/**
 * Admin Panel - Talep Listesi
 */
require_once dirname(__DIR__) . '/config/config.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/security.php';

secureSessionStart();

if (empty($_SESSION['admin_logged']) || $_SESSION['admin_logged'] !== true) {
    header('Location: login.php');
    exit;
}

// Oturum süresi kontrolü
if (isset($_SESSION['admin_time']) && (time() - $_SESSION['admin_time']) > SESSION_LIFETIME) {
    session_destroy();
    header('Location: login.php');
    exit;
}
$_SESSION['admin_time'] = time();

$tab = $_GET['tab'] ?? 'kiralama';
$allowedTabs = ['kiralama', 'demo', 'iletisim', 'satis', 'servis', 'makineler', 'saha-fotograflari', 'ayarlar'];
if (!in_array($tab, $allowedTabs)) $tab = 'kiralama';

$labels = [
    'kiralama' => 'Kiralama Talepleri',
    'demo' => 'Demo Talepleri',
    'iletisim' => 'İletişim Talepleri',
    'satis' => 'Satış Teklifi Talepleri',
    'servis' => 'Servis Talepleri',
    'makineler' => 'Makineler',
    'saha-fotograflari' => 'Saha Fotoğrafları',
    'ayarlar' => 'Site Ayarları',
];

$items = [];
$settings = getSettings();
if ($tab !== 'ayarlar' && $tab !== 'makineler' && $tab !== 'saha-fotograflari') {
    if (defined('USE_DB') && USE_DB && defined('DB_NAME') && DB_NAME) {
        require_once dirname(__DIR__) . '/includes/Database.php';
        $items = Database::getSubmissions($tab);
    } else {
        $file = DATA_PATH . '/' . $tab . '.json';
        if (file_exists($file)) {
            $items = json_decode(file_get_contents($file), true) ?: [];
            $items = array_reverse($items, true);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Panel | Gravisa</title>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <style>
    * { box-sizing: border-box; }
    body { font-family: 'DM Sans', sans-serif; margin: 0; background: #f5f7fa; color: #333; }
    :root {
      --admin-bg: #f5f7fa;
      --admin-surface: #fff;
      --admin-border: #e8e8e8;
      --admin-border-soft: #eef1f4;
      --admin-text: #0f172a;
      --admin-muted: #64748b;
      --admin-primary: #1e5f8a;
      --admin-primary-dark: #164a6e;
      --admin-radius: 12px;
      --admin-shadow: 0 2px 12px rgba(0,0,0,0.06);
      --admin-sidebar-w: 280px;
      --admin-header-h: 72px;
    }

    body { background: var(--admin-bg); color: var(--admin-text); }

    .admin-header {
      position: sticky;
      top: 0;
      z-index: 1100;
      background: linear-gradient(135deg, var(--admin-primary), var(--admin-primary-dark));
      color: #fff;
      padding: 14px 18px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 12px;
      min-height: var(--admin-header-h);
    }
    .admin-header h1 { margin: 0; font-size: 1.05rem; letter-spacing: -0.01em; }
    .admin-header a { color: rgba(255,255,255,0.92); text-decoration: none; font-size: 0.92rem; }
    .admin-header a:hover { color: #fff; }
    .admin-header__left { display: flex; align-items: center; gap: 10px; min-width: 0; }
    .admin-header__right { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; justify-content: flex-end; }

    .admin-icon-btn {
      appearance: none;
      border: 1px solid rgba(255,255,255,0.22);
      background: rgba(255,255,255,0.12);
      color: #fff;
      border-radius: 10px;
      padding: 10px 10px;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      line-height: 0;
      flex: 0 0 auto;
    }
    .admin-icon-btn:hover { background: rgba(255,255,255,0.18); }
    .admin-icon-btn:focus-visible { outline: 2px solid rgba(255,255,255,0.85); outline-offset: 2px; }
    .admin-burger { width: 20px; height: 14px; position: relative; }
    .admin-burger span { position: absolute; left: 0; right: 0; height: 2px; background: #fff; border-radius: 2px; }
    .admin-burger span:nth-child(1) { top: 0; }
    .admin-burger span:nth-child(2) { top: 6px; opacity: 0.95; }
    .admin-burger span:nth-child(3) { bottom: 0; }

    .admin-shell {
      display: grid;
      grid-template-columns: var(--admin-sidebar-w) minmax(0, 1fr);
      gap: 0;
      min-height: calc(100vh - var(--admin-header-h));
    }

    .admin-sidebar {
      position: sticky;
      top: var(--admin-header-h);
      align-self: start;
      height: calc(100vh - var(--admin-header-h));
      overflow: auto;
      background: var(--admin-surface);
      border-right: 1px solid var(--admin-border-soft);
      padding: 14px 12px;
    }
    .admin-sidebar__title {
      display: block;
      padding: 10px 12px;
      font-size: 0.78rem;
      font-weight: 700;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      color: var(--admin-muted);
    }
    .admin-sidebar__nav { display: flex; flex-direction: column; gap: 6px; }
    .admin-sidebar__link {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 10px 12px;
      border-radius: 10px;
      text-decoration: none;
      color: #334155;
      font-weight: 600;
      line-height: 1.25;
      border: 1px solid transparent;
    }
    .admin-sidebar__link:hover { background: #f8fafc; border-color: #eef2f7; color: var(--admin-primary); }
    .admin-sidebar__link.active { background: rgba(30,95,138,0.10); border-color: rgba(30,95,138,0.18); color: var(--admin-primary); }

    .admin-sidebar-overlay {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(15, 23, 42, 0.55);
      z-index: 1200;
    }
    .admin-sidebar-drawer {
      display: none;
      position: fixed;
      inset: 0;
      z-index: 1250;
      pointer-events: none;
    }
    .admin-sidebar-drawer__panel {
      pointer-events: auto;
      position: absolute;
      top: 0;
      left: 0;
      height: 100%;
      width: min(var(--admin-sidebar-w), 92vw);
      background: var(--admin-surface);
      border-right: 1px solid var(--admin-border-soft);
      box-shadow: 0 24px 80px rgba(0,0,0,0.25);
      transform: translateX(-102%);
      transition: transform 0.2s ease;
      display: flex;
      flex-direction: column;
    }
    .admin-sidebar-drawer__header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 10px;
      padding: 14px 14px;
      border-bottom: 1px solid var(--admin-border-soft);
      background: #fff;
      position: sticky;
      top: 0;
      z-index: 1;
    }
    .admin-sidebar-drawer__header strong { font-size: 0.95rem; color: #0f172a; }
    .admin-sidebar-drawer__body { padding: 12px; overflow: auto; }

    body.admin-drawer-open { overflow: hidden; }
    body.admin-drawer-open .admin-sidebar-overlay { display: block; }
    body.admin-drawer-open .admin-sidebar-drawer { display: block; }
    body.admin-drawer-open .admin-sidebar-drawer__panel { transform: translateX(0); }

    .admin-main { min-width: 0; }
    .admin-content { padding: 22px; max-width: 1200px; margin: 0 auto; }
    .admin-content--wide { max-width: 1480px; }

    .card { background: var(--admin-surface); border-radius: var(--admin-radius); box-shadow: var(--admin-shadow); border: 1px solid var(--admin-border); overflow: hidden; }
    .card-header { padding: 20px 24px; border-bottom: 1px solid #eee; font-weight: 700; font-size: 1.1rem; color: #1e5f8a; }
    .item { padding: 20px 24px; border-bottom: 1px solid #f0f0f0; }
    .item:last-child { border-bottom: none; }
    .item:hover { background: #fafafa; }
    .item-id { font-size: 0.75rem; color: #999; margin-bottom: 8px; }
    .item-main { font-weight: 600; color: #333; margin-bottom: 4px; }
    .item-meta { font-size: 0.875rem; color: #666; }
    .item-date { font-size: 0.8rem; color: #999; margin-top: 8px; }
    .item-actions { margin-top: 12px; }
    .btn-sm { display: inline-flex; align-items: center; justify-content: center; gap: 8px; padding: 8px 12px; background: #1e5f8a; color: #fff; border-radius: 10px; font-size: 0.85rem; text-decoration: none; font-family: inherit; border: none; cursor: pointer; white-space: nowrap; }
    .btn-sm:hover { background: #164a6e; }
    .btn-sm.secondary { background: #6c757d; }
    .btn-sm.secondary:hover { background: #596068; }
    .empty { padding: 48px; text-align: center; color: #999; }
    /* Detay modal: header'ın üstünde kalmalı (header z-index:1100) */
    .detail-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 2200; align-items: flex-start; justify-content: center; padding: calc(24px + var(--admin-header-h)) 24px 24px; }
    .detail-overlay.show { display: flex; }
    .detail-box { background: #fff; border-radius: 12px; max-width: 520px; width: 100%; max-height: 90vh; overflow-y: auto; }
    .detail-box h3 { margin: 0 0 20px; padding: 20px 24px; border-bottom: 1px solid #eee; color: #1e5f8a; }
    .detail-box .body { padding: 24px; }
    .detail-row { display: flex; padding: 10px 0; border-bottom: 1px solid #f5f5f5; }
    .detail-row:last-child { border-bottom: none; }
    .detail-label { font-weight: 600; width: 140px; flex-shrink: 0; color: #666; font-size: 0.9rem; }
    .detail-value { color: #333; }
    .detail-close { padding: 16px 24px; border-top: 1px solid #eee; text-align: right; }
    .detail-reply { margin-top: 20px; padding-top: 20px; border-top: 1px solid #eee; }
    .detail-reply textarea { width: 100%; min-height: 100px; padding: 10px 12px; border: 1px solid #ddd; border-radius: 8px; font-family: inherit; margin-bottom: 10px; }
    .detail-reply label { display: flex; align-items: center; gap: 8px; margin-bottom: 12px; font-size: 0.9rem; }
    .reply-status { font-size: 0.85rem; color: #0a0; margin-top: 8px; }
    .admin-machines-layout { display: flex; flex-direction: column; gap: 24px; }
    .admin-machines-layout--split {
      display: grid;
      grid-template-columns: minmax(0, 1fr) minmax(300px, 400px);
      gap: 24px;
      align-items: start;
    }
    @media (max-width: 992px) {
      .admin-machines-layout--split {
        grid-template-columns: 1fr;
      }
    }
    .machine-editor-column {
      position: sticky;
      top: 16px;
    }
    @media (max-width: 992px) {
      .machine-editor-column { position: static; }
    }
    .machine-editor-panel { scroll-margin-top: 24px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px 22px; }
    .machine-editor-column-title {
      margin: 0 0 14px;
      font-size: 1rem;
      font-weight: 700;
      color: #1e5f8a;
      padding-bottom: 10px;
      border-bottom: 1px solid #e2e8f0;
    }
    .machine-list-toolbar { display: flex; flex-wrap: wrap; gap: 10px; align-items: center; margin-bottom: 12px; }
    .machine-list-toolbar input[type="search"] { flex: 1; min-width: 200px; padding: 10px 14px; border: 1px solid #ddd; border-radius: 8px; font-size: 0.9rem; }
    .machine-list-toolbar select { min-width: 200px; max-width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 0.9rem; background: #fff; }
    .machine-img-preview-wrap { margin-top: 10px; border-radius: 8px; overflow: hidden; border: 1px solid #e5e7eb; background: #fff; max-width: 360px; display: none; }
    .machine-img-preview-wrap.is-visible { display: block; }
    .machine-img-preview-wrap img { width: 100%; height: auto; max-height: 320px; object-fit: contain; object-position: center; display: block; image-rendering: auto; }
    .machine-edit-context { font-size: 0.9rem; padding: 10px 12px; border-radius: 8px; margin-bottom: 12px; border: 1px solid #c5d7e6; background: #e8f4fc; color: #164a6e; }
    .machine-edit-context.is-new { background: #f1f5f9; border-color: #e2e8f0; color: #475569; }
    .admin-table-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; }
    .machine-form-hint { font-size: 0.8rem; color: #64748b; margin-top: 4px; line-height: 1.4; }

    /* Genel responsive iyileştirmeler */
    .admin-table-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; max-width: 100%; }
    .admin-table-wrap table { width: 100%; }
    .admin-table-wrap::-webkit-scrollbar { height: 10px; }
    .admin-table-wrap::-webkit-scrollbar-thumb { background: rgba(100,116,139,0.25); border-radius: 999px; }
    .admin-table-wrap { touch-action: pan-x pan-y; }

    /* Mobilde aksiyon kolonuna erişim */
    .admin-table-row-clickable { cursor: pointer; }
    .admin-table-row-clickable:hover { background: #fafcff; }
    .admin-table-sticky-last {
      position: sticky;
      right: 0;
      background: #fff;
      box-shadow: -10px 0 16px rgba(15,23,42,0.05);
      border-left: 1px solid rgba(226,232,240,0.9);
      z-index: 1;
    }
    .admin-table-sticky-last--head {
      background: #f5f7fa;
      z-index: 2;
    }
    /* File input mobilde taşmasın */
    input[type="file"] { max-width: 100%; }
    .machine-form-hint { overflow-wrap: anywhere; word-break: break-word; }

    .admin-actions-row { display: flex; gap: 10px; align-items: center; flex-wrap: wrap; }
    .admin-actions-row > * { max-width: 100%; }
    .admin-actions-row input, .admin-actions-row select { min-width: 0; }
    .admin-btn-row { display: flex; gap: 10px; align-items: center; flex-wrap: wrap; }
    .admin-btn-row .admin-inline-msg { color: var(--admin-muted); font-size: 0.9rem; }
    .admin-inline-msg { margin-left: 12px; }

    .admin-jump-btn {
      display: none;
      align-items: center;
      justify-content: center;
      gap: 8px;
      padding: 10px 12px;
      border-radius: 10px;
      border: 1px solid rgba(30,95,138,0.20);
      background: rgba(30,95,138,0.08);
      color: var(--admin-primary);
      cursor: pointer;
      font: inherit;
      font-weight: 700;
      white-space: nowrap;
    }
    .admin-jump-btn:hover { background: rgba(30,95,138,0.12); }
    .admin-jump-btn:focus-visible { outline: 2px solid rgba(30,95,138,0.45); outline-offset: 2px; }

    /* Card header içerikleri taşmasın */
    .card-header { display: flex; flex-direction: column; align-items: flex-start; gap: 10px; }
    .card-header > span { margin-left: 0 !important; }
    .card-header code { word-break: break-word; }

    /* Hamburger sadece tablet/mobil */
    @media (min-width: 993px) {
      #adminSidebarToggle { display: none; }
    }

    .admin-split { display: flex; gap: 24px; flex-wrap: wrap; }
    .admin-split__col { min-width: 0; }

    /* Mobil/tablet */
    @media (max-width: 992px) {
      .admin-shell { grid-template-columns: 1fr; }
      .admin-sidebar { display: none; }
      .admin-content { padding: 16px; }
      .admin-header { padding: 12px 14px; }
      .admin-header h1 { font-size: 1rem; }
      .admin-jump-btn { display: inline-flex; }

      /* Makineler toolbar: input/select görünür kalsın */
      .machine-list-toolbar {
        display: grid;
        grid-template-columns: 1fr;
        align-items: stretch;
      }
      .machine-list-toolbar select,
      .machine-list-toolbar input[type="search"] {
        width: 100%;
        min-width: 0;
      }
      #machine_search_count { white-space: normal !important; }
    }
    @media (max-width: 560px) {
      .admin-content { padding: 12px; }
      .admin-header__right { width: 100%; justify-content: flex-start; }
      .admin-header a { font-size: 0.9rem; }
      .card-header { padding: 16px 16px; }
      .item { padding: 16px 16px; }
      .detail-overlay { padding: calc(14px + var(--admin-header-h)) 14px 14px; }
      .detail-box { border-radius: 12px; max-height: 92vh; }
      .detail-box h3 { padding: 16px 16px; margin-bottom: 12px; }
      .detail-box .body { padding: 16px; }
      .detail-row { flex-direction: column; gap: 6px; }
      .detail-label { width: auto; }
      .detail-close { padding: 14px 16px; }
      .item-actions { display: flex; flex-wrap: wrap; gap: 8px; }
      .item-actions .btn-sm { width: auto; }

      .admin-split { flex-direction: column; gap: 16px; }
      .admin-split__col { width: 100%; }
      /* Inline min-width:320px değerlerini mobilde ez (layout kaymasını engeller) */
      .admin-split__col { min-width: 0 !important; }

      .admin-inline-msg { margin-left: 0; display: block; width: 100%; }
      .admin-btn-row { flex-direction: column; align-items: stretch; }
      .admin-btn-row .btn-sm { width: 100%; }
    }

    @media (max-width: 360px) {
      .admin-content { padding: 10px; }
      .admin-body-pad { padding: 12px; }
    }

    /* Makineler tablosu: mobilde taşmayı azalt (kolonları gizle) */
    @media (max-width: 680px) {
      table.admin-table--machines { min-width: 0 !important; }
      table.admin-table--machines th:nth-child(5),
      table.admin-table--machines td:nth-child(5), /* Yıl */
      table.admin-table--machines th:nth-child(6),
      table.admin-table--machines td:nth-child(6), /* Güç */
      table.admin-table--machines th:nth-child(7),
      table.admin-table--machines td:nth-child(7), /* Stok */
      table.admin-table--machines th:nth-child(8),
      table.admin-table--machines td:nth-child(8)  /* Görsel */ {
        display: none;
      }
      /* Sticky aksiyon kolonunun padding'i */
      .admin-table-sticky-last { min-width: 140px; }
    }

    /* Makineler: dar ekranda tablo yerine kart liste */
    .admin-card-list { display: none; flex-direction: column; gap: 12px; width: 100%; }
    .admin-card {
      background: #fff;
      border: 1px solid #e8e8e8;
      border-radius: 12px;
      box-shadow: 0 2px 12px rgba(0,0,0,0.04);
      overflow: hidden;
      width: 100%;
    }
    .admin-card__body { padding: 14px 14px; display: grid; gap: 10px; }
    .admin-card__title { font-weight: 800; color: #0f172a; line-height: 1.25; }
    .admin-card__meta { color: #475569; font-size: 0.92rem; }
    .admin-card__grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
    .admin-card__kv { background: #f8fafc; border: 1px solid #eef2f7; border-radius: 10px; padding: 10px 10px; }
    .admin-card__k { font-size: 0.78rem; letter-spacing: 0.02em; color: #64748b; font-weight: 700; margin-bottom: 4px; }
    .admin-card__v { color: #0f172a; font-weight: 700; font-size: 0.92rem; }
    .admin-card__actions { padding: 12px 14px; border-top: 1px solid #eef2f7; display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
    .admin-card__actions .btn-sm { width: 100%; }
    .admin-card__img {
      width: 100%;
      height: 150px;
      background: #f1f5f9;
      display: flex;
      align-items: center;
      justify-content: center;
      border-bottom: 1px solid #eef2f7;
    }
    .admin-card__img img { max-height: 140px; object-fit: contain; }
    @media (max-width: 680px) {
      .admin-table--machines { display: none; }
      #machineCardList { display: flex; }
      .admin-card__grid { grid-template-columns: 1fr; }
    }

    @media (max-width: 680px) {
      .admin-table--saha { display: none; }
      #sahaCardList { display: flex; }
    }

    /* Dar ekranda buton taşmalarını engelle */
    @media (max-width: 420px) {
      .admin-card__actions { grid-template-columns: 1fr; }
      .btn-sm { white-space: normal; }
    }

    /* Kart içerikleri daha ferah ve hizalı */
    .admin-card__title { font-size: 1.05rem; }
    .admin-card__meta { line-height: 1.4; }
    .admin-card__img { border-bottom: 1px solid #eef2f7; }

    /* "Forma git" butonu küçük ekranda tam genişlik */
    @media (max-width: 560px) {
      .admin-jump-btn { width: 100%; }
    }

    .admin-section-head {
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 12px;
      flex-wrap: wrap;
    }
    @media (max-width: 560px) {
      .admin-section-head { flex-direction: column; align-items: stretch; }
      .admin-section-head .btn-sm { width: 100%; }
    }

    /* Admin iç paneller: mobilde daha dengeli padding */
    .admin-body-pad { padding: 24px; }
    @media (max-width: 560px) {
      .admin-body-pad { padding: 16px; }
      .admin-card__body { padding: 12px 12px; }
      .admin-card__actions { padding: 12px 12px; }
    }

    /* Formlarda iki kolonlu satırı mobilde stack et */
    @media (max-width: 560px) {
      .admin-form-row { flex-direction: column !important; }
      .admin-form-row > * { flex: 1 1 auto !important; width: 100% !important; }
    }
  </style>
</head>
<body>
  <input type="hidden" id="csrf_token" value="<?= htmlspecialchars(csrfToken()) ?>" />
  <header class="admin-header">
    <div class="admin-header__left">
      <button type="button" class="admin-icon-btn" id="adminSidebarToggle" aria-label="Menü" aria-expanded="false">
        <span class="admin-burger" aria-hidden="true"><span></span><span></span><span></span></span>
      </button>
      <h1>Gravisa Admin Panel</h1>
    </div>
    <div class="admin-header__right">
      <a href="../">Siteye Git</a>
      <span style="margin: 0 4px; opacity: 0.6;">|</span>
      <a href="logout.php">Çıkış</a>
    </div>
  </header>

  <div class="admin-sidebar-overlay" id="adminSidebarOverlay" aria-hidden="true"></div>
  <div class="admin-sidebar-drawer" id="adminSidebarDrawer" aria-hidden="true">
    <aside class="admin-sidebar-drawer__panel" role="dialog" aria-modal="true" aria-label="Admin menü">
      <div class="admin-sidebar-drawer__header">
        <strong>Menü</strong>
        <button type="button" class="admin-icon-btn" id="adminSidebarClose" aria-label="Kapat">
          <span aria-hidden="true" style="font-weight:700; font-size:16px; line-height:1;">✕</span>
        </button>
      </div>
      <div class="admin-sidebar-drawer__body">
        <span class="admin-sidebar__title">Sayfalar</span>
        <nav class="admin-sidebar__nav" aria-label="Admin navigasyon">
          <?php foreach ($allowedTabs as $t): ?>
          <a href="?tab=<?= $t ?>" class="admin-sidebar__link <?= $tab === $t ? 'active' : '' ?>"><?= $labels[$t] ?></a>
          <?php endforeach; ?>
        </nav>
      </div>
    </aside>
  </div>

  <div class="admin-shell">
    <aside class="admin-sidebar" aria-label="Admin menü">
      <span class="admin-sidebar__title">Sayfalar</span>
      <nav class="admin-sidebar__nav">
        <?php foreach ($allowedTabs as $t): ?>
        <a href="?tab=<?= $t ?>" class="admin-sidebar__link <?= $tab === $t ? 'active' : '' ?>"><?= $labels[$t] ?></a>
        <?php endforeach; ?>
      </nav>
    </aside>

    <div class="admin-main">
      <main class="admin-content<?= $tab === 'makineler' ? ' admin-content--wide' : '' ?>">
    <?php if ($tab === 'ayarlar'): ?>
    <div class="card">
      <div class="card-header">Site Ayarları</div>
      <div class="body" style="padding: 24px;">
        <div class="admin-actions-row" style="margin: 0 0 12px;">
          <a class="btn-sm secondary" href="#cat-images">Kategori görsellerine git</a>
        </div>
        <form id="settingsForm">
          <?php echo csrfField(); ?>
          <div style="display: grid; gap: 20px; max-width: 520px;">
            <label style="display: block;">
              <span style="display: block; font-weight: 600; margin-bottom: 6px; color: #555;">İletişim E-postası (sitede görünen)</span>
              <input type="email" name="contact_email" value="<?= htmlspecialchars($settings['contact_email'] ?? '') ?>" style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 8px;" />
            </label>
            <label style="display: block;">
              <span style="display: block; font-weight: 600; margin-bottom: 6px; color: #555;">Servis E-postası</span>
              <input type="email" name="servis_email" value="<?= htmlspecialchars($settings['servis_email'] ?? '') ?>" style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 8px;" />
            </label>
            <label style="display: block;">
              <span style="display: block; font-weight: 600; margin-bottom: 6px; color: #555;">WhatsApp Numarası (sadece rakam, örn. 905551234567)</span>
              <input type="text" name="whatsapp_number" value="<?= htmlspecialchars($settings['whatsapp_number'] ?? '') ?>" placeholder="905551234567" style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 8px;" />
            </label>
            <label style="display: block;">
              <span style="display: block; font-weight: 600; margin-bottom: 6px; color: #555;">Telefon (görünen metin)</span>
              <input type="text" name="phone_display" value="<?= htmlspecialchars($settings['phone_display'] ?? '') ?>" placeholder="0555 123 45 67" style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 8px;" />
            </label>
            <label style="display: block;">
              <span style="display: block; font-weight: 600; margin-bottom: 6px; color: #555;">Adres</span>
              <textarea name="address" rows="3" style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 8px;"><?= htmlspecialchars($settings['address'] ?? '') ?></textarea>
            </label>
            <label style="display: flex; align-items: flex-start; gap: 10px; font-size: 0.9rem; color: #444;">
              <input type="checkbox" name="prefer_env_contact" value="1" style="margin-top: 3px;" <?= !empty($settings['prefer_env_contact']) ? 'checked' : '' ?> />
              <span><strong>İletişimde öncelik .env dosyasında</strong> — İşaretliyse e-posta, WhatsApp, telefon ve form mail alanları yalnızca <code style="font-size:0.85em;">config/.env</code> üzerinden okunur; aşağıdaki panel alanları yok sayılır. .env’i sık değiştiriyorsanız kullanın. Panelden yönetmek için kutuyu kaldırın.</span>
            </label>
            <hr style="border: none; border-top: 1px solid #eee;" />
            <p style="font-size: 0.9rem; color: #666;">Form talepleri aşağıdaki adrese e-posta ile gönderilir. Boş bırakırsanız config.php içindeki MAIL_TO kullanılır.</p>
            <label style="display: block;">
              <span style="display: block; font-weight: 600; margin-bottom: 6px; color: #555;">Taleplerin gönderileceği e-posta (mail_to)</span>
              <input type="email" name="mail_to" value="<?= htmlspecialchars($settings['mail_to'] ?? '') ?>" placeholder="destek@gravisa.com.tr" style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 8px;" />
            </label>
            <label style="display: block;">
              <span style="display: block; font-weight: 600; margin-bottom: 6px; color: #555;">Gönderen adı (e-postada görünen)</span>
              <input type="text" name="mail_from_name" value="<?= htmlspecialchars($settings['mail_from_name'] ?? '') ?>" style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 8px;" />
            </label>
            <label style="display: block;">
              <span style="display: block; font-weight: 600; margin-bottom: 6px; color: #555;">Gönderen e-posta (mail_from)</span>
              <input type="email" name="mail_from" value="<?= htmlspecialchars($settings['mail_from'] ?? '') ?>" style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 8px;" />
            </label>
            <hr style="border: none; border-top: 1px solid #eee;" />
            <p style="font-weight: 600; color: #1e5f8a;">SEO Ayarları</p>
            <label style="display: block;">
              <span style="display: block; font-weight: 600; margin-bottom: 6px; color: #555;">Site başlığı (marka adı)</span>
              <input type="text" name="seo_site_title" value="<?= htmlspecialchars($settings['seo_site_title'] ?? 'Gravisa') ?>" placeholder="Gravisa" style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 8px;" />
            </label>
            <label style="display: block;">
              <span style="display: block; font-weight: 600; margin-bottom: 6px; color: #555;">Varsayılan meta açıklama (tüm sayfalar)</span>
              <textarea name="seo_default_description" rows="2" style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 8px;"><?= htmlspecialchars($settings['seo_default_description'] ?? '') ?></textarea>
            </label>
            <label style="display: block;">
              <span style="display: block; font-weight: 600; margin-bottom: 6px; color: #555;">Varsayılan anahtar kelimeler (virgülle ayırın)</span>
              <input type="text" name="seo_default_keywords" value="<?= htmlspecialchars($settings['seo_default_keywords'] ?? '') ?>" placeholder="iş makineleri, kiralama, satış" style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 8px;" />
            </label>
            <label style="display: block;">
              <span style="display: block; font-weight: 600; margin-bottom: 6px; color: #555;">Sayfa bazlı SEO (isteğe bağlı JSON)</span>
              <textarea name="seo_pages" rows="4" placeholder='{"index":{"title":"Ana Sayfa","description":"..."},"iletisim":{"title":"İletişim","description":"..."}}' style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 0.85rem;"><?= htmlspecialchars($settings['seo_pages'] ?? '') ?></textarea>
              <span style="font-size: 0.8rem; color: #666;">Sayfa id: index, iletisim, makineler, satis-teklifi, kiralama, servis, kurumsal, hakkimizda, vizyon-misyon, referanslar, saha-fotograflari, makine-detay</span>
            </label>
            <div>
              <button type="submit" class="btn-sm" id="settingsBtn">Kaydet</button>
              <span id="settingsMsg" style="margin-left: 12px; font-size: 0.9rem;"></span>
            </div>
          </div>
        </form>
      </div>
    </div>

    <div class="card" id="cat-images" style="margin-top: 18px;">
      <div class="card-header">Kategori Görselleri</div>
      <div class="body" style="padding: 24px;">
        <p style="margin:0 0 12px; color:#64748b; font-size:0.9rem;">
          Ana sayfa ve makine kataloğundaki kategori görsellerini buradan manuel ayarlayabilirsiniz. Seçilmezse sistem kategori altındaki makinelerden görsel bulmaya devam eder.
        </p>
        <div id="catImgMsg" style="margin:0 0 12px; font-size:0.9rem;"></div>
        <div id="catImgList" style="display:grid; gap:12px;"></div>
      </div>
    </div>
    <?php elseif ($tab === 'makineler'): ?>
    <div class="card">
      <div class="card-header">Makineler</div>
      <div class="body admin-body-pad">
        <div class="admin-machines-layout admin-machines-layout--split">
          <div class="machine-list-column">
            <h3 style="margin:0 0 12px; font-size:1.1rem;">Makine listesi</h3>
            <div class="machine-list-toolbar">
              <select id="machine_tip_filter" aria-label="Kategori filtre">
                <option value="">Tüm kategoriler</option>
              </select>
              <input type="search" id="machine_search" placeholder="ID, no, tip, firma, model…" autocomplete="off" />
              <span id="machine_search_count" style="font-size:0.85rem; color:#666; white-space:nowrap;"></span>
              <button type="button" class="admin-jump-btn" id="machineJumpToFormBtn" aria-label="Makine formuna git">Forma git</button>
            </div>
            <p class="machine-form-hint" style="margin:0 0 12px;">Liste, sitedeki kategorilerle aynı <strong>Tip</strong> alanına göre gruplanır. Bir satırı düzenleyip Kaydet dediğinizde yalnızca o makine güncellenir.</p>
            <div id="machineCardList" class="admin-card-list" aria-label="Makine kart listesi"></div>
            <div class="admin-table-wrap">
              <table class="admin-table--machines" style="width: 100%; border-collapse: collapse; font-size: 0.9rem; min-width: 720px;">
                <thead>
                  <tr style="background:#f5f7fa;">
                    <th style="text-align:left; padding:8px; border-bottom:1px solid #eee;">ID</th>
                    <th style="text-align:left; padding:8px; border-bottom:1px solid #eee;">No</th>
                    <th style="text-align:left; padding:8px; border-bottom:1px solid #eee;">Tip</th>
                    <th style="text-align:left; padding:8px; border-bottom:1px solid #eee;">Firma / Model</th>
                    <th style="text-align:left; padding:8px; border-bottom:1px solid #eee;">Yıl</th>
                    <th style="text-align:left; padding:8px; border-bottom:1px solid #eee;">Güç</th>
                    <th style="text-align:left; padding:8px; border-bottom:1px solid #eee;">Stok</th>
                    <th style="text-align:left; padding:8px; border-bottom:1px solid #eee;">Görsel</th>
                    <th class="admin-table-sticky-last admin-table-sticky-last--head" style="text-align:right; padding:8px; border-bottom:1px solid #eee;">İşlem</th>
                  </tr>
                </thead>
                <tbody id="machineTableBody">
                  <tr><td colspan="9" style="padding:12px; text-align:center; color:#999;">Yükleniyor...</td></tr>
                </tbody>
              </table>
            </div>
          </div>
          <aside class="machine-editor-column" aria-label="Makine formu">
            <div id="machine-editor-anchor" class="machine-editor-panel" tabindex="-1">
            <h3 class="machine-editor-column-title">Makine ekle / düzenle</h3>
            <div id="machine_edit_context" class="machine-edit-context is-new" aria-live="polite">Yeni kayıt — Kaydet dediğinizde listede oluşur. Görsel, bu formdaki kayda gider.</div>
            <div style="display:flex; justify-content:flex-end; align-items:center; margin-bottom:12px; flex-wrap:wrap; gap:10px;">
              <button type="button" class="btn-sm" id="machineNewBtn">+ Yeni makine</button>
            </div>
            <form id="machineForm" enctype="multipart/form-data">
              <?php echo csrfField(); ?>
              <input type="hidden" name="id" id="machine_id" value="">
              <input type="hidden" name="img_existing" id="machine_img_existing" value="">
              <div style="display:flex; flex-direction:column; gap:10px;">
                <label>
                  <span style="display:block; font-weight:600; margin-bottom:4px; color:#555;">Envanter no (Excel)</span>
                  <input type="text" name="no" id="machine_no" placeholder="Örn. 14 — boş bırakılırsa kayıt ID kullanılır" style="width:100%; padding:8px 10px; border:1px solid #ddd; border-radius:8px;">
                  <span class="machine-form-hint">Toplu görsel dosya adı: <code id="machine_img_filename_hint">images/makineler/makine_NO.jpg</code> (.png / .webp de olur). Makpark içe aktarma bu numarayı kullanır.</span>
                </label>
                <label>
                  <span style="display:block; font-weight:600; margin-bottom:4px; color:#555;">Tip (kategori)</span>
                  <input type="text" name="tip" id="machine_tip" required style="width:100%; padding:8px 10px; border:1px solid #ddd; border-radius:8px;" list="machine_tip_suggestions">
                </label>
                <datalist id="machine_tip_suggestions"></datalist>
                <label>
                  <span style="display:block; font-weight:600; margin-bottom:4px; color:#555;">Firma</span>
                  <input type="text" name="firma" id="machine_firma" required style="width:100%; padding:8px 10px; border:1px solid #ddd; border-radius:8px;">
                </label>
                <label>
                  <span style="display:block; font-weight:600; margin-bottom:4px; color:#555;">Tip / Model</span>
                  <input type="text" name="tipModel" id="machine_tipModel" required style="width:100%; padding:8px 10px; border:1px solid #ddd; border-radius:8px;">
                </label>
                <label>
                  <span style="display:block; font-weight:600; margin-bottom:4px; color:#555;">Model Yılı</span>
                  <input type="text" name="modelYil" id="machine_modelYil" style="width:100%; padding:8px 10px; border:1px solid #ddd; border-radius:8px;">
                </label>
                <div class="admin-form-row" style="display:flex; gap:8px;">
                  <label style="flex:2;">
                    <span style="display:block; font-weight:600; margin-bottom:4px; color:#555;">Güç</span>
                    <input type="text" name="guc" id="machine_guc" style="width:100%; padding:8px 10px; border:1px solid #ddd; border-radius:8px;">
                  </label>
                  <label style="flex:1;">
                    <span style="display:block; font-weight:600; margin-bottom:4px; color:#555;">Birim</span>
                    <input type="text" name="gucBirim" id="machine_gucBirim" placeholder="kW / HP" style="width:100%; padding:8px 10px; border:1px solid #ddd; border-radius:8px;">
                  </label>
                </div>
                <label>
                  <span style="display:block; font-weight:600; margin-bottom:4px; color:#555;">Kapasite</span>
                  <input type="text" name="kapasite" id="machine_kapasite" style="width:100%; padding:8px 10px; border:1px solid #ddd; border-radius:8px;">
                </label>
                <label>
                  <span style="display:block; font-weight:600; margin-bottom:4px; color:#555;">Şasi Seri No</span>
                  <input type="text" name="saseSeriNo" id="machine_saseSeriNo" style="width:100%; padding:8px 10px; border:1px solid #ddd; border-radius:8px;">
                </label>
                <label>
                  <span style="display:block; font-weight:600; margin-bottom:4px; color:#555;">Motor Seri No</span>
                  <input type="text" name="motorSeriNo" id="machine_motorSeriNo" style="width:100%; padding:8px 10px; border:1px solid #ddd; border-radius:8px;">
                </label>
                <label>
                  <span style="display:block; font-weight:600; margin-bottom:4px; color:#555;">Motor Marka</span>
                  <input type="text" name="motorMarka" id="machine_motorMarka" style="width:100%; padding:8px 10px; border:1px solid #ddd; border-radius:8px;">
                </label>
                <label>
                  <span style="display:block; font-weight:600; margin-bottom:4px; color:#555;">Motor Tip</span>
                  <input type="text" name="motorTip" id="machine_motorTip" style="width:100%; padding:8px 10px; border:1px solid #ddd; border-radius:8px;">
                </label>
                <label>
                  <span style="display:block; font-weight:600; margin-bottom:4px; color:#555;">Teknik Özellikler</span>
                  <textarea name="teknik" id="machine_teknik" rows="5" placeholder="Örn.\nÇalışma Ağırlığı: 12 ton\nKepçe Kapasitesi: 0.8 m³\nYakıt: Dizel" style="width:100%; padding:8px 10px; border:1px solid #ddd; border-radius:8px; font-family:inherit; resize:vertical;"></textarea>
                  <span class="machine-form-hint">Her satırı <strong>Anahtar: Değer</strong> şeklinde yazın. Bu alan makine detay sayfasında “Teknik Özellikler” bölümünde gösterilir.</span>
                </label>
                <label style="display:flex; align-items:center; gap:8px;">
                  <input type="checkbox" name="stok" id="machine_stok" checked>
                  <span style="font-size:0.9rem; color:#555;">Stokta</span>
                </label>
                <label>
                  <span style="display:block; font-weight:600; margin-bottom:4px; color:#555;">Görsel</span>
                  <input type="file" name="img" id="machine_img" accept="image/jpeg,image/png,image/webp,image/jfif,.jpg,.jpeg,.png,.webp,.jfif" style="width:100%; font-size:0.85rem;">
                  <small id="machine_img_info" class="machine-form-hint" style="display:block;"></small>
                  <p class="machine-form-hint">Yüklediğiniz dosya <strong>yalnızca şu an düzenlediğiniz</strong> makineye (üstteki ID şeridi) yazılır; sitede aynı kayıt anında güncellenir. İsterseniz dosyayı <code>makine_{no}.jpg</code> adıyla klasöre koyup <code>python scripts/import_makpark.py --assign-images-only</code> ile de eşleyebilirsiniz.</p>
                  <div id="machine_img_preview_wrap" class="machine-img-preview-wrap" aria-hidden="true">
                    <img id="machine_img_preview" src="" alt="Önizleme" />
                  </div>
                </label>
                <div class="admin-btn-row">
                  <button type="submit" class="btn-sm" id="machineSaveBtn">Kaydet</button>
                  <button type="button" class="btn-sm secondary" id="machineResetBtn">Temizle</button>
                  <span id="machineMsg" class="admin-inline-msg" style="font-size:0.85rem;"></span>
                </div>
              </div>
            </form>
            </div>
          </aside>
        </div>
      </div>
    </div>
    <?php elseif ($tab === 'saha-fotograflari'): ?>
    <div class="card">
      <div class="card-header">Saha Fotoğrafları</div>
      <div class="body admin-body-pad">
        <div class="admin-split">
          <div class="admin-split__col" style="flex: 2 1 0; min-width: 320px;">
            <div class="admin-section-head" style="margin-top:0; margin-bottom:12px;">
              <h3 style="margin:0;">Fotoğraf Listesi</h3>
              <button type="button" class="admin-jump-btn" id="sahaJumpToFormBtn" aria-label="Saha fotoğraf formuna git">Forma git</button>
            </div>
            <div id="sahaCardList" class="admin-card-list" aria-label="Saha fotoğraf kart listesi"></div>
            <div class="admin-table-wrap">
              <table class="admin-table--saha" style="width: 100%; border-collapse: collapse; font-size: 0.9rem; min-width: 620px;">
                <thead>
                  <tr style="background:#f5f7fa;">
                    <th style="text-align:left; padding:8px; border-bottom:1px solid #eee;">ID</th>
                    <th style="text-align:left; padding:8px; border-bottom:1px solid #eee;">Başlık</th>
                    <th style="text-align:left; padding:8px; border-bottom:1px solid #eee;">Açıklama</th>
                    <th style="text-align:left; padding:8px; border-bottom:1px solid #eee;">Görsel</th>
                    <th style="text-align:right; padding:8px; border-bottom:1px solid #eee;">İşlem</th>
                  </tr>
                </thead>
                <tbody id="sahaTableBody">
                  <tr><td colspan="5" style="padding:12px; text-align:center; color:#999;">Yükleniyor...</td></tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="admin-split__col" style="flex: 1 1 0; min-width: 320px;">
            <div class="admin-section-head" style="margin-bottom:12px;">
              <h3 style="margin: 0;">Fotoğraf Ekle / Düzenle</h3>
              <button type="button" class="btn-sm" id="sahaNewBtn">+ Yeni Saha Fotoğrafı Ekle</button>
            </div>
            <form id="sahaForm" enctype="multipart/form-data" data-scroll-anchor="saha-editor-anchor">
              <?php echo csrfField(); ?>
              <input type="hidden" name="id" id="saha_id" value="">
              <div style="display:flex; flex-direction:column; gap:10px;">
                <label>
                  <span style="display:block; font-weight:600; margin-bottom:4px; color:#555;">Başlık</span>
                  <input type="text" name="title" id="saha_title" required style="width:100%; padding:8px 10px; border:1px solid #ddd; border-radius:8px;">
                </label>
                <label>
                  <span style="display:block; font-weight:600; margin-bottom:4px; color:#555;">Açıklama</span>
                  <input type="text" name="description" id="saha_description" style="width:100%; padding:8px 10px; border:1px solid #ddd; border-radius:8px;">
                </label>
                <label>
                  <span style="display:block; font-weight:600; margin-bottom:4px; color:#555;">Sıra</span>
                  <input type="number" name="sort_order" id="saha_sort_order" value="0" style="width:100%; padding:8px 10px; border:1px solid #ddd; border-radius:8px;">
                </label>
                <label>
                  <span style="display:block; font-weight:600; margin-bottom:4px; color:#555;">Görsel (JPG / PNG)</span>
                  <input type="file" name="img" id="saha_img" accept="image/*" style="width:100%; font-size:0.85rem;">
                  <small id="saha_img_info" style="display:block; margin-top:4px; font-size:0.8rem; color:#777;"></small>
                </label>
                <div class="admin-btn-row">
                  <button type="submit" class="btn-sm" id="sahaSaveBtn">Kaydet</button>
                  <button type="button" class="btn-sm secondary" id="sahaResetBtn">Temizle</button>
                  <span id="sahaMsg" class="admin-inline-msg" style="font-size:0.85rem;"></span>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <?php else: ?>
    <div class="card">
      <div class="card-header">
        <?= $labels[$tab] ?>
        <span style="font-size:0.85rem; color:#666;">(Toplam <?= count($items) ?> kayıt)</span>
        <?php if (!empty($items)): ?>
        <div class="admin-actions-row" style="margin-top:8px;">
          <input type="text" id="requestSearch" placeholder="İsim, e-posta, telefon, konu ara..." style="flex:1; min-width:220px; padding:6px 10px; border-radius:8px; border:1px solid #d0d7de; font-size:0.85rem;">
          <select id="requestDateFilter" style="padding:6px 10px; border-radius:8px; border:1px solid #d0d7de; font-size:0.85rem;">
            <option value="all">Tüm tarihler</option>
            <option value="7">Son 7 gün</option>
            <option value="30">Son 30 gün</option>
          </select>
        </div>
        <?php endif; ?>
      </div>
      <?php if (empty($items)): ?>
      <div class="empty">Henüz talep bulunmuyor.</div>
      <?php else: ?>
      <?php foreach ($items as $id => $data): ?>
      <?php
      $main = $data['ad_soyad'] ?? $data['name'] ?? '-';
      $meta = $data['email'] ?? $data['telefon'] ?? $data['phone'] ?? '';
      if ($tab === 'kiralama') $meta = ($data['lokasyon'] ?? '') . ' • ' . ($data['sure'] ?? '');
      elseif ($tab === 'demo') $meta = ($data['machine'] ?? '') . ' • ' . ($data['phone'] ?? '');
      elseif ($tab === 'iletisim') $meta = ($data['konu'] ?? '') . ' • ' . ($data['telefon'] ?? '');
      elseif ($tab === 'satis') $meta = ($data['model'] ?? '') . ' • ' . ($data['email'] ?? '');
      elseif ($tab === 'servis') $meta = ($data['lokasyon'] ?? '') . ' • ' . ($data['servis_turu'] ?? '');
      $createdAt = $data['created_at'] ?? '';
      ?>
      <div class="item" data-request-id="<?= htmlspecialchars($id) ?>" data-main="<?= htmlspecialchars($main) ?>" data-meta="<?= htmlspecialchars($meta) ?>" data-date="<?= htmlspecialchars($createdAt) ?>">
        <div class="item-id"><?= htmlspecialchars($id) ?></div>
        <div class="item-main">
          <?= htmlspecialchars($main) ?>
        </div>
        <div class="item-meta">
          <?= htmlspecialchars($meta) ?>
        </div>
        <div class="item-date">
          <?= htmlspecialchars($createdAt) ?>
        </div>
        <div class="item-actions">
          <button type="button" class="btn-sm" onclick="showDetail(<?= htmlspecialchars(json_encode($id), ENT_QUOTES) ?>, <?= htmlspecialchars(json_encode($data), ENT_QUOTES) ?>)">Detay</button>
          <button type="button" class="btn-sm secondary" data-delete-request="<?= htmlspecialchars($id) ?>">Sil</button>
        </div>
      </div>
      <?php endforeach; ?>
      <?php endif; ?>
    </div>
    <?php endif; ?>
      </main>
    </div>
  </div>

  <div class="detail-overlay" id="detailOverlay">
    <div class="detail-box">
      <h3 id="detailTitle">Talep Detayı</h3>
      <div class="body" id="detailBody"></div>
      <div class="detail-close">
        <button type="button" class="btn-sm secondary" onclick="closeDetail()">Kapat</button>
      </div>
    </div>
  </div>

  <script>
    var currentDetailId = null;
    var currentDetailData = null;
    function esc(s) {
      if (s == null || s === undefined) return '';
      var d = document.createElement('div');
      d.textContent = String(s);
      return d.innerHTML;
    }
    function showDetail(id, data) {
      currentDetailId = id;
      currentDetailData = data;
      var labels = {
        ad_soyad: 'Ad Soyad', name: 'Ad Soyad', email: 'E-posta', telefon: 'Telefon', phone: 'Telefon',
        firma: 'Firma', lokasyon: 'Adres', sure: 'Kiralama Süresi', operator: 'Operatör',
        baslangic: 'Başlangıç', bitis: 'Bitiş', model: 'Model', makine_id: 'Makine ID', makine_model: 'Makine Model',
        adet: 'Adet', machine: 'Makine', date: 'Tarih', note: 'Not', not: 'Ek Notlar',
        konu: 'Konu', mesaj: 'Mesaj', created_at: 'Tarih',
        servis_turu: 'Servis Türü', seri_no: 'Seri No / Plaka',
        admin_reply: 'Verdiğiniz Cevap', replied_at: 'Cevap Tarihi'
      };
      var skipKeys = ['created_at', 'reply_email_sent'];
      var html = '<div class="detail-row"><span class="detail-label">ID</span><span class="detail-value">' + esc(id) + '</span></div>';
      for (var k in data) {
        if (skipKeys.indexOf(k) >= 0 || (data[k] === '' && k !== 'admin_reply') || data[k] == null) continue;
        var lbl = labels[k] || k;
        html += '<div class="detail-row"><span class="detail-label">' + esc(lbl) + '</span><span class="detail-value">' + esc('' + data[k]).replace(/\n/g, '<br>') + '</span></div>';
      }
      html += '<div class="detail-row"><span class="detail-label">Oluşturulma</span><span class="detail-value">' + esc(data.created_at || '') + '</span></div>';
      html += '<div class="detail-reply"><h4 style="margin: 0 0 12px; font-size: 1rem;">Cevap ver</h4>';
      html += '<textarea id="replyText" placeholder="Müşteriye yazacağınız cevap...">' + esc(data.admin_reply || '') + '</textarea>';
      html += '<label><input type="checkbox" id="replySendEmail" /> Müşteriye e-posta ile gönder (e-posta adresi varsa)</label>';
      html += '<div><button type="button" class="btn-sm" id="replySubmitBtn">Cevabı Kaydet</button><span class="reply-status" id="replyStatus"></span></div></div>';
      document.getElementById('detailBody').innerHTML = html;
      document.getElementById('detailOverlay').classList.add('show');
      document.getElementById('replySubmitBtn').onclick = function() { submitReply(id); };
    }
    function submitReply(id) {
      var reply = document.getElementById('replyText').value.trim();
      var sendEmail = document.getElementById('replySendEmail').checked;
      var btn = document.getElementById('replySubmitBtn');
      var status = document.getElementById('replyStatus');
      if (!reply) { status.textContent = 'Lütfen cevap metni yazın.'; status.style.color = '#c00'; return; }
      btn.disabled = true;
      status.textContent = 'Kaydediliyor...';
      status.style.color = '';
      var fd = new FormData();
      fd.append('id', id);
      fd.append('reply', reply);
      fd.append('send_email', sendEmail ? '1' : '0');
      var csrf = document.getElementById('csrf_token');
      if (csrf) fd.append('_csrf_token', csrf.value);
      fetch('../api/admin-reply.php', { method: 'POST', body: fd })
        .then(function(r) { return r.json(); })
        .then(function(res) {
          status.textContent = res.message || (res.success ? 'Kaydedildi.' : 'Hata.');
          status.style.color = res.success ? '#0a0' : '#c00';
          if (res.success && currentDetailId === id) {
            currentDetailData.admin_reply = reply;
            currentDetailData.replied_at = new Date().toLocaleString('tr-TR');
          }
        })
        .catch(function() { status.textContent = 'Bağlantı hatası.'; status.style.color = '#c00'; })
        .finally(function() { btn.disabled = false; });
    }
    function closeDetail() {
      document.getElementById('detailOverlay').classList.remove('show');
      currentDetailId = null;
      currentDetailData = null;
    }
    document.getElementById('detailOverlay').addEventListener('click', function(e) {
      if (e.target === this) closeDetail();
    });

    // Admin sidebar drawer (mobil)
    (function() {
      var toggle = document.getElementById('adminSidebarToggle');
      var overlay = document.getElementById('adminSidebarOverlay');
      var drawer = document.getElementById('adminSidebarDrawer');
      var closeBtn = document.getElementById('adminSidebarClose');
      if (!toggle || !overlay || !drawer) return;

      function openDrawer() {
        document.body.classList.add('admin-drawer-open');
        overlay.setAttribute('aria-hidden', 'false');
        drawer.setAttribute('aria-hidden', 'false');
        toggle.setAttribute('aria-expanded', 'true');
      }
      function closeDrawer() {
        document.body.classList.remove('admin-drawer-open');
        overlay.setAttribute('aria-hidden', 'true');
        drawer.setAttribute('aria-hidden', 'true');
        toggle.setAttribute('aria-expanded', 'false');
      }
      function isMobile() {
        return (window.innerWidth || 1024) <= 992;
      }

      toggle.addEventListener('click', function() {
        if (!isMobile()) return;
        if (document.body.classList.contains('admin-drawer-open')) closeDrawer();
        else openDrawer();
      });
      overlay.addEventListener('click', closeDrawer);
      if (closeBtn) closeBtn.addEventListener('click', closeDrawer);
      document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeDrawer();
      });
      window.addEventListener('resize', function() {
        // desktop'a geçince drawer state'i temizle
        if (!isMobile()) closeDrawer();
      });

      // Drawer içindeki linke tıklayınca kapat
      drawer.addEventListener('click', function(e) {
        var a = e.target && e.target.closest && e.target.closest('a.admin-sidebar__link');
        if (a) closeDrawer();
      });
    })();

    // Talep listesi filtreleme ve silme
    (function() {
      var searchInput = document.getElementById('requestSearch');
      var dateFilter = document.getElementById('requestDateFilter');
      var csrf = document.getElementById('csrf_token');
      var headerTextNode = null;

      if (!searchInput && !dateFilter) return;

      var items = Array.prototype.slice.call(document.querySelectorAll('.item[data-request-id]'));

      function parseDate(str) {
        if (!str) return null;
        // 'YYYY-MM-DD HH:MM:SS' formatını Date'e çevir
        var parts = str.split(' ');
        if (parts.length < 1) return null;
        var d = parts[0].split('-');
        if (d.length !== 3) return null;
        var y = parseInt(d[0], 10),
            m = parseInt(d[1], 10) - 1,
            day = parseInt(d[2], 10);
        return new Date(y, m, day);
      }

      function applyFilter() {
        var q = (searchInput ? searchInput.value.toLowerCase() : '').trim();
        var days = dateFilter ? parseInt(dateFilter.value, 10) : NaN;
        var now = new Date();
        var visibleCount = 0;

        items.forEach(function(el) {
          var main = (el.getAttribute('data-main') || '').toLowerCase();
          var meta = (el.getAttribute('data-meta') || '').toLowerCase();
          var dateStr = el.getAttribute('data-date') || '';
          var dt = parseDate(dateStr);

          var textMatch = !q || main.indexOf(q) !== -1 || meta.indexOf(q) !== -1;
          var dateMatch = true;

          if (!isNaN(days) && days > 0 && dt instanceof Date && !isNaN(dt.getTime())) {
            var diffMs = now.getTime() - dt.getTime();
            var diffDays = diffMs / (1000 * 60 * 60 * 24);
            dateMatch = diffDays <= days;
          }

          var show = textMatch && dateMatch;
          el.style.display = show ? '' : 'none';
          if (show) visibleCount++;
        });

        // Toplam kayıt sayısını güncelle
        var headerSpan = document.querySelector('.card-header span');
        if (headerSpan) {
          headerSpan.textContent = '(Toplam ' + visibleCount + ' kayıt)';
        }
      }

      if (searchInput) {
        searchInput.addEventListener('input', function() {
          applyFilter();
        });
      }
      if (dateFilter) {
        dateFilter.addEventListener('change', function() {
          applyFilter();
        });
      }

      document.addEventListener('click', function(e) {
        var btn = e.target.closest('[data-delete-request]');
        if (!btn) return;
        var id = btn.getAttribute('data-delete-request');
        if (!id) return;
        if (!confirm('Bu talebi silmek istediğinize emin misiniz?')) {
          return;
        }
        btn.disabled = true;
        var fd = new FormData();
        fd.append('id', id);
        fd.append('action', 'delete');
        if (csrf) fd.append('_csrf_token', csrf.value);
        fetch('../api/talepler-admin.php', { method: 'POST', body: fd })
          .then(function(r) { return r.json(); })
          .then(function(res) {
            if (!res.success) {
              alert(res.message || 'Silinirken hata oluştu.');
              btn.disabled = false;
              return;
            }
            var item = btn.closest('.item[data-request-id]');
            if (item && item.parentNode) {
              item.parentNode.removeChild(item);
              // listeden de çıkar
              items = items.filter(function(el) { return el !== item; });
              applyFilter();
              if (!items.length) {
                var container = document.querySelector('.card');
                if (container) {
                  container.innerHTML = '<div class="empty">Henüz talep bulunmuyor.</div>';
                }
              }
            }
          })
          .catch(function() {
            alert('Bağlantı hatası.');
            btn.disabled = false;
          });
      });

      // İlk yüklemede filtreyi uygula (sayaç doğru başlasın)
      applyFilter();
    })();
    (function() {
      var f = document.getElementById('settingsForm');
      if (!f) return;
      f.addEventListener('submit', function(e) {
        e.preventDefault();
        var btn = document.getElementById('settingsBtn');
        var msg = document.getElementById('settingsMsg');
        btn.disabled = true;
        msg.textContent = 'Kaydediliyor...';
        msg.style.color = '';
        var fd = new FormData(f);
        fetch('../api/settings.php', { method: 'POST', body: fd })
          .then(function(r) { return r.json(); })
          .then(function(res) {
            msg.textContent = res.message || '';
            msg.style.color = res.success ? '#0a0' : '#c00';
          })
          .catch(function() { msg.textContent = 'Bağlantı hatası.'; msg.style.color = '#c00'; })
          .finally(function() { btn.disabled = false; });
      });
    })();

    // Kategori görselleri (ayarlar sekmesi)
    (function() {
      var list = document.getElementById('catImgList');
      if (!list) return;
      var msg = document.getElementById('catImgMsg');
      var csrf = document.getElementById('csrf_token');

      function setMsg(text, ok) {
        if (!msg) return;
        msg.textContent = text || '';
        msg.style.color = ok ? '#0a0' : '#c00';
      }

      function esc(s) {
        if (s == null || s === undefined) return '';
        var d = document.createElement('div');
        d.textContent = String(s);
        return d.innerHTML;
      }

      function fetchData() {
        setMsg('Yükleniyor...', true);
        fetch('../api/category-images-admin.php')
          .then(function(r){ return r.json(); })
          .then(function(res){
            if (!res.success) { setMsg(res.message || 'Yüklenemedi.', false); return; }
            render(res.categories || [], res.items || {});
            setMsg('', true);
          })
          .catch(function(){ setMsg('Yüklenemedi.', false); });
      }

      function render(categories, items) {
        list.innerHTML = '';
        if (!categories || !categories.length) {
          list.innerHTML = '<div style="color:#64748b;">Kategori bulunamadı (makineler verisi yok).</div>';
          return;
        }
        categories.forEach(function(c) {
          var key = String(c.key || '');
          var label = String(c.label || key);
          var count = String(c.count != null ? c.count : '');
          var path = items && items[key] ? String(items[key]) : '';
          var img = path ? ('<img src="../' + esc(path).replace(/ /g,'%20') + '" alt="" style="width:48px;height:48px;object-fit:cover;border-radius:10px;border:1px solid #e2e8f0;background:#fff;">') : '<div style="width:48px;height:48px;border-radius:10px;border:1px dashed #cbd5e1;background:#f8fafc;display:flex;align-items:center;justify-content:center;color:#94a3b8;font-weight:700;">—</div>';

          var row = document.createElement('div');
          row.style.display = 'grid';
          row.style.gridTemplateColumns = '56px minmax(0, 1fr)';
          row.style.gap = '12px';
          row.style.alignItems = 'start';
          row.style.padding = '12px';
          row.style.border = '1px solid #e2e8f0';
          row.style.borderRadius = '12px';
          row.style.background = '#fff';

          row.innerHTML =
            '<div>' + img + '</div>' +
            '<div style="min-width:0;">' +
              '<div style="display:flex;align-items:center;justify-content:space-between;gap:10px;flex-wrap:wrap;">' +
                '<div style="min-width:0;">' +
                  '<div style="font-weight:800;color:#0f172a;line-height:1.2;word-break:break-word;">' + esc(label) + '</div>' +
                  '<div style="color:#64748b;font-size:0.85rem;margin-top:2px;">key: <code>' + esc(key) + '</code>' + (count ? (' • ' + esc(count) + ' makine') : '') + '</div>' +
                '</div>' +
              '</div>' +
              '<div class="admin-actions-row" style="margin-top:10px;">' +
                '<input type="file" accept="image/*" data-file="' + esc(key) + '" style="flex:1;min-width:220px;">' +
                '<button type="button" class="btn-sm" data-save="' + esc(key) + '">Kaydet</button>' +
                '<button type="button" class="btn-sm secondary" data-del="' + esc(key) + '"' + (path ? '' : ' disabled') + '>Kaldır</button>' +
              '</div>' +
              (path ? ('<div style="margin-top:8px;color:#64748b;font-size:0.85rem;">Mevcut: <code>' + esc(path) + '</code></div>') : '') +
            '</div>';
          list.appendChild(row);
        });
      }

      function postForm(fd) {
        if (csrf) fd.append('_csrf_token', csrf.value);
        return fetch('../api/category-images-admin.php', { method:'POST', body: fd })
          .then(function(r){ return r.json(); });
      }

      list.addEventListener('click', function(e) {
        var saveBtn = e.target.closest && e.target.closest('[data-save]');
        var delBtn = e.target.closest && e.target.closest('[data-del]');
        if (!saveBtn && !delBtn) return;

        if (saveBtn) {
          var key = saveBtn.getAttribute('data-save');
          var input = list.querySelector('input[type="file"][data-file="' + CSS.escape(key) + '"]');
          if (!input || !input.files || !input.files[0]) {
            setMsg('Lütfen bir görsel seçin.', false);
            return;
          }
          var fd = new FormData();
          fd.append('action', 'save');
          fd.append('key', key);
          fd.append('file', input.files[0]);
          saveBtn.disabled = true;
          setMsg('Kaydediliyor...', true);
          postForm(fd)
            .then(function(res){
              if (!res.success) { setMsg(res.message || 'Hata.', false); return; }
              setMsg('Kaydedildi.', true);
              fetchData();
            })
            .catch(function(){ setMsg('Bağlantı hatası.', false); })
            .finally(function(){ saveBtn.disabled = false; });
        }

        if (delBtn) {
          var key2 = delBtn.getAttribute('data-del');
          if (!confirm('Bu kategori görselini kaldırmak istiyor musunuz?')) return;
          var fd2 = new FormData();
          fd2.append('action', 'delete');
          fd2.append('key', key2);
          delBtn.disabled = true;
          setMsg('Kaldırılıyor...', true);
          postForm(fd2)
            .then(function(res){
              if (!res.success) { setMsg(res.message || 'Hata.', false); return; }
              setMsg('Kaldırıldı.', true);
              fetchData();
            })
            .catch(function(){ setMsg('Bağlantı hatası.', false); })
            .finally(function(){ delBtn.disabled = false; });
        }
      });

      fetchData();
    })();

    // Makineler yönetimi
    (function() {
      var tbody = document.getElementById('machineTableBody');
      var form = document.getElementById('machineForm');
      if (!tbody || !form) return;

      var msg = document.getElementById('machineMsg');
      var saveBtn = document.getElementById('machineSaveBtn');
      var resetBtn = document.getElementById('machineResetBtn');
      var imgInfo = document.getElementById('machine_img_info');
      var imgExisting = document.getElementById('machine_img_existing');
      var imgInput = document.getElementById('machine_img');
      var imgPreviewWrap = document.getElementById('machine_img_preview_wrap');
      var imgPreview = document.getElementById('machine_img_preview');
      var searchInput = document.getElementById('machine_search');
      var searchCount = document.getElementById('machine_search_count');
      var tipFilterSelect = document.getElementById('machine_tip_filter');
      var editorAnchor = document.getElementById('machine-editor-anchor');
      var editContext = document.getElementById('machine_edit_context');
      var csrf = document.getElementById('csrf_token');

      var machineAllItems = [];
      var previewBlobUrl = null;

      function machineTitleUi(m) {
        if (!m) return '';
        var f = String(m.firma != null ? m.firma : '').trim();
        var t = String(m.tipModel != null ? m.tipModel : '').trim();
        var fl = f.toLowerCase();
        var tl = t.toLowerCase();
        if (!f) return t;
        if (!t || tl === fl) return f;
        if (tl.indexOf(fl + ' ') === 0) return t;
        return f + ' ' + t;
      }

      function setMessage(text, ok) {
        if (!msg) return;
        msg.textContent = text || '';
        msg.style.color = ok ? '#0a0' : '#c00';
      }

      function revokePreviewBlob() {
        if (previewBlobUrl) {
          try { URL.revokeObjectURL(previewBlobUrl); } catch (e) {}
          previewBlobUrl = null;
        }
      }

      function setPreviewFromServerPath(relPath) {
        revokePreviewBlob();
        if (!imgPreview || !imgPreviewWrap) return;
        if (relPath && String(relPath).trim()) {
          var enc = String(relPath).replace(/ /g, '%20');
          imgPreview.src = '../' + enc;
          imgPreviewWrap.classList.add('is-visible');
          imgPreviewWrap.setAttribute('aria-hidden', 'false');
        } else {
          imgPreview.removeAttribute('src');
          imgPreviewWrap.classList.remove('is-visible');
          imgPreviewWrap.setAttribute('aria-hidden', 'true');
        }
      }

      function scrollToEditor() {
        if (!editorAnchor) return;
        editorAnchor.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        setTimeout(function() {
          try { editorAnchor.focus({ preventScroll: true }); } catch (e) {}
          var tip = document.getElementById('machine_tip');
          if (tip) tip.focus();
        }, 350);
      }

      function updateFilenameHint() {
        var hint = document.getElementById('machine_img_filename_hint');
        var noEl = document.getElementById('machine_no');
        if (!hint || !noEl) return;
        var n = noEl.value.trim();
        if (!n) {
          var mid = document.getElementById('machine_id').value.trim();
          n = mid || 'NO';
        }
        hint.textContent = 'images/makineler/makine_' + n + '.jpg';
      }

      function rebuildTipFilter() {
        if (!tipFilterSelect) return;
        var prev = tipFilterSelect.value;
        var tips = [];
        var seen = {};
        machineAllItems.forEach(function(m) {
          var t = String(m.tip || '').trim();
          if (!t || seen[t]) return;
          seen[t] = true;
          tips.push(t);
        });
        tips.sort(function(a, b) { return a.localeCompare(b, 'tr'); });
        tipFilterSelect.innerHTML = '<option value="">Tüm kategoriler</option>';
        tips.forEach(function(t) {
          var o = document.createElement('option');
          o.value = t;
          o.textContent = t;
          tipFilterSelect.appendChild(o);
        });
        if (prev && tips.indexOf(prev) !== -1) tipFilterSelect.value = prev;
        else tipFilterSelect.value = '';
        var datalist = document.getElementById('machine_tip_suggestions');
        if (datalist) {
          datalist.innerHTML = '';
          tips.forEach(function(t) {
            var opt = document.createElement('option');
            opt.value = t;
            datalist.appendChild(opt);
          });
        }
      }

      function updateEditContext() {
        if (!editContext) return;
        var mid = document.getElementById('machine_id').value.trim();
        var firma = (document.getElementById('machine_firma') && document.getElementById('machine_firma').value) || '';
        var model = (document.getElementById('machine_tipModel') && document.getElementById('machine_tipModel').value) || '';
        if (mid) {
          editContext.classList.remove('is-new');
          editContext.textContent = 'Düzenlenen kayıt: ID #' + mid + (firma || model ? ' — ' + String(firma + ' ' + model).trim() : '') + '. Yüklediğiniz görsel bu makineye yazılır.';
        } else {
          editContext.classList.add('is-new');
          editContext.textContent = 'Yeni kayıt — Kaydet dediğinizde listede oluşur. Görsel, bu formdaki kayda gider.';
        }
      }

      function resetForm() {
        revokePreviewBlob();
        form.reset();
        document.getElementById('machine_id').value = '';
        var noEl = document.getElementById('machine_no');
        if (noEl) noEl.value = '';
        var techEl = document.getElementById('machine_teknik');
        if (techEl) techEl.value = '';
        if (imgExisting) imgExisting.value = '';
        if (imgInput) imgInput.value = '';
        if (imgInfo) imgInfo.textContent = '';
        setPreviewFromServerPath('');
        updateEditContext();
        updateFilenameHint();
        setMessage('', true);
      }

      function fillForm(m) {
        revokePreviewBlob();
        if (imgInput) imgInput.value = '';
        document.getElementById('machine_id').value = m.id || '';
        var noEl = document.getElementById('machine_no');
        if (noEl) noEl.value = m.no != null ? String(m.no) : '';
        document.getElementById('machine_tip').value = m.tip || '';
        document.getElementById('machine_firma').value = m.firma || '';
        document.getElementById('machine_tipModel').value = m.tipModel || '';
        document.getElementById('machine_modelYil').value = m.modelYil || '';
        document.getElementById('machine_guc').value = m.guc || '';
        document.getElementById('machine_gucBirim').value = m.gucBirim || '';
        document.getElementById('machine_kapasite').value = m.kapasite || '';
        document.getElementById('machine_saseSeriNo').value = m.saseSeriNo || '';
        document.getElementById('machine_motorSeriNo').value = m.motorSeriNo || '';
        document.getElementById('machine_motorMarka').value = m.motorMarka || '';
        document.getElementById('machine_motorTip').value = m.motorTip || '';
        var techEl = document.getElementById('machine_teknik');
        if (techEl) techEl.value = m.teknik || '';
        document.getElementById('machine_stok').checked = !!m.stok;
        var path = (m.img && String(m.img).trim()) ? String(m.img).trim() : '';
        if (imgExisting) imgExisting.value = path;
        if (imgInfo) {
          imgInfo.textContent = path ? ('Kayıtlı dosya: ' + path) : 'Henüz görsel yok — aşağıdan yükleyebilirsiniz.';
        }
        setPreviewFromServerPath(path);
        updateEditContext();
        updateFilenameHint();
      }

      function applyMachineFilter() {
        var tipSel = tipFilterSelect ? String(tipFilterSelect.value || '').trim() : '';
        var q = (searchInput && searchInput.value || '').trim().toLowerCase();
        var filtered = machineAllItems;
        filtered = filtered.filter(function(m) {
          if (tipSel && String(m.tip || '') !== tipSel) return false;
          return true;
        });
        if (q) {
          filtered = filtered.filter(function(m) {
            var blob = [m.id, m.no, m.tip, m.firma, m.tipModel, m.modelYil, m.guc, m.motorTip].map(function(x) {
              return String(x != null ? x : '').toLowerCase();
            }).join(' ');
            return blob.indexOf(q) !== -1;
          });
        }
        if (searchCount) {
          searchCount.textContent = machineAllItems.length
            ? (filtered.length + ' / ' + machineAllItems.length + ' makine')
            : '';
        }
        renderRows(filtered);
      }

      function renderRows(items) {
        var cardList = document.getElementById('machineCardList');
        var isNarrow = (window.innerWidth || 1024) <= 680;
        if (!machineAllItems.length) {
          tbody.innerHTML = '<tr><td colspan="9" style="padding:12px; text-align:center; color:#999;">Henüz makine eklenmemiş.</td></tr>';
          if (cardList) cardList.innerHTML = '<div class="empty" style="padding:16px;">Henüz makine eklenmemiş.</div>';
          return;
        }
        if (!items || !items.length) {
          tbody.innerHTML = '<tr><td colspan="9" style="padding:12px; text-align:center; color:#999;">Aramanıza uygun makine yok.</td></tr>';
          if (cardList) cardList.innerHTML = '<div class="empty" style="padding:16px;">Aramanıza uygun makine yok.</div>';
          return;
        }
        if (cardList) cardList.innerHTML = '';
        tbody.innerHTML = '';

        // Dar ekranda: kart listesi render et (yatay kaydırma ihtiyacını kaldır)
        if (isNarrow && cardList) {
          items.forEach(function(m) {
            var noDisp = (m.no != null && String(m.no).trim() !== '') ? String(m.no) : '—';
            var title = machineTitleUi(m) || (m.tip || '') || ('Makine #' + (m.id || ''));
            var imgHtml = (m.img && String(m.img).trim())
              ? '<div class="admin-card__img"><img src="../' + String(m.img).replace(/ /g, '%20') + '" alt="" loading="lazy"></div>'
              : '';
            var year = m.modelYil || '—';
            var power = (m.guc || '') ? (String(m.guc || '') + ' ' + String(m.gucBirim || '')).trim() : '—';
            var stok = m.stok ? 'Stokta' : 'Talebe göre';
            var tip = m.tip || '—';

            var el = document.createElement('article');
            el.className = 'admin-card';
            el.innerHTML =
              imgHtml +
              '<div class="admin-card__body">' +
                '<div class="admin-card__title">' + String(noDisp) + ' • ' + String(title) + '</div>' +
                '<div class="admin-card__meta">Tip: ' + String(tip) + ' • ID: ' + String(m.id || '') + '</div>' +
                '<div class="admin-card__grid">' +
                  '<div class="admin-card__kv"><div class="admin-card__k">Model Yılı</div><div class="admin-card__v">' + String(year) + '</div></div>' +
                  '<div class="admin-card__kv"><div class="admin-card__k">Güç</div><div class="admin-card__v">' + String(power || '—') + '</div></div>' +
                  '<div class="admin-card__kv"><div class="admin-card__k">Stok</div><div class="admin-card__v">' + String(stok) + '</div></div>' +
                '</div>' +
              '</div>' +
              '<div class="admin-card__actions">' +
                '<button type="button" class="btn-sm" data-edit="' + (m.id || '') + '">Düzenle</button>' +
                '<button type="button" class="btn-sm secondary" data-delete="' + (m.id || '') + '">Sil</button>' +
              '</div>';
            cardList.appendChild(el);
          });
          return;
        }

        items.forEach(function(m) {
          var imgPreviewCell = m.img
            ? '<img src="../' + String(m.img).replace(/ /g, '%20') + '" alt="" loading="lazy" style="width:56px; height:42px; object-fit:contain; border-radius:4px; background:#f1f5f9;">'
            : '-';
          var noDisp = (m.no != null && String(m.no).trim() !== '') ? String(m.no) : '—';
          var tr = document.createElement('tr');
          tr.className = 'admin-table-row-clickable';
          tr.dataset.rowId = String(m.id || '');
          tr.innerHTML =
            '<td style="padding:6px 8px; border-bottom:1px solid #f0f0f0; font-size:0.8rem; color:#999;">' + (m.id || '') + '</td>' +
            '<td style="padding:6px 8px; border-bottom:1px solid #f0f0f0; font-weight:600; color:#164a6e;">' + noDisp + '</td>' +
            '<td style="padding:6px 8px; border-bottom:1px solid #f0f0f0;">' + (m.tip || '') + '</td>' +
            '<td style="padding:6px 8px; border-bottom:1px solid #f0f0f0;">' + machineTitleUi(m) + '</td>' +
            '<td style="padding:6px 8px; border-bottom:1px solid #f0f0f0;">' + (m.modelYil || '') + '</td>' +
            '<td style="padding:6px 8px; border-bottom:1px solid #f0f0f0;">' + (m.guc || '') + ' ' + (m.gucBirim || '') + '</td>' +
            '<td style="padding:6px 8px; border-bottom:1px solid #f0f0f0;">' + (m.stok ? 'Stokta' : 'Talebe göre') + '</td>' +
            '<td style="padding:6px 8px; border-bottom:1px solid #f0f0f0;">' + imgPreviewCell + '</td>' +
            '<td class="admin-table-sticky-last" style="padding:6px 8px; border-bottom:1px solid #f0f0f0; text-align:right;">' +
              '<button type="button" class="btn-sm" data-edit="' + (m.id || '') + '">Düzenle</button> ' +
              '<button type="button" class="btn-sm secondary" data-delete="' + (m.id || '') + '">Sil</button>' +
            '</td>';
          tbody.appendChild(tr);
        });
      }

      function loadMachines() {
        fetch('../api/makineler-admin.php')
          .then(function(r) { return r.json(); })
          .then(function(res) {
            if (!res.success) {
              setMessage(res.message || 'Makineler yüklenemedi.', false);
              return;
            }
            machineAllItems = res.items || [];
            rebuildTipFilter();
            applyMachineFilter();
          })
          .catch(function() {
            setMessage('Makineler yüklenemedi.', false);
          });
      }

      if (imgInput) {
        imgInput.addEventListener('change', function() {
          revokePreviewBlob();
          var f = imgInput.files && imgInput.files[0];
          if (!f) {
            var cur = imgExisting ? imgExisting.value.trim() : '';
            setPreviewFromServerPath(cur);
            if (imgInfo) imgInfo.textContent = cur ? ('Kayıtlı dosya: ' + cur) : 'Henüz görsel yok.';
            return;
          }
          if (f.size > 12 * 1024 * 1024) {
            setMessage('Dosya 12 MB\'dan küçük olmalı.', false);
            imgInput.value = '';
            return;
          }
          previewBlobUrl = URL.createObjectURL(f);
          if (imgPreview && imgPreviewWrap) {
            imgPreview.src = previewBlobUrl;
            imgPreviewWrap.classList.add('is-visible');
            imgPreviewWrap.setAttribute('aria-hidden', 'false');
          }
          if (imgInfo) imgInfo.textContent = 'Seçilen: ' + f.name + ' (' + Math.round(f.size / 1024) + ' KB) — Kaydet ile yüklenecek.';
        });
      }

      tbody.addEventListener('click', function(e) {
        var t = e.target;
        var btnEdit = t && t.closest ? t.closest('[data-edit]') : null;
        var btnDel = t && t.closest ? t.closest('[data-delete]') : null;
        if (btnEdit && btnEdit.dataset && btnEdit.dataset.edit) {
          var id = btnEdit.dataset.edit;
          var m = machineAllItems.find(function(x) { return String(x.id) === String(id); });
          if (m) {
            fillForm(m);
            setMessage('Düzenleme modunda — alanları güncelleyip Kaydet\'e basın.', true);
            scrollToEditor();
          }
          return;
        } else if (btnDel && btnDel.dataset && btnDel.dataset.delete) {
          if (!confirm('Bu makineyi silmek istediğinize emin misiniz?')) return;
          var idd = btnDel.dataset.delete;
          var fd = new FormData();
          fd.append('action', 'delete');
          fd.append('id', idd);
          if (csrf) fd.append('_csrf_token', csrf.value);
          fetch('../api/makineler-admin.php', { method: 'POST', body: fd })
            .then(function(r) { return r.json(); })
            .then(function(res) {
              setMessage(res.message || (res.success ? 'Silindi.' : 'Silme hatası.'), !!res.success);
              if (res.success) {
                machineAllItems = res.items || [];
                rebuildTipFilter();
                applyMachineFilter();
                resetForm();
              }
            })
            .catch(function() { setMessage('Silme işlemi başarısız.', false); });
          return;
        }

        // Satırın herhangi bir yerine tıklayınca düzenle (mobil erişim)
        var tr = t && t.closest ? t.closest('tr.admin-table-row-clickable') : null;
        if (!tr) return;
        var rid = tr.getAttribute('data-row-id') || '';
        if (!rid) return;
        var mm = machineAllItems.find(function(x) { return String(x.id) === String(rid); });
        if (mm) {
          fillForm(mm);
          setMessage('Düzenleme modunda — alanları güncelleyip Kaydet\'e basın.', true);
          scrollToEditor();
        }
      });

      // Kart listesi aksiyonları (mobil)
      document.addEventListener('click', function(e) {
        var cardList = document.getElementById('machineCardList');
        if (!cardList || !cardList.contains(e.target)) return;
        var btnEdit = e.target && e.target.closest ? e.target.closest('[data-edit]') : null;
        var btnDel = e.target && e.target.closest ? e.target.closest('[data-delete]') : null;
        if (btnEdit && btnEdit.dataset && btnEdit.dataset.edit) {
          var id = btnEdit.dataset.edit;
          var m = machineAllItems.find(function(x) { return String(x.id) === String(id); });
          if (m) {
            fillForm(m);
            setMessage('Düzenleme modunda — alanları güncelleyip Kaydet\'e basın.', true);
            scrollToEditor();
          }
        } else if (btnDel && btnDel.dataset && btnDel.dataset.delete) {
          if (!confirm('Bu makineyi silmek istediğinize emin misiniz?')) return;
          var idd = btnDel.dataset.delete;
          var fd = new FormData();
          fd.append('action', 'delete');
          fd.append('id', idd);
          if (csrf) fd.append('_csrf_token', csrf.value);
          fetch('../api/makineler-admin.php', { method: 'POST', body: fd })
            .then(function(r) { return r.json(); })
            .then(function(res) {
              setMessage(res.message || (res.success ? 'Silindi.' : 'Silme hatası.'), !!res.success);
              if (res.success) {
                machineAllItems = res.items || [];
                rebuildTipFilter();
                applyMachineFilter();
                resetForm();
              }
            })
            .catch(function() { setMessage('Silme işlemi başarısız.', false); });
        }
      });

      form.addEventListener('submit', function(e) {
        e.preventDefault();
        saveBtn.disabled = true;
        setMessage('Kaydediliyor...', true);
        var fd = new FormData(form);
        fd.append('action', 'save');
        var midEl = document.getElementById('machine_id');
        var noEl2 = document.getElementById('machine_no');
        if (midEl) fd.set('id', midEl.value || '');
        if (noEl2) fd.set('no', noEl2.value || '');
        if (csrf) fd.append('_csrf_token', csrf.value);
        fetch('../api/makineler-admin.php', { method: 'POST', body: fd })
          .then(function(r) { return r.json(); })
          .then(function(res) {
            setMessage(res.message || (res.success ? 'Kaydedildi.' : 'Hata.'), !!res.success);
            if (res.success) {
              machineAllItems = res.items || [];
              rebuildTipFilter();
              applyMachineFilter();
              var sid = res.saved_id;
              if (sid) {
                var saved = machineAllItems.find(function(x) { return String(x.id) === String(sid); });
                if (saved) {
                  fillForm(saved);
                  if (imgInput) imgInput.value = '';
                  setMessage('Kaydedildi. Görsel yolu güncellendi.', true);
                }
              } else {
                resetForm();
              }
              scrollToEditor();
            }
          })
          .catch(function() { setMessage('Kayıt sırasında hata oluştu.', false); })
          .finally(function() { saveBtn.disabled = false; });
      });

      if (resetBtn) {
        resetBtn.addEventListener('click', function() {
          resetForm();
        });
        var newBtn = document.getElementById('machineNewBtn');
        if (newBtn) newBtn.addEventListener('click', function() {
          resetForm();
          scrollToEditor();
          var tip = document.getElementById('machine_tip');
          if (tip) tip.focus();
        });
      }

      // Mobilde hızlı erişim: "Forma git"
      var jumpBtn = document.getElementById('machineJumpToFormBtn');
      if (jumpBtn) {
        jumpBtn.addEventListener('click', function() {
          scrollToEditor();
        });
      }

      if (searchInput) {
        searchInput.addEventListener('input', function() {
          applyMachineFilter();
        });
      }
      if (tipFilterSelect) {
        tipFilterSelect.addEventListener('change', function() {
          applyMachineFilter();
        });
      }
      var machineNoInput = document.getElementById('machine_no');
      if (machineNoInput) {
        machineNoInput.addEventListener('input', updateFilenameHint);
      }

      ['machine_firma', 'machine_tipModel', 'machine_tip'].forEach(function (fid) {
        var el = document.getElementById(fid);
        if (el) el.addEventListener('input', updateEditContext);
      });

      loadMachines();
    })();

    // Saha Fotoğrafları yönetimi
    (function() {
      var tbody = document.getElementById('sahaTableBody');
      var form = document.getElementById('sahaForm');
      if (!tbody || !form) return;

      var msg = document.getElementById('sahaMsg');
      var saveBtn = document.getElementById('sahaSaveBtn');
      var resetBtn = document.getElementById('sahaResetBtn');
      var imgInfo = document.getElementById('saha_img_info');
      var csrf = document.getElementById('csrf_token');

      function setMessage(text, ok) {
        if (!msg) return;
        msg.textContent = text || '';
        msg.style.color = ok ? '#0a0' : '#c00';
      }

      function resetForm() {
        form.reset();
        document.getElementById('saha_id').value = '';
        document.getElementById('saha_sort_order').value = '0';
        document.getElementById('saha_img').value = '';
        if (imgInfo) imgInfo.textContent = '';
        setMessage('', true);
      }

      function fillForm(p) {
        document.getElementById('saha_id').value = p.id || '';
        document.getElementById('saha_title').value = p.title || '';
        document.getElementById('saha_description').value = p.description || '';
        document.getElementById('saha_sort_order').value = p.sort_order || 0;
        if (imgInfo) imgInfo.textContent = p.img ? ('Mevcut: ' + p.img) : 'Görsel yüklenmemiş.';
      }

      function scrollToSahaForm() {
        // formun kendisi sağ kolonda, mobilde aşağıda kalıyor; güvenli scroll
        form.scrollIntoView({ behavior: 'smooth', block: 'start' });
        setTimeout(function() {
          var t = document.getElementById('saha_title');
          if (t) t.focus();
        }, 250);
      }

      function esc(s) {
        if (s == null || s === undefined) return '';
        var d = document.createElement('div');
        d.textContent = String(s);
        return d.innerHTML;
      }
      function safeImg(src) {
        if (!src || typeof src !== 'string') return '';
        var t = src.trim().toLowerCase();
        if (t.indexOf('javascript:') === 0 || t.indexOf('data:') === 0 || t.indexOf('vbscript:') === 0) return '';
        return src;
      }
      function renderRows(items) {
        var cardList = document.getElementById('sahaCardList');
        var isNarrow = (window.innerWidth || 1024) <= 680;
        if (!items || !items.length) {
          tbody.innerHTML = '<tr><td colspan="5" style="padding:12px; text-align:center; color:#999;">Henüz fotoğraf eklenmemiş.</td></tr>';
          if (cardList) cardList.innerHTML = '<div class="empty" style="padding:16px;">Henüz fotoğraf eklenmemiş.</div>';
          return;
        }
        items.sort(function(a,b){ return (a.sort_order||0) - (b.sort_order||0); });
        tbody.innerHTML = '';
        if (cardList) cardList.innerHTML = '';

        if (isNarrow && cardList) {
          items.forEach(function(p) {
            var imgSrc = safeImg(p.img);
            var imgHtml = imgSrc
              ? '<div class="admin-card__img"><img src="../' + esc(imgSrc).replace(/ /g, '%20') + '" alt="" loading="lazy"></div>'
              : '';
            var title = esc(p.title || '—');
            var desc = esc(p.description || '');
            var id = esc(p.id || '');
            var order = esc(String(p.sort_order != null ? p.sort_order : 0));

            var el = document.createElement('article');
            el.className = 'admin-card';
            el.innerHTML =
              imgHtml +
              '<div class="admin-card__body">' +
                '<div class="admin-card__title">' + title + '</div>' +
                (desc ? '<div class="admin-card__meta">' + desc + '</div>' : '<div class="admin-card__meta">Açıklama yok</div>') +
                '<div class="admin-card__grid">' +
                  '<div class="admin-card__kv"><div class="admin-card__k">ID</div><div class="admin-card__v">' + id + '</div></div>' +
                  '<div class="admin-card__kv"><div class="admin-card__k">Sıra</div><div class="admin-card__v">' + order + '</div></div>' +
                '</div>' +
              '</div>' +
              '<div class="admin-card__actions">' +
                '<button type="button" class="btn-sm" data-edit="' + id + '">Düzenle</button>' +
                '<button type="button" class="btn-sm secondary" data-delete="' + id + '">Sil</button>' +
              '</div>';
            cardList.appendChild(el);
          });
          return;
        }

        items.forEach(function(p) {
          var imgSrc = safeImg(p.img);
          var imgPreview = imgSrc ? '<img src="../' + esc(imgSrc).replace(/ /g, '%20') + '" alt="" style="width:60px; height:40px; object-fit:cover; border-radius:4px;">' : '-';
          var tr = document.createElement('tr');
          tr.innerHTML =
            '<td style="padding:6px 8px; border-bottom:1px solid #f0f0f0; font-size:0.8rem; color:#999;">' + esc(p.id || '') + '</td>' +
            '<td style="padding:6px 8px; border-bottom:1px solid #f0f0f0;">' + esc(p.title || '') + '</td>' +
            '<td style="padding:6px 8px; border-bottom:1px solid #f0f0f0; max-width:180px; overflow:hidden; text-overflow:ellipsis;">' + esc(p.description || '') + '</td>' +
            '<td style="padding:6px 8px; border-bottom:1px solid #f0f0f0;">' + imgPreview + '</td>' +
            '<td style="padding:6px 8px; border-bottom:1px solid #f0f0f0; text-align:right;">' +
              '<button type="button" class="btn-sm" data-edit="' + esc(p.id || '') + '">Düzenle</button> ' +
              '<button type="button" class="btn-sm secondary" data-delete="' + esc(p.id || '') + '">Sil</button>' +
            '</td>';
          tbody.appendChild(tr);
        });
      }

      function loadSaha() {
        fetch('../api/saha-fotograflari-admin.php')
          .then(function(r) { return r.json(); })
          .then(function(res) {
            if (!res.success) {
              setMessage(res.message || 'Yüklenemedi.', false);
              return;
            }
            renderRows(res.items || []);
          })
          .catch(function() { setMessage('Yüklenemedi.', false); });
      }

      tbody.addEventListener('click', function(e) {
        var t = e.target;
        var btnEdit = t && t.closest ? t.closest('[data-edit]') : null;
        var btnDel = t && t.closest ? t.closest('[data-delete]') : null;
        if (btnEdit && btnEdit.dataset && btnEdit.dataset.edit) {
          var id = btnEdit.dataset.edit;
          fetch('../api/saha-fotograflari-admin.php')
            .then(function(r) { return r.json(); })
            .then(function(res) {
              if (!res.success || !Array.isArray(res.items)) return;
              var p = res.items.find(function(x) { return String(x.id) === String(id); });
              if (p) { fillForm(p); setMessage('Düzenleme modunda.', true); scrollToSahaForm(); }
            });
        } else if (btnDel && btnDel.dataset && btnDel.dataset.delete) {
          if (!confirm('Bu fotoğrafı silmek istediğinize emin misiniz?')) return;
          var fd = new FormData();
          fd.append('action', 'delete');
          fd.append('id', btnDel.dataset.delete);
          if (csrf) fd.append('_csrf_token', csrf.value);
          fetch('../api/saha-fotograflari-admin.php', { method: 'POST', body: fd })
            .then(function(r) { return r.json(); })
            .then(function(res) {
              setMessage(res.message || (res.success ? 'Silindi.' : 'Hata.'), !!res.success);
              if (res.success) { renderRows(res.items || []); resetForm(); }
            })
            .catch(function() { setMessage('Silme başarısız.', false); });
        }
      });

      // Kart listesi aksiyonları (mobil)
      document.addEventListener('click', function(e) {
        var cardList = document.getElementById('sahaCardList');
        if (!cardList || !cardList.contains(e.target)) return;
        var btnEdit = e.target && e.target.closest ? e.target.closest('[data-edit]') : null;
        var btnDel = e.target && e.target.closest ? e.target.closest('[data-delete]') : null;
        if (btnEdit && btnEdit.dataset && btnEdit.dataset.edit) {
          var id = btnEdit.dataset.edit;
          fetch('../api/saha-fotograflari-admin.php')
            .then(function(r) { return r.json(); })
            .then(function(res) {
              if (!res.success || !Array.isArray(res.items)) return;
              var p = res.items.find(function(x) { return String(x.id) === String(id); });
              if (p) { fillForm(p); setMessage('Düzenleme modunda.', true); scrollToSahaForm(); }
            });
        } else if (btnDel && btnDel.dataset && btnDel.dataset.delete) {
          if (!confirm('Bu fotoğrafı silmek istediğinize emin misiniz?')) return;
          var fd = new FormData();
          fd.append('action', 'delete');
          fd.append('id', btnDel.dataset.delete);
          if (csrf) fd.append('_csrf_token', csrf.value);
          fetch('../api/saha-fotograflari-admin.php', { method: 'POST', body: fd })
            .then(function(r) { return r.json(); })
            .then(function(res) {
              setMessage(res.message || (res.success ? 'Silindi.' : 'Hata.'), !!res.success);
              if (res.success) { renderRows(res.items || []); resetForm(); }
            })
            .catch(function() { setMessage('Silme başarısız.', false); });
        }
      });

      form.addEventListener('submit', function(e) {
        e.preventDefault();
        saveBtn.disabled = true;
        setMessage('Kaydediliyor...', true);
        var fd = new FormData(form);
        fd.append('action', 'save');
        var existingImg = (imgInfo && imgInfo.textContent.indexOf('Mevcut: ') === 0) ? imgInfo.textContent.replace('Mevcut: ', '') : '';
        fd.append('img_existing', existingImg);
        if (csrf) fd.append('_csrf_token', csrf.value);
        fetch('../api/saha-fotograflari-admin.php', { method: 'POST', body: fd })
          .then(function(r) { return r.json(); })
          .then(function(res) {
            setMessage(res.message || (res.success ? 'Kaydedildi.' : 'Hata.'), !!res.success);
            if (res.success) { renderRows(res.items || []); resetForm(); }
          })
          .catch(function() { setMessage('Kayıt hatası.', false); })
          .finally(function() { saveBtn.disabled = false; });
      });

      if (resetBtn) resetBtn.addEventListener('click', resetForm);
      var newBtn = document.getElementById('sahaNewBtn');
      if (newBtn) newBtn.addEventListener('click', function() {
        resetForm();
        scrollToSahaForm();
      });

      // Mobilde hızlı erişim: "Forma git"
      var jumpBtn = document.getElementById('sahaJumpToFormBtn');
      if (jumpBtn) {
        jumpBtn.addEventListener('click', function() {
          scrollToSahaForm();
        });
      }
      loadSaha();
    })();
  </script>
</body>
</html>
