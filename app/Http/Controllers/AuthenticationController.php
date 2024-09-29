<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\Forgotemail;
use App\Mail\ConfirmEmail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Lang;

class AuthenticationController extends Controller
{
	// STATIC

	private static function login_authentication($request)
	{
		if (empty($request['password']))
		{
			return [
				'statuscode' => 400,
				'message' => Lang::get('messages.auth.textnopassentered'),
			];
		}

		if (!empty($request['usernameoremail']))
		{
			if (User::where('name', $request->usernameoremail)->first())
				$user=User::where('name', $request->usernameoremail)->first();
			else if (User::where('email', $request->usernameoremail)->first())
				$user=User::where('email', $request->usernameoremail)->first();
			else
			{
				return [
					'statuscode' => 400,
					'message' => Lang::get('messages.auth.textwrongusername')
				];
			}
		} 
		else
		{
			return [
				'statuscode' => 400,
				'message' => Lang::get('messages.auth.textnousernameoremail')
			];
		}

		if(!$user || !Hash::check($request->password, $user->password))
		{
			return [
				'statuscode' => 400,
				'message' => Lang::get('messages.auth.textincorrectlogin')
			];
		}

		$token = $user->createToken('auth_token')->accessToken;
		
		unset($user['password']);
		
		return [
			'statuscode' => 200,
			'message'=> Lang::get('messages.auth.textsuccessfullogin'),
			'user' => $user,
			'token' => $token,
		];
	}

	private static function registration_authentication($request, $type)
	{
		
		$allready = true;
		$message = "";
		
		if (empty($request['name']) || empty($request['email']) || empty($request['password']))
		{
			$allready = false;
			$message .= Lang::get('messages.auth.textneparerequired');
		}
	
		if (!filter_var($request['email'], FILTER_VALIDATE_EMAIL))
		{
			$allready = false;
			$message .=Lang::get('messages.auth.textinvalidemail');
		}
		
		if (User::where('email', $request['email'])->first())
		{
			$allready = false;
			$message .= Lang::get('messages.auth.textemailtaken');
		}
		
		if (User::where('name', $request['name'])->first())
		{
			$allready = false;
			$message .= Lang::get('messages.auth.textusernameuse');
		}
		
		if (strlen($request['password']) < 8)
		{
			$allready = false;
			$message .= Lang::get('messages.auth.textpasswordshot');
		}
		
		if ($allready)
		{
			$identifier = md5(rand(1000000000, 9999999999));

			$user = User::create([
				'name' => $request->name,
				'email' => $request->email,
				'password' => Hash::make($request->password),
				'identifier' => $identifier,
				'rank' => 1
			]);

			unset($user['password']);
		
			$token = $user->createToken('auth_token')->accessToken;

			Mail::to($user['email'])->send(new ConfirmEmail($user['email'], $type));

			return [
				'statuscode' => 201,
				'user' => $user,
				'token' => $token,
				'message' => Lang::get('messages.auth.textregistrationsuccessful'),
			];
		}
		else
		{
			return [
				'statuscode' => 400,
				'message' => $message,
			];
		}
	}

	private static function modify_autentichation($request)
	{
		$user = auth()->user();
		$requestData = $request->only(['name', 'email', 'rank']);

		$allReady = true;
		$message = "";

		if (!empty($request['name']))
		{
			if (strlen($request['name']) < 8) {
				$allReady = false;
				$message .= Lang::get('messages.auth.textusernameshort');
			} 
			else if (User::where('name', $request['name'])->count() && 
			User::where('name', $request['name'])->first()->name !== $user->name)
			{
				$allReady = false;
				$message .= Lang::get('messages.auth.textusernameuse');
			}
		}

		if (!empty($request['email']))
		{
			if (User::where('email', $request['email'])->count() && 
				User::where('email', $request['email'])->first()->email !== $user->email)
			{
				$allReady = false;
				$message .= Lang::get('messages.auth.textemailuse');
			} 
			else
			{
				if (isset($request['email']) && !filter_var($request['email'], FILTER_VALIDATE_EMAIL))
				{
					$allReady = false;
					$message .= Lang::get('messages.auth.textinvalidemail');
				}
			}
		}

		if (!empty($request['rank']) && ($request['rank'] == 0 || $request['rank'] == 1))
		{
			$user->rank = $request['rank'];
			$user->save();
		}

		if ($allReady)
		{
			if (isset($request['newpassword']))
			{
				if (strlen($request['newpassword']) >= 8) {
					$user->password = Hash::make($request['newpassword']);
					$user->save();
				} else {
					return [
						'statuscode' => 400,
						'message' => Lang::get('messages.auth.textpasswordshot')
					];
				}
			}

			if (!empty($requestData)) {
				$user->update($requestData);
			}
	
			return [
				'statuscode' => 200,
				'message' => Lang::get('messages.auth.textuserupdated'),
			];
		}
		else
		{
			return [
				'statuscode' => 400,
				'message' => $message
			];
		}
	}

