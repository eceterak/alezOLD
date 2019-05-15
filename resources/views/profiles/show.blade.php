@extends('layouts.master')
@section('content')
    <p>{{ $profile->name }}</p>
    <p>{{ $profile->created_at->diffForHumans() }}</p>
    @forelse($adverts as $advert)
        <article class="card lg:flex mb-4">
            <div class="flex lg:static lg:w-1/8 items-center justify-center mb-0 lg:mb-0 sm:mb-2">
                <img src="/storage/notfound.png">
            </div>
            <div class="lg:static lg:w-7/8 lg:pl-2">
                <header clas="flex jutify-between">
                    <h3 class="font-normal text-lg mb-2"><a href="{{ route('adverts.show', [$advert->city->slug, $advert->slug])}}">{{ $advert->title }}</a></h3>
                    @auth
                        <form action="{{ route('adverts.favourite.store', $advert->slug) }}" method="POST">
                            @csrf
                            <button class="btn btn-primary" {{ $advert->isFavourited() ? 'disabled' : '' }}>Ulubione</button>
                        </form>
                    @endauth
                </header>
                <section>
                    <p class="text-grey-darker">{{ str_limit($advert->description, 100) }}</p>
                </section>
            </div>
        </article>
    @empty
        
    @endforelse

    {{ $adverts->links() }}
@endsection