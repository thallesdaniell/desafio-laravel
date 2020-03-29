<div class="row">

    @if(Session::has('message'))
        <div class="col-lg-12 col-lg-offset-1">
            <div class="alert alert-success alert-dismissible show fade">
                <em> {!! session('message') !!}</em>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @endif

    @if(Session::has('message_error'))
        <div class="col-lg-12 col-lg-offset-1">
            <div class="alert alert-danger alert-dismissible show fade">
                <em> {!! session('message_error') !!}</em>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @endif

    @if(Session::has('message_warning'))
        <div class="col-lg-12 col-lg-offset-1">
            <div class="alert alert-warning alert-dismissible show fade">
                <em> {!! session('message_warning') !!}</em>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @endif

    @if (count($errors) > 0)
        <div class="col-lg-12 col-lg-offset-1">
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger alert-dismissible show fade">
                    <em>   {{ $error }}</em>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endforeach
        </div>
    @endif
</div>
