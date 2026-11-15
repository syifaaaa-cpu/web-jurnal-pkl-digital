<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeadersMiddleware
{
    /**
     * Handle an incoming request and attach cybersecurity defensive headers.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // 1. Anti-Clickjacking: Melarang penanaman halaman ke dalam iframe domain lain
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // 2. Anti-MIME Sniffing: Memaksa browser mematuhi tipe konten resmi
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // 3. Anti-XSS Filter untuk browser pendukung
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // 4. Referrer Policy: Menjaga kerahasiaan parameter query URL saat navigasi luar
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // 5. Anti-MITM: HTTP Strict Transport Security (HSTS)
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');

        // 6. Content Security Policy (CSP): Membatasi sumber skrip, gaya, font, gambar, dan frame
        $cspPolicy = "default-src 'self'; "
            ."script-src 'self' 'unsafe-inline' https://cdn.tailwindcss.com https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://unpkg.com; "
            ."style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdnjs.cloudflare.com; "
            ."font-src 'self' https://fonts.gstatic.com https://cdnjs.cloudflare.com; "
            ."img-src 'self' data: https:; "
            ."connect-src 'self' https://cdn.tailwindcss.com; "
            ."frame-ancestors 'self';";
        $response->headers->set('Content-Security-Policy', $cspPolicy);

        // 7. Permissions Policy: Membatasi API perangkat browser
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), payment=()');

        // 8. Information Disclosure: Hapus header identifikasi server
        $response->headers->remove('X-Powered-By');
        if (function_exists('header_remove')) {
            header_remove('X-Powered-By');
        }

        return $response;
    }
}
