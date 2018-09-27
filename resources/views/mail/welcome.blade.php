@extends('mail.layouts')
@section('saludo')
Bienvenido
@endsection
@section('content')
<tr>
	<td style="padding: 5px 0 5px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px; text-align: justify;">
		<p>
			Bienvenid@ <b>{{ $data['name'] }} {{ $data['last_name'] }}</b>, a nuestra plataforma, donde podrás participar en todas las competiciones de baile que desees y podrás consultar los horarios, precios y novedades sobre cada competición.
		</p>
		<p>
			Presiona el siguiente botón para confirmar tu cuenta: <a href="{{ url('/confirm/' . $data['confirm']) }}" style="border-radius: 3px; -webkit-box-shadow: none; box-shadow: none; border: 1px solid transparent; background-color: #00c0ef; border-color: #00acd6; display: inline-block; margin-bottom: 0; font-weight: normal; text-align: center; vertical-align: middle; -ms-touch-action: manipulation; touch-action: manipulation; text-decoration: none; padding: 5px; color: black; font-weight: 600; cursor: pointer; background-image: none; white-space: nowrap;">Click aquí!</a>
		</p>
		<br><br><br><br>
		<p> Si tienes problemas al presionar el botón puedes hacer click en este enlace: <a href="{{ url('/confirm/' . $data['confirm']) }}">click aquí!</a> </p>
	</td>
</tr>
@endsection
