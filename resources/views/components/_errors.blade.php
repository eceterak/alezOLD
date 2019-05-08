@if($errors->any())
    <div class="mt-4">
        <ul class="list-reset">
            @foreach($errors->all() as $error)
                <li class="p-2 text-sm text-red">{{ $error }}</li>
            @endforeach  
        </ul>
    </div>
@endif