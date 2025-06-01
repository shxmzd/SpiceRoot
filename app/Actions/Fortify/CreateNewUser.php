<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Illuminate\Validation\Rule;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        \Log::info('CreateNewUser::create called', ['input' => $input]);

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 
                'string', 
                'email', 
                'max:255',
                // Use Rule::unique for MongoDB compatibility
                Rule::unique('users')->where(function ($query) use ($input) {
                    return $query->where('email', $input['email']);
                })
            ],
            'password' => $this->passwordRules(),
            'role' => ['required', 'string', 'in:buyer,seller'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        try {
            $user = User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
                'role' => $input['role'],
            ]);

            // Log successful creation for debugging
            \Log::info('User created successfully', [
                'user_id' => $user->id, 
                'email' => $user->email,
                'role' => $user->role
            ]);

            return $user;
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('User creation failed', [
                'error' => $e->getMessage(),
                'input' => $input
            ]);
                     
            throw $e;
        }
    }
}