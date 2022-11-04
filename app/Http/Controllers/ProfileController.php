<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('auth.profile');
    }

    public function updateProfile(Request $request){
        //validation rules

        $request->validate([
            'name' =>'required|min:4|string|max:255',
            'email'=>'required|email|string|max:255'
        ]);
        $user =auth()->user();

        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->isColor = $request->get('isColor');
        if($request->isColor == 1){
            $user->background = $request->get('background');
        }else{
            $user->color = $request->get('color');

        }
        $user->save();


        return back()->with('message','Profile Updated');
    }
}
