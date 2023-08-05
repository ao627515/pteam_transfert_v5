<div class="{{ $class }}">
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    <input  class="form-control @error($name) is-invalid @enderror" name="{{ $name }}" id="{{ $name }}" value="{{ old($name, $value) }}" {{ $attributes }} >
    @error($name)
        <div class="invalid-feedback form-text">
            {{ $message }}
        </div>
    @enderror
</div>

