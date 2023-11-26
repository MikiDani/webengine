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
	
    <h1>NEWS</h1>

    @php

        print "MODULE:";
        dump($module);
        print "NEWS:";
        dump($news);

    @endphp

</div>
@endsection