<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ResetPasswordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return view('login.reset-password', [
            'token' => $request->token,
            'email' => $request->email,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email',
            'password' => [
                'required', 'string','min:8',
                'regex:\^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/',
                'confirmed'
            ],
        ],[
        'password.regex' => 'Password must contain at least one letter, one number, and one special character.',
        ]
    );
    if($validator->fails())
    {
        return redirect()->back()->withErrors($validator)->withInput();
    }
    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));
            $user->save();
        }
    );
    if($status === Password::PASSWORD_RESET) {
        return to_route('sign-in.create')->with('status', 'Password has been reset successfully!.');
    }
    return redirect()->back()->withErrors(['email' => [__($status)]])->withInput();
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email',
            'password' => [
                'required', 'string','min:8',
                'regex:\^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/',
                'confirmed'
            ],
        ],[
        'password.regex' => 'Password must contain at least one letter, one number, and one special character.',
        ]
    );
    if($validator->fails())
    {
        return redirect()->back()->withErrors($validator)->withInput();
    }
    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));
            $user->save();
        }
    );
    if($status === Password::PASSWORD_RESET) {
        return to_route('sign-in.create')->with('status', 'Password has been reset successfully!.');
    }
    return redirect()->back()->withErrors(['email' => [__($status)]])->withInput();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
