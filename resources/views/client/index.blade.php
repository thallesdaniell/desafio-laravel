@extends('layout.app')
@section('title','Clientes')

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
                <h1>Clientes</h1>
                <div class="section-header-breadcrumb">
                    <a href="{{ route('client.create') }}" class="btn btn-primary text-right">Criar Cliente</a>
                </div>
            </div>
            @include('layout.alerts')
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                <div class="form-group dados_form">
                                    <label class="control-label">Pesquisar</label>
                                    <input type="text" class="form-control input-sm mb-md disabled search" id="7"
                                           name="">
                                </div>

                                <div class="">
                                    <table class="table table-borderless " id="table">
                                        <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th width="10px"></th>
                                            <th width="10px"></th>

                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($clients as $client)
                                            <tr>
                                                <td>
                                                    <h3 class="">
                                                        <small class="text-muted">
                                                            <div class="card-header-action">
                                                                <a data-collapse="#mycard-collapse{{$client->id}}"
                                                                   class="btn btn-icon btn-info" href="#"><i
                                                                        class="fas fa-plus"></i></a>
                                                                {{$client->name}}

                                                            </div>
                                                        </small>
                                                    </h3>
                                                    <div class="accordian-body collapse"
                                                         id="mycard-collapse{{$client->id}}">
                                                        <div class="col-lg-12">
                                                            <div class="activities">
                                                                <div class="activity">
                                                                    <div
                                                                        class="activity-icon bg-primary text-white shadow-primary">
                                                                        <i style="font-size: 15px;"
                                                                           class="far fa-envelope"></i>
                                                                    </div>
                                                                    <div class="activity-detail">
                                                                        <p>{{$client->email}}</p>
                                                                    </div>
                                                                </div>
                                                                @foreach($client->phone as $phone)
                                                                    <div class="activity">
                                                                        <div
                                                                            class="activity-icon bg-primary text-white shadow-primary">
                                                                            <i style="font-size: 15px;"
                                                                               class="fas fa-phone-square"></i>
                                                                        </div>
                                                                        <div class="activity-detail">
                                                                            <p>{{$phone->phone}}</p>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-right">
                                                    <a href="{{route('client.edit',$client->id)}}"
                                                       class="btn btn-icon btn-primary" data-toggle="tooltip"
                                                       data-placement="top" title="Editar">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                </td>
                                                <td class="text-left">
                                                    <form method="POST"
                                                          action="{{route('client.destroy',$client->id) }}"
                                                          id="client_destroy{{ $client->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <a class="btn btn-icon btn-danger" data-toggle="tooltip"
                                                           ata-placement="top" title="Excluir" href="#"
                                                           onClick="document.getElementById('client_destroy{{ $client->id }}').submit();">
                                                            <i class="far fa-trash-alt"></i>
                                                        </a>
                                                    </form>
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

    <script src="{{asset('assets/js/scripts.js')}}"></script>
    <script src="{{asset('assets/js/custom.js')}}"></script>

    <script>
        DataTable = $('#table').DataTable({
            "dom": "lBrtip",
            "language": {"url": "http://cdn.datatables.net/plug-ins/1.10.20/i18n/Portuguese.json"},
            "order": [[0, "desc"]],
            "ordering": false
        });

        $('.search').on('keyup change', function () {
            let value = $(this).val();
            DataTable.columns(0).search(value).draw();
        });

    </script>
@endsection
