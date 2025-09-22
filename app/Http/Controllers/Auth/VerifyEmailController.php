<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Routing\Redirector;
use Illuminate\Routing\UrlGenerator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    public function __construct(private readonly Redirector $redirector, private readonly UrlGenerator $urlGenerator)
    {
    }
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $this->redirector->intended($this->urlGenerator->route('dashboard', absolute: false).'?verified=1');
        }

        $request->fulfill();

        return $this->redirector->intended($this->urlGenerator->route('dashboard', absolute: false).'?verified=1');
    }
}
