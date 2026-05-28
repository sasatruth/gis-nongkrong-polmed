<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login · GIS Nongkrong Polmed</title>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{
    --br:#7A4E2D;--cf:#A97142;--cr:#F8EFE3;--dk:#2B1B12;
    --gd:#D4A017;--sf:#EDE0D0;
}
body{
    font-family:'DM Sans',sans-serif;
    min-height:100vh;
    display:flex;align-items:center;justify-content:center;
    background:#0f0804;
    overflow:hidden;
    position:relative;
}
/* Animated grain background */
body::before{
    content:'';
    position:fixed;inset:0;
    background:
        radial-gradient(ellipse 80% 60% at 20% 40%, rgba(122,78,45,.35) 0%, transparent 60%),
        radial-gradient(ellipse 60% 80% at 80% 20%, rgba(169,113,66,.2) 0%, transparent 50%),
        radial-gradient(ellipse 40% 40% at 50% 90%, rgba(43,27,18,.8) 0%, transparent 60%);
    z-index:0;
}
/* Floating coffee cups */
.float-bg{
    position:fixed;inset:0;z-index:0;overflow:hidden;pointer-events:none;
}
.float-bg span{
    position:absolute;font-size:clamp(40px,6vw,90px);opacity:.04;
    animation:floatUp 18s linear infinite;
}
.float-bg span:nth-child(1){left:5%;animation-delay:0s;font-size:80px;}
.float-bg span:nth-child(2){left:25%;animation-delay:4s;font-size:50px;}
.float-bg span:nth-child(3){left:50%;animation-delay:8s;font-size:70px;}
.float-bg span:nth-child(4){left:75%;animation-delay:2s;font-size:60px;}
.float-bg span:nth-child(5){left:90%;animation-delay:12s;font-size:45px;}
@keyframes floatUp{
    0%{transform:translateY(110vh) rotate(0deg);opacity:0}
    10%{opacity:.06}90%{opacity:.06}
    100%{transform:translateY(-20vh) rotate(360deg);opacity:0}
}
/* Card */
.login-wrap{
    position:relative;z-index:1;
    width:100%;max-width:420px;
    padding:1.5rem;
}
.login-card{
    background:rgba(255,255,255,.04);
    backdrop-filter:blur(24px);
    border:1px solid rgba(255,255,255,.1);
    border-radius:28px;
    padding:44px 40px 40px;
    box-shadow:0 32px 64px rgba(0,0,0,.5),inset 0 1px 0 rgba(255,255,255,.1);
    animation:slideUp .6s cubic-bezier(.16,1,.3,1) both;
}
@keyframes slideUp{from{opacity:0;transform:translateY(30px)}to{opacity:1;transform:translateY(0)}}
.brand{
    text-align:center;
    margin-bottom:36px;
}
.brand-icon{
    width:64px;height:64px;
    background:linear-gradient(135deg,var(--cf),var(--br));
    border-radius:20px;
    display:flex;align-items:center;justify-content:center;
    font-size:28px;
    margin:0 auto 16px;
    box-shadow:0 8px 24px rgba(122,78,45,.4);
}
.brand h1{
    font-family:'Syne',sans-serif;
    font-size:1.5rem;font-weight:800;
    color:#fff;
    letter-spacing:-.5px;
    margin-bottom:4px;
}
.brand p{
    font-size:.82rem;color:rgba(255,255,255,.4);
    font-weight:300;
}
/* Alert */
.alert-err{
    background:rgba(220,53,69,.15);
    border:1px solid rgba(220,53,69,.3);
    color:#ff8a8a;
    border-radius:12px;
    padding:12px 16px;
    font-size:.83rem;
    margin-bottom:20px;
    display:flex;align-items:center;gap:8px;
}
/* Form */
.form-group{
    margin-bottom:18px;
}
.form-group label{
    display:block;
    font-size:.75rem;font-weight:500;
    color:rgba(255,255,255,.5);
    text-transform:uppercase;letter-spacing:.6px;
    margin-bottom:8px;
}
.input-wrap{
    position:relative;
}
.input-wrap input{
    width:100%;
    padding:14px 16px 14px 44px;
    background:rgba(255,255,255,.07);
    border:1.5px solid rgba(255,255,255,.1);
    border-radius:14px;
    color:#fff;
    font-family:'DM Sans',sans-serif;
    font-size:.9rem;
    outline:none;
    transition:all .2s;
}
.input-wrap input::placeholder{color:rgba(255,255,255,.25)}
.input-wrap input:focus{
    background:rgba(255,255,255,.1);
    border-color:var(--cf);
    box-shadow:0 0 0 4px rgba(169,113,66,.15);
}
.input-icon{
    position:absolute;left:14px;top:50%;transform:translateY(-50%);
    font-size:1rem;pointer-events:none;
}
.btn-login{
    width:100%;
    padding:15px;
    background:linear-gradient(135deg,var(--cf) 0%,var(--br) 100%);
    color:#fff;
    border:none;
    border-radius:14px;
    font-family:'Syne',sans-serif;
    font-size:.95rem;font-weight:700;
    letter-spacing:.3px;
    cursor:pointer;
    margin-top:8px;
    transition:all .2s;
    box-shadow:0 4px 16px rgba(122,78,45,.4);
    position:relative;overflow:hidden;
}
.btn-login::after{
    content:'';
    position:absolute;inset:0;
    background:linear-gradient(rgba(255,255,255,.15),transparent);
    border-radius:14px;
}
.btn-login:hover{
    transform:translateY(-2px);
    box-shadow:0 8px 24px rgba(122,78,45,.5);
}
.btn-login:active{transform:translateY(0)}
.back-link{
    text-align:center;
    margin-top:20px;
    font-size:.78rem;
    color:rgba(255,255,255,.3);
}
.back-link a{color:var(--cf);text-decoration:none;}
.back-link a:hover{text-decoration:underline;}
</style>
</head>
<body>
<div class="float-bg">
    <span>☕</span><span>🍵</span><span>☕</span><span>🫖</span><span>☕</span>
</div>
<div class="login-wrap">
    <div class="login-card">
        <div class="brand">
            <div class="brand-icon">☕</div>
            <h1>GIS Nongkrong</h1>
            <p>Admin Dashboard · Politeknik Negeri Medan</p>
        </div>

        <?php if (session()->getFlashdata('error')): ?>
        <div class="alert-err">
            ⚠️ <?= esc(session()->getFlashdata('error')) ?>
        </div>
        <?php endif; ?>

        <form action="/admin/login/process" method="POST">
            <?= csrf_field() ?>
            <div class="form-group">
                <label>Username</label>
                <div class="input-wrap">
                    <span class="input-icon">👤</span>
                    <input type="text" name="username"
                           value="<?= esc(old('username')) ?>"
                           placeholder="Masukkan username"
                           autocomplete="username" required>
                </div>
            </div>
            <div class="form-group">
                <label>Password</label>
                <div class="input-wrap">
                    <span class="input-icon">🔒</span>
                    <input type="password" name="password"
                           placeholder="Masukkan password"
                           autocomplete="current-password" required>
                </div>
            </div>
            <button type="submit" class="btn-login">Masuk ke Dashboard →</button>
        </form>
        <div class="back-link">
            <a href="/">← Kembali ke Beranda</a>
        </div>
    </div>
</div>
</body>
</html>