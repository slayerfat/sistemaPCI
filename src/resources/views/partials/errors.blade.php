@if ($errors->any())
<div class="container">
    <div class="alert alert-danger">
        <div id="error-message">
            <strong>Oops!</strong>
            <span>Parece que hay problemas con los datos suministrados.</span>
        </div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif
