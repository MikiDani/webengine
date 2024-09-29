@extends('backend_default')

@section('page_js')
	<script type="module" src="/js/backend.js"></script>
@endsection

@section('content')
	<div class="row p-0 m-0 full-win">
		<div class="d-flex justify-content-center align-items-center">
			<div class="login-box col-12 col-sm-8 col-md-6 col-xl-4 p-3 my-3 bg-light rounded">
				<div class="login-box-head">
					<hr>
						<div class="d-flex justify-content-center align-items-center">
							<a href="{{route('start')}}" class="link-clean">
								<h3 class="text-uppercase p-0 m-0 mx-5 text-center">
									<img src="{{ env('APP_LOGO') }}" alt="{{ env('APP_NAME') }} logo" class="admin-login-logo">
									{{ env('APP_NAME') }}
								</h3>
							</a>
							@include('backend._langselector')
							<div class="icon-bg icon-bg-3">
								<i class="bi bi-box-arrow-in-right align-middle icon-size-3 text-white"></i>
							</div>
						</div>
					<hr><h4 class="text-center">{{ __('messages.login.textlogin') }}</h4><hr>
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
						<label class="mt-3">{{ __('messages.login.textusernameoremail') }}</label>
						<input type="text" name="usernameoremail" value="{{ old('usernameoremail') }}" class="form-control mt-2">
					</p>
					<p>
						<label class="mt-3">{{ __('messages.login.textpassword') }}</label>
						<input type="password" name="password" class="form-control mt-2">
					</p>
					<div class="row p-0 m-0 login-distance">
						<div class="p-0 m-0 col-12 col-xl-6 text-center">
							<label class="me-1">{{ __('messages.login.textistay') }}</label>
							<input type="checkbox" name="stay" class="form-check-input align-middle p-0 m-0">
						</div>
						<div class="p-0 m-0 col-12 col-xl-6 mb-3 mb-xl-0 text-center">
							<a href="{{route('admin_registration')}}">{{ __('messages.login.textiwouldlike') }}</a>
						</div>
					</div>
					<div class="row p-0 m-0">
						<button type="submit" class="btn btn-lg bg-primary text-uppercase text-white">{{ __('messages.login.textlogin') }}</button>
						<div class="forgot-button link-1 login-distance text-center p-3">
							<span><i class="bi bi-patch-question align-middle me-2"></i>{{ __('messages.login.textiforgot') }}</span>
						</div>
					</div>
				</form>
				<form id="forgot-password" class="forgot-action" style="display:none;" method="POST" action="{{route('admin_forgotemail_post')}}" novalidate>
					@csrf
					<div class="row p-0 m-0">
						<span class="p-0 m-0 mb-2">{{ __('messages.login.textpleaseenter') }}</span>
						<div class="col-9 p-0 m-0">
							<p>
								<input id="email" type="email" name="email" class="form-control form-control-sm width-95 pe-2" autocomplete="off" disabled required>
							</p>
						</div>
						<div class="col-3 p-0 m-0">
							<button type="submit" class="btn btn-sm btn-primary text-uppercase text-white w-100">{{ __('messages.login.textsend') }}</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection