@forelse($adverts as $advert)
    <div class="card mb-6">
        <div class="flex -mx-2">
            <div class="flex lg:static lg:w-1/6 items-center justify-center mb-0 lg:mb-0 sm:mb-2 px-2">
                <img src="{{ $advert->featured_photo_path }}">
            </div>
            <div class="card-body lg:static lg:w-5/6 px-2">
                <div class="flex justify-between">
                    <h3 class="font-normal text-lg mb-4"><a href="{{ route('adverts.show', [$advert->city->slug, $advert->slug])}}">{{ $advert->title }}</a></h3>
                    @auth
                        <favourite :advert="{{ $advert }}"></favourite>
                    @endauth
                </div>
                <section>
                    <p class="text-grey-darker">{{ str_limit($advert->description, 100) }}</p>
                    <p class="text-grey-darker">{{ $advert->rent }}</p>
                    <p class="text-grey-darker">{{ $advert->created_at }}</p>
                </section>
            </div>
        </div>
    </div>
@empty
    <div>Brak ogloszen</div>
@endforelse
{{ $adverts->links() }}

{{-- Vue.js aproach --}}
{{--<city-view :initial-adverts-count="{{ $city->adverts_count }}" inline-template>
    <div>
        <header class="mb-4">
            <h3 class="text-grey-darker">Pokoje na wynajem w {{ $city->name }}</h3>
            <p class="text-grey-darker" v-text="advertsCount"></p>
        </header>
        <main>
            <adverts @removed="advertsCount--"></adverts>
        </main>
    </div>
</city-view> --}}