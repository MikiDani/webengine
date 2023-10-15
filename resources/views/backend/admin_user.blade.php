@extends('backend_default')

@section('content')
    @include('backend.admin_menu')

        
        <div class="row p-0 m-0">
            <div class="d-flex justify-content-center align-items-top">
                <div class="login-box col-12 col-sm-8 col-md-6 col-xl-4 p-3 my-3 bg-light rounded">
                    <div class="login-box-head">
                        <hr>
                            <h4 class="text-center">User Profile</h4>
                        <hr>
                    </div>
                    <div class="message text-center p-3">
                        @if(session('message'))
                            <h6 class="p-0 m-0">{!! session('message') !!}</h6>
                            @php Session::forget('message'); @endphp
                        @endif
                    </div>
                    <form method="POST" action="{{route('admin_login_post')}}">
                        @csrf
                        <label class="mt-3">Username or email</label>
                        <input type="text" name="usernameoremail" value="miklosdani@gmail.com" class="form-control mt-2" minlength="8" maxlength="255" autocomplete="off" required>
                        <label class="mt-3">Password</label>
                        <input type="password" name="password" value="12345678" class="form-control mt-2" minlength="8" maxlength="255" autocomplete="off" required>
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
                </div>
            </div>
        </div>
        
@endsection