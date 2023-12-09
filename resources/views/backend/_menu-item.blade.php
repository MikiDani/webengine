@php $count++; @endphp

<li data-id="{{ $menu->id }}" class="menu-sortable menu-sortable_{{ $count }} list-style-type-none">
    <div class="menulist-box bg-primary p-2 m-1 text-center rounded">
        <div class="menulist-i-position">
            <i class="bi bi-arrows-move me-1"></i>
        </div>
        <div class="menulist-i-add">
            <i id="plus_{{ $menu->id }}" class="plus-button d-inline-block me-1"></i>
        </div>
        <div class="menulist-i-delete">
            <i id="delete_{{ $menu->id }}" class="minus-button-menulist d-inline-block me-1"></i>
        </div>
        <div class="row p-0 m-0">
            <div class="p-0 m-0 mx-auto col-8 col-lg-5">
                <span class="align-middle form-menulang">HU:</span>
                <input type="text" name="menuname_hu" value="{{ $menu->menuname_hu }}" class="form-menuname align-middle" form="null">
            </div>
            <div class="p-0 m-0 mx-auto col-8 col-lg-5 mt-2 mt-lg-0">
                <span class="align-middle form-menulang">EN:</span>
                <input type="text" name="menuname_en" value="{{ $menu->menuname_en }}" class="form-menuname align-middle" form="null">
            </div>
        </div>
        <div class="menulist-i-select">
            <i id="select_{{ $menu->id }}" class="select-button d-inline-block align-middle"></i>
        </div>
        <div class="menulist-i-openclose">
            @if (isset($menu->child) && !empty($menu->child))
                <i id="openclose_{{ $menu->id }}" class="bi bi-caret-down d-inline-block"></i>
            @else
                <i id="openclose_{{ $menu->id }}" class="bi bi bi-filter d-inline-block"></i>
            @endif
        </div>
    </div>
    @if (isset($menu->child) && !empty($menu->child))
        <ul data-count="{{ $count }}" class="menu-menurow_{{ $count }} list-style-type-none">
            @foreach ($menu->child as $child)
                @include('backend._menu-item', ['menu' => $child])
            @endforeach
        </ul>
    @endif
</li>
