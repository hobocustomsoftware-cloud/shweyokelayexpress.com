<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Show login form
     * @return view
     */
    public function showLoginForm(){
        return view('admin.auth.login');
    }

    /**
     * Login user
     * @param Request $request
     * @return redirect
     */
    public function login(Request $request)
    {
        $credentials = $request->only('name', 'password');

        $request->validate([
            'name' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return redirect()->intended('/');
        }

        return back()->withErrors(['name' => 'Invalid credentials.']);
    }

    /**
     * Logout user
     * @param Request $request
     * @return redirect
     */
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login');
    }

    /**
     * Show forgot password form
     * @return view
     */
    public function showForgotPasswordForm(){
        return view('admin.auth.forgot-password');
    }

    /**
     * Send reset password link
     * @param Request $request
     * @return redirect
     */
    public function sendResetLink(Request $request){
        $request->validate([
            'name' => 'required',
        ]);

        $user = User::where('name', $request->name)->first();
        if (!$user) {
            return back()->withErrors(['name' => 'User not found.']);
        }

        // Generate a simple token (in production, use a more secure method)
        $token = bin2hex(random_bytes(32));
        
        // Store user ID in session with token for this demo
        // In production, you would store this in database with expiration
        session(['reset_user_' . $token => $user->id]);
        
        return redirect()->route('show-reset-password', ['token' => $token])
            ->with('success', 'Password reset link generated. Use this page to reset your password.');
    }

    /**
     * Show reset password form
     * @param string $token
     * @return view
     */
    public function showResetPasswordForm($token){
        return view('admin.auth.reset-password', compact('token'));
    }

    /**
     * Reset password
     * @param Request $request
     * @return redirect
     */
    public function resetPassword(Request $request){
        $request->validate([
            'token' => 'required',
            'password' => 'required|confirmed',
        ]);

        // Get user ID from session using the token
        $userId = session('reset_user_' . $request->token);
        if (!$userId) {
            return back()->withErrors(['token' => 'Invalid or expired reset token.']);
        }

        $user = User::find($userId);
        if (!$user) {
            return back()->withErrors(['token' => 'User not found.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect('/login')->with('success', 'Password reset successfully.');
    }
}
