<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class ForgetPasswordController extends Controller
{
    /**
     * Show the forgot password form
     */
    public function create()
    {
        return view('login.forget-password');
    }

    /**
     * Handle password reset request
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'user_name' => 'required|exists:users,user_name'
        ], [
            'email.exists' => 'Could not find a user with that email.',
            'user_name.exists' => 'Could not find a user with that username.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Verify email and username match the same user
        $user = User::where('email', $request->email)
            ->where('user_name', $request->user_name)
            ->first();

        if (!$user) {
            return redirect()->back()
                ->withErrors(['notMatch' => 'Username and email don\'t match'])
                ->withInput();
        }

        // Send password reset link
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? redirect()->back()->with('status', __($status))
            : redirect()->back()->withErrors(['email' => __($status)]);
    }
}