	private static function logout_autentichation($request)
	{
		if (auth()->check()) {
			$request->user()->token()->revoke();
			return [
				'statuscode' => 200,
				'message' => Lang::get('messages.auth.textloggedout'),
			];
		} else {
			return [
				'statuscode' => 401,
				'message' => Lang::get('messages.auth.textuserisnotauth'),
			];
		}
	}

	private static function forgotemail_func($request, $type)
	{
		$validator = Validator::make($request->all(), [
			'email' => 'required|email',
		]);

		if ($validator->fails()) {
			return [
				'statuscode' => 400,
				'message' => Lang::get('messages.auth.textnotemailformat'),
			];
		}

		$user = User::where('email', $request->email)->first();
		if (!$user) {
			return [
				'statuscode' => 400,
				'message' => Lang::get('messages.auth.textincorrectemail'),
			];
		}

		$toEmail = $request->email;
		
		Mail::to($toEmail)->send(new ForgotEmail($toEmail, $type));

		return [
			'statuscode' => 200,
			'message' => Lang::get('messages.auth.textsentletter1') . $request->email . Lang::get('messages.auth.textsentletter2'),
		];
	}

	private static function confirmation_func($request)
	{
		$allready = true;
		$message = "";

		$user = User::find($request->id);
	
		if ($user) {
			$hashed_identifier = $request->identifier;

			if (Hash::check($user->identifier, $hashed_identifier)) {

				$user->email_verified_at = Carbon::now();
				$user->save();
				$username = ucfirst($user->name);

				$message = $username . Lang::get('messages.auth.textuserconfirmation');
			} else {
				$allready = false;
				$message = Lang::get('messages.auth.texterrorauth');
			}
		} else {
			$allready = false;
			$message = Lang::get('messages.auth.texterrorauthuser');
		}

		if ($allready)
		{
			return [
				'statuscode' => '201',
				'message' => $message
			];
		}
		else
		{
			return [
				'statuscode' => '400',
				'message' => $message
			];
		}
	}

	private static function resubscribe($response)
	{
		$user = User::where('email', $response['email'])->where('identifier', $response['identifier'])->first();
		
		if (Hash::check($response['password'], $user->password)) {
			if ($user) {
				$user->delete();
				return [
					'statuscode' => '200',
					'message' => Lang::get('messages.auth.textuserdeletedsuccessful'),
				];
			} else {
				return [
					'statuscode' => '400',
					'message' => Lang::get('messages.auth.texterrorinidentication'),
				];
			}
		} else {
			return [
				'statuscode' => '400',
				'message' => Lang::get('messages.auth.texterrorinidentication'),
			];
		}
	}

	private static function request_maker($response)
	{

		$return_respone = [
			'messages' => [],
			'statuscode' => null,
		];

		if (isset($response['message']))
			$return_respone['messages']['message'] = $response['message'];

		if (isset($response['token']))
			$return_respone['messages']['token'] = $response['token'];

		if (isset($response['user']))
			$return_respone['messages']['user'] = $response['user'];

		if ($response['statuscode'])
			$return_respone['statuscode'] = $response['statuscode'];

		return $return_respone;
	}

	// API

