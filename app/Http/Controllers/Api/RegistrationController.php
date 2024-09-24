<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class RegistrationController extends Controller
{
    public function create()
    {
        return view('registration.create');
    }

    public function store(Request $request)
    {

    //     // Validation rules for the registration form
    //     $rules = [
    //         'name' => 'required',
    //         'email' => 'required|email|unique:users',
    //         'password' => 'required|min:8|confirmed',
    //     ];

    //     // Validate the form data
    //     $request->validate($rules);

        // Create a new user

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->password = bcrypt($request->input('password'));
        $user->save();

        // Redirect the user after successful registration

        return redirect('/')->with('success', 'Registration completed successfully!');
    }
}





