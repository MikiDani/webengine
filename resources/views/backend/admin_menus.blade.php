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
			<div id="menu-box" class="col-12 col-md-6 p-0 m-0">
				@php $count = 0; @endphp
				<ul data-count="{{ $count }}" class="menu-menurow_{{ $count }} p-0 m-0 p-2">
					@foreach ($staticmenu as $menu)
						@include('backend._menu-item', ['menu' => $menu])
					@endforeach
				</ul>
			</div>
			<div id="menu-element-box" class="col-12 col-md-6 p-0 m-0 p-2 bg-light rounded">
				<div id="menu-element-label" class="p-0 m-0 p-2 ps-3 bg-primary rounded d-flex align-items-center text-bold">Label</div>

				<p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Similique saepe non, eum repudiandae quaerat quasi, quae ex molestias consequuntur, sequi ipsam doloremque sed assumenda facere? Quisquam voluptates possimus id minus.
				Minima corporis similique ipsam accusamus vero, modi blanditiis. Minima eius at earum in aspernatur, non, a magni dolores maxime optio ullam error delectus eveniet ipsam quis. Qui doloremque quod ad.
				Commodi, maxime! In rem eius soluta amet facere sequi error libero nam aut nulla iure sapiente, tenetur officiis? Voluptas atque quaerat ipsam praesentium officiis nesciunt sunt ea possimus deleniti in?
				Aperiam, fugiat. Veniam natus sit voluptate perspiciatis.</p>
			</div>
		</div>
	</div>
@endsection