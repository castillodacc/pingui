@extends('mail.layouts')
@section('content')
<tr>
	<td style="padding: 5px 0 5px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px; text-align: justify;">
		<p><b>Remitente:</b> {{ $data['name'] }} {{ $data['last_name'] }}.</p>
		<p><b>Email:</b> {{ $data['email'] }}.</p>
		<p><b>Télefono:</b> {{ $data['phone'] }}.</p>
		<p>{{ $data['message'] }}</p>
	</td>
</tr>
@endsection