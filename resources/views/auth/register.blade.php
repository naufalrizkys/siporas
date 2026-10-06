<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun – SIPORAS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        html, body {
            min-height: 100vh;
            font-family: 'Open Sans', sans-serif;
            background: #f8fafc;
            color: #111827;
            display: flex;
            flex-direction: column;
        }
    </style>
</head>
<body>


{{-- Form --}}
<div style="flex:1;display:flex;align-items:center;justify-content:center;padding:36px 16px;">
    <div style="background:#fff;border:1.5px solid #e2e8f0;border-radius:16px;padding:36px 40px;width:100%;max-width:480px;box-shadow:0 8px 30px rgba(0,0,0,0.06);">

        {{-- Icon + Judul --}}
        <div style="text-align:center;margin-bottom:28px;">
            <div style="width:72px;height:72px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;">
                <img src="{{ asset('images/logo-grobogan.png') }}" alt="Logo Kabupaten Grobogan"
                     style="width:72px;height:72px;object-fit:contain;">
            </div>
            <h1 style="font-size:22px;font-weight:800;color:#111827;margin-bottom:4px;">Daftar Akun</h1>
            <p style="font-size:13px;color:#6b7280;">Buat akun untuk mengakses layanan SIPORAS</p>
        </div>

        {{-- Error --}}
        @if($errors->any())
        <div style="background:#fff7f7;border:1.5px solid #fecaca;border-radius:10px;padding:12px 16px;margin-bottom:20px;font-size:13px;color:#991b1b;display:flex;align-items:flex-start;gap:10px;">
            <i class="fas fa-exclamation-triangle" style="margin-top:2px;flex-shrink:0;"></i>
            <div>
                <strong style="display:block;margin-bottom:2px;">Terdapat kesalahan:</strong>
                @foreach($errors->all() as $error)
                    <div>• {{ $error }}</div>
                @endforeach
            </div>
        </div>
        @endif

        <form method="POST" action="{{ route('register.post') }}">
            @csrf

            {{-- Nama Lengkap --}}
            <div style="margin-bottom:16px;">
                <label style="display:block;font-size:11.5px;font-weight:700;color:#374151;text-transform:uppercase;letter-spacing:.04em;margin-bottom:5px;">
                    Nama Lengkap <span style="color:#dc2626;">*</span>
                </label>
                <div style="position:relative;">
                    <i class="fas fa-user" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#9ca3af;font-size:13px;"></i>
                    <input type="text" name="name" value="{{ old('name') }}" required autofocus
                           placeholder="Contoh: Ahmad Fauzi"
                           style="width:100%;border:1.5px solid {{ $errors->has('name') ? '#fca5a5' : '#d1d5db' }};border-radius:8px;padding:10px 12px 10px 36px;font-size:13px;font-family:'Open Sans',sans-serif;color:#111827;outline:none;background:#fff;"
                           onfocus="this.style.borderColor='#991b1b'" onblur="this.style.borderColor='#d1d5db'">
                </div>
            </div>

            {{-- Email --}}
            <div style="margin-bottom:16px;">
                <label style="display:block;font-size:11.5px;font-weight:700;color:#374151;text-transform:uppercase;letter-spacing:.04em;margin-bottom:5px;">
                    Email <span style="color:#dc2626;">*</span>
                </label>
                <div style="position:relative;">
                    <i class="fas fa-envelope" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#9ca3af;font-size:13px;"></i>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           placeholder="nama@email.com"
                           style="width:100%;border:1.5px solid {{ $errors->has('email') ? '#fca5a5' : '#d1d5db' }};border-radius:8px;padding:10px 12px 10px 36px;font-size:13px;font-family:'Open Sans',sans-serif;color:#111827;outline:none;background:#fff;"
                           onfocus="this.style.borderColor='#991b1b'" onblur="this.style.borderColor='#d1d5db'">
                </div>
                <p style="font-size:11.5px;color:#6b7280;margin-top:5px;display:flex;align-items:center;gap:4px;">
                    <i class="fas fa-info-circle" style="color:#9ca3af;font-size:11px;"></i>
                    Pastikan email aktif — notifikasi status pengajuan akan dikirim ke email ini.
                </p>
            </div>

            {{-- Password --}}
            <div style="margin-bottom:16px;">
                <label style="display:block;font-size:11.5px;font-weight:700;color:#374151;text-transform:uppercase;letter-spacing:.04em;margin-bottom:5px;">
                    Password <span style="color:#dc2626;">*</span>
                </label>
                <div style="position:relative;">
                    <i class="fas fa-lock" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#9ca3af;font-size:13px;"></i>
                    <input type="password" name="password" id="pwd-input" required
                           placeholder="Minimal 8 karakter"
                           style="width:100%;border:1.5px solid {{ $errors->has('password') ? '#fca5a5' : '#d1d5db' }};border-radius:8px;padding:10px 40px 10px 36px;font-size:13px;font-family:'Open Sans',sans-serif;color:#111827;outline:none;background:#fff;"
                           onfocus="this.style.borderColor='#991b1b'" onblur="this.style.borderColor='#d1d5db'">
                    <button type="button" onclick="togglePwd('pwd-input','pwd-eye')"
                            style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#9ca3af;font-size:13px;padding:0;">
                        <i class="fas fa-eye" id="pwd-eye"></i>
                    </button>
                </div>
            </div>

            {{-- Konfirmasi Password --}}
            <div style="margin-bottom:24px;">
                <label style="display:block;font-size:11.5px;font-weight:700;color:#374151;text-transform:uppercase;letter-spacing:.04em;margin-bottom:5px;">
                    Konfirmasi Password <span style="color:#dc2626;">*</span>
                </label>
                <div style="position:relative;">
                    <i class="fas fa-lock" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#9ca3af;font-size:13px;"></i>
                    <input type="password" name="password_confirmation" id="pwd-conf-input" required
                           placeholder="Ulangi password"
                           style="width:100%;border:1.5px solid #d1d5db;border-radius:8px;padding:10px 40px 10px 36px;font-size:13px;font-family:'Open Sans',sans-serif;color:#111827;outline:none;background:#fff;"
                           onfocus="this.style.borderColor='#991b1b'" onblur="this.style.borderColor='#d1d5db'">
                    <button type="button" onclick="togglePwd('pwd-conf-input','pwd-conf-eye')"
                            style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#9ca3af;font-size:13px;padding:0;">
                        <i class="fas fa-eye" id="pwd-conf-eye"></i>
                    </button>
                </div>
            </div>

            {{-- Tombol Daftar --}}
            <button type="submit"
                    style="width:100%;background:#991b1b;color:#fff;font-weight:800;font-size:14.5px;padding:13px;border-radius:10px;border:none;cursor:pointer;font-family:'Open Sans',sans-serif;display:flex;align-items:center;justify-content:center;gap:10px;box-shadow:0 4px 14px rgba(153,27,27,0.25);"
                    onmouseover="this.style.background='#7f1d1d'" onmouseout="this.style.background='#991b1b'">
                <i class="fas fa-user-check"></i> Daftar Akun
            </button>
        </form>

        {{-- Divider Google --}}
        <div style="display:flex;align-items:center;gap:12px;margin:20px 0;">
            <div style="flex:1;height:1px;background:#e5e7eb;"></div>
            <span style="font-size:11.5px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.05em;">atau</span>
            <div style="flex:1;height:1px;background:#e5e7eb;"></div>
        </div>

        {{-- Google --}}
        <a href="{{ route('auth.google') }}"
           style="width:100%;background:#fff;color:#374151;font-weight:700;font-size:13.5px;padding:11px;border-radius:8px;border:1.5px solid #d1d5db;cursor:pointer;font-family:'Open Sans',sans-serif;display:flex;align-items:center;justify-content:center;gap:10px;text-decoration:none;"
           onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='#fff'">
            <svg width="18" height="18" viewBox="0 0 24 24">
                <path fill="#4285F4" d="M23.745 12.27c0-.7-.06-1.4-.19-2.07H12v4.51h6.6c-.29 1.52-1.14 2.82-2.4 3.68v3.05h3.88c2.27-2.09 3.665-5.17 3.665-9.17z"/>
                <path fill="#34A853" d="M12 24c3.24 0 5.95-1.08 7.93-2.91l-3.88-3.05c-1.08.72-2.45 1.16-4.05 1.16-3.12 0-5.77-2.11-6.72-4.96H1.29v3.15C3.26 21.3 7.31 24 12 24z"/>
                <path fill="#FBBC05" d="M5.28 14.24c-.25-.72-.38-1.49-.38-2.24s.13-1.52.38-2.24V6.61H1.29C.47 8.24 0 10.06 0 12s.47 3.76 1.29 5.39l3.99-3.15z"/>
                <path fill="#EA4335" d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C17.95 1.19 15.24 0 12 0 7.31 0 3.26 2.7 1.29 6.61l3.99 3.15c.95-2.85 3.6-4.96 6.72-4.96z"/>
            </svg>
            Daftar dengan Google
        </a>

        <div style="border-top:1.5px solid #f3f4f6;margin:20px 0;"></div>

        <div style="text-align:center;font-size:13px;color:#4b5563;">
            Sudah punya akun?
            <a href="{{ route('login') }}" style="color:#111827;font-weight:800;text-decoration:none;margin-left:4px;">
                Masuk di sini <i class="fas fa-arrow-right" style="font-size:11px;"></i>
            </a>
        </div>
    </div>
</div>

<script>
    function togglePwd(inputId, eyeId) {
        const input = document.getElementById(inputId);
        const eye   = document.getElementById(eyeId);
        if (input.type === 'password') {
            input.type = 'text';
            eye.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            input.type = 'password';
            eye.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }
</script>
</body>
</html>
