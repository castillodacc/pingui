<template>
	<div>
		<form @submit.prevent="register" v-if="r === true">
			<p>Datos de pareja:	</p>
			<div class="col-md-4">
				<div class="form-group">
					<label for="febd_num_1" class="control-label">
						<span class="fa fa-febd_num_1"></span> Número de FEBD:
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
			<div class="col-md-8" v-show="!!inscription.febd_num_2 && !!inscription.febd_num_1">
				<div class="form-group">
					<label for="price_id" class="control-label">
						<span class="fa fa-price_id"></span> Categoría en la que participará:
					</label>
					<select id="price_id" class="form-control" v-model="inscription.price_id" @change="pay">
						<option value="">Seleccione una categoría</option>
						<option v-for="p in tournament.prices" :value="p.id">{{ p.name }} - {{ p.price }}€</option>
					</select>
					<small id="price_idHelp" class="form-text text-muted" v-text="msg.price_id"></small>
				</div>
			</div>
			<div class="col-md-8" v-show="inscription.price_id">
				<p>Seleccione el tipo de pago:</p>
				<div class="col-md-6 btn borde" :class="{'btn-black': inscription.type_pay == 1}" @click="changeType(1)">
					Transferencia
				</div>
				<div class="col-md-6 btn borde" :class="{'btn-black': inscription.type_pay == 2}" @click="changeType(2)">
					Paypal<i class="glypicon glypicon-ravelry" aria-hidden="true"></i>
				</div>
				<small id="type_payHelp" class="form-text text-muted" v-text="msg.type_pay"></small>
				<h4>Total a Pagar: <b>{{ inscription.price }} €</b></h4>
				<div class="col-md-12" v-if="inscription.type_pay == 1">
					<p style="font-size: 14px;">Guarde los datos bancarios y haga un deposito dependiendo de la categoria del baile que participará.</p>
					<p style="margin: 0">Banco: <b>Banco Sabadell</b></p>
					<p style="margin: 0">Cuenta: <b>IBAN : ES65 0081 0400 1100 0131 0241</b></p>
					<p style="margin: 0">Titular: <b>Kavarna</b></p>
					<p style="margin: 0">Monto: <b>{{ inscription.price }} €</b></p>
				</div>
			</div>
			<div class="span pull-right" style="padding: 15px"><button type="submit" class="btn-black">Registrar</button></div>
		</form>
		<div class="col-md-8" v-else>
			<div class="alert alert-success">
				<h3 class="text-center">Ya te haz Registrado.</h3>
				<p>Hola {{ data.name }} {{ data.last_name }}, haz sido registrado de forma exitosa en esta competencia.</p>
				<p>
					<b>Estado del pago: </b>
					<span v-if="r.state_pay == 1">Ya fué aprovado su pago...</span>
					<span v-else>En espera de aprovación...</span>
				</p>
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
					<p style="margin: 0">Monto: <b>{{ r.price }} €</b></p>
				</div>
			</div>
		</div>
	</div>
</template>

<style>
.borde {border: 1px solid;}
p {font-size: 1.3em;}
</style>

<script>
	export default {
		name: 'Inscription',
		props: ['id'],
		data() {
			return {
				r: true,
				data: {},
				tournament: {},
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
					price_id: '',
					price: '',
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
			pay: function () {
				let price = this.inscription.price_id;
				for(let p in this.tournament.prices) {
					if (this.tournament.prices[p].id == price) {
						return this.inscription.price = this.tournament.prices[p].price;
					}
				}
			},
			get: function () {
				axios.post('/get-data', {id: this.id})
				.then(response => {
					if (response.data.state) {
						this.r = response.data.state;
					}
					this.tournament = response.data.tournament;
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
			changeType: function (num) {this.inscription.type_pay = num;},
			register: function () {
				toastr.info('Procesando Información, ¡por favor espere!');
				axios.post('/inscription', this.inscription)
				.then(response => {
					if (this.inscription.type_pay == 2) {
						toastr.success('Registro exitoso, espere respuesta de PayPal');
						setTimeout(() => window.location.href = response.data, 1000);
					} else {
						toastr.success('Registro exitoso');
						setTimeout(() => window.location.reload(), 1000);
					}
				});
			}
		}
	}
</script>
