<?php

namespace App\Livewire\Profile;

use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Auth;
use Laravel\Jetstream\Contracts\UpdatesUserProfileInformation;
use Livewire\Component;
use Livewire\WithFileUploads;

class UpdateProfileInformationForm extends Component
{
    use WithFileUploads;

    /**
     * The component's state.
     */
    public $state = [];

    /**
     * The new avatar for the user.
     */
    public $photo;

    /**
     * The "password confirmation" form state.
     */
    public $confirmingPassword = false;

    /**
     * The password confirmation form input.
     */
    public $confirmablePassword = '';

    /**
     * Indicates if email verification links are being sent.
     */
    public $verificationLinkSent = false;

    /**
     * Prepare the component.
     */
    public function mount()
    {
        $this->state = Auth::user()->withoutRelations()->toArray();
    }

    /**
     * Update the user's profile information.
     */
    public function updateProfileInformation(UpdatesUserProfileInformation $updater)
    {
        $this->resetErrorBag();

        $updater->update(
            Auth::user(),
            $this->photo
                ? array_merge($this->state, ['photo' => $this->photo])
                : $this->state
        );

        if (isset($this->photo)) {
            return redirect()->route('profile.show');
        }

        $this->dispatch('saved');

        $this->dispatch('refresh-navigation-menu');
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function sendEmailVerification()
    {
        if (Auth::user() instanceof MustVerifyEmail) {
            Auth::user()->sendEmailVerificationNotification();

            $this->verificationLinkSent = true;
        }
    }

    /**
     * Delete the current user's profile photo.
     */
    public function deleteProfilePhoto()
    {
        Auth::user()->deleteProfilePhoto();

        $this->dispatch('refresh-navigation-menu');
    }

    /**
     * Get the current user of the application.
     */
    public function getUserProperty()
    {
        return Auth::user();
    }

    /**
     * Render the component.
     */
    public function render()
    {
        return view('profile.update-profile-information-form');
    }
}
