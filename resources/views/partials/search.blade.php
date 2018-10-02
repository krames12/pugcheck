<section class="search-container search">
    <form id="search-form" name="search_form" action="{{ action('HomeController@search') }}" method="POST">
        {{ csrf_field() }}
        <label for="character-name">Character Name</label>
        <input type="text" name="character" id="character-name" />
        <div>
            <label for="realm-select">Realm Name</label>
            <select name="realm" id="realm-select">
                @foreach($realms as $realm)
                    <option value="{{ $realm->slug }}">{{ $realm->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="region-name" id="region-label" class="block">Region</label>
            <select name="region" id="region-name">
                <option value="us">US</option>
                <option value="eu">EU</option>
            </select>
        </div>
        <button type="submit" name="find_character" id="find-character-button">Find Character</button>
    </form>
</section>
