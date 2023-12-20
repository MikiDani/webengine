

<h4 class="text-center text-uppercase my-2">{{ __('messages.modules.gallery.textgallerymodulename') }}</h4>

<div class="row p-0 m-0">
	@empty($moduledata)
		<div class="p-3 m-0 text-center">
			<i class="bi bi-chat-right-dots me-3"></i><span>{{ __('messages.modules.gallery.textnodatamessage') }}</span>
		</div>
	@endempty
	<form id="sendemailmodule-form" method="post" action="{{ route("admin_module_save", ['menuid' => $menu['id'], 'moduleid' => $module['id'], 'type' => 'new' ]) }}" class="p-0 m-0" novalidate>
		@csrf
		<input type="hidden" name="moduletype" value="gallery">
		<div class="row p-3 m-0 bg-light border border-2 rounded">
			
			<div class="p-0 m-0 text-center">
				<button type="submit" class="btn btn-warning btn-sm mt-3">{{ __('messages.modules.gallery.textgallerysubmit') }}</button>
			</div>
		</div>
	</form>
</div>
