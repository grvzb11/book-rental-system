<div class="form-section">
    <div class="form-section-heading">
        <div><span class="section-kicker">Book details</span><h2>Catalog information</h2></div>
        @isset($book)
            <span class="badge {{ $book->status === 'Available' ? 'success' : 'warning' }}">{{ $book->status }}</span>
        @endisset
    </div>

    <div class="book-form-grid">
        <div class="cover-uploader" data-cover-uploader>
            <label class="cover-preview" for="cover_image" data-cover-preview>
                @if (isset($book) && $book->cover_url)
                    <img src="{{ $book->cover_url }}" alt="Current cover for {{ $book->title }}" data-cover-image>
                    <span class="cover-placeholder hidden" data-cover-placeholder>
                        <b>+</b><strong>Add cover</strong><small>JPG, PNG or WebP</small>
                    </span>
                @else
                    <span class="cover-placeholder" data-cover-placeholder>
                        <b>+</b><strong>Add cover</strong><small>JPG, PNG or WebP</small>
                    </span>
                    <img class="hidden" alt="Selected book cover preview" data-cover-image>
                @endif
            </label>
            <input class="visually-hidden @error('cover_image') invalid @enderror" id="cover_image" name="cover_image" type="file" accept="image/jpeg,image/png,image/webp" data-cover-input>
            <div class="cover-uploader-actions">
                <label class="btn secondary small" for="cover_image">Choose Image</label>
                <button class="btn ghost small" type="button" data-cover-clear>Clear</button>
            </div>
            <small class="field-hint">Optional · portrait cover recommended · max 3 MB</small>
            @isset($book)
                @if ($book->cover_image)
                    <label class="check-row"><input type="checkbox" name="remove_cover" value="1" data-remove-cover> Remove current cover when saving</label>
                @endif
            @endisset
            @error('cover_image')<small class="field-error">{{ $message }}</small>@enderror
        </div>

        <div class="form-grid book-fields">
            <div class="field full">
                <label for="title">Title <span>*</span></label>
                <input class="@error('title') invalid @enderror" id="title" name="title" type="text" value="{{ old('title', $book->title ?? '') }}" placeholder="e.g., Noli Me Tangere" required autofocus>
                @error('title')<small class="field-error">{{ $message }}</small>@enderror
            </div>

            <div class="field full">
                <label for="author">Author <span>*</span></label>
                <input class="@error('author') invalid @enderror" id="author" name="author" type="text" value="{{ old('author', $book->author ?? '') }}" placeholder="e.g., Jose Rizal" required>
                @error('author')<small class="field-error">{{ $message }}</small>@enderror
            </div>

            <div class="field">
                <label for="published_year">Published Year <span>*</span></label>
                <input class="@error('published_year') invalid @enderror" id="published_year" name="published_year" type="number" min="1000" max="{{ now()->year }}" value="{{ old('published_year', $book->published_year ?? '') }}" placeholder="1887" required>
                @error('published_year')<small class="field-error">{{ $message }}</small>@enderror
            </div>

            <div class="field">
                <label for="price">Price <span>*</span></label>
                <div class="input-prefix"><span>₱</span><input class="@error('price') invalid @enderror" id="price" name="price" type="number" step="0.01" min="0" value="{{ old('price', $book->price ?? '') }}" placeholder="0.00" required></div>
                @error('price')<small class="field-error">{{ $message }}</small>@enderror
            </div>

            <div class="field full">
                <label for="description">Description <em>Optional</em></label>
                <textarea class="@error('description') invalid @enderror" id="description" name="description" rows="6" maxlength="5000" placeholder="Short description or notes about the book" data-character-input>{{ old('description', $book->description ?? '') }}</textarea>
                <div class="field-meta"><span>Use a concise description for easier catalog browsing.</span><span><b data-character-count>0</b>/5,000</span></div>
                @error('description')<small class="field-error">{{ $message }}</small>@enderror
            </div>
        </div>
    </div>
</div>
