@extends('backend_default')

@section('page_js')
	<script type="module" src="/js/backend.js"></script>
@endsection

@section('content')
	
	@include('backend.admin_menu')
	
	<div class="row p-0 m-0">
		<div class="d-flex justify-content-center align-items-top">
			<div class="login-box col-12 col-sm-8 col-md-6 col-xl-4 p-3 my-3 bg-light rounded">
				<div class="login-box-head">
					<hr><h4 class="text-center">{{ __('messages.userprofile.textuserprofile') }}</h4><hr>
				</div>
				<div class="message text-center p-3">
					@if(session('message'))
						<h6 class="p-0 m-0">{!! session('message') !!}</h6>
						@php Session::forget('message'); @endphp
					@endif
				</div>
				<form method="POST" id="profile-form" action="{{route('admin_modify_post')}}" autocomplete="off" novalidate>
					@csrf
					<label>{{ __('messages.userprofile.textemail') }}</label>
					<input type="text" value="{{ Auth::check() ? Auth::user()->email : '' }}" class="form-control mt-2" disabled>
					<p class="p-0 m-0 mt-3">
						<span>{{ __('messages.userprofile.textyourcurrent') }}</span>
						<input id="currentpassword" type="password" name="currentpassword" class="form-control mt-2">
					</p>
					<p>
						<label class="mt-3">{{ __('messages.userprofile.textusername') }}</label>
						<input type="text" name="name" value="{{ Auth::check() ? Auth::user()->name : '' }}" class="form-control mt-2">
					</p>
					@if( Auth::user()->rank == 0)
						<p>
							{{ Auth::user()->rank }}
							<label class="mt-3">{{ __('messages.userprofile.textrank') }}</label>
							<select name="rank" class="form-control mt-2">
								<option value="1" @if( Auth::user()->rank == 1) selected @endif>User</option>
								<option value="0" @if( Auth::user()->rank == 0) selected @endif>Admin</option>
							</select>
						</p>
					@endif
					{{-- action change password --}}
					<div class="row p-0 m-0">
						<div class="change-button link-1 login-distance text-center p-3 pb-0">
							<span><i class="bi bi-key align-middle me-2"></i>{{ __('messages.userprofile.textiwantto') }}</span>
						</div>
					</div>
					<div class="change-action row p-0 m-0 mb-5" style="display:none;">
						<p class="p-0 m-0">
							<label>{{ __('messages.userprofile.textnewpass') }}</label>
							<input type="password" id="newpassword" name="newpassword" class="form-control mt-2" disabled>
						</p>
						<p class="p-0 m-0 mt-3">
							<label>{{ __('messages.userprofile.textnewpassagain') }}</label>
							<input type="password" id="newpasswordagain" name="newpasswordagain" class="form-control mt-2" disabled>
						</p>
					</div>
					{{-- submit --}}
					<div class="row p-0 m-0">
						<button id="modifyprofilebutton" type="submit" class="btn btn-lg bg-primary text-uppercase text-white">{{ __('messages.userprofile.textmodifyprofile') }}</button>
					</div>
				</form>
				{{-- action subscribe --}}
				<div class="row p-0 m-0">
					<div class="unsubscribe-button link-1 login-distance text-center p-3">
						<span><i class="bi bi bi-exclamation-diamond align-middle me-2"></i>{{ __('messages.userprofile.textiwouldlike') }}</span>
					</div>
				</div>
				<div class="unsubscribe-action row p-0 m-0" style="display:none;">
					<form method="POST" id="unsubscribe-form" action="{{ route('admin_unsubscribe') }}" class="row p-0 m-0" novalidate>
						@csrf
						<div class="row col-12 p-0 m-0 mb-3">
							<p class="p-0 m-0 my-3">
								<span>{{ __('messages.userprofile.textyourcurrent') }}</span>
								<input type="password" name="currentpassword" class="form-control mt-2">
							</p>
							<div class="col-6 p-0 m-0 d-flex justify-content-end align-items-center pe-2">
								<input type="checkbox" name="confirm" class="form-check-input me-2">
								<label>{{ __('messages.userprofile.textconfirmation') }}</label>
							</div>
							<div class="col-6 p-0 m-0 d-flex justify-content-start align-items-center">
								<input type="submit" value="{{ __('messages.userprofile.textdelete') }}" class="btn btn-danger text-white">
							</div>
							<p id="checkbox-messages" class="p-0 m-0 mt-2 error-style"></p>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection