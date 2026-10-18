<div class="form-section">
    <div class="form-section-heading"><div><span class="section-kicker">Borrower details</span><h2>Personal information</h2></div></div>
    <div class="form-grid">
        <div class="field full">
            <label for="name">Complete Name <span>*</span></label>
            <input class="@error('name') invalid @enderror" id="name" name="name" type="text" value="{{ old('name', $borrower->name ?? '') }}" placeholder="e.g., Juan Dela Cruz" required autofocus>
            @error('name')<small class="field-error">{{ $message }}</small>@enderror
        </div>
        <div class="field full">
            <label for="contact_number">Contact Number <span>*</span></label>
            <input class="@error('contact_number') invalid @enderror" id="contact_number" name="contact_number" type="text" value="{{ old('contact_number', $borrower->contact_number ?? '') }}" placeholder="e.g., 0917 123 4567" required>
            <small class="field-hint">Enter the borrower's reachable phone or contact number.</small>
            @error('contact_number')<small class="field-error">{{ $message }}</small>@enderror
        </div>
    </div>
</div>
