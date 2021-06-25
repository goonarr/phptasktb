<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Exception;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
        $this->middleware('super.admin', ['only' => ['users', 'updateRole']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show the application user manager for SUPERADMIN.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function users()
    {
        return view('users', ['users' => User::all() ]);
    }

    /**
     * Change User Role
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function updateRole(Request $request)
    {
        $validate = Validator::make($request->all(), [
          'userId' => 'required|integer',
          'newRole' => 'required|string'
        ]);


        if ( $validate->fails() ) {
          return redirect()->back()->withErrors('Request malformed!');
        }

        if (! in_array( $request->input('newRole'), User::getRoles() )){
          return redirect()->back()->withErrors('Role not supported');
        }

        $user_obj = User::findOrFail($request->input('userId'));

        try{
          $user_obj->role = $request->input('newRole');
          $user_obj->save();
        } catch (Exception $e){
          return redirect()->back()->withErrors('Something went wrong, please try again later!');
        }

        //ON SUCCESS
        return redirect()->back()->withSuccess('Role changed for user '.$user_obj->name);
    }
}
