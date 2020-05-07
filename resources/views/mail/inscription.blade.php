@extends('mail.layouts')
@section('saludo')
@if($data->user_id)
Hola {{ $data->user->fullName() }}.
@else
Hola {{ $data->name_1 }} {{ $data->name_2 }}.
@endif
@endsection
@section('content')
<tr>
	<td style="padding: 5px 0 5px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px; text-align: justify;">
		<p>Has completado la inscripción a la competición de: "{{ $data->tournament->name }}".</p>
		<p>Para validar la inscripción es imprescindible haber realizado el pago.</p>
		@if($data->method_pay == 1)
		<p>Si todavía tienes que realizar el pago por transferencia bancaria, recuerda introducir en el campo de referencia los nombres de los participantes. </p>
		<p>Los datos para realizar la transferencia bancaria son los siguientes:</p>
		<ul>
			<li>Banco: <b>{{ $data->tournament->organizer->bank }}</b>.</li>
			<li>Cuenta: <b>{{ $data->tournament->organizer->account }}</b>.</li>
			<li>Titular: <b>{{ $data->tournament->organizer->headline }}</b>.</li>
			<li>Total: <b>{{ $data->pay }} €</b>.</li>
		</ul>
		@endif
		<p>Para ver el listado de participantes <a href="{{ route('list', $data->tournament->slug) }}">haz click aquí</a>.</p>
		<p>Para ver más información sobre la competición visita nuestra página web: <a href="{{ url('/') }}">{{ url('/') }}</a></p>
		<p>Un cordial saludo.</p>
		<p>El equipo de <a href="{{ url('/') }}">PINGUI.es</a></p>
	</td>
</tr>
@endsection
