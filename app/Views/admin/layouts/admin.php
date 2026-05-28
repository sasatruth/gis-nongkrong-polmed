<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $pageTitle ?? 'Admin' ?> · GIS Nongkrong Polmed</title>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{
    --br:#7A4E2D;--cf:#A97142;--cr:#F8EFE3;--dk:#2B1B12;
    --gd:#D4A017;--sf:#EDE0D0;
    --sidebar:240px;
    --topbar:64px;
}
body{font-family:'DM Sans',sans-serif;background:#f4ede4;color:var(--dk);min-height:100vh;}

/* ── Sidebar ── */
.sidebar{
    position:fixed;top:0;left:0;bottom:0;width:var(--sidebar);
    background:var(--dk);
    display:flex;flex-direction:column;
    z-index:100;
    transition:transform .3s;
}
.sidebar-brand{
    padding:20px 22px 16px;
    border-bottom:1px solid rgba(255,255,255,.07);
}
.sidebar-brand .logo-icon{
    width:40px;height:40px;
    background:linear-gradient(135deg,var(--cf),var(--br));
    border-radius:12px;
    display:flex;align-items:center;justify-content:center;
    font-size:18px;margin-bottom:10px;
}
.sidebar-brand h2{
    font-family:'Syne',sans-serif;
    font-size:1rem;font-weight:800;color:#fff;
    letter-spacing:-.3px;line-height:1.2;
}
.sidebar-brand span{font-size:.7rem;color:rgba(255,255,255,.3);font-weight:300;}
.sidebar-nav{
    flex:1;overflow-y:auto;
    padding:16px 12px;
    display:flex;flex-direction:column;gap:2px;
}
.nav-label{
    font-size:.62rem;font-weight:700;color:rgba(255,255,255,.25);
    text-transform:uppercase;letter-spacing:.8px;
    padding:14px 10px 6px;
}
.nav-item{
    display:flex;align-items:center;gap:10px;
    padding:10px 12px;
    border-radius:10px;
    color:rgba(255,255,255,.55);
    text-decoration:none;
    font-size:.85rem;font-weight:400;
    transition:all .15s;
}
.nav-item:hover{background:rgba(255,255,255,.06);color:rgba(255,255,255,.9);}
.nav-item.active{
    background:rgba(169,113,66,.2);
    color:#fff;
    font-weight:500;
}
.nav-item.active::before{
    content:'';
    position:absolute;left:0;
    width:3px;height:34px;
    background:var(--cf);
    border-radius:0 4px 4px 0;
}
.nav-item{position:relative;}
.nav-item i{font-size:1rem;width:18px;text-align:center;}
.sidebar-footer{
    padding:16px;
    border-top:1px solid rgba(255,255,255,.07);
}
.admin-chip{
    display:flex;align-items:center;gap:10px;
    padding:10px 12px;
    background:rgba(255,255,255,.05);
    border-radius:12px;
    margin-bottom:8px;
}
.admin-avatar{
    width:34px;height:34px;
    background:linear-gradient(135deg,var(--cf),var(--br));
    border-radius:10px;
    display:flex;align-items:center;justify-content:center;
    font-size:14px;flex-shrink:0;
}
.admin-chip-name{font-size:.8rem;font-weight:600;color:#fff;line-height:1.2;}
.admin-chip-role{font-size:.68rem;color:rgba(255,255,255,.35);}
.btn-logout{
    display:flex;align-items:center;justify-content:center;gap:6px;
    width:100%;padding:9px;
    background:rgba(220,53,69,.15);
    border:1px solid rgba(220,53,69,.25);
    color:#ff8a8a;
    border-radius:10px;
    font-size:.8rem;font-weight:500;
    text-decoration:none;
    transition:all .15s;
    cursor:pointer;
}
.btn-logout:hover{background:rgba(220,53,69,.25);color:#ff6b6b;}

/* ── Main ── */
.main-wrap{
    margin-left:var(--sidebar);
    min-height:100vh;
    display:flex;flex-direction:column;
}
.topbar{
    height:var(--topbar);
    background:#fff;
    border-bottom:1px solid #e8d5c0;
    display:flex;align-items:center;
    padding:0 28px;
    gap:16px;
    position:sticky;top:0;z-index:50;
}
.topbar-title{
    font-family:'Syne',sans-serif;
    font-size:1rem;font-weight:700;color:var(--dk);
    flex:1;
}
.topbar-right{display:flex;align-items:center;gap:10px;}
.btn-view-site{
    display:flex;align-items:center;gap:6px;
    padding:8px 16px;
    background:var(--sf);
    color:var(--br);
    border-radius:10px;
    font-size:.8rem;font-weight:600;
    text-decoration:none;
    transition:all .15s;
    border:none;cursor:pointer;
}
.btn-view-site:hover{background:#e0cdb8;color:var(--br);}
.page-content{
    flex:1;
    padding:28px;
}

/* ── Flash messages ── */
.flash{
    border-radius:12px;
    padding:13px 18px;
    margin-bottom:20px;
    font-size:.85rem;
    display:flex;align-items:center;gap:10px;
    animation:fadeIn .3s ease;
}
@keyframes fadeIn{from{opacity:0;transform:translateY(-8px)}to{opacity:1;transform:none}}
.flash-success{background:#d4edda;color:#1a6e35;border:1px solid #b8dfc6;}
.flash-error{background:#fde8ea;color:#9b1a2a;border:1px solid #f5c2c7;}
</style>
</head>
<body>
<!-- ── SIDEBAR ── -->
<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="logo-icon">☕</div>
        <h2>GIS Nongkrong</h2>
        <span>Admin Panel · Polmed</span>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-label">Menu Utama</div>
        <a href="/admin" class="nav-item <?= uri_string() === 'admin' ? 'active' : '' ?>">
            <i class="bi bi-grid-1x2-fill"></i> Dashboard
        </a>
        <a href="/admin/tempat" class="nav-item <?= str_starts_with(uri_string(), 'admin/tempat') ? 'active' : '' ?>">
            <i class="bi bi-geo-alt-fill"></i> Tempat Nongkrong
        </a>
        <div class="nav-label">Lihat Situs</div>
        <a href="/" target="_blank" class="nav-item">
            <i class="bi bi-house-fill"></i> Beranda
        </a>
        <a href="/map" target="_blank" class="nav-item">
            <i class="bi bi-map-fill"></i> Peta GIS
        </a>
    </nav>
    <div class="sidebar-footer">
        <div class="admin-chip">
            <div class="admin-avatar">👤</div>
            <div>
                <div class="admin-chip-name"><?= esc(session()->get('admin_nama') ?? 'Admin') ?></div>
                <div class="admin-chip-role"><?= esc(session()->get('admin_username') ?? '') ?></div>
            </div>
        </div>
        <a href="/admin/logout" class="btn-logout">
            <i class="bi bi-box-arrow-right"></i> Logout
        </a>
    </div>
</aside>

<!-- ── MAIN ── -->
<div class="main-wrap">
    <header class="topbar">
        <div class="topbar-title"><?= $pageTitle ?? 'Dashboard' ?></div>
        <div class="topbar-right">
            <a href="/" target="_blank" class="btn-view-site">
                <i class="bi bi-box-arrow-up-right"></i> Lihat Situs
            </a>
        </div>
    </header>
    <main class="page-content">
        <?php if (session()->getFlashdata('success')): ?>
        <div class="flash flash-success">✅ <?= esc(session()->getFlashdata('success')) ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
        <div class="flash flash-error">⚠️ <?= esc(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>
        <?= $this->renderSection('content') ?>
    </main>
</div>
</body>
</html>