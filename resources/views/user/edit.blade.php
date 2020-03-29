@extends('layout.app')
@section('title','Editar Usuário')

@section('before_css')
@endsection

@section('after_css')

@endsection

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Editar Usuário</h1>
            </div>
            @include('layout.alerts')
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form method="POST" action="{{route('user.update',$user->id)}}">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="name">Nome</label>
                                        <input type="text" name="name" class="form-control" id="name" value="{{$user->name}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">E-mail</label>
                                        <input type="text" name="email" class="form-control" id="name" value="{{$user->email}}">
                                    </div>

                                    <div class="form-group">
                                        <label for="name">Senha</label>
                                        <input type="password" name="password" class="form-control" id="password" value="">
                                    </div>

                                    @if(!$roles->isEmpty() && auth()->user()->is_admin)
                                        <h5><b>Atribuir Perfis</b></h5>
                                        <div class="form-group">
                                            @foreach ($roles as $role)
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" name="roles[]" {{  $roles_user->contains($role->name) ? 'checked' : '' }}  value="{{$role->name}}" id="customCheck{{$role->id}}">
                                                    <label class="custom-control-label" for="customCheck{{$role->id}}">{{ ucfirst($role->name) }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

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
    <script src="{{asset('assets/js/scripts.js')}}"></script>>
    <script src="{{asset('assets/js/custom.js')}}"></script>
@endsection
