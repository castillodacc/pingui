<template>
	<div>
		<form @submit.prevent="register" v-if="r === true">
			<div class="col-md-4">
				<div class="form-group">
					<label for="febd_num_1" class="control-label">
						<span class="fa fa-febd_num_1"></span> Número de FEBD: {{id}}
					</label>
					<input id="febd_num_1" type="text" class="form-control" v-model="inscription.febd_num_1" disabled="">
					<small id="febd_num_1Help" class="form-text text-muted" v-text="msg.febd_num_1"></small>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label for="febd_num_2" class="control-label">
						<span class="fa fa-febd_num_2"></span> Número FEBD de la pareja:
					</label>
					<select id="febd_num_2" class="form-control" v-model="inscription.febd_num_2" disabled="">
						<option value="">Seleccione su pareja</option>
						<option v-for="p in data.parejas" :value="p.febd_num">{{ p.febd_num }} - {{ p.name }} {{ p.last_name }}</option>
					</select>
					<small id="febd_num_2Help" class="form-text text-muted" v-text="msg.febd_num_2"></small>
				</div>
			</div>
			<div class="col-md-8" style="font-size: 1.5em">
				<div class="row">
					<p>Seleccione el tipo de pago</p>
					<div class="col-md-6 btn borde" :class="{'btn-primary': inscription.type_pay == 1}" @click="changeType(1)">
						Transferencia
					</div>
					<div class="col-md-6 btn borde" :class="{'btn-primary': inscription.type_pay == 2}" @click="changeType(2)">
						Paypal<i class="glypicon glypicon-ravelry" aria-hidden="true"></i>
					</div>
					<small id="type_payHelp" class="form-text text-muted" v-text="msg.type_pay"></small>
				</div>
				<div class="col-md-12" v-if="inscription.type_pay == 1">
					<hr>
					<p style="font-size: 14px;">Guarde los datos bancarios y haga un deposito dependiendo de la categoria del baile que participará.</p>
					<p style="margin: 0">Banco: <b>Banco Sabadell</b></p>
					<p style="margin: 0">Cuenta: <b>IBAN : ES65 0081 0400 1100 0131 0241</b></p>
					<p style="margin: 0">Titular: <b>Kavarna</b></p>
				</div>
			</div>
			<div class="span pull-right" style="padding: 15px"><button type="submit">Registrar</button></div>
		</form>
		<div class="col-md-8" v-else>
			<div class="alert alert-success">
				<h3 class="text-center">Ya te haz Registrado.</h3>
				<p>Hola {{ data.name }} {{ data.last_name }}, haz sido registrado de forma exitosa en esta competencia.</p>
				<p>
					<b>Estado de Participación: </b>
					<span v-if="r.state == 1">Ya fué aprovada su participación en la competencia...</span>
					<span v-else>En espera de aprovación...</span>
				</p>
				<div v-if="r.type_pay == 1 && !r.state">
					<p style="font-size: 14px;">No te olvides de llevar a cabo la forma de pago seleccionada.</p>
					<p style="margin: 0">Banco: <b>Banco Sabadell</b></p>
					<p style="margin: 0">Cuenta: <b>IBAN : ES65 0081 0400 1100 0131 0241</b></p>
					<p style="margin: 0">Titular: <b>Kavarna</b></p>
				</div>
			</div>
		</div>
	</div>
</template>

<style>
.borde {
	border: 1px solid;
}
</style>

<script>
	export default {
		name: 'Inscription',
		props: ['id'],
		data() {
			return {
				r: true,
				data: {},
				msg: {
					febd_num_1: 'Número del usuario.',
					febd_num_2: 'Seleccione la pareja con la que participará.',
					type_pay: 'Señale el tipo de pago.',
				},
				inscription: {
					user_id: '',
					tournament_id: '',
					febd_num_1: '',
					name_1: '',
					last_name_1: '',
					name_2: '',
					last_name_2: '',
					type_pay: '',
				}
			};
		},
		mounted() {
			this.inscription.tournament_id = this.id;
			this.get();
		},
		methods: {
			get: function () {
				axios.post('/get-data', {id: this.id})
				.then(response => {
					if (response.data.state) {
						this.r = response.data.state;
					}
					this.data = response.data.user;
					this.inscription.user_id = this.data.id;
					this.inscription.febd_num_1 = this.data.febd_num;
					this.inscription.name_1 = this.data.name;
					this.inscription.last_name_1 = this.data.last_name;
					if (this.data.parejas.length > 0) {
						this.inscription.febd_num_2 = this.data.parejas[0].febd_num;
						this.inscription.name_2 = this.data.parejas[0].name;
						this.inscription.last_name_2 = this.data.parejas[0].last_name;
					}
				});
			},
			changeType: function (num) {this.inscription.type_pay = num; },
			register: function () {
				axios.post('/inscription', this.inscription)
				.then(response => {
					toastr.success('Registro exitoso');
					setTimeout(() => window.location.refresh(), 1000);
				});
			}
		}
	}
</script>
