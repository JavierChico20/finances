<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Routing\Redirector;
use Illuminate\Routing\UrlGenerator;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class EmailVerificationPromptController extends Controller
{
    public function __construct(private readonly Redirector $redirector, private readonly UrlGenerator $urlGenerator)
    {
    }
    /**
     * Show the email verification prompt page.
     */
    public function __invoke(Request $request): RedirectResponse|Response
    {
        return $request->user()->hasVerifiedEmail()
                    ? $this->redirector->intended($this->urlGenerator->route('dashboard', absolute: false))
                    : Inertia::render('auth/VerifyEmail', ['status' => $request->session()->get('status')]);
    }
}
