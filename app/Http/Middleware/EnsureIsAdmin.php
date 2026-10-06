<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Belum login → ke beranda (bukan langsung ke /login)
        if (! Auth::check()) {
            return redirect()->route('home')
                ->with('error', 'Silakan login melalui halaman beranda untuk mengakses panel admin.');
        }

        // Sudah login tapi bukan admin → ke beranda
        if (! Auth::user()->isAdmin()) {
            return redirect()->route('home')
                ->with('error', 'Anda tidak memiliki akses ke halaman administrator.');
        }

        // Auto logout admin setelah 5 menit (300 detik) tidak aktif / meninggalkan halaman
        $lastActivity = session('admin_last_activity');
        $currentTime = time();
        $timeoutDuration = 300; // 5 menit

        if ($lastActivity && ($currentTime - $lastActivity > $timeoutDuration)) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->with('error', 'Sesi login admin Anda telah berakhir karena tidak ada aktivitas selama lebih dari 5 menit. Silakan login kembali.');
        }

        session(['admin_last_activity' => $currentTime]);

        return $next($request);
    }
}
