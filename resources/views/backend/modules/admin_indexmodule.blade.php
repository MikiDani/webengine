@php    
	if (str_replace('_', '-', app()->getLocale()) == "hu") {
		$menuname = $menu['menuname_hu'];
		$modulename = $module['modulename_hu'];
	}
	else if (str_replace('_', '-', app()->getLocale()) == "en")
	{
		$menuname = $menu['menuname_en'];
		$modulename = $module['modulename_en'];
	}
@endphp

@extends('backend_default')

@section('page_js')
	<script type="module" src="/js/backend.js"></script>
@endsection

@section('content')
@include('backend.admin_menu')
<div class="row card mx-auto p-3 m-3">
	
	<h3 class="text-center"></h3>
	<div class="crumbmenu p-0 m-0 pb-3">
		<a href="{{ route("admin_menus", ['menulistid' => $menu['id']]) }}"><div class="crumbmenu-back-icon d-inline-block p-2 bg-primary rounded"><i class="bi bi-chevron-double-left text-white"></i></div></a>
		<a href="{{ route("admin_menus", ['menulistid' => $menu['id']]) }}">{{ $menuname }}</a> / {{ $modulename }}
	</div>

	@if(session('message'))
		<div class="p-3 pb-0 m-0 text-center">
			<i class="bi bi-chat-right-dots me-3"></i><span>{{ session('message') }}</span>
		</div>
	@endif

	@php $viewway = 'backend.modules._module_' . $moduletype['bladename']; @endphp

	@includeIf($viewway)

</div>
@endsection