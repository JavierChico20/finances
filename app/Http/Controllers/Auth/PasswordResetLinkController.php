<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Auth\Passwords\PasswordBrokerManager;
use Illuminate\Routing\Redirector;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Inertia\Inertia;
use Inertia\Response;

class PasswordResetLinkController extends Controller
{
    public function __construct(private readonly PasswordBrokerManager $passwordBrokerManager, private readonly Redirector $redirector)
    {
    }
    /**
     * Show the password reset link request page.
     */
    public function create(Request $request): Response
    {
        return Inertia::render('auth/ForgotPassword', [
            'status' => $request->session()->get('status'),
        ]);
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $this->passwordBrokerManager->sendResetLink($request->only('email'));

        return $this->redirector->back()->with('status', __('A reset link will be sent if the account exists.'));
    }
}
