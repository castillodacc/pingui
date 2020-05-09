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
	<link type="text/css" href="/css/app.css" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
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
		<div class="main front-page-main">
			<div class="container">
				<div class="row">
					<div  id="app" class="col-md-12">
						<div class="row">
							<div class="col-md-12">
								<h2 class="text-center"><span style="color:#C63A36">{{ $tournament->type_id == 1 ? 'LISTA DE INSCRITOS' : 'LIST' }}</span></h2>
								<h3 class="text-center text-uppercase">{{ $tournament->name }}</h3>
								@if($tournament->type_id == 2)
								<h3 style="padding-top:20px;color:#e32727;border-bottom: 1px solid #000; line-height: 0.1em; margin: 10px 0 20px; text-align: center;">
									<span style="padding:0 10px; background:#fff;color:#C63A36;font-size:28px;">
										Single
									</span>
								</h3>
								<div class="row">
									<div class="col-md-12">
										<table class="table table-condensed table-hover table-striped">
											<thead>
												<tr>
													<th>Nombre</th>
													<th>Apellido</th>
													<th>Club</th>
													<th>Email</th>
												</tr>
											</thead>
											<tbody>
												@foreach($tournament->inscriptions as $i)
												<?php if ($i->inscriptionOnline->category_id == 2) {continue;} ?>
												<tr>
													<td>{{ $i->name_1 }}</td>
													<td>{{ $i->lats_name_1 }}</td>
													<td>{{ $i->inscriptionOnline->club }}</td>
													<td>{{ $i->inscriptionOnline->email }}</td>
												</tr>
												@endforeach
											</tbody>
										</table>
									</div>
								</div>
								@endif
								@if($tournament->type_id == 2)
								<h3 style="padding-top:20px;color:#e32727;border-bottom: 1px solid #000; line-height: 0.1em; margin: 10px 0 20px; text-align: center;">
									<span style="padding:0 10px; background:#fff;color:#C63A36;font-size:28px;">
										Couple
									</span>
								</h3>
								<div class="row">
									<div class="col-md-12">
										<table class="table table-condensed table-hover table-striped">
											<thead>
												<tr>
													<th>Nombre</th>
													<th>Apellido</th>
													<th>Club</th>
													<th>Email</th>
												</tr>
											</thead>
											<tbody>
												@foreach($tournament->inscriptions as $i)
												<?php if ($i->inscriptionOnline->category_id == 1) {continue;} ?>
												<tr>
													<td>{{ $i->name_1 }}</td>
													<td>{{ $i->lats_name_1 }}</td>
													<td>{{ $i->inscriptionOnline->club }}</td>
													<td>{{ $i->inscriptionOnline->email }}</td>
												</tr>
												@endforeach
											</tbody>
										</table>
									</div>
								</div>
								@endif
							</div>
							@if(!$tournament->type_id == 1)
							@foreach([1,2,3] as $n)
							<div class="col-md-4">
								<h3 class="text-center">
									<span style="color:#C63A36">
										@if ($n == 1)
										Categoría OPENS
										@elseif ($n == 2)
										Categoría LATINOS
										@else
										Categoría STANDARD
										@endif
									</span>
								</h3>
								@foreach($tournament->prices->where('category_id', $n) as $p)
								@if(!$p->inscriptions->count()) <?php continue; ?> @endif
								<h3 style="padding-top:10px;color:#e32727;border-bottom: 1px solid #000; line-height: 0.1em; margin: 0px 0 14px; text-align: center; ">
									<span style="padding:0 10px; background:#fff;color:#C63A36;font-size:20px;">
										@if ($n == 1)
										{{ $p->subHelp()->name }}
										@elseif ($n == 2)
										{{ $p->subHelp()->category_latino->name }} - {{ $p->subHelp()->name }}
										@else
										{{ $p->subHelp()->category_standar->name }} - {{ $p->subHelp()->name }}
										@endif
									</span>
								</h3>
								<table class="table table-condensed table-hover table-striped">
									<thead>
										<tr>
											<th>Hombre</th>
											<th>Mujer</th>
										</tr>
									</thead>
									<tbody>
										@foreach($p->inscriptions as $i)
										<tr>
											<td>{{ $i->name_1 }} {{ $i->last_name_1 }}</td>
											<td>{{ $i->name_2 }} {{ $i->last_name_2 }}</td>
										</tr>
										@endforeach
									</tbody>
								</table>
								@endforeach
							</div>
							@endforeach
							@endif
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
	<script type="text/javascript" src="/js/app.js"></script>
</body>
</html>