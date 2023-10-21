@extends('backend_default')

@section('page_js')
    <script type="module" src="/js/authentication.js"></script>
@endsection

@section('content')
    <div class="row p-0 m-0 full-win">
        <div class="d-flex justify-content-center align-items-center">
            <div class="login-box col-12 col-sm-8 col-md-6 col-xl-4 p-3 my-3 bg-light rounded">
                <div class="login-box-head">
                    <hr>
                        <div class="d-flex justify-content-center align-items-center">
                            <a href="{{route('start')}}" class="link-clean">
                                <h3 class="text-uppercase align-middle p-0 m-0 mx-3">
                                    <img src="/img/favicons/logo_anim.gif" alt="logo" class="admin-login-logo">
                                    WebEngine
                                </h3>
                            </a>
                            <div class="icon-bg icon-bg-3">
                                <i class="bi bi-box-arrow-in-right align-middle icon-size-3 text-white"></i>
                            </div>
                        </div>
                    <hr><h4 class="text-center">Login</h4><hr>
                </div>
                <div class="message text-center p-3">
                    @if(session('message'))
                        <h6 class="p-0 m-0">{!! session('message') !!}</h6>
                        @php Session::forget('message'); @endphp
                    @endif
                </div>
                <form method="POST" id="login-form" action="{{route('admin_login_post')}}" autocomplete="off" novalidate>
                    @csrf
                    <p>
                        <label class="mt-3">Username or email</label>
                        <input type="text" name="usernameoremail" value="{{ old('usernameoremail') }}" class="form-control mt-2">
                    </p>
                    <p>
                        <label class="mt-3">Password</label>
                        <input type="password" name="password" class="form-control mt-2">
                    </p>
                    <div class="row p-0 m-0 login-distance">
                        <div class="col-6 text-center">
                            <label class="me-1">I stay logged in</label>
                            <input type="checkbox" name="stay" class="form-check-input align-middle p-0 m-0">
                        </div>
                        <div class="col-6 text-center">
                            <a href="{{route('admin_registration')}}">I would like to register</a>
                        </div>
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
                        <span class="p-0 m-0 mb-2">Please enter the email address you registered with.</span>
                        <div class="col-9 p-0 m-0">
                            <input type="email" name="email" class="form-control form-control-sm width-95 pe-2" autocomplete="off" required>
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