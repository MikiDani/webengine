@extends('backend_default')

@section('page_js')
	<script type="module" src="/js/backend.js"></script>
@endsection

@section('content')
	@include('backend.admin_menu')
	<form id="menu-save" method="post" action="{{ route('menu_save') }}" class="p-0 m-0">
		@csrf
		<input id="menuarray" type="hidden" name="menuarray" value="javacript">
		<div class="row card mt-3 mx-auto">
			@if(session('message'))
				<div class="p-3 bg-info rounded">
					<h6>{{ session('message') }}</h6>
				</div>
			@endif
			<div class="row p-0 m-0 menu-head bg-success rounded-top p-2">
				<div class="col-12 col-lg-3 p-0 m-0 me-lg-2">
					<button id="new-root-menu" type="button" class="form-control form-control-sm border-0 d-inline bg-primary">Add new root menu</button>
				</div>
				<div class="col-12 col-lg-3 p-0 m-0 me-lg-2 mt-2 mt-lg-0">
					<button id="save-menu" class="form-control form-control-sm border-0 d-inline bg-warning">
						Saving All Changes
						<i class="bi bi-exclamation-diamond"></i>
					</button>
				</div>
			</div>
			<div class="menu-container row p-0 m-0">
				<div id="menu-box" data-max-id="0" class="col-12 col-md-8 p-0 m-0">
					@php $count = 0; $displayValue = $staticmenu == null ? 'block' : 'none'; @endphp
					<ul data-count="{{ $count }}" class="menu-menurow_{{ $count }} p-0 m-0 p-2">
						<div id="nomenuelement" class="p-0 m-0 p-2 mb-0 bg-info text-center rounded" style="display:{{ $displayValue }}">{{ __('messages.pagemenulist.textmenujsonisempty') }}</div>
						@if($staticmenu !== null)
							@foreach ($staticmenu as $menu)
								@include('backend._menu-item', ['menu' => $menu])
							@endforeach
						@endif
					</ul>
				</div>
				<div id="menu-module-box" data-menumodulelist-maxid="0" class="col-12 col-md-4 p-0 m-0 p-2 pt-0 p-lg-2 mt-1 bg-light rounded">
					<div id="menu-module-label" class="p-0 m-0 p-2 ps-3 mb-2 bg-success text-white rounded d-flex align-items-center text-bold">{{ __('messages.pagemenulist.textselectedelementlabel') }}</div>
					@if($menumodulelist)
						@foreach($menumodulelist as $menurowid => $menurowvalue)
							<div class="modulerow_{{ $menurowid }} p-0 m-0" data-id="{{ $menurowid }}" style="display:none;">
								@foreach($menurowvalue as $modulelistid => $modulevalue)
									<div id="menumodulelist_{{ $modulelistid }}" data-modulelist-id="{{ $modulelistid }}" class="module-sortable_{{ $menurowid }} pos-relative bg-primary p-3 pt-1 m-0 mb-2 rounded">
										<input type="hidden" name="edit[{{ $menurowid }}][{{ $modulelistid }}][moduletype]" value="{{ $modulevalue['typeid'] }}">
										<div class="pos-module-arrow">
											<i class="bi bi-arrows-move d-inline-block align-middle me-1"></i>
										</div>
										<div class="pos-module-delete">
											<i class="minus-button-module d-inline-block align-middle me-1" data-modulelist-id="{{ $modulelistid }}"></i>
										</div>
										<div class="text-center text-small">modulelistid: {{ $modulelistid }}</div>	{{-- ideiglenes !!! --}}
										<div class="text-center pb-1">{{ __('messages.pagemenulist.textmoduletypelabel') }} <strong>{{ $modulevalue['typename'] }}</strong></div>
										<div class="p-0 m-0 d-flex justify-content-start align-items-center">
											<div class="p-0 m-0 width-10">HU:</div>
											<div class="p-0 m-0 width-90">
												<input type="text" name="edit[{{ $menurowid }}][{{ $modulelistid }}][modulename_hu]" value="{{ $modulevalue['modulename_hu'] }}" class="form-control">
											</div>
										</div>
										<div class="p-0 m-0 d-flex justify-content-start align-items-center mt-1">
											<div class="p-0 m-0 width-10">EN:</div>
											<div class="p-0 m-0 width-90">
												<input type="text" name="edit[{{ $menurowid }}][{{ $modulelistid }}][modulename_en]" value="{{ $modulevalue['modulename_en'] }}" class="form-control">
											</div>
										</div>
										<a id="selectmodule_{{ $menurowid }}" href="{{ route('admin_module', ['menuid' => $menurowid, 'moduleid' => $modulelistid]) }}" class="btn bg-selectmodulebutton mt-1 w-100">{{ __('messages.pagemenulist.textselectmodulebutton') }}</a>
									</div>
								@endforeach
							</div>
						@endforeach
					@endif
					<div id="new_menumodule" class="pos-relative bg-secondary p-3 pt-1 m-0 mb-2 rounded" style="display:none;">
						<div class="text-center pb-1"><strong>{{ __('messages.pagemenulist.textinsertnewmodule') }}</strong></div>
						<div class="p-0 m-0 d-flex justify-content-start align-items-center">
							<div class="p-0 m-0 width-40">{{ __('messages.pagemenulist.textmoduletypelabel') }}</div>
							<div class="p-0 m-0 width-60">
								<select name="new_moduletype" class="form-control" form="null">
									@foreach($moduletypes as $moduletype)
										<option value="{{ $moduletype->id }}">{{ $moduletype->name }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="p-0 m-0 d-flex justify-content-start align-items-center mt-1">
							<div class="p-0 m-0 width-10">HU:</div>
							<div class="p-0 m-0 width-90">
								<input id="new_modulename_hu" type="text" name="new_modulename_hu" value="{{-- javascript --}}" class="form-control" form="null">
							</div>
						</div>
						<div class="p-0 m-0 d-flex justify-content-start align-items-center mt-1">
							<div class="p-0 m-0 width-10">EN:</div>
							<div class="p-0 m-0 width-90">
								<input id="new_modulename_en" type="text" name="new_modulename_en" value="{{-- javascript --}}" class="form-control" form="null">
							</div>
						</div>
						<button id="add-module-button" type="button" class="btn btn-warning mt-1 w-100" >{{ __('messages.pagemenulist.textaddnew') }}</button>
					</div>
				</div>
			</div>
		</div>
		<input id="id_menulist" type="hidden" name="id_menulist">
	</form>
	<script>
		var page_menulistid = "{{ $menulistid }}"
		var textmoduletypelabel = "{{ __('messages.pagemenulist.textmoduletypelabel') }}"
		var textmoduledeletealert = "{{ __('messages.pagemenulist.textmoduledeletealert') }}"
		var textselectedelementlabel = "{{ __('messages.pagemenulist.textselectedelementlabel') }}"
		var textselectmodulebutton = "{{ __('messages.pagemenulist.textselectmodulebutton') }}"
		var textmustbesaved = "{{ __('messages.pagemenulist.textmustbesaved') }}"
	</script>
@endsection