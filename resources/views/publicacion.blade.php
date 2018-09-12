<!DOCTYPE html>
<html lang="es"class="yes-js js_active js cye-disabled cye-nm">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>Pingui</title>
	<link rel="stylesheet" href="/css/bootstrap.min.css" type="text/css" media="all">
	<link rel="stylesheet" href="/css/jquery.flexslider.min.css" type="text/css" media="all">
	<link rel="stylesheet" href="/css/css-style.css" type="text/css" media="all">
	<link rel="stylesheet" href="/css/shop-isle-style.css" type="text/css" media="all">
	<link type="text/css" href="/css/optanon.css" rel="stylesheet">
	<script type="text/javascript" src="/js/jquery.min.1.11.2.js"></script>
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
								<li id="menu-item-2753" class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-2753"><a href="/" class="section-scroll">Home</a></li>
								<li id="menu-item-2753" class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-2753"><a href="/#competitions" class="section-scroll">Competencias</a></li>
								@if(\Auth::check())
								<li id="menu-item-2753" class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-2753"><a href="/perfil">Perfil</a></li>
								<li id="menu-item-2753" class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-2753">
									<a href="#" data-toggle="tooltip" title="Salir" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
										<span class="fa fa-lock"></span> Salir
									</a>
								</li>
								<form id="logout-form" action="/logout" method="POST" style="display:none;">
									<input type="hidden" name="_token" value="">
									<input type="hidden" name="_method" value="POST">
								</form>
								@else
								<li id="menu-item-2753" class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-2753"><a href="/login">Iniciar Sesión</a></li>
								<li id="menu-item-2753" class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-2753"><a href="/registro">Registrate</a></li>
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
							<div class="">
								<h1  class="hidden-xs hidden-sm">{{ $tournament->name }}</h1>
								<hr>
								<small>Publicado: {{ $tournament->created_at->format('d/m/Y') }}.</small><br>
								<small>Se realizará desde: {{ $tournament->start }} - Hasta: {{ $tournament->end }}.</small><br>
								<small><strong>Organizador: {{ $tournament->organizador }}.</strong></small><br>
								<small><strong>Inscripción: {{ ($tournament->inscription) ? 'Abierta' : 'Cerrada' }}.</strong></small>
								<small><strong>Precio de entradas: {{ $tournament->entrance_price }}.</strong></small><br>
								<small><strong>Precio de Participación: {{ $tournament->price }}.</strong></small><br>
								<div class="btn-group" role="group" aria-label="...">
									@if($tournament->info)
									<a href="{{ asset('storage/info/' . $tournament->info) }}" class="btn btn-info" target="_blanck">Hoja informativa</a>
									@endif
									@if($tournament->maps)
									<a href="{{ $tournament->maps }}" class="btn btn-black" target="_blanck">Mapa</a>
									@endif
									@if($tournament->hours)
									<a href="{{ asset('storage/hours/' . $tournament->hours) }}" class="btn btn-success" target="_blanck">Horarios</a>
									@endif
									@if($tournament->results)
									<a href="{{ $tournament->results }}" class="btn btn-danger" target="_blanck">Resultados</a>
									@endif
								</div>
								<hr>
								<p class="text-justify">{{ $tournament->description }}</p>
							</div>
							<hr>
							<div class="row">
								<h4>Referees:</h4>
								@foreach($tournament->referees as $r)
								<span class="label label-primary">{{ $r->name }}</span>
								@endforeach
							</div>
							<hr>
							<div class="row">
								Categorias Participantes:
								<div class="row">
									<h4 style="display: inline;">Categorias Opens:</h4>
									@foreach($tournament->category_opens as $c)
									<span class="label label-success">{{ $c->name }}</span>
									@endforeach
								</div>
								<div class="row">
									<h4 style="display: inline;">Categorias Latinos:</h4>
									@foreach($tournament->subcategory_latinos as $c)
									<span class="label label-success">{{ $c->name }}</span>
									@endforeach
								</div>
								<div class="row">
									<h4 style="display: inline;">Categorias Standar:</h4>
									@foreach($tournament->subcategory_standars as $c)
									<span class="label label-success">{{ $c->name }}</span>
									@endforeach
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