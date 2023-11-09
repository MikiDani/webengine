@extends('backend_default')

@section('page_js')
	<script type="module" src="/js/backend.js"></script>
@endsection

@section('content')

	@include('backend.admin_menu')

	<div class="row card mt-3 mx-auto">
		@if(session('message'))
			<div class="p-3 bg-info rounded">
				<h6>{{ session('message') }}</h6>
			</div>
		@endif
		<div class="row p-0 m-0 menu-head bg-success rounded-top p-2">
			<div class="col-12 col-lg-3 p-0 m-0 me-lg-2">
				<button id="new-root-menu" class="form-control form-control-sm border-0 d-inline bg-primary">Add new root menu</button>
			</div>
			<div class="col-12 col-lg-3 p-0 m-0 me-lg-2 mt-2 mt-lg-0">
				<button id="save-menu" class="form-control form-control-sm border-0 d-inline bg-warning">Save Menü</button>
			</div>
		</div>
		<form id="menu-save" method="post" action="{{ route('menu_save') }}" style="display:none;">
			@csrf
			<input id="menuarray" type="hidden" name="menuarray" value="javacript">
		</form>
		<div class="menu-container row p-0 m-0">
			<div id="menu-box" data-max-id="0" class="col-12 col-md-8 p-0 m-0">
				@php $count = 0; $displayValue = $staticmenu == null ? 'block' : 'none'; @endphp
				<ul data-count="{{ $count }}" class="menu-menurow_{{ $count }} p-0 m-0 p-2">
					<div id="nomenuelement" class="p-0 m-0 p-2 mb-0 bg-info text-center rounded" style="display:{{ $displayValue }}">{{ __('messages.pagemenulist.menujsonisempty') }}</div>
					@if($staticmenu !== null)
						@foreach ($staticmenu as $menu)
							@include('backend._menu-item', ['menu' => $menu])
						@endforeach
					@endif
				</ul>
			</div>
			<div id="menu-element-box" class="col-12 col-md-4 p-0 m-0 p-2 pt-0 p-lg-2 bg-light rounded">
				<div id="menu-element-label" class="p-0 m-0 p-2 ps-3 bg-primary rounded d-flex align-items-center text-bold">{{ __('messages.pagemenulist.selectedelementlabel') }}</div>
			</div>
		</div>
	</div>
@endsection