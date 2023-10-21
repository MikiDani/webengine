@extends('backend_default')

@section('page_js')
<script type="module" src="/js/authentication.js"></script>
<script type="module" src="/js/registration_validate.js"></script>
<script type="module" src="/js/validate_messages.js"></script>
@endsection

@section('content')
    @php $number_primary = rand(0,9); $number_secondary = rand(0, 9); @endphp
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
                    <hr><h4 class="text-center">Registration</h4><hr>
                </div>
                <div class="message text-center p-3">
                    @if(session('message'))
                        <h6 class="p-0 m-0">{!! session('message') !!}</h6>
                        @php Session::forget('message'); @endphp
                    @endif
                </div>
                <form method="POST" id="registration-form" action="{{route('admin_registration_post')}}" autocomplete="off" novalidate>
                    @csrf
                    <p>
                        <label class="mt-3">Username</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control mt-2">
                    </p>
                    <p>
                        <label class="mt-3">E-mail</label>
                        <input type="text" name="email" value="{{ old('email') }}" class="form-control mt-2">
                    </p>
                    <p>
                        <label class="mt-3">Password</label>
                        <input type="password" id="password" name="password" class="form-control mt-2">
                    </p>
                    <p>
                        <label class="mt-3">Password again</label>
                        <input type="password" name="re_password" class="form-control mt-2">
                    </p>
                    <div class="row p-0 m-0">
                        <div class="robot-button link-1 login-distance text-center">
                            <span><i class="bi bi-exclamation-diamond align-middle me-2"></i>Please give me the result.</span>
                        </div>
                    </div>
                    <div class="robot-action row p-0 m-0" style="display:none;">
                        <span class="p-0 m-0">Enter the sum of the numbers.</span>
                        <div class="d-flex justify-content-center align-items-center p-0 m-0 mt-2 mb-3">
                            <span class="form-control number-width">{{ $number_primary }}</span>
                            <span class="mx-2"> + </span>
                            <span class="form-control number-width">{{ $number_secondary }}</span>
                            <span class="mx-2"> = </span>
                            <input type="number" name="numberresult" value="{{ old('numberresult') }}" min="0" max="18" class="form-control number-width">
                            <input type="hidden" name="numberprimary" value="{{ $number_primary }}">
                            <input type="hidden" name="numbersecondary" value="{{ $number_secondary }}">
                        </div>
                    </div>
                    <div class="row p-0 m-0 login-distance text-center">
                        <a href="{{route('admin_login')}}">I go to the login page.</a>
                    </div>
                    <div class="row p-0 m-0">
                        <button type="submit" class="btn btn-lg bg-primary text-uppercase text-white">Registration</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection