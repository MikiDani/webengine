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
                            <h3 class="text-uppercase align-middle p-0 m-0 mx-3">
                                <img src="/img/favicons/apple-touch-icon.png" alt="logo" class="admin-login-logo">
                                WebEngine
                            </h3>
                            <div class="icon-bg icon-bg-3">
                                <i class="bi bi-box-arrow-in-right align-middle icon-size-3 text-white"></i>
                            </div>
                        </div>
                    <hr><h4 class="text-center">New Password</h4><hr>
                </div>
                <div class="message text-center p-3">
                    @if(session('message'))
                        <h6 class="p-0 m-0">{!! session('message') !!}</h6>
                        @php session()->forget('message'); @endphp
                    @endif
                </div>
                <form method="POST" id="newpass-form" action="{{route('admin_newpass_post')}}" autocomplete="off" novalidate>
                    @csrf
                    <p>
                        <label class="mt-3">New Password</label>
                        <input type="password" id="password" name="password" class="form-control mt-2" minlength="8" maxlength="255" autocomplete="off" required>
                    </p>
                    <p>
                        <label class="mt-3">Repeat password</label>
                        <input type="password" name="re_password" class="form-control mt-2" minlength="8" maxlength="255" autocomplete="off" required>
                    </p>
                    <div class="row p-0 m-0">
                        <button type="submit" class="btn btn-lg bg-primary text-uppercase text-white">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection