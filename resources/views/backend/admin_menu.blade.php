<nav class="navbar navbar-expand-sm navbar-light bg-light">
	<div class="container justify-content-center text-center">
		<a class="navbar-brand" href="{{ route('start') }}"><img src="/img/favicons/apple-touch-icon.png" alt="logo" class="admin-menu-logo"> WebEngine</a>
		<button class="navbar-toggler custom-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse backend-menu-text justify-content-center pt-3" id="navbarNav">
			<ul class="navbar-nav">
				<li class="nav-item">
					<a href="{{ route('start') }}">Frontend page</a>
				</li>
				<li class="nav-item">
					<a href="{{ route('admin_index') }}">Index</a>
				</li>
				<li class="nav-item">
					<a href="{{ route('admin_menus') }}">Page Menus</a>
				</li>
				<li class="nav-item">
					<a href="{{ route('admin_user') }}">User Options</a>
				</li>
				<li class="nav-item">
					<a href="{{ route('admin_logout')}}">Logout</a>
				</li>
			</ul>
		</div>
	</div>
</nav>