	public function api_user()
	{
		$user = auth()->user()->only(['name', 'email', 'email_verified_at', 'rank']);
		return response()->json($user);
	}
	public function api_login(Request $request)
	{
		if (Cache::get('webuser')) {
			$auth_user = Cache::get('webuser');

			if ($auth_user->email == $request->usernameoremail || $auth_user->name == $request->usernameoremail) {
				return [
					'statuscode' => 400,
					'message' => Lang::get('messages.auth.'),'You are already logged in in a browser.'
				];
			}
		}

		$response = self::login_authentication($request);
		$return_response = self::request_maker($response);
		$statuscode = intval ($return_response['statuscode']);

		return response()->json([$return_response['messages']], $statuscode);
	}

	public function api_register(Request $request)
	{
		$response = self::registration_authentication($request, 'api');
		$return_response = self::request_maker($response);
		$statuscode = intval ($return_response['statuscode']);

		return response()->json([$return_response['messages']], $statuscode);
	}

	public function api_modify(Request $request)
	{
		if (Auth::guard('api')->check()) {
			$hased_passroed = Auth::guard('api')->user()->password;
			$userid = Auth::guard('api')->user()->id;

			if (Cache::get('webuser')) {
				$auth_user = Cache::get('webuser'); 
				if ($auth_user->id == $userid) {
					return [
						'statuscode' => 400,
						'message' => Lang::get('messages.auth.'),'You are already logged in in a browser.'
					];
				}
			}

			if (Hash::check($request->password, $hased_passroed))
			{
				$response = self::modify_autentichation($request);
			}
			else
			{
				$response = [
					'statuscode' => '400',
					'message' => Lang::get('messages.auth.'),'Identification error.'
				];
			}
		} else {
			$response = [
				'statuscode' => '400',
				'message' => Lang::get('messages.auth.'),'Identification error.'
			];
		}
				
		$return_response = self::request_maker($response);
		$statuscode = intval ($return_response['statuscode']);

		return response()->json([$return_response['messages']], $statuscode);
	}

	public function api_logout(Request $request)
	{
		$response = self::logout_autentichation($request);
		$return_response = self::request_maker($response);
		$statuscode = intval ($return_response['statuscode']);

		return response()->json([$return_response['messages']], $statuscode);
	}

	public function api_unsubscribe(Request $request)
	{
		$request['email'] = $request->email;
		$request['identifier'] = $request->identifier;
		$request['password'] = $request->password;

		$response = self::resubscribe($request);
		$return_response = self::request_maker($response);
		$statuscode = intval ($return_response['statuscode']);

		return response()->json([$return_response['messages']], $statuscode);
	}

	public function api_confirmation(Request $request)
	{
		$response = self::confirmation_func($request);
		$return_response = self::request_maker($response);
		$statuscode = intval ($return_response['statuscode']);

		return response()->json([$return_response['messages']], $statuscode);
	}

	public function api_forgotemail(Request $request)
	{
		$response = self::forgotemail_func($request, 'api');
		$return_response = self::request_maker($response);
		$statuscode = intval ($return_response['statuscode']);

		return response()->json([$return_response['messages']], $statuscode);
	}

	public function api_error()
	{
		$return_respone = [];
		$return_respone['messages']['message'] = 'error';
		$statuscode = 400;
		$return_respone['']['code'] = 0;
		
		return response()->json([$return_respone['messages']], $statuscode);
	}
 
	// WEB
	
	public function admin_login()
	{
		if (session()->has('message')) {
			session()->flash('message', session('message'));
		}
		else
		{
			session()->flash('message', '<span class="text-black">' . Lang::get('messages.auth.textyoucanlog') . '</span>');
		}

		return view('backend.admin_login');
	}

