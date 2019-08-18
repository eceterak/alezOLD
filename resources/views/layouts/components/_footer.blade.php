<section class="container pt-6 pb-5">
    <div class="row">
        <div class="col-lg-4 pr-lg-6">
            <a href="{{ route('index') }}" class="navbar-brand mb-4">www.alez.pl</a>
            <p>Morbi convallis bibendum urna ut viverra. Maecenas quis consequat libero, a feugiat eros. Nunc ut lacinia tortor morbi ultricies laoreet ullamcorper phasellus semper.</p>
        </div>
        <div class="col-lg-4 px-lg-3" id="useful-links">
            <h5 class="mb-4">Pomocne linki</h5>
            <ul class="nav flex-column">
                <li class="nav-item row">
                    <a href="{{ route('index') }}" class="nav-link col-6">Strona główna</a>
                    <a href="{{ route('cities') }}" class="nav-link col-6">Miasta</a>
                </li>
                <li class="nav-item row">
                    <a href="{{ route('aboutUs') }}" class="nav-link col-6">O nas</a>
                    <a href="{{ route('home') }}" class="nav-link col-6">Twoje konto</a>
                </li>
                <li class="nav-item row">
                    <a href="{{ route('privacyPolicy') }}" class="nav-link col-6">Polityka prywatności</a>
                    <a href="{{ route('adverts.create') }}" class="nav-link col-6">Dodaj ogłoszenie</a>
                </li>
                <li class="nav-item row">
                    <a href="{{ route('termsAndConditions') }}" class="nav-link col-6">Regulamin serwisu</a>
                </li>
            </ul>
        </div>
        <div class="col-lg-4 pl-lg-6">
            <h5 class="mb-4">Kontakt z nami</h5>
            <p>Możesz skontaktować się z nami od poniedziałku do piątku w godzinach od 9:00 do 17:00</p>
            <ul class="list-group list-group-flush">
                <li class="list-group-item border-0 p-0"><a href="#"><i class="fas fa-phone mr-2 fa-xs"></i>+48 777 888 999</a></li>
                <li class="list-group-item border-0 p-0"><a href="#"><i class="fas fa-envelope mr-2 fa-xs"></i>help@alez.pl</a></li>
            </ul>
        </div>
    </div>
</section>
<section class="container">
    <div class="border-top">
        <div class="d-flex post justify-content-between py-4">
            <p class="mb-0">Copyright &copy; {{ \Carbon\Carbon::now()->year }} alez.pl</p>
            <p class="mb-0 text-right">Korzystanie z serwisu oznacza akceptację <a href="{{ route('termsAndConditions') }}">regulaminu</a></p>
        </div>
    </div>
</section>