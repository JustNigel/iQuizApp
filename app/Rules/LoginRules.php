<?php

namespace App\Rules;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginRules implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!Auth::attempt(['email' => $value, 'password' => request()->password])) {
            $user = User::withTrashed()->where('email', $value)->first();
            if (
                $user &&
                Hash::check(request()->password, optional($user)->password)
            ) {
                $user->restore();
            } else {
                $fail('Invalid Credentials!');
            }
        }
    }
}