	public function admin_login_post(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'usernameoremail' => ['required', 'string', 'min:8', 'max:255'],
			'password' => ['required', 'string', 'min:8', 'max:255']
		]);

		if ($validator->fails()) {
			session()->flash('message', '<span class="text-danger">'. Lang::get('messages.auth.textfildsincorrectly') . '</span>');
			return redirect()->route('admin_login')->withInput();
		}

		$email_check = User::where('email', $request->usernameoremail)->first();
		$name_check = User::where('name', $request->usernameoremail)->first();

		$email_verified = null;

		if ($email_check && Hash::check($request->password, $email_check->password)) {
			$email_verified = $email_check->email_verified_at;
			$userid = $email_check->id;
		} else if ($name_check && Hash::check($request->password, $name_check->password)) {
			$email_verified = $name_check->email_verified_at;
			$userid = $name_check->id;
		}
		else 
		{
			session()->flash('message', '<span class="text-danger">'. Lang::get('messages.auth.textincorrectlogin') . '</span>');
			return redirect()->route('admin_login')->withInput();
		}

		if(is_null($email_verified))
		{
			session()->flash('message', '<span class="text-warning">'. Lang::get('messages.auth.textnotauth') . '</span>');
			return redirect()->route('admin_login')->withInput();
		}

		$stay = ($request->stay == 'on') ? true : false;

		if (Auth::attempt(['name' => $request->usernameoremail, 'password' =>  $request->password], $stay) 
		 || Auth::attempt(['email' => $request->usernameoremail, 'password' =>  $request->password], $stay))
		{
			$user = User::find($userid);
			Cache::put('webuser', $user, now()->addDays(2));

			$request->session()->regenerate();
			return view('backend.admin_index');
		}
		else
		{
			session()->flash('message', '<span class="text-danger">'. Lang::get('messages.auth.textincorrectlogin') . '</span>');
			return back();
		}
	}

	public function admin_registration()
	{
		if (session()->has('message')) {
			session()->flash('message', session('message'));
		}
		else
		{
			session()->flash('message', '<span class="text-black">'. Lang::get('messages.auth.textyoucanregistration') . '</span>');
		}

		return view('backend.admin_registration');
	}

	public function admin_registration_post(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'name' => ['required', 'string', 'min:8', 'max:50'],
			'email' => ['required', 'email'],
			'password' => ['required', 'string', 'min:8', 'max:255'],
			're_password' => ['required', 'string', 'min:8', 'max:255'],
		]);

		if ($validator->fails()) {
			session()->flash('message', '<span class="text-danger">'. Lang::get('messages.auth.textfildsincorrectly') . '</span>');
			return redirect()->route('admin_registration')->withInput();
		}

		if (!($request->password == $request->re_password)) {
			session()->flash('message', '<span class="text-danger">'. Lang::get('messages.auth.textfillingerror') . '</span>');
			return redirect()->route('admin_registration');
		}

		$p_num = intval($request->numberprimary);
		$s_num = intval($request->numbersecondary);

		if(isset($request->numberresult) && (($p_num + $s_num) == intval($request->numberresult)))
		{
			$admin_response = self::registration_authentication($request, 'web');

			if ($admin_response['statuscode'] == 200 || $admin_response['statuscode'] == 201)
			{
				session()->flash('message', '<span class="text-black">'.$admin_response['message'].'</span>');
				return redirect()->route('admin_login');
			}
			else
			{
				session()->flash('message', '<span class="text-danger">'.$admin_response['message'].'</span>');
				return redirect()->route('admin_registration')->withInput();
			}
		}
		else
		{
			session()->flash('message', '<span class="text-danger">'. Lang::get('messages.auth.textrobot') . '</span>');
			return redirect()->route('admin_registration')->withInput();
		}
	}

	public function admin_modify_post(Request $request)
	{
		if (Hash::check($request->currentpassword, Auth::user()->password))
		{
			if (isset($request->newpassword))
			{
				if (!(isset($request->newpasswordagain) && $request->newpassword == $request->newpasswordagain))
				{
					session()->flash('message', '<span class="text-danger">'. Lang::get('messages.auth.textpassdonotmatch') .'</span>');
					return redirect()->route('admin_user')->withInput();
				}
			}

			$admin_response = self::modify_autentichation($request);

			if ($admin_response['statuscode'] == 200 || $admin_response['statuscode'] == 201)
			{
				session()->flash('message', '<span class="text-success">'.$admin_response['message'].'</span>');
				return redirect()->route('admin_user');
			}
			else
			{
				session()->flash('message', '<span class="text-danger">'.$admin_response['message'].'</span>');
				return redirect()->route('admin_user');
			}
		}
		else
		{
			session()->flash('message', '<span class="text-danger">'. Lang::get('messages.auth.textinvalidpassword') . '</span>');
			return redirect()->route('admin_user')->withInput();
		}
	}

	public function admin_logout()
	{
		Auth::logout();
		Cache::forget('webuser');
		session()->flash('message', '<span class="text-black">'. Lang::get('messages.auth.textloggedout') . '</span>');
		return redirect()->route('admin_login');
	}

	public function admin_unsubscribe(Request $request)
	{
		if (isset($request->confirm) && $request->confirm == 'on') {
			$user = Auth::user();
			$currentpassword = $request->currentpassword;
			$request = null;
			$request['email'] = $user->email;
			$request['identifier'] = $user->identifier;
			$request['password'] = $currentpassword;
			$admin_response = self::resubscribe($request);

			if ($admin_response['statuscode'] == 200 || $admin_response['statuscode'] == 201)
			{
				session()->flash('message', '<span class="text-success">'.$admin_response['message'].'</span>');
				Auth::logout();
				Cache::forget('webuser');
				return redirect()->route('admin_login');
			}
			else
			{
				session()->flash('message', '<span class="text-danger">'.$admin_response['message'].'</span>');
				return back();
			}

		} else {
			session()->flash('message', '<span class="text-danger">'. Lang::get('messages.auth.textcheckboxnotselected') . '</span>');
			return redirect()->route('admin_user');
		}
	}
	
	public function admin_forgotemail_post(Request $request)
	{
		$admin_response = self::forgotemail_func($request, 'admin');

		if ($admin_response['statuscode'] == 200)
		{
			session()->flash('message', '<span class="text-black">'.$admin_response['message'].'</span>');
			return back();
		}
		else
		{
			session()->flash('message', '<span class="text-danger">'.$admin_response['message'].'</span>');
			return back();
		}
	}

	public function admin_confirmation(Request $request)
	{
		$response = self::confirmation_func($request);

		if ($response['statuscode'] == 200 || $response['statuscode'] == 201)
		{
			session()->flash('message', '<span class="text-black">'.$response['message'].'</span>');
			return view('backend.admin_login');
		}
		else
		{
			session()->flash('message', '<span class="text-danger">'.$response['message'].'</span>');
			return view('backend.admin_login');
		}
	}
	public function admin_newpass(Request $request)
	{
		$getuserid = $request->id;
		$user = User::find($getuserid);
	
		if ($user) {
			$hashed_identifier = $request->identifier;
		} else {
			return back();
		}
		
		if (Hash::check($user->identifier, $hashed_identifier)) {
			$username = ucfirst($user->name);
			session(['userid' => $user->id]);

			if (!(session()->exists('message')))
			{
				session()->flash('message', '<span class="text-black">'. Lang::get('messages.auth.textnewpass1') . ' ' . $username . '! ' . Lang::get('messages.auth.textnewpass2') . '</span>');
			}

			return view('backend.admin_newpass');

		} else {
			session()->flash('message', '<span class="text-danger">'. Lang::get('messages.auth.textanerror') . '</span>');
			return back();
		}
	}

	public function admin_newpass_post(Request $request)
	{
		if (isset($request->password) && isset($request->re_password))
		{
			if (strlen($request->password) >= 8)
			{
				if ($request->password == $request->re_password)
				{
					$user = User::find(session('userid'));
					$user->password = Hash::make($request->password);
					if (!$user->email_verified_at)
						$user->email_verified_at = Carbon::now();
					$user->save();
					session()->flash('message', '<span class="text-black">' . $user->name . Lang::get('messages.auth.textyoucantry') . '</span>');
					return redirect()->route('admin_login');
				}
				else
				{
					session()->flash('message', '<span class="text-danger">' . Lang::get('messages.auth.textpassdonotmatch') . '</span>');
					return view('backend.admin_newpass');
				}
			}
			else
			{
				session()->flash('message', '<span class="text-danger">' . Lang::get('messages.auth.textpasswordshot') . '</span>');
				return view('backend.admin_newpass');
			}
		}
		else
		{
			session()->flash('message', '<span class="text-danger">' . Lang::get('messages.auth.textemptyinputfill') . '</span>');
			return view('backend.admin_newpass');
		}
	}
}