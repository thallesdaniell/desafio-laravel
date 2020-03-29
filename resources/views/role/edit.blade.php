@extends('layout.app')
@section('title','Editar Perfil')

@section('before_css')
@endsection

@section('after_css')

@endsection

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Editar Perfil</h1>
            </div>
            @include('layout.alerts')
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form method="POST" action="{{route('role.update',$role->id)}}">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="name">Nome</label>
                                        <input type="text" name="name" class="form-control" id="name" value="{{$role->name}}">
                                    </div>

                                    <h5><b>Atribuir Permissões</b></h5>

                                    <div class="form-group">
                                        @foreach ($permissions as $permission)

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input"
                                                       {{  $role_permissions->contains($permission->name) ? 'checked' : '' }} name="permissions[]"
                                                       value="{{$permission->id}}" id="customCheck{{$permission->id}}">
                                                <label class="custom-control-label"
                                                       for="customCheck{{$permission->id}}">{{ ucfirst($permission->name) }}</label>
                                            </div>
                                        @endforeach
                                    </div>

                                    <button type="submit" class="btn btn-primary">Salvar</button>
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
@endsection
