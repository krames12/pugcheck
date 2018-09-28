<section class="search-container search">
    <form id="search-form" name="search_form" action="{{ action('HomeController@search') }}" method="POST">
        {{ csrf_field() }}
        <label for="character-name">Character Name</label>
        <input type="text" name="character" id="character-name" />
        <label for="realm-name">Realm Name</label>
        <input type="text" name="realm" id="realm-name" />
        <label for="region-name" id="region-label">Region</label>
        <select name="region" id="region-name">
            <option value="us">US</option>
            <option value="eu">EU</option>
        </select>
        <button type="submit" name="find_character" id="find-character-button">Find Character</button>
    </form>
</section>
