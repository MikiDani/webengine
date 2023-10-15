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

class AuthenticationController extends Controller
{
    // STATIC

    private static function login_authentication($request) {
        if (empty($request['password']))
        {
            return [
                'statuscode' => 400,
                'message' => 'No password entered.',
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
                    'message' => 'Wrong username or email.'
                ];
            }
        } 
        else
        {
            return [
                'statuscode' => 400,
                'message' => 'No username or email entered.'
            ];
        }

        if(!$user || !Hash::check($request->password, $user->password))
        {
            return [
                'statuscode' => 400,
                'message' => 'Incorrect login!'
            ];
        }

        $token = $user->createToken('auth_token')->accessToken;
        
        unset($user['password']);
        
        return [
            'statuscode' => 200,
            'message'=> 'Successful login.',
            'user' => $user,
            'token' => $token,
        ];
    }

    private static function registration_authentication($request, $type) {
        
        $allready = true;
        $message = "";
        
        if (empty($request['name']) || empty($request['email']) || empty($request['password']))
        {
            $allready = false;
            $message .= 'Name, email, and password are required. ';
        }
    
        if (!filter_var($request['email'], FILTER_VALIDATE_EMAIL))
        {
            $allready = false;
            $message .= 'Invalid email format. ';
        }
        
        if (User::where('email', $request['email'])->first())
        {
            $allready = false;
            $message .= 'The email address is already taken. ';
        }
        
        if (User::where('name', $request['name'])->first())
        {
            $allready = false;
            $message .= 'The username is already in use. ';
        }
        
        if (strlen($request['password']) < 8)
        {
            $allready = false;
            $message .= 'Password must be at least 8 characters long';
        }

        if ($allready)
        {
            $identifier = md5(rand(1000000000, 9999999999));

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'identifier' => $identifier,
                'rank' => 0
            ]);

            unset($user['password']);
        
            $token = $user->createToken('auth_token')->accessToken;

            Mail::to($user['email'])->send(new ConfirmEmail($user['email'], $type));

            return [
                'statuscode' => 201,
                'user' => $user,
                'token' => $token,
                'message' => 'The registration is successful!',
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

    private static function modify_autentichation($request) {
        $user = auth()->user();
        $requestData = $request->only(['name', 'email', 'rank']);

        $allReady = true;
        $message = "";

        if (!empty($request['name']))
        {
            if (strlen($request['name']) < 5) {
                $allReady = false;
                $message .= 'Username must be at least 5 characters long. ';
            } 
            else if (User::where('name', $request['name'])->count() && 
            User::where('name', $request['name'])->first()->name !== $user->name)
            {
                $allReady = false;
                $message .= 'The username is already in use. ';
            }
        }

        if (User::where('email', $request['email'])->count() && 
            User::where('email', $request['email'])->first()->email !== $user->email)
        {
            $allReady = false;
            $message .= 'The email is already in use. ';
        } 
        else
        {
            if (isset($request['email']) && !filter_var($request['email'], FILTER_VALIDATE_EMAIL))
            {
                $allReady = false;
                $message .= 'Invalid email format. ';
            }
        }
        
        if ($allReady)
        {
            if (isset($request['new_password']))
            {
                if (strlen($request['new_password']) >= 8) {
                    $user->password = Hash::make($request['new_password']);
                    $user->save();
                } else {
                    return [
                        'statuscode' => 400,
                        'message' => 'The new password must be at least 8 characters long.'
                    ];
                }
            }

            if (!empty($requestData)) {
                $user->update($requestData);
            }
    
            return [
                'statuscode' => 201,
                'message' => 'User has been updated.'
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
                'message' => 'Logged out successfully',
            ];
        } else {
            return [
                'statuscode' => 401,
                'message' => 'User is not authenticated',
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
                'message' => 'You did not enter the e-mail address format.'
            ];
        }

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return [
                'statuscode' => 400,
                'message' => 'Incorrect email entry.'
            ];
        }

        $toEmail = $request->email;
        
        Mail::to($toEmail)->send(new ForgotEmail($toEmail, $type));

        return [
            'statuscode' => 200,
            'message' => 'We have sent the letter to your address. '.$request->email.'  Check your letters!'
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

                $message = $username.' succesfuly confirmation.';
            } else {
                $allready = false;
                $message = 'An error occurred during authentication.';
            }
        } else {
            $allready = false;
            $message = 'An error occurred during authentication user.';
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
                    'message' => 'You are already logged in in a browser.'
                ];
            }
        }

        $response = self::login_authentication($request);
        $return_response = self::request_maker($response);

        return response()->json([$return_response['messages']], $return_response['statuscode']);
    }

    public function api_register(Request $request)
    {
        $response = self::registration_authentication($request, 'api');
        $return_response = self::request_maker($response);

        return response()->json([$return_response['messages']], $return_response['statuscode']);
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
                        'message' => 'You are already logged in in a browser.'
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
                    'message' => 'Identification error.'
                ];
            }
        } else {
            $response = [
                'statuscode' => '400',
                'message' => 'Identification error.'
            ];
        }
                
        $return_response = self::request_maker($response);

        return response()->json([$return_response['messages']], $return_response['statuscode']);
    }

    public function api_logout(Request $request)
    {
        $response = self::logout_autentichation($request);
        $return_response = self::request_maker($response);

        return response()->json([$return_response['messages']], $return_response['statuscode']);
    }

    public function api_confirmation(Request $request)
    {
        $response = self::confirmation_func($request);
        $return_response = self::request_maker($response);

        return response()->json([$return_response['messages']], $return_response['statuscode']);
    }

    public function api_forgotemail(Request $request)
    {

        $response = self::forgotemail_func($request, 'api');
        $return_response = self::request_maker($response);

        return response()->json([$return_response['messages']], $return_response['statuscode']);
    }
 
    // WEB
    
    public function admin_login()
    {
        if (session()->has('message')) {
            session()->flash('message', session('message'));
        }
        else
        {
            session()->flash('message', '<span class="text-black">You can log in here.</span>');
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
            session()->flash('message', '<span class="text-danger">The fields were filled in incorrectly.</span>');
            return redirect()->route('admin_login')->withInput();
        }

        $email_check = User::where('email', $request->usernameoremail)->first();
        $name_check = User::where('name', $request->usernameoremail)->first();

        $email_verified = null;

        if ($email_check && Hash::check($request->password, $email_check->password)) {
            $email_verified = $email_check->email_verified_at;
            $userid = $email_check->id;
        } else if ($name_check && Hash::check($request->password, $name_check->password)) {
            $email_verified = $email_check->email_verified_at;
            $userid = $email_check->id;
        } else 
        {
            session()->flash('message', '<span class="text-danger">Incorrect login!</span>');
            return redirect()->route('admin_login')->withInput();
        }

        if(is_null($email_verified))
        {
            session()->flash('message', '<span class="text-warning">You have not yet authenticated yourself by email.</span>');
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
            session()->flash('message', '<span class="text-danger">Incorrect login!</span>');
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
            session()->flash('message', '<span class="text-black">You can registration in here.</span>');
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
            session()->flash('message', '<span class="text-danger">The fields were filled in incorrectly.</span>');
            return redirect()->route('admin_registration')->withInput();
        }

        if (!($request->password == $request->re_password)) {
            session()->flash('message', '<span class="text-danger">Filling error.</span>');
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
            session()->flash('message', '<span class="text-danger">Maybe you are a robot?</span>');
            return redirect()->route('admin_registration')->withInput();
        }
    }

    public function admin_logout()
    {
        Auth::logout();
        Cache::forget('webuser');
        session()->flash('message', 'You have logged out of your account!');
        return redirect()->route('admin_login');
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

        $request->kisfasz = $user;
    
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
                session()->flash('message', '<span class="text-black">Helló '.$username.'! Here you can enter your new password for logging in.</span>');
            }

            return view('backend.admin_newpass');
        } else {
            session()->flash('message', '<span class="text-danger">An error occurred!</span>');
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
                    $user->save();
                    session()->flash('message', 'Hi '. $user->name . ' ! You can try your new password.');
                    return redirect()->route('admin_login');
                }
                else
                {
                    session()->flash('message', 'The two passwords do not match.');
                    return view('backend.admin_newpass');
                }
            }
            else
            {
                session()->flash('message', 'The password must be at least 8 characters long.');
                return view('backend.admin_newpass');
            }
        }
        else
        {
            session()->flash('message', 'Empty input fill.');
            return view('backend.admin_newpass');
        }
    }
}