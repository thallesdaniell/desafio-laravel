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
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="far fa-user"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total</h4>
                            </div>
                            <div class="card-body">
                                {{$total}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">


                                <div class="">
                                    <table class="table table-borderless" id="table">
                                        <thead>
                                        <tr>
                                            <th>Ultimos cadastrados</th>


                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($clientes as $cliente)
                                            <tr>
                                                <td>
                                                    <h3 class="">
                                                        <small class="text-muted">
                                                            <div class="card-header-action">
                                                                <a data-collapse="#mycard-collapse{{$cliente->id}}"
                                                                   class="btn btn-icon btn-info" href="#"><i
                                                                        class="fas fa-plus"></i></a>
                                                                {{$cliente->name}}

                                                            </div>
                                                        </small>
                                                    </h3>
                                                    <div class="accordian-body collapse"
                                                         id="mycard-collapse{{$cliente->id}}">
                                                        <div class="col-lg-12">
                                                            <div class="activities">
                                                                <div class="activity">
                                                                    <div
                                                                        class="activity-icon bg-primary text-white shadow-primary">
                                                                        <i style="font-size: 15px;"
                                                                           class="far fa-envelope"></i>
                                                                    </div>
                                                                    <div class="activity-detail">
                                                                        <p>{{$cliente->email}}</p>
                                                                    </div>
                                                                </div>
                                                                @foreach($cliente->phone as $phone)
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
