<label for="exampleInputEmail1" class="form-label">Polda</label>
<select class="form-select" aria-label="Default select example" name="polda">
    @foreach ($poldas as $polda)
        <option value="{{ $polda->id }}">{{ $polda->name }}</option>
    @endforeach
</select>
