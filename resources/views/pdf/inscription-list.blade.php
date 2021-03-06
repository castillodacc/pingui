<style>
html {
	font-family: helvetica;
	font-size: 12px;
}
.text-center {
	text-align: center;
}
.row {
	width: 100%;
}
.col-md-12 {
	width: 100%;
	float: left;
}
.page-break {
	page-break-after: always;
}
.table {
	width: 100%;
	max-width: 100%;
	border-collapse: collapse;
	border-spacing: 0;
	margin: 0 0 1.5em;
	box-sizing: border-box;	
}
.table td, .table th {
	border: 1px solid #d2d2d2;
}
</style>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
@if($tournament->type_id == 1)
<div class="row">
	<div class="col-md-12">
		<h2 class="text-center"><span style="color:#C63A36">LISTA DE INSCRITOS</span></h2>
		<h3 class="text-center text-uppercase">{{ $tournament->name }}</h3>
		<h3 style="padding-top:10px;color:#e32727;border-bottom: 1px solid #000; line-height: 0.1em; margin: 10px 0 20px; text-align: center; "><span style="padding:0 10px; background:#fff;color:#C63A36;font-size:20px;">{{ $tournament->inscriptions->count() }} Parejas</span></h3> 
	</div>
	@foreach([1,2,3] as $n)
	<div class="col-md-4">
		<h3 class="text-center" style="min-width: 100%;display: block;">
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
		<h3 style="min-width: 100%;display: block;padding-top:10px;color:#e32727;border-bottom: 1px solid #000; line-height: 0.1em; margin: 0px 0 14px; text-align: center;">
			<span style="padding:0 10px; background:#fff;color:#C63A36;font-size:16px;">
				@if ($n == 1)
				{{ $p->subHelp()->name }}
				@elseif ($n == 2)
				{{ $p->subHelp()->category_latino->name }} - {{ $p->subHelp()->name }}
				@else
				{{ $p->subHelp()->category_standar->name }} - {{ $p->subHelp()->name }}
				@endif
			</span>
		</h3>
		<table class="table table-condensed table-hover table-striped table-bordered">
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
	<hr>
	<div class="page-break"></div>
	@endforeach
</div>
@endif



@if($tournament->type_id == 2)
<div class="row">
	<div class="col-md-12">
		<h2 class="text-center"><span style="color:#C63A36">LIST</span></h2>
		<h2 class="text-center text-uppercase">{{ $tournament->name }}</h2>
		<h3 style="padding-top:10px;color:#e32727;border-bottom: 1px solid #000; line-height: 0.1em; margin: 10px 0 20px; text-align: center; "><span style="padding:0 10px; background:#fff;color:#C63A36;font-size:20px;">{{ $tournament->inscriptions->count() }} Inscribed</span></h3> 
	</div>
	@foreach($dances as $key => $value)
	<?php
	$test = true;
	foreach ($tournament->inscriptions as $i) {
		if (in_array($key, explode(',', $i->inscriptionOnline->dance))) {
			$test = false; continue;
		}
	}
	if ($test) {continue;}
	?>
	<div class="col-md-4">
		<h2 class="text-center" style="min-width: 100%;display: block;">
			<span style="color:#C63A36">
				{{ $value }}
			</span>
		</h2>
		@foreach($age_groups as $key_ag => $value_ag)
		<?php
		$test2 = true;
		foreach ($tournament->inscriptions as $i) {
			if (in_array($key_ag, explode(',', $i->inscriptionOnline->age_group)) && in_array($key, explode(',', $i->inscriptionOnline->dance))) {
				$test2 = false; continue;
			}
		}
		if ($test2) {continue;}
		?>
		<h4 class="text-center" style="min-width: 100%;display: block;">
			<span style="color:#C63A36">
				{{ $value_ag }}
			</span>
		</h4>
		<table class="table table-condensed table-hover table-striped table-bordered">
			<thead>
				<tr>
					<th>Nombre</th>
					<th>Apellido</th>
					<th>Pais</th>
				</tr>
			</thead>
			<tbody>
				@foreach($tournament->inscriptions as $i)
				<?php if (! in_array($key, explode(',', $i->inscriptionOnline->dance))) {continue;} ?>
				<?php if (! in_array($key_ag, explode(',', $i->inscriptionOnline->age_group))) {continue;} ?>
				<tr>
					<td>{{ $i->name_1 }}</td>
					<td>{{ $i->last_name_1 }}</td>
					<td>{{ $i->inscriptionOnline->country }}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		@endforeach
	</div>
	<hr>
	<div class="page-break"></div>
	@endforeach
</div>
@endif
