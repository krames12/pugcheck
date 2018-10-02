@extends('base')

@section('content')
    @include('partials.search')

    <div class="character-info">
        <p class="character-name">{{ $character->name }}</p>
        <img src="{{ asset('images').'/'.$class_name.'.png' }}"
             alt="{{ $class_name }} symbol"
             class="class-icon {{ $class_name }}"
        />
        <div class="item-level-container">
            <p class="item-level">Item Level: <span class="item-level">{{ $character->items->averageItemLevel }}</span></p>
        </div>
    </div>
@endsection
