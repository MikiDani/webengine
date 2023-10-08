@extends('backend_default')

@section('content')
@include('backend.admin_menu')
<div class="row card mx-auto p-3 m-3">
    
    @if(session('message'))
        <div class="p-3 bg-info">
            <h6>{{ session('message') }}</h6>
        </div>
    @endif
    
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia cumque et consequatur, amet labore accusantium suscipit non perspiciatis explicabo adipisci? Enim beatae debitis quod ipsum voluptatibus odit dignissimos incidunt quam molestiae quae, perferendis in consequatur eos cumque iste dolores iusto quibusdam dolorum necessitatibus tempore facere mollitia sint id? Culpa, voluptate?</p>

    <figure>
        <img src="/img/image.jpg" alt="Egy példa kép" class="w-100">
        <figcaption>Ez egy példa kép leírása.</figcaption>
    </figure>
    
</div>
@endsection
