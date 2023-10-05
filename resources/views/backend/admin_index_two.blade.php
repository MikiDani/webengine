@extends('backend_default')

@section('content')
    {{-- menu --}}
    <div class="row p-0 m-0">
        {{-- @include('layouts.admin.menu') --}}
        <div class="card bg-danger">

            <div class="p-3 bg-info">
                @if (Auth::check())
                    HELLÓ {{ Auth::user()->name }} !!!
                @endif
            </div>

            BACKEND PAGE INDEX TWO. Jee bent vagyok!!! TWO

            <figure>
                <img src="/img/image2.jpg" alt="Egy példa kép" class="w-100">
                <figcaption>Ez egy példa kép leírása.</figcaption>
            </figure>
            
            <a href="{{route('admin_index')}}">ONE link</a>
            
        </div>
        {{-- @include('layouts.backend.footer') --}}
    </div>
@endsection