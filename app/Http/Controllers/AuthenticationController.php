<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\Forgotemail;

use App\Mail\SimpleEmail;



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

    private static function registration_authentication($request) {
        
        $allReady = true;
        $message = "";
        
        if (empty($request['name']) || empty($request['email']) || empty($request['password']))
        {
            $allReady = false;
            $message .= 'Name, email, and password are required. ';
        }
    
        if (!filter_var($request['email'], FILTER_VALIDATE_EMAIL))
        {
            $allReady = false;
            $message .= 'Invalid email format. ';
        }
        
        if (User::where('email', $request['email'])->first())
        {
            $allReady = false;
            $message .= 'The email address is already taken. ';
        }
        
        if (User::where('name', $request['name'])->first())
        {
            $allReady = false;
            $message .= 'The username is already in use. ';
        }
        
        if (strlen($request['password']) < 8)
        {
            $allReady = false;
            $message .= 'Password must be at least 8 characters long';
        }

        if ($allReady)
        {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'rank' => 0
            ]);

            unset($user['password']);
        
            $token = $user->createToken('auth_token')->accessToken;

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
        $requestData = $request->only(['name', 'email', 'password', 'rank']);

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
        
        if (strlen($request['password']) < 8) {
            $allReady = false;
            $message .= 'Password must be at least 8 characters long. ';
        }

        if ($allReady)
        {
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

    private static function logout_autentichation($request) {
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

    private static function request_maker($response) {

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
        $response = self::login_authentication($request);
        $return_response = self::request_maker($response);

        return response()->json([$return_response['messages']
        ], $return_response['statuscode']);
    }

    public function api_register(Request $request)
    {
        $response = self::registration_authentication($request);
        $return_response = self::request_maker($response);

        return response()->json([$return_response['messages']
        ], $return_response['statuscode']);
    }

    public function api_modify(Request $request)
    {
        $response = self::modify_autentichation($request);
        $return_response = self::request_maker($response);

        return response()->json([$return_response['messages']
        ], $return_response['statuscode']);
    }

    public function api_logout(Request $request)
    {
        $response = self::logout_autentichation($request);
        $return_response = self::request_maker($response);

        return response()->json([$return_response['messages']
        ], $return_response['statuscode']);
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
            return redirect()->route('admin_login');
        }

        // Itt lesz ellenőrizve hogy visszaigazolta-e az email címet.

        // if (User::where('email', $request->email)->whereNull('email_verified_at')->exists())
        // {
        //     session()->flash('message', 'Sikertelen bejelentkezés!');
        //     return back();
        // }

        $stay = ($request->stay == 'on') ? true : false;

        if (Auth::attempt(['name' => $request->usernameoremail, 'password' =>  $request->password], $stay) 
         || Auth::attempt(['email' => $request->usernameoremail, 'password' =>  $request->password], $stay))
        {
            $request->session()->regenerate();
            return redirect()->route('admin_index');
        }
        else
        {
            session()->flash('message', '<span class="text-danger">Incorrect login!</span>');
            return redirect()->route('admin_login');
        }
    }

    public function admin_logout()
    {
        Auth::logout();
        session()->flash('message', 'You have logged out of your account!');
        return view('backend.admin_login');
    }
    
    public function admin_forgotemail_post(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            session()->flash('message', '<span class="text-danger">You did not enter the e-mail address format.</span>');
            return view('backend.admin_login');
        }

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            session()->flash('message', '<span class="text-danger">Incorrect email entry.</span>');
            return view('backend.admin_login');
        }

        //dd($request->email);

        $toEmail = $request->email;
        $subject = 'Teszt e-mail';
        $message = 'Ez egy teszt e-mail a Laravelből.';
    
        Mail::to($toEmail)->send(new ForgotEmail($subject, $message));

        session()->flash('message', '<span class="text-black">We have sent the letter to your address.</span> <span class="text-primary text-italic">'.$request->email.'</span> <span class="text-black"> Check your letters!');
        return view('backend.admin_login');
    }

    public function admin_newpass($identification = null)
    {
        dump($identification);

        session()->flash('message', '<span class="text-black">Helló Newcommer!</span>');
        return view('backend.admin_newpass');

    }
    public function admin_newpass_post(Request $request)
    {
        dd($request);
    }
}