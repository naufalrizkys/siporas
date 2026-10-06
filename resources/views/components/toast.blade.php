{{-- Toast Notification Component --}}
{{-- Usage: <x-toast /> --}}

@if(session('success') || session('error'))
<div id="toast-notif"
     style="
        position:fixed;top:20px;right:20px;z-index:99999;
        display:flex;align-items:center;gap:12px;
        background:#fff;border-radius:12px;
        padding:14px 18px;
        box-shadow:0 8px 32px rgba(0,0,0,.15),0 2px 8px rgba(0,0,0,.08);
        border-left:4px solid {{ session('error') ? '#ef4444' : '#16a34a' }};
        min-width:280px;max-width:380px;
        animation:toastIn .35s cubic-bezier(.21,1.02,.73,1) forwards;
        font-family:'Inter','Open Sans',sans-serif;
     ">
    <div style="width:36px;height:36px;border-radius:50%;background:{{ session('error') ? '#fef2f2' : '#f0fdf4' }};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
        @if(session('error'))
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>
        </svg>
        @else
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="20 6 9 17 4 12"/>
        </svg>
        @endif
    </div>
    <div style="flex:1;min-width:0;">
        <div style="font-size:13px;font-weight:700;color:{{ session('error') ? '#991b1b' : '#166534' }};margin-bottom:1px;">
            {{ session('error') ? 'Terjadi Kesalahan' : 'Berhasil!' }}
        </div>
        <div style="font-size:12px;color:#6b7280;line-height:1.4;">
            {{ session('success') ?? session('error') }}
        </div>
    </div>
    <button onclick="dismissToast()"
        style="background:none;border:none;cursor:pointer;color:#9ca3af;padding:0;line-height:1;font-size:16px;flex-shrink:0;">
        &times;
    </button>
</div>

<style>
@keyframes toastIn {
    from { opacity:0; transform:translateX(60px) scale(.95); }
    to   { opacity:1; transform:translateX(0) scale(1); }
}
@keyframes toastOut {
    from { opacity:1; transform:translateX(0) scale(1); }
    to   { opacity:0; transform:translateX(60px) scale(.95); }
}
</style>

<script>
(function() {
    function dismissToast() {
        const t = document.getElementById('toast-notif');
        if (!t) return;
        t.style.animation = 'toastOut .3s ease forwards';
        setTimeout(() => t.remove(), 300);
    }
    window.dismissToast = dismissToast;
    // Auto dismiss setelah 3 detik
    setTimeout(dismissToast, 3000);
})();
</script>
@endif
