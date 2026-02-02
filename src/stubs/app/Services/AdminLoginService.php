<?php
namespace App\Services;

use App\Http\Requests\Admin\AdminLoginValidation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AdminLoginService
{
    /**
     * Show admin login page
     */
    public function index()
    {
        return view('admin.adminLogin');
    }

    /**
     * Handle admin login
     */
    public function doLogin(AdminLoginValidation $request)
    {
        $this->ensureIsNotRateLimited($request);

        $credentials = $request->only('user_name', 'password');

        if (! Auth::guard('admin')->attempt($credentials)) {
            RateLimiter::hit($this->throttleKey($request));

            throw ValidationException::withMessages([
                'user_name' => 'Invalid username or password.',
            ]);
        }
        RateLimiter::clear($this->throttleKey($request));
        $request->session()->regenerate();

        return redirect()->to('admin');
    }

    /**
     * Rate limit protection
     */
    protected function ensureIsNotRateLimited(AdminLoginValidation $request): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey($request), 5)) {
            return;
        }

        throw ValidationException::withMessages([
            'user_name' => 'Too many login attempts. Please try again later.',
        ]);
    }

    /**
     * Unique throttle key
     */
    protected function throttleKey(AdminLoginValidation $request): string
    {
        return Str::lower($request->user_name) . '|' . $request->ip();
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/');
    }
}
