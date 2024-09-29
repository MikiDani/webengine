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
					<hr><h4 class="text-center">{{ __('messages.newpass.textnewpass') }}</h4><hr>
				</div>
				<div class="message text-center p-3">
					@if(session('message'))
						<h6 class="p-0 m-0">{!! session('message') !!}</h6>
						@php session()->forget('message'); @endphp
					@endif
				</div>
				<form method="POST" id="newpass-form" action="{{ route('admin_newpass_post') }}" autocomplete="off" novalidate>
					@csrf
					<p>
						<label class="mt-3">{{ __('messages.newpass.textnewpass') }}</label>
						<input type="password" id="password" name="password" class="form-control mt-2" minlength="8" maxlength="255" autocomplete="off" required>
					</p>
					<p>
						<label class="mt-3">{{ __('messages.newpass.textrepeatpass') }}</label>
						<input type="password" name="re_password" class="form-control mt-2" minlength="8" maxlength="255" autocomplete="off" required>
					</p>
					<div class="row p-0 m-0 pt-4">
						<button type="submit" class="btn btn-lg bg-primary text-uppercase text-white">{{ __('messages.newpass.textsave') }}</button>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection