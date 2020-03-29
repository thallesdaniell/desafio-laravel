@extends('layout.app')
@section('title','Usuários')

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
                <h1>Usuários</h1>
                <div class="section-header-breadcrumb">
                    <a href="{{ route('user.create') }}" class="btn btn-primary text-right">Criar Usuário</a>
                </div>

            </div>
            @include('layout.alerts')
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="table" class="datatable table table-hover table-responsive-lg">
                                        <thead >
                                        <tr>
                                            <th>#</th>
                                            <th>Nome</th>
                                            <th>E-mail</th>
                                            <th>Perfis do usuário</th>
                                            <th width='10%'>Operações</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $user->id }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->roles()->pluck('name')->implode(' ') }}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-block btn-primary dropdown" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Ação
                                                        </button>
                                                        <div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton">
                                                            <a class="dropdown-item" href="{{ route('user.edit',$user->id) }}"><i class="fas fa-cog"></i> Editar</a>
                                                            <div class="dropdown-divider"></div>
                                                            <form method="POST" action="{{route('user.destroy',$user->id) }}" id="user_destroy{{ $user->id }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <a class="dropdown-item" href="#" onClick="document.getElementById('user_destroy{{ $user->id }}').submit();">
                                                                    <i class="fas fa-trash"></i> Deletar
                                                                </a>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
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
    <script src="{{asset('assets/js/scripts.js')}}"></script>>
    <script src="{{asset('assets/js/custom.js')}}"></script>

    <script>
        DataTable = $('#table').DataTable({
            //"dom": "lBrtip",
            "language": {"url": "http://cdn.datatables.net/plug-ins/1.10.20/i18n/Portuguese.json"},
            "order": [[0, "desc"]],
            //"ordering": false
        });
    </script>
@endsection
