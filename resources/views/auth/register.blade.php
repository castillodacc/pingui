@extends('layouts.app')

@section('title', 'Registro | ')

@section('end')
<body class="hold-transition login-page layout-top-nav">
    <div id="app" class="wrapper">
        <div class="login-box register">
            <div class="login-logo">
                {!! config('frontend.logo_lg') !!}
            </div>
            {{-- /.login-logo --}}
            <div class="login-box-body">
                <p class="login-box-msg">Ingresa para comenzar tu sesión.</p>

                <form method="POST" action="{{ url('register') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">

                            <div class="col-md-6">
                                <div class="form-group has-feedback {{ $errors->has('user') ? 'has-error' : '' }}">
                                    <label for="user" class="control-label">Nombre o Alias:</label>
                                    <input id="user" type="text" class="form-control" name="user"  placeholder="Usuario" value="{{ old('user') }}" required autofocus>
                                    <span class="fa fa-users form-control-feedback"></span>
                                    @if ($errors->has('user'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('user') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group has-feedback {{ $errors->has('name') ? 'has-error' : '' }}">
                                    <label for="name" class="control-label">Nombre:</label>
                                    <input id="name" type="text" class="form-control" name="name"  placeholder="Nombre" value="{{ old('name') }}" required autofocus>
                                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                    @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group has-feedback {{ $errors->has('last_name') ? 'has-error' : '' }}">
                                    <label for="last_name" class="control-label">Apellido:</label>
                                    <input id="last_name" type="text" class="form-control" name="last_name"  placeholder="Apellido" value="{{ old('last_name') }}" required>
                                    <span class="fa fa-user-o form-control-feedback"></span>
                                    @if ($errors->has('last_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group has-feedback {{ $errors->has('num_id') ? 'has-error' : '' }}">
                                    <label for="num_id" class="control-label">D.N.I:</label>
                                    <input id="num_id" type="text" class="form-control" name="num_id" placeholder="######" value="{{ old('num_id') }}" required>
                                    <span class="fa fa-id-card-o form-control-feedback"></span>
                                    @if ($errors->has('num_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('num_id') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group has-feedback {{ $errors->has('phone') ? 'has-error' : '' }}">
                                    <label for="phone" class="control-label">Número Telefónico:</label>
                                    <input id="phone" type="text" class="form-control" name="phone" placeholder="######" value="{{ old('phone') }}">
                                    <span class="fa fa-phone form-control-feedback"></span>
                                    @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group has-feedback {{ $errors->has('web') ? 'has-error' : '' }}">
                                    <label for="web" class="control-label">Web:</label>
                                    <input id="web" type="text" class="form-control" name="web" placeholder="www.dominio.com" value="{{ old('web') }}">
                                    <span class="fa fa-web form-control-feedback"></span>
                                    @if ($errors->has('web'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('web') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('club_id') ? 'has-error' : '' }}">
                                    <label for="club_id" class="control-label">Club:</label>
                                    <select id="club_id" type="text" class="form-control" name="club_id" placeholder="######">
                                        <option value="">Seleccione el club al que pertenece</option>
                                        @foreach ($clubs as $c)
                                        <option value="{{ $c->id }}" @if(old('club_id') == $c->id) selected="" @endif>{{ $c->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('club_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('club_id') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group {{ $errors->has('rol') ? 'has-error' : '' }}">
                                    <label for="rol" class="control-label">Perfil:</label>
                                    <select id="rol" type="text" class="form-control" name="rol" placeholder="######" required>
                                        <option value="">Seleccione el Perfil al que pertenece</option>
                                        @foreach ($roles as $r)
                                        <option value="{{ $r->id }}" @if(old('rol') == $r->id) selected="" @endif>{{ $r->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('rol'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('rol') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
                                    <label for="email" class="control-label">E-Mail:</label>
                                    <input id="email" type="text" class="form-control" name="email"  placeholder="usuario@dominio.com" value="{{ old('email') }}" required>
                                    <span class="fa fa-envelope form-control-feedback"></span>
                                    @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
                                    <label for="password" class="control-label">Contraseña:</label>
                                    <input id="password" type="password" class="form-control" name="password"  placeholder="Contraseña" required>
                                    <span class="fa fa-lock form-control-feedback"></span>
                                    @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group has-feedback {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                                    <label for="password_confirmation" class="control-label">Confirmación:</label>
                                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation"  placeholder="Confirmación" required>
                                    <span class="fa fa-lock form-control-feedback"></span>
                                    @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="col-xs-5">
                                    <a href="/login">Ya tengo una Cuenta.</a>
                                </div>
                                <div class="col-xs-4 col-md-offset-3">
                                    <button type="submit" class="btn btn-primary btn-block btn-flat">Ingresar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.login-box-body -->
        </div>
        <!-- /.login-box -->
    </div>
</body>
@endsection