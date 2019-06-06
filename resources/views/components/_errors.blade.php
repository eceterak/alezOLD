@if($errors->any())
    <div class="mt-4">
        <ul class="list-group">
            @foreach($errors->all() as $error)
                <li class="list-group-item list-group-item-action list-group-item-danger">{{ $error }}</li>
            @endforeach  
        </ul>
    </div>
@endif