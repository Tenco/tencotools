<?php

namespace tencotools\Http\Controllers;

use Illuminate\Http\Request;

use tencotools\Http\Requests;

use Socialite;
use Auth;
use tencotools\User;

class AuthController extends Controller
{
    

	// show login link to the user
	public function login()
    {

    	// only login if not already logged in
    	if (Auth::guest())
    	{
    		return view('login');

    	}
    	
    	// send user to root if already logged in
    	return redirect('/');

    }


    public function redirectToProvider()
    {

    	return Socialite::with('google')->redirect();

    }


    public function handleProviderCallback(Request $request)
    {

    	if ($request->has('code'))
    	{
	
	    	$remoteuserdata = Socialite::driver('google')->user();

	    	#dd($remoteuserdata->email);

	    	// Figure out if this user has access
			if ($user = User::where('email', $remoteuserdata->email)->first())
			{
				// update the user DB record
				$this->updateUserRecord($user, $remoteuserdata);
				return $this->userHasAccess($user);
			}

			// else no access:
			return redirect('login')
					->withError("You do not seem to have access to this service. Please contact Tenco.");
		}

		// else
		return redirect('login');
    }


    public function userHasAccess($user)
	{
		Auth::login($user, true);
		return redirect('/');
	}

	// update user record on successful login
	public function updateUserRecord(User $user, $userData)
	{

		#dd($userData->avatar);
		$user->update([
		
			'name' => $userData->name,
			'avatar' => $userData->avatar,

			]);
		
		return;
	}


    public function logout()
    {
    	Auth::logout();
    	return redirect('login');

    }
}
