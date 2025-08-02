<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Request;

class SignInController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('login.sign-in');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_name' => ['required', 'min:3', 'string'],
            'password' => ['required', 'min:8', 'string'],
        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $credentials = $request->only('user_name', 'password');
        //dd($credentials);
        $remember = $request->has('remember');
        //dd($cr);

        //$user = User::where(['user_name' => $request->user_name, 'password' => Hash::make($request->passwprd)])->first();
        //dd($user);
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            //return redirect()->intended(route('tasks.report'));
            return to_route('tasks.report');
        }
        //dd(1);
        return redirect()->back()->withErrors(['email' => 'The provided credentials do not match.'])->withInput();
        //$user = User::where('username', request()->userName, 'password', request()->password);
        //auth()->login($user, request()->remember);
        //return to_route('tasks.report');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return;
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
    public function update(Request $request, User $user)
    {
        //
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return to_route('login');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
