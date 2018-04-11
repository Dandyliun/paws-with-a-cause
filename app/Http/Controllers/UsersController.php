<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class UsersController extends Controller
{


	/*--------------------------------------------------------------------------
     | Default Class Constructor
     |
     |------------------------------------------------------------------------*/
    public function __construct() {
        // Apply the auth middleware to all UsersController class methods
        $this->middleware('auth');
    }



    /*--------------------------------------------------------------------------
     | Get All Users
     |
     |------------------------------------------------------------------------*/
	// Show all users
    public function showUsers() {
		$users = User::all();
		return view('users.view_all', compact('users'));
	}



	/*--------------------------------------------------------------------------
     | Edit Users
     | @param user id
     |------------------------------------------------------------------------*/
	// Show the edit user view
	public function showUser($id) {
		$user = User::where('id', $id)->first();
		return view('users.edit', compact('user'));
	}




	/*--------------------------------------------------------------------------
     | Create a New User
     | @param post request
     |------------------------------------------------------------------------*/
	protected function create(Request $request) {
        // Determine the new user's role
        if(strtolower($request->role) == 'admin') {
            $is_admin = 1;
        } else {
            $is_admin = 0;
        }
        // Create the new user
		User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'is_admin' => $is_admin,
            'password' => bcrypt($request->password),
        ]);
    }




	/*--------------------------------------------------------------------------
     | Update User
     | @param post request
     |------------------------------------------------------------------------*/
	protected function update(Request $request) {
        // Select the user from the database
        $user = User::where('id', $request->user_id)->first();
        // Determine the posted user role
        if(strtolower($request->role) == 'admin') {
            $is_admin = 1;
        } else {
            $is_admin = 0;
        }
        // Update the database record
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        if($request->role != null) {
            $user->is_admin = $is_admin;
        }
        if($request->password != null || $request->password != '') {
        	$user->password = bcrypt($request->password);
        }
        $user->save();
    }



    /*--------------------------------------------------------------------------
     | Delete User
     | @param post request
     |------------------------------------------------------------------------*/
	protected function delete(Request $request) {

        // Select the user from the database
        $user = User::find($request->user_id);

        // Delete the selected user
        $user->delete();

    }



    /*--------------------------------------------------------------------------
     | User Profile
     | @param post request
     |------------------------------------------------------------------------*/
     public function showProfile() {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }




}
