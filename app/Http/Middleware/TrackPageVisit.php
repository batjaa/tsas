<?php

namespace App\Http\Middleware;

use App\Models\PageVisit;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackPageVisit
{
    private const BOT_KEYWORDS = [
        'googlebot', 'bingbot', 'slurp', 'duckduckbot', 'baiduspider',
        'yandexbot', 'sogou', 'facebot', 'ia_archiver', 'semrushbot',
        'ahrefsbot', 'mj12bot', 'dotbot', 'petalbot', 'bytespider',
        'applebot', 'gptbot', 'claudebot', 'bot', 'spider', 'crawl',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }

    public function terminate(Request $request, Response $response): void
    {
        if ($request->method() !== 'GET') {
            return;
        }

        PageVisit::create([
            'url' => substr($request->fullUrl(), 0, 2048),
            'product_id' => $this->extractProductId($request),
            'referrer' => $this->extractExternalReferrer($request),
            'device' => $this->detectDevice($request->userAgent() ?? ''),
            'user_agent' => substr((string) $request->userAgent(), 0, 1024) ?: null,
            'ip' => $request->ip(),
            'status_code' => $response->getStatusCode(),
            'is_bot' => $this->isBot($request->userAgent() ?? ''),
        ]);
    }

    private function extractProductId(Request $request): ?int
    {
        $id = $request->route('id');

        if ($id && $request->route()->getName() === 'products.show') {
            return (int) $id;
        }

        return null;
    }

    private function extractExternalReferrer(Request $request): ?string
    {
        $referrer = $request->header('referer');

        if (! $referrer) {
            return null;
        }

        $referrerHost = parse_url($referrer, PHP_URL_HOST);
        $siteHost = parse_url(config('app.url'), PHP_URL_HOST);

        if (! $referrerHost || $referrerHost === $siteHost) {
            return null;
        }

        return substr($referrerHost, 0, 2048);
    }

    private function detectDevice(string $ua): string
    {
        $ua = strtolower($ua);

        if (preg_match('/tablet|ipad|playbook|silk/i', $ua)) {
            return 'tablet';
        }

        if (preg_match('/mobile|iphone|ipod|android.*mobile|opera m(ob|in)i|windows phone/i', $ua)) {
            return 'mobile';
        }

        return 'desktop';
    }

    private function isBot(string $ua): bool
    {
        $ua = strtolower($ua);

        foreach (self::BOT_KEYWORDS as $keyword) {
            if (str_contains($ua, $keyword)) {
                return true;
            }
        }

        return false;
    }
}
