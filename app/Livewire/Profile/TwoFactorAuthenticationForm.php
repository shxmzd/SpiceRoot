<?php

namespace App\Livewire\Profile;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Actions\ConfirmTwoFactorAuthentication;
use Laravel\Fortify\Actions\DisableTwoFactorAuthentication;
use Laravel\Fortify\Actions\EnableTwoFactorAuthentication;
use Laravel\Fortify\Actions\GenerateNewRecoveryCodes;
use Laravel\Fortify\Contracts\TwoFactorAuthenticationProvider;
use Laravel\Fortify\RecoveryCode;
use Livewire\Component;

class TwoFactorAuthenticationForm extends Component
{
    /**
     * Indicates if two factor authentication QR code is being displayed.
     */
    public $showingQrCode = false;

    /**
     * Indicates if the two factor authentication confirmation input and QR code are being displayed.
     */
    public $showingConfirmation = false;

    /**
     * Indicates if two factor authentication recovery codes are being displayed.
     */
    public $showingRecoveryCodes = false;

    /**
     * The OTP code for confirming two factor authentication.
     */
    public $code;

    /**
     * The "password confirmation" form state.
     */
    public $confirmingPassword = false;

    /**
     * The password confirmation form input.
     */
    public $confirmablePassword = '';

    /**
     * Enable two factor authentication for the user.
     */
    public function enableTwoFactorAuthentication(Request $request, TwoFactorAuthenticationProvider $provider)
    {
        if (is_null(Auth::user()->two_factor_secret)) {
            app(EnableTwoFactorAuthentication::class)(Auth::user());

            $this->showingQrCode = true;
            $this->showingConfirmation = true;
            $this->showingRecoveryCodes = false;
        }
    }

    /**
     * Confirm two factor authentication for the user.
     */
    public function confirmTwoFactorAuthentication(TwoFactorAuthenticationProvider $provider)
    {
        if (is_null(Auth::user()->two_factor_confirmed_at)) {
            app(ConfirmTwoFactorAuthentication::class)(Auth::user(), $this->code);

            $this->showingQrCode = false;
            $this->showingConfirmation = false;
            $this->showingRecoveryCodes = true;
            $this->code = '';
        }
    }

    /**
     * Display the user's recovery codes.
     */
    public function showRecoveryCodes()
    {
        $this->showingRecoveryCodes = true;
    }

    /**
     * Generate new recovery codes for the user.
     */
    public function regenerateRecoveryCodes()
    {
        app(GenerateNewRecoveryCodes::class)(Auth::user());

        $this->showingRecoveryCodes = true;
    }

    /**
     * Disable two factor authentication for the user.
     */
    public function disableTwoFactorAuthentication()
    {
        app(DisableTwoFactorAuthentication::class)(Auth::user());

        $this->showingQrCode = false;
        $this->showingConfirmation = false;
        $this->showingRecoveryCodes = false;
    }

    /**
     * Get the current user of the application.
     */
    public function getUserProperty()
    {
        return Auth::user();
    }

    /**
     * Determine if two factor authentication is enabled.
     */
    public function getEnabledProperty()
    {
        return ! empty($this->user->two_factor_secret);
    }

    /**
     * Get the SVG element for the user's two factor authentication QR code.
     */
    public function getTwoFactorQrCodeSvgProperty()
    {
        return app(TwoFactorAuthenticationProvider::class)->qrCodeSvg(
            config('app.name'),
            $this->user->email,
            decrypt($this->user->two_factor_secret)
        );
    }

    /**
     * Get the two factor authentication recovery codes for the user.
     */
    public function getRecoveryCodesProperty()    {
        return collect(json_decode(decrypt($this->user->two_factor_recovery_codes), true))
            ->map(function ($code) {
                return new RecoveryCode($code);
            });
    }

    /**
     * Debug method to test Livewire functionality.
     */
    public function debugTest()
    {
        session()->flash('message', 'Debug test successful - Livewire is working!');
        $this->dispatch('debug-test-fired');
    }

    /**
     * Start confirming the user's password.
     */
    public function startConfirmingPassword($confirmableId)
    {
        // Debug: Log to session to see if method is called
        session()->flash('message', 'startConfirmingPassword called with ID: ' . $confirmableId);
        
        $this->confirmablePassword = '';

        $this->dispatch('confirming-password');

        $this->confirmingPassword = true;

        return $confirmableId;
    }

    /**
     * Stop confirming the user's password.
     */
    public function stopConfirmingPassword()
    {
        $this->confirmingPassword = false;
        $this->confirmablePassword = '';
    }

    /**
     * Confirm the user's password.
     */
    public function confirmPassword()
    {
        if (! Hash::check($this->confirmablePassword, Auth::user()->password)) {
            throw ValidationException::withMessages([
                'confirmable_password' => [__('This password does not match our records.')],
            ]);
        }

        session(['auth.password_confirmed_at' => time()]);

        $this->dispatch('password-confirmed', [
            'id' => request('id', time()),
        ]);

        $this->stopConfirmingPassword();
    }

    /**
     * Render the component.
     */
    public function render()
    {
        return view('profile.two-factor-authentication-form');
    }
}
