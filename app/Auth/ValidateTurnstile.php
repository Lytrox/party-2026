<?php

namespace App\Auth;

use App\Rules\Turnstile;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ValidateTurnstile
{
    /**
     * Handle the incoming authentication pipeline request.
     *
     * @throws ValidationException
     */
    public function handle(Request $request, \Closure $next): mixed
    {
        validator(
            $request->only('cf-turnstile-response'),
            ['cf-turnstile-response' => ['required', new Turnstile]],
            [
                'cf-turnstile-response.required' => __('Please complete the CAPTCHA.'),
            ]
        )->validate();

        return $next($request);
    }
}
