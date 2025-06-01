<?php

namespace App\Livewire\Profile;

use App\Actions\Fortify\UpdateUserPassword;
use Illuminate\Support\Facades\Hash;
use Laravel\Jetstream\Contracts\UpdatesUserPasswords;
use Livewire\Component;

class UpdatePasswordForm extends Component
{
    /**
     * The component's state.
     */
    public $state = [
        'current_password' => '',
        'password' => '',
        'password_confirmation' => '',
    ];    /**
     * Update the user's password.
     */
    public function updatePassword(UpdatesUserPasswords $updater)
    {
        $this->resetErrorBag();

        $updater->update(auth()->user(), $this->state);

        if (request()->hasSession()) {
            request()->session()->put([
                'password_hash_'.auth()->getDefaultDriver() => auth()->user()->getAuthPassword(),
            ]);
        }

        $this->state = [
            'current_password' => '',
            'password' => '',
            'password_confirmation' => '',
        ];

        $this->dispatch('saved');
    }

    /**
     * Get the current user of the application.
     */
    public function getUserProperty()
    {
        return auth()->user();
    }

    /**
     * Render the component.
     */
    public function render()
    {
        return view('profile.update-password-form');
    }
}
