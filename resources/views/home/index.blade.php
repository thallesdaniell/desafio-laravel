@extends('layout.app')
@section('title','Home')

@section('before_css')
@endsection

@section('after_css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.0/css/select.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/1.0.7/css/responsive.dataTables.min.css">

    <style>
        .table:not(.table-sm) thead th {
            background-color: rgb(255, 255, 255);
        }
    </style>
@endsection

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Início</h1>
            </div>
            @include('layout.alerts')

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Acessos</h4>
                            </div>
                            <div class="card-body">
                                <div class="buttons">
                                    @canany([config("desafio.role-default"),"Visualizar Telefones","Editar Telefone","Excluir Telefone"])
                                        <a class="btn-lg btn-block btn btn-outline-primary" href="{{route('client.index')}}">Clientes</a>
                                    @endcanany
                                    @can(config("desafio.role-default"))
                                        <a class="btn-lg btn-block btn btn-outline-primary" href="{{route('user.index')}}">Usuários</a>
                                    @endcan
                                    @can(config("desafio.role-default"))
                                        <a class="btn-lg btn-block btn btn-outline-primary" href="{{route('role.index')}}">Perfis</a>
                                    @endcan
                                    @canany([config("desafio.role-default"),"Visualizar Histórico","Visualizar Histórico Todos"])
                                        <a class="btn-lg btn-block btn btn-outline-primary" href="{{route('log.index')}}">Histórico</a>
                                    @endcanany

                                </div>
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
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/1.0.7/js/dataTables.responsive.min.js"></script>

    <!-- Template JS File -->
    <script src="{{asset('assets/js/scripts.js')}}"></script>
    <script src="{{asset('assets/js/custom.js')}}"></script>

    <script>
        $('#table').DataTable({
            "dom": "Bt",
            "language": {"url": "http://cdn.datatables.net/plug-ins/1.10.20/i18n/Portuguese.json"},
            "order": [[ 0, "desc" ]],
            "ordering": false
        });
    </script>
@endsection
