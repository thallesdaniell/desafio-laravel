@extends('layout.app')
@section('title','Criar Cliente')

@section('before_css')
@endsection

@section('after_css')

@endsection

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Criar Cliente</h1>
            </div>
            @include('layout.alerts')
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form method="POST" action="{{route('client.store')}}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name">Nome</label>
                                        <input type="text" name="name" class="form-control" id="name" value="{{old('name')}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">E-mail</label>
                                        <input type="text" name="email" class="form-control" id="email" value="{{old('email')}}">
                                    </div>

                                    @if(old('phones'))
                                        @foreach(old('phones') as $phone)
                                            <div id="inputAdd">
                                                <div class="input-group mb-3">
                                                    <input type="text" name="phones[]"
                                                           class="form-control m-input phones" value="{{$phone}}">
                                                    <div class="input-group-append">
                                                        <button id="remove" type="button" class="btn btn-danger">
                                                            Remover
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                    <div id="new"></div>

                                    <div class="text-right">
                                        <button id="addRow" type="button" class="btn btn-info text-right">Adicionar Telefone</button>
                                    </div>
                                    <div class="text-left">
                                        <button class="btn btn-primary">Salvar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('before_scripts')
@endsection

@section('after_scripts')
    <script src="{{asset('assets/js/scripts.js')}}"></script>
    <script src="{{asset('assets/js/custom.js')}}"></script>
    <script src="{{asset('assets/js/jquery.mask.min.js')}}"></script>
    <script>
        $( document ).ready(function() {
            console.log( "ready!" );
            $('.phones').mask('(00)00000-0000');
        });

        $("#addRow").click(function () {
            var html = '';
            html += '<div id="inputAdd">';
            html += '<div class="input-group mb-3">';
            html += '<input type="text" name="phones[]" class="form-control m-input phones">';
            html += '<div class="input-group-append">';
            html += '<button id="remove" type="button" class="btn btn-danger">Remover</button>';
            html += '</div>';
            html += '</div>';

            var payment = $(html);
            var container = $('#new');

            var copy = payment.clone();
            copy.find('.phones').mask('(00)00000-0000');
            container.append(copy)
        });



        $(document).on('click', '#remove', function () {
            $(this).closest('#inputAdd').remove();


        });
    </script>
@endsection
