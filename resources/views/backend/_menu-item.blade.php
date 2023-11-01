@php $count++; @endphp

<li data-id="{{ $menu->id }}" class="menu-sortable menu-sortable_{{ $count }} menu-list-line-height">
    <div class="menu-list-line-min-width bg-primary p-2 m-1 text-center rounded">
        <i class="bi bi-arrows-move d-inline-block align-middle me-1"></i>
        <i id="plus_{{ $menu->id }}" class="plus-button d-inline-block align-middle me-1"></i>
        <i id="delete_{{ $menu->id }}" class="minus-button d-inline-block align-middle me-1"></i>
        <input type="text" name="menuname" value="{{ $menu->name }}" class="form-menuname d-inline-block align-middle">
        <i id="select_{{ $menu->id }}" class="select-button d-inline-block align-middle"></i>
        @if (isset($menu->child) && !empty($menu->child))
            <i id="openclose_{{ $menu->id }}" class="bi bi-caret-down mt-05 float-end d-inline-block align-middle"></i>
        @else
            <i id="openclose_{{ $menu->id }}" class="bi bi bi-filter mt-05 float-end d-inline-block align-middle"></i>
        @endif
    </div>
    @if (isset($menu->child) && !empty($menu->child))
        <ul data-count="{{ $count }}" class="menu-menurow_{{ $count }}">
            @foreach ($menu->child as $child)
                @include('backend._menu-item', ['menu' => $child])
            @endforeach
        </ul>
    @endif
</li>