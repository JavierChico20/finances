<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Routing\Router;
use Illuminate\Auth\AuthManager;
use Illuminate\Routing\Redirector;
use Illuminate\Routing\UrlGenerator;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;
use Laravel\Fortify\Features;

class AuthenticatedSessionController extends Controller
{
    public function __construct(private readonly Router $router, private readonly AuthManager $authManager, private readonly Redirector $redirector, private readonly UrlGenerator $urlGenerator)
    {
    }
    /**
     * Show the login page.
     */
    public function create(Request $request): Response
    {
        return Inertia::render('auth/Login', [
            'canResetPassword' => $this->router->has('password.request'),
            'status' => $request->session()->get('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $user = $request->validateCredentials();

        if (Features::enabled(Features::twoFactorAuthentication()) && $user->hasEnabledTwoFactorAuthentication()) {
            $request->session()->put([
                'login.id' => $user->getKey(),
                'login.remember' => $request->boolean('remember'),
            ]);

            return to_route('two-factor.login');
        }

        $this->authManager->login($user, $request->boolean('remember'));

        $request->session()->regenerate();

        return $this->redirector->intended($this->urlGenerator->route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $this->authManager->guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return $this->redirector->to('/');
    }
}
