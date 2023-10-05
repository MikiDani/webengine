@extends('backend_default')

@section('content')
    {{-- menu --}}
    <div class="row p-0 m-0">
        @include('backend.admin_menu')
        <div class="card">

            <div class="p-3 bg-info">
                @if (Auth::check())
                    HELLÓ {{ Auth::user()->name }} !!!
                    @php 
                    dump(Auth::user());
                    @endphp
                @endif
            </div>

            BACKEND PAGE INDEX. Jee bent vagyok!!!

            <figure>
                <img src="/img/image.jpg" alt="Egy példa kép" class="w-100">
                <figcaption>Ez egy példa kép leírása.</figcaption>
            </figure>
            
            <a href="{{route('admin_index_two')}}">TWO link</a>
            <hr>
            <a href="{{route('admin_logout')}}">LOGOUT</a>
        </div>
    </div>
@endsection