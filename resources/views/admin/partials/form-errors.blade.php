@if ($errors->any())
    <div class="alert alert-danger">
        <strong>La modification n’a pas été enregistrée.</strong>
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
