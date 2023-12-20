

<h4 class="text-center text-uppercase my-2">{{ __('messages.modules.sendmail.textsendmailmodulename') }}</h4>

<div class="row p-0 m-0">
	@empty($moduledata)
		@php $moduledata['message'] = ''; $moduledata['newsletter'] = false; @endphp
		<div class="p-3 m-0 text-center">
			<i class="bi bi-chat-right-dots me-3"></i><span>{{ __('messages.modules.sendmail.textnodatamessage') }}</span>
		</div>
	@endempty
	<form id="sendemailmodule-form" method="post" action="{{ route("admin_module_save", ['menuid' => $menu['id'], 'moduleid' => $module['id'], 'type' => 'new' ]) }}" class="p-0 m-0" novalidate>
		@csrf
		<input type="hidden" name="moduletype" value="sendemail">
		<div class="row p-3 m-0 bg-light border border-2 rounded">
			<label class="mb-2">{{ __('messages.modules.sendmail.textmodulemessage') }}</label>
			<textarea name="message" class="form-control" rows="10">{{ $moduledata['message'] }}</textarea>
			<div class="form-check d-flex justify-content-center align-items-center mt-2">
				<input  type="checkbox" name="newsletter" value="on" class="form-check-input me-2" id="flexCheckDefault" @if($moduledata['newsletter']) checked @endif>
				<label class="form-check-label mx-2" for="flexCheckDefault">
					{{ __('messages.modules.sendmail.textnewslettermessage') }}
				</label>
			</div>
			<div class="p-0 m-0 text-center">
				<button type="submit" class="btn btn-warning btn-sm mt-3">{{ __('messages.modules.sendmail.textsubmit') }}</button>
			</div>
		</div>
	</form>
</div>
