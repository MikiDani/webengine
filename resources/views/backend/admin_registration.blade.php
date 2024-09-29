@extends('backend_default')

@section('page_js')
	<script type="module" src="/js/backend.js"></script>
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
					<hr><h4 class="text-center">{{ __('messages.registration.textregistration') }}</h4><hr>
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
						<label class="mt-3">{{ __('messages.registration.textusername') }}</label>
						<input type="text" name="name" value="{{ old('name') }}" class="form-control mt-2">
					</p>
					<p>
						<label class="mt-3">{{ __('messages.registration.textemail') }}</label>
						<input type="text" name="email" value="{{ old('email') }}" class="form-control mt-2">
					</p>
					<p>
						<label class="mt-3">{{ __('messages.registration.textpassword') }}</label>
						<input type="password" id="password" name="password" class="form-control mt-2">
					</p>
					<p>
						<label class="mt-3">{{ __('messages.registration.textpasswordagin') }}</label>
						<input type="password" name="re_password" class="form-control mt-2">
					</p>
					<div class="row p-0 m-0">
						<div class="robot-button link-1 login-distance text-center">
							<span><i class="bi bi-exclamation-diamond align-middle me-2"></i>{{ __('messages.registration.textpleaseresult') }}</span>
						</div>
					</div>
					<div class="robot-action row p-0 m-0" style="display:none;">
						<span class="p-0 m-0">{{ __('messages.registration.textenterthesum') }}</span>
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
						<a href="{{route('admin_login')}}">{{ __('messages.registration.textigo') }}</a>
					</div>
					<div class="row p-0 m-0">
						<button type="submit" class="btn btn-lg bg-primary text-uppercase text-white">{{ __('messages.registration.textregistration') }}</button>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection