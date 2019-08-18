@extends('layouts.hero')

@section('content')
    <section class="container py-6" id="why-alez">
        <div class="row">
            <div class="col-md-4 pl-0 text-center">
                <div class="px-5 mb-4 mb-md-0">
                    <img src="{{ asset('images/hand.png') }}" alt="">
                    <h5 class="my-3">Najlepsze ceny</h5>
                    <p>Every 3 minutes someone finds a flatmate on SpareRoom. With the biggest selection of ads, you'll find yours.</p>
                </div>
            </div>
            <div class="col-md-4 pl-0 text-center">
                <div class="px-5 mb-4 mb-md-0">
                    <img src="{{ asset('images/insurance.png') }}" alt="">
                    <h5 class="my-3">Najlepsze ceny</h5>
                    <p>Every 3 minutes someone finds a flatmate on SpareRoom. With the biggest selection of ads, you'll find yours.</p>
                </div>
            </div>
            <div class="col-md-4 pl-0 text-center">
                <div class="px-5 mb-4 mb-md-0">
                    <img src="{{ asset('images/hotel.png') }}" alt="">
                    <h5 class="my-3">Najlepsze ceny</h5>
                    <p>Every 3 minutes someone finds a flatmate on SpareRoom. With the biggest selection of ads, you'll find yours.</p>
                </div>
            </div>
        </div>
    </section>
    @if(isset($adverts) && $adverts->count())
        <div id="most-visited">
            <section class="container py-6">
                <h4>Najczęściej odwiedzane</h4>
                <div class="row">
                    @foreach($adverts as $advert)
                        <div class="col-md-4">
                            <div class="position-relative">
                                <a href="{{ route('adverts.show', [$advert->city->slug, $advert->slug]) }}">
                                    <img src="{{ $advert->featured_photo_path }}" alt="" class="img-fluid rounded">                            
                                </a>
                                <div class="position-absolute text-white px-3" style="bottom: 1rem;">
                                    <p class="h2">{{ $advert->rent }}&nbsp;<span class="h6">zł/mc</span></p>
                                    <p class="h6">{{ $advert->city->name }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-center">
                    <a href="" class="btn btn-primary font-weight-bold mt-4">Zobacz więcej</a>
                </div>
            </section>
        </div>
    @endif
@endsection