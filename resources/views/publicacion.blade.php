<!DOCTYPE html>
<html lang="es"class="yes-js js_active js cye-disabled cye-nm">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>Pingui</title>
	<link rel="shortcut icon" href="{{ asset('/favicon.png') }}" type="image/x-icon">
	<link rel="stylesheet" href="/css/bootstrap.min.css" type="text/css" media="all">
	<link rel="stylesheet" href="/css/jquery.flexslider.min.css" type="text/css" media="all">
	<link rel="stylesheet" href="/css/css-style.css" type="text/css" media="all">
	<link rel="stylesheet" href="/css/shop-isle-style.css" type="text/css" media="all">
	<link type="text/css" href="/css/optanon.css" rel="stylesheet">
	<script type="text/javascript" src="/js/jquery.min.1.12.4.js"></script>
	<script type="text/javascript" src="/js/jquery-migrate.min.js"></script>
</head>
<body class="home blog">
	<header class="header">
		<nav class="navbar navbar-custom navbar-fixed-top  navbar-color-on-scroll navbar-transparent" role="navigation" style="background-color: rgba(10, 10, 10, 0.9) !important;">
			<div class="container">
				<div class="header-container">
					<div class="navbar-header">
						<div class="shop_isle_header_title">
							<div class="shop-isle-header-title-inner">
								<h1 class="site-title"><a href="/" title="ShopIsle" rel="home">{!! config('frontend.logo_lg') !!}</a></h1>
								<p class="site-description"><a href="/" title="" rel="home"></a></p>
							</div>
						</div>
						<div type="button" class="navbar-toggle" data-toggle="collapse" data-target="#custom-collapse">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</div>
					</div>
					<div class="header-menu-wrap">
						<div class="collapse navbar-collapse" id="custom-collapse">
							<ul id="menu-menu-1" class="nav navbar-nav navbar-right">
								<li class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home"><a href="/" class="section-scroll">Home</a></li>
								<li class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home"><a href="/#competitions" class="section-scroll">Competiciones</a></li>
								<li id="menu-item-2753" class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-2753"><a href="/contacto">Contacto</a></li>
								@if(\Auth::check())
								<li class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home"><a href="/perfil">Perfil</a></li>
								<li class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home">
									<a href="#" data-toggle="tooltip" title="Salir" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
										<span class="fa fa-lock"></span> Salir
									</a>
								</li>
								<form id="logout-form" action="/logout" method="POST" style="display:none;">
									{{ csrf_field() }}
									<input type="hidden" name="_method" value="POST">
								</form>
								@else
								<li class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home"><a href="/login">Iniciar Sesión</a></li>
								<li class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home"><a href="/registro">Registrate</a></li>
								@endif
							</ul>
						</div>
					</div>
				</div>
			</div>
		</nav>
	</header>
	<div class="main">
		<div class="main front-page-main" style="background-color: #FFF; min-height: 97vh; padding-top: 100px;">
			<div class="container">
				<div class="well"> 
					<div class="row">
						<div class="col-md-12">
							<div class="row hidden-md hidden-lg"><h1 class="text-center" >{{ $tournament->name }}</h1></div>
							<div class="pull-left col-md-4 col-xs-12 thumb-contenido">
								<img class="center-block img-responsive" src="{{ asset('storage/' . $tournament->image) }}" />
							</div>
							<div class="pull-right col-md-8 col-xs-12">
								<div class="row">
									<h1  class="hidden-xs hidden-sm">{{ $tournament->name }}</h1>
								</div>
								<div class="row">
									<div class="pull-left col-md-7 col-xs-12">
										<small>Se realizará: {{ Carbon::parse($tournament->start)->format('d/m/Y') }}.</small><br>
										<small><strong>Organizador:</strong> {{ $tournament->organizer->name }}.</small><br>
										<small><strong>Inscripción: {{ ($tournament->inscription) ? 'Abierta' : 'Cerrada' }}.</strong></small><br>
										@if($tournament->info)
										<small><strong>Precio de competición:</strong> <a href="{{ asset('storage/info/' . $tournament->info) }}" class="btn btn-info btn-block" target="_blank">Consultar Hoja Informativa</a></small><br>
										<div class="col-md-4">

										</div>
										@endif
										<h5><b>Precios de los Opens:</b></h5>
										<ul>
											@foreach($tournament->prices->where('category_id', 1) as $p)
											<li>
												{{ optional($p->subO)->name }}:
												<em><b>{{ $p->price }} €</b></em>
											</li>
											@endforeach
										</ul>
									</div>
									<div class="pull-right col-md-5 col-xs-12">
										<h5><b>Más Información:</b></h5>
										<ul>
											@foreach($tournament->moreInfo->where('active', 1) as $p)
											<li>
												<a href="{{ $p->link }}" class="btn-link" target="_blank">{{ $p->name }}</a>
											</li>
											@endforeach
										</ul>
									</div>
									@if(\Auth::guest())
									<div class="pull-right col-md-4 col-xs-12 hidden-xs hidden-sm" style="border: 1px solid; border-radius: 10px">
										<div class="card card-container ">
											<span id="profile-name" class="profile-name-card"><b class="text-center">Inicia Sesión</b></span>
											<form class="form-signin" action="/login" method="post">
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
												<div class="form-group {{ $errors->has('password') ? 'has-error' : '' }} has-feedback">
													<label for="password" class="control-label">Contraseña:</label>
													<input id="password" type="password" class="form-control" name="password"  placeholder="Contraseña" value="" required>
													<span class="glyphicon glyphicon-cog form-control-feedback"></span>
													@if ($errors->has('password'))
													<span class="help-block">
														<strong>{{ $errors->first('password') }}</strong>
													</span>
													@endif
												</div>
												<button type="submit" class="btn btn-primary btn-block">Ingresar</button>
												<a href="/registro">No tienes cuenta?</a>
											</form>
										</div>
									</div>
									@endif
								</div>
								<div class="row">
									@if(\Auth::check() && \Auth::user()->febd_num == '')
									<div class="col-md-12">
										<div class="alert alert-info" role="alert">
											<span class="text-warning">
												Actualiza tu <b><a href="/perfil/3">perfil</a></b> para inscribirte.
											</span>
										</div>
									</div>
									@endif
									<div class="col-md-12">
										<div class="row">
											@if(\Auth::guest())
											<div class="col-md-4">
												<a href="/registro" class="btn btn-primary btn-block">Registrate</a>
											</div>
											@endif
											@if($tournament->maps)
											<div class="col-md-2">
												<a href="{{ $tournament->maps }}" class="btn btn-black btn-block" target="_blank">Mapa</a>
											</div>
											@endif
											@if($tournament->hours && $tournament->show_hour)
											<div class="col-md-3">
												<a href="{{ asset('storage/hours/' . $tournament->hours) }}" class="btn btn-success btn-block" target="_blank">Horarios</a>
											</div>
											@endif
											@if($tournament->inscription)
											<div class="col-md-3">
												<a href="{{ route('publication.inscription', $tournament->slug) }}" class="btn btn-warning btn-block">Inscribrete</a>
											</div>
											@elseif($tournament->results)
											<div class="col-md-4">
												<a href="http://results.pingui.es/events.php?pod_id={{ $tournament->results }}" class="btn btn-danger btn-block" target="_blank">Resultados</a>
											</div>
											@endif
										</div>
									</div>
								</div>
								<hr>
								<p class="text-justify">{{ $tournament->description }}</p>
							</div>
							<hr>
							<div class="clearfix"></div>
							<div class="row">
								<div class="col-md-8">
									<h4><b>Categorias Participantes:</b></h4>
									<div class="row">
										<div class="col-md-12">
											<h5 style="display: inline;">Categorias Opens:</h5>
											@foreach($tournament->prices->where('category_id', 1) as $c)
											<span class="label label-success">{{ $c->subO->name }}</span>
											@endforeach
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<h5 style="display: inline;">Categorias Latinos:</h5>
											@foreach($tournament->prices->where('category_id', 2) as $c)
											<span class="label label-success">{{ $c->subL->category_latino->name }} - {{ $c->subL->name }}</span>
											@endforeach
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<h5 style="display: inline;">Categorias Standar:</h5>
											@foreach($tournament->prices->where('category_id', 3) as $c)
											<span class="label label-success">{{ $c->subS->category_standar->name }} - {{ $c->subS->name }}</span>
											@endforeach
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<h4><b>Hoteles:</b></h4>
									<div class="row">
										@foreach($tournament->hotels as $c)
										<a href="{{ $c->link }}" class="btn btn-link" target="_blank">{{ $c->name }}</a>
										@endforeach
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="bottom-page-wrap">
			<footer class="footer bg-dark">
				<hr class="divider-d">
				<div class="container">
					<div class="row">
						<div class="col-sm-6">
							<p class="shop-isle-poweredby-box">
								<a class="shop-isle-poweredby" href="/"> {!! config('frontend.credits') !!} </a>
							</p>
						</div>
					</div>
				</div>
			</footer>
		</div>
	</div>
	<script type="text/javascript" src="/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="/js/jquery.flexslider.min.js"></script>
	<script type="text/javascript" src="/js/custom.js"></script>
</body>
</html>