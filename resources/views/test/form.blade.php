<form action="{{route('test.store')}}" method="post">
    @csrf
    <div class="list-group">
        <label class="list-group-item">
            <input class="form-check-input me-1" name="permissions[]" type="checkbox" value="user index">
            user index
        </label>
        <label class="list-group-item">
            <input class="form-check-input me-1" name="permissions[]" type="checkbox" value="user create">
            user create
        </label>
        <label class="list-group-item">
            <input class="form-check-input me-1" name="permissions[]" type="checkbox" value="user edit">
            user edit
        </label>
    </div>
    <button type="submit">Store</button>
</form>
