<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Routing\Redirector;
use Illuminate\Routing\UrlGenerator;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    public function __construct(private readonly Redirector $redirector, private readonly UrlGenerator $urlGenerator)
    {
    }
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $this->redirector->intended($this->urlGenerator->route('dashboard', absolute: false));
        }

        $request->user()->sendEmailVerificationNotification();

        return $this->redirector->back()->with('status', 'verification-link-sent');
    }
}
