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
		<nav class="navbar navbar-custom navbar-fixed-top  navbar-color-on-scroll navbar-transparent" role="navigation">
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
								<li id="menu-item-2753" class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-2753"><a href="#home" class="section-scroll">Home</a></li>
								<li id="menu-item-2753" class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-2753"><a href="#competitions" class="section-scroll">Competencias</a></li>
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
		<section id="home" class="home-section home-parallax home-fade  home-full-height" style="height: 699px;">
			<div class="hero-slider">
				<ul class="slides" style="margin-left: 0; padding-left: 0;">
					<li class="bg-dark-30 bg-dark" style="background-image: url('/images/bailando.jpg'); width: 100%; float: left; margin-right: -100%; position: relative; opacity: 0; display: block; z-index: 1;" data-thumb-alt="">
						<div class="hs-caption" style="top: 0px; display: table;">
							<div class="caption-content" style="opacity: 1;">
								<h1 class="hs-title-size-4 font-alt mb-30">Bienvenido a <br><b>P I N G U I</b></h1>
								{{-- <div class="hs-title-size-1 font-alt mb-40">Paris Street Style</div> --}}
								<a href="#competitions" class="section-scroll btn btn-border-w btn-round">Competiciones</a>
							</div>
						</div>
					</li>
					@foreach($tournament2 as $t)
					<li class="bg-dark-30 bg-dark flex-active-slide" style="background-image: url('{{ asset('storage/' . $t->image) }}'); width: 100%; float: left; margin-right: -100%; position: relative; opacity: 1; display: block; z-index: 2;" data-thumb-alt="">
						<div class="hs-caption" style="top: 0px; display: table;">
							<div class="caption-content" style="opacity: 1;">
								<div class="hs-title-size-4 font-alt mb-30"><b>{{ $t->name }}</b></div>
								<div class="container">
									@if(strlen($t->description) > 120)
									<div class="hs-title-size-1 font-alt mb-40">{{ substr($t->description, 0, 120) . '...' }}</div>
									@else
									<div class="hs-title-size-1 font-alt mb-40">{{ $t->description }}</div>
									@endif
								</div>
								<a href="{{ route('publication.show', $t->slug) }}" class="section-scroll btn btn-border-w btn-round">Ver Detalles</a>
							</div>
						</div>
					</li>
					@endforeach
				</ul>
				<ul class="flex-direction-nav">
					<li class="flex-nav-prev">
						<a class="flex-prev" href="#">
						</a>
					</li>
					<li class="flex-nav-next">
						<a class="flex-next" href="#">
						</a>
					</li>
				</ul>
			</div>
		</section>
		<div class="main front-page-main" style="background-color: #FFF">
			<section id="competitions" class="module-small" style="min-height: 100vh">
				<div class="container">
					<div class="row multi-columns-row">
						@foreach($tournament as $t)
						<div class="col-sm-6 col-md-3 col-lg-3">
							<a href="#">
								<div class="shop-item">
									<div class="shop-item-image">
										<img width="262" height="328" src="#" class="attachment-shop_catalog size-shop_catalog wp-post-image" alt="" srcset="{{ asset('storage/' . $t->image) }}" sizes="(max-width: 262px) 100vw, 262px" style="min-height: 330px;">	
										<div class="shop-item-detail">
											<p class="product woocommerce add_to_cart_inline " style="border:4px solid #ccc; padding: 12px;">
												<a href="{{ route('publication.show', $t->slug) }}">
													<b style="font-size: 1.5em">Ver Detalles</b>
												</a>
											</p>
											{{-- <div class="product-button-wrap">
												<div class="add-to-cart-button-wrap">
													<a href="{{ route('publication.show', $t->slug) }}" class="button product_type_simple add_to_cart_button ajax_add_to_cart">Ver Detalles</a>
												</div>
											</div> --}}
										</div>
									</div>
									<h4 class="shop-item-title font-alt">
										<a href="{{ route('publication.show', $t->slug) }}">{{ $t->name }}</a>
									</h4>
									<div class="product-rating-home">
										<div class="star-rating">Desde: {{ \Carbon::parse($t->start)->format('d/m/Y') }} - Hasta: {{ \Carbon::parse($t->end)->format('d/m/Y') }}.
											{{-- <div class="hs-title-size-1 font-alt mb-40">desde: {{ $t->start }} - hasta: {{ $t->end }}</div> --}}
											{{-- <span style="width:20%">{{ $t->description }}</span> --}}
										</div>
									</div>
									<span class="onsale">Inscripción: <b>{{ ($t->inscription) ? 'Abierta' : 'Cerrada' }}</b>.</span><br>
									{{-- <span class="amount">Precio de Entradas: {{ number_format($t->entrance_price, 2) }}<span> €</span></span> --}}
									{{-- <ins>
										<span class="woocommerce-Price-amount amount">12.00<span class="woocommerce-Price-currencySymbol">£</span></span>
									</ins> --}}
								</div>
							</a>
						</div>
						@endforeach
					</div>
					<div class="row mt-30">
						<div class="col-sm-12 align-center">{!! $tournament->render() !!}</div>
					</div>
				</div>
			</section>
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