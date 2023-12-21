
<div id="gallery-box" class="row p-0 m-0">
	<h4 class="text-center text-uppercase my-2">{{ __('messages.modules.gallery.textgallerymodulename') }}</h4>

	<div class="row p-0 m-0">
		@empty($moduledata)
			<div class="p-3 m-0 text-center">
				<i class="bi bi-chat-right-dots me-3"></i><span>{{ __('messages.modules.gallery.textnodatamessage') }}</span>
			</div>
		@endempty
			
		{{-- NEW IMAGE --}}
		<button class="bg-info rounded-top border-0 p-1 border border-bottom border-5 border-dark" id="collapseButton" data-bs-toggle="collapse" data-bs-target="#gallery-newimage-collapse">
			{{ __('messages.modules.gallery.textnewimagesubmit') }}
			<span class="collapse-icon">
				<i class="bi bi-chevron-bar-down"></i>
			</span>
		</button>
		<div id="gallery-newimage-collapse" class="collapse p-0 m-0">
			<form id="gallery-newimage-form" method="post" action="{{ route("admin_module_save", ['menuid' => $menu['id'], 'moduleid' => $module['id'], 'type' => 'new' ]) }}" class="p-3 m-0 bg-primary rounded-bottom" enctype="multipart/form-data" novalidate>
				@csrf
				<input type="hidden" name="rowid" @isset($rowid) value="{{ $rowid }}" @else value="0" @endisset>
				<input type="hidden" name="moduletype" value="gallery">
				<input type="hidden" name="last_sequence" value="@isset($last_sequence){{ $last_sequence }} @else 0 @endisset">
				<div class="row p-0 m-0">
					<div class="row p-0 m-0 my-2">
						<p class="p-0 m-0">
							<div class="p-0 m-0 col-auto label-min-width align-self-center">
								<label>{{ __('messages.modules.gallery.textpicturename') }} HU:</label>
							</div>
							<div class="col">
								<input type="text" name="picturename_hu" class="form-control" autocomplete="off">
							</div>
						</p>
					</div>
					<div class="row p-0 m-0 my-2">
						<p class="p-0 m-0">
							<div class="p-0 m-0 col-auto label-min-width align-self-center">
								<label>{{ __('messages.modules.gallery.textpicturename') }} EN:</label>
							</div>
							<div class="col">
								<input type="text" name="picturename_en" class="form-control" autocomplete="off">
							</div>
						</p>
					</div>
					<div class="row p-0 m-0 my-2">
						<p class="p-0 m-0">
							<div class="p-0 m-0 col-auto label-min-width align-self-center">
								<label>{{ __('messages.modules.gallery.textgalleryfiletext') }}</label>
							</div>
							<div class="col">
								<input type="file" name="new_image" class="form-control">
							</div>
						</p>
					</div>
					<button type="submit" class="btn btn-warning btn-sm mt-5">{{ __('messages.modules.gallery.textnewimagesubmit') }}</button>
				</div>
			</form>
		</div>
	
		<form id="sendemailmodule-form" method="post" action="{{ route("admin_module_save", ['menuid' => $menu['id'], 'moduleid' => $module['id'], 'type' => 'edit' ]) }}" class="p-0 m-0" novalidate>
			@csrf
			<input type="hidden" name="moduletype" value="gallery">
			<div class="row p-3 mt-3 m-0 bg-light border border-2 rounded">
				<div id="pictures-list" class="row p-0 m-0 d-flex justify-content-start align-items-start">
					@foreach($moduledata as $row)
						@if(isset($row['imagedata']['imagename']))
							<div class="pic-frame picture-sortable col-12 col-md-4 p-0 m-0 p-2 bg-light rounded">
								<div class="pos-module-arrow-gallery pt-0">
									<i class="arrow-button-pic d-inline-block align-middle p-0 m-0"></i>
								</div>
								<div class="pic-del-pos-right" data-id="{{ $row['id'] }}">
									<a href="{{ route('delpic', ['menuid' => $menu['id'], 'moduleid' => $module['id'], "type" => $moduletype['name'], "rowid" => $row['id']]) }}" class="p-0 m-0">
										<i class="delete-button-pic d-inline-block align-middle"></i>
									</a>
								</div>
								@php
									$filePath = 'images/' . $row['imagedata']['imagename'];
									$picturename = (str_replace('_', '-', app()->getLocale()) == 'hu') ? $row['picturename_hu'] : $row['picturename_en'];
								@endphp
								@if(Storage::disk('public')->exists($filePath))
									<img src="{{ Storage::url('public/'.$filePath) }}" alt="{{ $picturename }}" title="{{ $picturename }}" class="w-100">
								@else
									<img src="/img/nopic.png" alt="nopic" title="nopic" class="w-100">
								@endif
								<div class="p-0 m-0 my-2 mt-auto">
									<label class="my-2">{{ __('messages.modules.gallery.textpicturename') }} HU:</label>
									<input type="text" name="edit[{{ $row['id'] }}][picturename_hu]" class="form-control" value="@isset($row['picturename_hu']) {{ $row['picturename_hu'] }} @endif">
									<label class="my-2">{{ __('messages.modules.gallery.textpicturename') }} EN:</label>
									<input type="text" name="edit[{{ $row['id'] }}][picturename_en]" class="form-control" value="@isset($row['picturename_hu']) {{ $row['picturename_en'] }} @endif">
								</div>
								<div class="form-check d-flex justify-content-center align-items-center">
									<input type="checkbox" name="edit[{{ $row['id'] }}][active]" @if($row['active']) value="on" @endif class="form-check-input me-2" id="flexCheckDefault" @if($row['active']) checked @endif>
									<label class="form-check-label mx-2" for="flexCheckDefault">
										{{ __('messages.modules.gallery.textpictureative') }}
									</label>
								</div>
							</div>
						@endif
					@endforeach
				</div>	
				<div class="p-0 m-0 text-center">
					<button type="submit" class="btn btn-warning btn-sm mt-3">{{ __('messages.modules.gallery.textgallerysubmit') }}</button>
				</div>
			</div>
		</form>
	</div>
</div>