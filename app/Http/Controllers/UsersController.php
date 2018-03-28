<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

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
	public function showUsers() {
		$users = User::all();
		return view('users.view_all', compact('users'));
	}



	/*--------------------------------------------------------------------------
     | Edit Users
     | @param user id
     |------------------------------------------------------------------------*/
	// Get the edit user view
	public function showUser($id) {
		$user = User::where('id', $id)->first();
		return view('users.edit', compact('user'));
	}




	/*--------------------------------------------------------------------------
     | Create a New User
     | @param post request
     |------------------------------------------------------------------------*/
	protected function create(Request $request) {

		if($request->password == $request->confirmed_password) {

			User::create([
	            'first_name' => $request->first_name,
	            'last_name' => $request->last_name,
	            'email' => $request->email,
	            'password' => bcrypt($request->password),
	        ]);

		} else {
			die(header("HTTP/1.1 500 Internal Server Error"));
		}

    }




	/*--------------------------------------------------------------------------
     | Update User
     | @param post request
     |------------------------------------------------------------------------*/
	protected function update(Request $request) {

        $user = User::where('id', $request->user_id)->first();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
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

        

    }


}
