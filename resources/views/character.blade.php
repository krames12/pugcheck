@extends('base')

@section('content')
    @include('partials.search')

    <div class="character-info">
        <p class="character-name">{{ $character->name }}</p>
        <p><span class="item-level">{{ $character->items->averageItemLevel }}</span></p>
        <img src="{{ asset('images').'/'.$class_name.'.png' }}"
             alt="{{ $class_name }} symbol"
             class="class-icon {{ $class_name }}"
        />
    </div>
    <div class="expansion-relevant-info">

    </div>

    {{-- Determine two highest difficulties. --}}
    @foreach($difficulties as $difficulty)
        @php
            $progress = $difficulty != 'Looking For Raid' ? strtolower($difficulty) : 'lfr';

            $kills = $progression->{$progress.'Progress'};
        @endphp
        <div class="raid-instance">
            <div class="raid-instance-title">
                <span class="collapse fa fa-plus" id="{{ $progress }}-toggle"></span>
                <h5 class="instance-name">{{ $progression->name }}</h5>
                <p class="difficulty">{{ $kills }}/{{ $progression->total_bosses }} {{ $difficulty }}</p>
            </div>
            <ul class="raid-bosses hidden">
                @foreach($progression->bosses as $boss)
                <li>
                    @if ( $boss->{$progress.'Kills'} > 0)
                    <span class="killed-box far fa-check-square"></span>
                    @else
                    <span class="killed-box far fa-square"></span>
                    @endif
                        @if(isset($boss->{$progress.'LogUrl'}))
                            <a href="{{ $boss->{$progress.'LogUrl'} }}"
                               alt="Link to Warcraftlogs"
                               class="warcraftlog-report far fa-chart-bar"></a>
                        @else
                            <span class="placeholder-icon-spot"></span>
                        @endif
                    {{ $boss->name }}
                </li>
                @endforeach
            </ul>
        </div>
    @endforeach

    <script>
        document.addEventListener('click', event => {
            if(event.target.classList.contains('collapse')) {
                let toggleElement = event.target;
                let bosses = toggleElement.closest('.raid-instance').children[1];
                bosses.classList.toggle('hidden');
                event.target.classList.toggle('fa-plus');
                event.target.classList.toggle('fa-minus');
            }
        })
    </script>
@endsection
