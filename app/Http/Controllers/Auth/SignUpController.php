<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;

class SignUpController extends Controller
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
        return view('login.sign-up');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => ['required', 'min:3', 'string'],
            'userName' => ['required', 'min:3', 'string', 'unique:users,user_name'],
            'email' => ['required', 'email','unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],
            'check' => 'required'
        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        //if(request()->password === request()->confirmPassword)
        //{
            User::create([
                'name' => request()->name,
                'user_name' => request()->userName,
                'email' => request()->email,
                'password' => Hash::make(request()->password),
            ]);
            return to_route('login')->with('success', 'Account created successfully! Please sign in.');
        //}
        //return view('login.sign-up');
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
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
