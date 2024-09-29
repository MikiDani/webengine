<nav class="navbar navbar-expand-lg navbar-light bg-light">
	<div class="container justify-content-center text-center">
		<a class="navbar-brand" href="{{ route('start') }}"><img src="{{ env('APP_LOGO') }}" alt="{{ env('APP_NAME') }} logo" class="admin-menu-logo">{{ env('APP_NAME') }}</a>
		<button class="navbar-toggler custom-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse backend-menu-text justify-content-center pt-3" id="navbarNav">
			<ul class="navbar-nav">
				<li class="nav-item">
					<a href="{{ route('start') }}">{{ __('messages.adminmenu.textfrontend') }}</a>
				</li>
				<li class="nav-item">
					<a href="{{ route('admin_index') }}">{{ __('messages.adminmenu.textindex') }}</a>
				</li>
				<li class="nav-item">
					<a href="{{ route('admin_menus') }}">{{ __('messages.adminmenu.textpagemenus') }}</a>
				</li>
				<li class="nav-item">
					<a href="{{ route('admin_user') }}">{{ __('messages.adminmenu.textuseroptions') }}</a>
				</li>
				<li class="nav-item">
					<a href="{{ route('admin_logout')}}">{{ __('messages.adminmenu.textlogout') }}</a>
				</li>
				@if (Auth::check())
					<li>
						<span class="mx-3">{{ Auth::user()->name }}</span>
					</li>
				@endif
				<li>
					@include('backend._langselector')
				</li>
			</ul>
		</div>
	</div>
</nav>