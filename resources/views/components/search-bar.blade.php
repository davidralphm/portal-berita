<form action="{{ $url }}" class="d-flex my-3">
    <input type="text" name="search" id="search" class="form-control me-3" placeholder="{{ $placeholder }}" value="{{ Request::get('search') }}">
    
    <input type="hidden" name="category" value="{{ Request::get('category') }}">

    <select name="sort" id="sort" class="form-control me-3">
        @foreach ($sortOptions as $key => $value)
            <option value="{{ $key }}" @if (Request::get('sort') == $key) selected @endif>Sort by {{ $value }}</option>
        @endforeach
    </select>

    <select name="sortOrder" id="sortOrder" class="form-control me-3">
        <option value="asc" @if (Request::get('sortOrder') == 'asc') selected @endif>Sort ascending</option>
        <option value="desc" @if (Request::get('sortOrder') == 'desc') selected @endif>Sort descending</option>
    </select>

    <button type="submit" class="btn btn-outline-success"><i class="fas fa-search"></i></button>
</form>