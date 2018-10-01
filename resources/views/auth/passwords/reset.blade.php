@extends('layouts.app')

@section('title', 'Recuperar Contraseña | ')

@section('end')
<body class="hold-transition login-page layout-top-nav">
    <div id="app" class="wrapper">
        <div class="login-box">
            <div class="login-logo">
                {!! config('frontend.logo_lg') !!}
            </div>
            <div class="login-box-body">
                <p class="login-box-msg">Recuperar Contraseña.</p>
                @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
                @endif

                <form method="POST" action="{{ route('password.request') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
                        <label for="email" class="control-label">Correo:</label>
                        <input id="email" type="email" class="form-control" name="email"  placeholder="Email" value="{{ old('email') }}" required autofocus>
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
                        <label for="password" class="control-label">Contraseña:</label>
                        <input id="password" type="password" class="form-control" name="password"  placeholder="Contraseña" required>
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group has-feedback {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                        <label for="password_confirmation" class="control-label">Contraseña:</label>
                        <input id="password_confirmation" type="password" class="form-control" name="password_confirmation"  placeholder="confirmación de Contraseña" required autofocus>
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">
                            Reiniciar Contraseña
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
@endsection
