<form id="changelang" method="post" action="{{ route('changelang') }}" class="p-0 m-0">
    @csrf
    <select id="selectlang" name="lang" class="form-select form-select-sm">
        <option value="hu" @if(str_replace('_', '-', app()->getLocale()) == 'hu') selected @endif>hu</option>
        <option value="en" @if(str_replace('_', '-', app()->getLocale()) == 'en') selected @endif>en</option>
    </select>
</form>
