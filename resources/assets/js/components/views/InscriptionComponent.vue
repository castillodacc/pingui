<template>
	<div class="box">
		<form action="">
			<div class="col-md-4">
				<div class="form-group">
					<label for="febd_num" class="control-label">
						<span class="fa fa-febd_num"></span> Número de FEBD:
					</label>
					<input id="febd_num" type="text" class="form-control" v-model="inscription.febd_num" disabled="">
					<small id="febd_numHelp" class="form-text text-muted" v-text="msg.febd_num"></small>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label for="febd_num_p" class="control-label">
						<span class="fa fa-febd_num_p"></span> Número FEBD de la pareja:
					</label>
					<select id="febd_num_p" class="form-control" v-model="inscription.febd_num_p">
						<option value="">Seleccione su pareja</option>
						<option v-for="p in data.parejas" :value="p.id" v-text="p.name"></option>
					</select>
					<small id="febd_num_pHelp" class="form-text text-muted" v-text="msg.febd_num_p"></small>
				</div>
			</div>
			<div class="col-md-8" style="font-size: 1.5em">
				<div class="row">
					<p>Seleccione el tipo de pago</p>
					<div class="col-md-6 btn" :class="{'btn-primary': inscription.type_pay == 1}" @click="changeType(1)">
						Transferencia
					</div>
					<div class="col-md-6 btn" :class="{'btn-primary': inscription.type_pay == 2}" @click="changeType(2)">
						Paypal<i class="glypicon glypicon-ravelry" aria-hidden="true"></i>
					</div>
				</div>
				<div class="col-md-12" v-if="inscription.type_pay == 1">
					<hr>
					<p style="font-size: 14px;">Guarde los datos bancarios y haga un deposito dependiendo de la categoria del baile que participará.</p>
					<p style="margin: 0">Banco: <b>Banco Sabadell</b></p>
					<p style="margin: 0">Cuenta: <b>IBAN : ES65 0081 0400 1100 0131 0241</b></p>
					<p style="margin: 0">Titular: <b>Kavarna</b></p>
				</div>
			</div>
				<!-- <div class="form-group">
					<label for="type_pay" class="control-label">
						<span class="fa fa-type_pay"></span> Tipo de pago:
					</label>
					<select id="type_pay" class="form-control" v-model="inscription.type_pay">
						<option value="">Seleccione el tipo de pago</option>
						<option value="1">Transferencia</option>
						<option value="2">Paypal</option>
					</select>
					<small id="type_payHelp" class="form-text text-muted" v-text="msg.type_pay"></small>
				</div> -->


<!-- 
    	'user_id',
    	'tournament_id',
    	'febd_num_1',
    	'name_1',
    	'last_name_1',
    	'febd_num_2',
    	'name_2',
    	'last_name_2',
    	'',
    	'state_pay',
    	'state',
    -->
</form>
</div>
</template>

<script>
	export default {
		name: 'Inscription',
		data() {
			return {
				data: {},
				msg: {
					febd_num: 'Número del usuario.',
					febd_num_p: '.',
					type_pay: '.',
				},
				inscription: {
					febd_num: '',
					febd_num_p: '',
					type_pay: '',
				}

// category_l : null
// category_s : null
// club_id : null
// confirm : "123"
// email : "root@pingui.es"
// febd_num : null
// group_l : null
// group_s : null
// id : 1
// international_id : null
// last_name : "Root"
// name : "Root"
// num_id : 99999999
// phone : null
// trainer_l : null
// trainer_s : null
// user : "Root"
// web : null

};
},
mounted() {
	this.get();
},
methods: {
	get: function () {
		axios.post('/get-data')
		.then(response => {
			this.data = response.data.user;
			this.inscription.febd_num = response.data.user.febd_num;
			// inscription.febd_num_p = response.data.user.febd_num;
		});
	},
	changeType: function (num) {
		console.log('asd')
		this.inscription.type_pay = num;
	}
}
}
</script>
