<div class="d-flex align-items-center">
    <img class="d-flex @rtl ms-3 @else me-3 @endrtl rounded-circle shadow" src="{{ asset('img/avatar/author.jpg') }}" alt="...">
    <div class="flex-fill">
        <h5 class="my-0 bold">{{$post->author->name}}</h5>

        <hr>
        <p class="small text-secondary mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
    </div>
</div>
