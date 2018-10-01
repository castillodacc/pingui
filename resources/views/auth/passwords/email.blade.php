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

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

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

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">
                            Enviar enlace para reestablecer contraseña
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
@endsection
