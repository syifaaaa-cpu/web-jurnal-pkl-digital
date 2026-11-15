<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SanitizeInputMiddleware
{
    /**
     * Fields that should be exempted from tag stripping (e.g. passwords).
     *
     * @var list<string>
     */
    protected array $except = [
        'password',
        'password_confirmation',
        'current_password',
        'new_password',
        'new_password_confirmation',
        '_token',
    ];

    /**
     * Handle an incoming request and sanitize string inputs to eliminate dangerous script tags.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $input = $request->all();

        array_walk_recursive($input, function (&$value, $key): void {
            if (is_string($value) && ! in_array($key, $this->except, true)) {
                // Bersihkan blok <script>...</script> dan <style>...</style> beserta isinya
                $cleaned = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $value);
                $cleaned = preg_replace('/<style\b[^>]*>(.*?)<\/style>/is', '', (string) $cleaned);

                // Hapus null byte dan sisa tag HTML lainnya
                $cleaned = str_replace(chr(0), '', (string) $cleaned);
                $value = trim(strip_tags($cleaned));
            }
        });

        $request->merge($input);

        return $next($request);
    }
}
