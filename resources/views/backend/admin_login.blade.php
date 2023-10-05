@extends('backend_default')

@section('css')
	{{-- modulok css majd  --}}
@endsection

@section('js')
    <script src="/backend/javascript/admin.js"></script>
@endsection

@section('content')
    <form method="POST" action="{{route('admin_login_post')}}">
        @csrf
        <div class="row p-2 m-0 admin-login-content d-flex justify-content-center align-items-center">
            <div class="login-box col-12 col-md-6 col-xl-4 p-3 bg-light rounded">
                <div class="login-box-head">
                    <hr>
                    <div class="d-flex justify-content-center align-items-center">
                        <h3 class="text-uppercase align-middle p-0 m-0 mx-3">Admin Login</h3>
                        <div class="icon-bg icon-bg-3">
                            <i class="bi bi-box-arrow-in-right align-middle icon-size-3 text-white"></i>
                        </div>
                    </div>
                    <hr>
                </div>
                <div class="p-3 bg-info">
                    @auth
                        {{-- Ide kerülnek a bejelentkezett felhasználó számára megjelenítendő tartalmak --}}
                        Üdvözöljük, {{ Auth::user()->name }}!
                    @endauth
                    @guest
                        {{-- Ide kerülnek a bejelentkezés nélküli felhasználók számára megjelenítendő tartalmak --}}
                        Kérjük, jelentkezzen be vagy regisztráljon!
                    @endguest
                    @if (session()->has('access_token'))
                        {{ session('access_token') }}
                    @endif
                </div>
                <label class="mt-3">Username or email</label>
                <input type="text" name="usernameoremail" value="admin@admin.hu" class="form-control mt-2" minlength="5" maxlength="255" required>
                <label class="mt-3">Password</label>
                <input type="password" name="password" value="12345678" class="form-control mt-2" minlength="8" maxlength="255" required>
                
                <div class="message text-center p-3 text-danger">
                    @if(session('message'))
                        <h6>{{ session('message') }}</h6>
                    @endif
                </div>

                <div class="row p-0 m-0 mt-4">
                    <div class="col-4 p-0 m-0">
                        <button type="submit" class="btn btn-lg bg-primary text-uppercase text-white">Login</button>
                    </div>
                    <div class="col-8 p-0 m-0 my-auto">
                        <a class="link-1" href="#">
                            <span><i class="bi bi-exclamation-circle-fill text-warning"></i> I forgot my password!</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
    </form>
@endsection