<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CategorySubsWithIds implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $res = null;
        foreach ($value as $sub) {
          
            $res = isset($sub['title']);
            $res = isset($sub['id']);
        }
        if ($res == false) {
            $fail("sub category items must contain title and id");
        }
    }
}
