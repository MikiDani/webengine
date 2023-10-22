@extends('backend_default')

@section('page_js')
	<script type="module" src="/js/backend.js"></script>
@endsection

@section('content')
@include('backend.admin_menu')
<div class="row card mx-auto p-3 m-3">
	
	@if(session('message'))
		<div class="p-3 bg-info">
			<h6>{{ session('message') }}</h6>
		</div>
	@endif
	
	<p>{{ __('messages.adminindex.text01') }}</p>

	<figure>
		<img src="/img/image.jpg" alt="{{ __('messages.adminindex.text01alt') }}" class="w-100">
		<figcaption>{{ __('messages.adminindex.textpic01figtcaption') }}</figcaption>
	</figure>
	
</div>
@endsection