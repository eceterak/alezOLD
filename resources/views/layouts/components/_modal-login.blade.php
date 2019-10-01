<div class="modal fade" id="accountWarningnModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Zaloguj się aby kontynuować</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <nav class="nav nav-tabs mb-0" role="tablist">
                    <a class="nav-link active" data-toggle="tab" href="#login">Zaloguj się</a>
                    <a class="nav-link" data-toggle="tab" href="#register">Zarejestruj się</a>
                </nav>
                <div class="tab-content py-4">
                    <div class="tab-pane fade show active" id="login" role="tabpanel">
                        @include('auth.forms._login')
                    </div>
                    <div class="tab-pane fade" id="register" role="tabpanel">
                        @include('auth.forms._register')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>