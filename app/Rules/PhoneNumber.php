<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

final class PhoneNumber implements ValidationRule
{
    /**
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match('/^\+[1-9]\d{0,3}(\s\d{1,4}){1,4}$/', $value)) {
            $fail('The :attribute must be in format: +X XXX XXX XXX XXX with 4 to 17 digits.');
            return;
        }

        $cleaned = preg_replace('/(?!^\+)\D/', '', $value);
        $digitCount = strlen($cleaned) - 1;

        if ($digitCount < 4 || $digitCount > 17) {
            $fail('The :attribute must have between 4 and 17 digits.');
        }
    }
}
