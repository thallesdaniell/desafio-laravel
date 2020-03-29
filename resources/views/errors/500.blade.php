@extends('layout.erro')
@section('title',__('Server Error'))
@section('content')
    <section class="section">
        <div class="container mt-5">
            <div class="page-error">
                <div class="page-inner">
                    <h1>500</h1>
                    <div class="page-description">
                        {{__($exception->getMessage() ?: __('Server Error'))}}
                    </div>
                    <div class="page-search">
                        <form>
                            <div class="form-group floating-addon floating-addon-not-append">
                                <div class="input-group">
                                </div>
                            </div>
                        </form>
                        <div class="mt-3">
                            <a href="{{route('home')}}">Voltar para Home</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="simple-footer mt-5">
                Copyright &copy; Stisla {{date('Y')}}
            </div>
        </div>
    </section>
@endsection
