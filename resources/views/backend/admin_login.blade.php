@extends('backend_default')

@section('page_js')
<script type="module" src="/js/login.js"></script>
@endsection

@section('content')
    <div class="row p-0 m-0 full-win">
        <div class="d-flex justify-content-center align-items-center">
            <div class="login-box col-12 col-sm-8 col-md-6 col-xl-4 p-3 my-3 bg-light rounded">
                <div class="login-box-head">
                    <hr>
                        <div class="d-flex justify-content-center align-items-center">
                            <h3 class="text-uppercase align-middle p-0 m-0 mx-3">
                                <img src="/img/favicons/apple-touch-icon.png" alt="logo" class="admin-login-logo">
                            WebEngine</h3>
                            <div class="icon-bg icon-bg-3">
                                <i class="bi bi-box-arrow-in-right align-middle icon-size-3 text-white"></i>
                            </div>
                        </div>
                    <hr>
                        <h4 class="text-center">Admin Login</h4>
                    <hr>
                </div>
                <div class="message text-center p-3">
                    @if(session('message'))
                        <h6 class="p-0 m-0">{!! session('message') !!}</h6>
                    @endif
                </div>
                <form method="POST" action="{{route('admin_login_post')}}">
                    @csrf
                    <label class="mt-3">Username or email</label>
                    <input type="text" name="usernameoremail" value="miklosdani@gmail.com" class="form-control mt-2" minlength="8" maxlength="255" required>
                    <label class="mt-3">Password</label>
                    <input type="password" name="password" value="12345678" class="form-control mt-2" minlength="8" maxlength="255" required>
                    <div class="login-distance">
                        <label class="me-2">I stay logged in</label>
                        <input type="checkbox" name="stay" class="form-check-input align-middle p-0 m-0">
                    </div>
                    <div class="row p-0 m-0">
                        <button type="submit" class="btn btn-lg bg-primary text-uppercase text-white">Login</button>
                        <div class="forgot-button link-1 login-distance text-center p-3">
                            <span><i class="bi bi-patch-question align-middle me-2"></i>I forgot my password!</span>
                        </div>
                    </div>
                </form>
                <form class="forgot-action" style="display:none;" method="POST" action="{{route('admin_forgotemail_post')}}">
                    @csrf
                    <div class="row p-0 m-0">
                        <span>Please enter the email address you registered with.</span>
                        <div class="col-9 p-0 m-0">
                            <input type="email" name="email" value="miklosdani@gmail.com" class="form-control form-control-sm width-95 pe-2" required>
                        </div>
                        <div class="col-3 p-0 m-0">
                            <button type="submit" class="btn btn-sm btn-primary text-uppercase text-white w-100">Send</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection