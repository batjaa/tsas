<?php

namespace Tests\Feature;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class TrustedProxyTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config(['app.key' => 'base64:'.base64_encode(str_repeat('t', 32)), 'session.secure' => true]);

        Route::get('/_test/proxy', fn (Request $request) => [
            'secure' => $request->isSecure(),
            'login_url' => route('login'),
            'client_ip' => $request->ip(),
        ]);
    }

    public function test_trusted_proxy_preserves_https_urls_and_client_address(): void
    {
        config(['trustedproxy.proxies' => '*']);

        $this->forwardedRequest('/_test/proxy')
            ->assertOk()
            ->assertExactJson([
                'secure' => true,
                'login_url' => 'https://tsas.example/login',
                'client_ip' => '203.0.113.25',
            ]);
    }

    public function test_trusted_proxy_preserves_https_auth_redirect_and_secure_session_cookie(): void
    {
        config(['trustedproxy.proxies' => '*']);

        $response = $this->forwardedRequest('/dashboard');

        $response->assertRedirect('https://tsas.example/login');
        $response->assertCookie(config('session.cookie'));
        $this->assertTrue($response->getCookie(config('session.cookie'))->isSecure());
    }

    public function test_unconfigured_proxies_cannot_override_request_origin(): void
    {
        config(['trustedproxy.proxies' => []]);

        $this->forwardedRequest('/_test/proxy')
            ->assertOk()
            ->assertExactJson([
                'secure' => false,
                'login_url' => 'http://app.internal/login',
                'client_ip' => '172.18.0.2',
            ]);
    }

    public function test_comma_separated_proxy_ranges_are_supported(): void
    {
        config(['trustedproxy.proxies' => '10.0.0.0/8, 172.18.0.0/16']);

        $this->forwardedRequest('/_test/proxy')
            ->assertOk()
            ->assertJsonPath('secure', true)
            ->assertJsonPath('login_url', 'https://tsas.example/login');
    }

    public function test_addresses_outside_configured_proxy_ranges_are_not_trusted(): void
    {
        config(['trustedproxy.proxies' => '10.0.0.0/8']);

        $this->forwardedRequest('/_test/proxy')
            ->assertOk()
            ->assertJsonPath('secure', false)
            ->assertJsonPath('login_url', 'http://app.internal/login');
    }

    private function forwardedRequest(string $path): TestResponse
    {
        return $this->withServerVariables([
            'REMOTE_ADDR' => '172.18.0.2',
        ])->get('http://app.internal'.$path, [
            'X-Forwarded-For' => '203.0.113.25',
            'X-Forwarded-Host' => 'tsas.example',
            'X-Forwarded-Port' => '443',
            'X-Forwarded-Proto' => 'https',
        ]);
    }
}
