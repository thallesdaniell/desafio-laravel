@extends('layout.app')
@section('title','Logs')

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
                <h1>Histórico</h1>

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

                                <div class="table-responsive">
                                    <table class="table table-borderless " id="table">
                                        <thead>
                                        <tr>
                                            <th>Usuário</th>
                                            <th>Perfil</th>
                                            <th>Alteração</th>
                                            <th>Data</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($logs as $log)
                                            <tr>
                                                <td>
                                                    @if($log->causer_id)
                                                        {{$users->find($log->causer_id)->name}}
                                                    @else
                                                        {{$users->find($log->subject_id)->name}}

                                                    @endif
                                                </td>
                                                <td>
                                                    @if($log->causer_id)
                                                        {{$users->find($log->causer_id)->roles()->pluck('name')->implode(' ')}}
                                                    @else
                                                        {{$users->find($log->subject_id)->roles()->pluck('name')->implode(' ')}}

                                                    @endif
                                                </td>
                                                <td>
                                                    {{$log->description}}
                                                </td>
                                                <td>
                                                    {{Carbon\Carbon::parse($log->created_at, 'UTC')->format('d/m/Y H:i:s')}}
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
            DataTable.search(value).draw();
        });

    </script>
@endsection
