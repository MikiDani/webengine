@extends('backend_default')

@section('content')
	@include('backend.admin_menu')
	<div class="row card mx-auto p-3 m-3">
		
		@if(session('message'))
			<div class="p-3 bg-info">
				<h6>{{ session('message') }}</h6>
			</div>
		@endif
		
		Menus
		
	</div>
@endsection