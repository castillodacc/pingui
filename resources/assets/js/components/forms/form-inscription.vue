<template>
	<div v-if="can('inscription.store')">
		<form @submit.prevent="register" v-if="r === true">
			<h4>Datos de pareja</h4>
			<div class="col-md-4">
				<div class="form-group">
					<label for="name_1" class="control-label">
						<span class="fa fa-name_1"></span> Pareja 1:
					</label>
					<input id="name_1" type="text" class="form-control" v-model="pareja1" disabled="">
					<small id="name_1Help" class="form-text text-muted" v-text="msg.name_1"></small>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label for="name_2" class="control-label">
						<span class="fa fa-name_2"></span> Pareja 2:
					</label>
					<input id="name_2" type="text" class="form-control" v-model="pareja2" disabled="">
					<small id="name_2Help" class="form-text text-muted" v-text="msg.name_2"></small>
				</div>
			</div>
			<div class="col-md-8">
				<div class="row">
					<h4>Seleccione la modalidad que desea bailar:</h4>
					<div class="col-md-4">
						<p>Standard:</p>
						<div class="form-inline" v-for="p in tournament.prices" 
						v-if="p.category_id == 3 && data.category_s == p.level_id && data.group_s == p.subcategory_id">
							<label :for="p.id">
								<input type="checkbox" :id="p.id" class="" :value="p.id" v-model="prices">
								{{ p.level_text }} - {{ p.subcategory_text }} - {{ p.price }} €
							</label>
						</div>
					</div>
					<div class="col-md-4">
						<p>Latino:</p>
						<div class="form-inline" v-for="p in tournament.prices" v-if="p.category_id == 2 && data.category_l == p.level_id && data.group_l == p.subcategory_id">
							<label :for="p.id">
								<input type="checkbox" :id="p.id" class="" :value="p.id" v-model="prices">
								{{ p.level_text }} - {{ p.subcategory_text }} - {{ p.price }} €
							</label>
						</div>
					</div>
					<div class="col-md-4">
						<p>Open:</p>
						<div class="form-inline" v-for="p in tournament.prices" v-if="p.category_id == 1">
							<label :for="p.id">
								<input type="checkbox" :id="p.id" class="" :value="p.id" v-model="prices">
								{{ p.level_text }} - {{ p.price }} €
							</label>
						</div>
					</div>
				</div>
				<div class="col-md-12" v-show="inscription.price.length">
					<p>Seleccione el tipo de pago:</p>
					<div class="col-md-6 btn borde" :class="{'btn-black': inscription.method_pay == 1}" @click="changeType(1)">
						Transferencia
					</div>
					<div class="col-md-6 btn borde" :class="{'btn-black': inscription.method_pay == 2}" @click="changeType(2)">
						Paypal
					</div>
					<small id="method_payHelp" class="form-text text-muted" v-text="msg.method_pay"></small>
					<h4>Total a Pagar: <b>{{ inscription.pay }} €</b></h4>
					<div class="col-md-12" v-if="inscription.method_pay == 1">
						<p style="font-size: 14px;">Guarde los datos bancarios y haga un deposito dependiendo de la categoria del baile que participará.</p>
						<p style="margin: 0">Banco: <b>Banco Sabadell</b></p>
						<p style="margin: 0">Cuenta: <b>IBAN : ES65 0081 0400 1100 0131 0241</b></p>
						<p style="margin: 0">Titular: <b>Kavarna</b></p>
						<p style="margin: 0">Monto: <b>{{ inscription.pay }} €</b></p>
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="span pull-right" style="padding: 15px">
					<button type="button" class="btn btn-black" @click="open">Registrar</button>
				</div>
			</div>
			<div id="confirm" class="modal fade" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
				<div class="modal-dialog" role="document" style="top: 100px">
					<div class="modal-content">
						<div class="modal-header btn-black">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title">¿Esta Seguro de Registrar su participación en esta competencia?</h4>
						</div>
						<div class="modal-body">
							<p> Pareja: {{ pareja1 }} y {{ pareja2 }}</p>
							<small id="name_1Help" class="form-text text-muted"></small>
							<small id="name_2Help" class="form-text text-muted"></small>
							<p> Categorias: 
								<template v-for="p in prices">
									<span class="label label-info">{{ namePrice(p) }}</span>
									<span> </span>
								</template>
							</p>
							<small id="priceHelp" class="form-text text-muted"></small>
							<p> Método de Pago:
								<span v-if="inscription.method_pay == 1">Transferencia</span>
								<span v-if="inscription.method_pay == 2">PayPal</span>
							</p>
							<small id="method_payHelp" class="form-text text-muted"></small>
							<p> Total a Pagar: {{ inscription.pay }} € </p>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
							<button type="submit" class="btn btn-success">Confirmar</button>
						</div>
					</div>
				</div>
			</div>
		</form>
		<div class="col-md-8" v-else>
			<div class="alert alert-success">
				<h3 class="text-center">Ya te haz Registrado.</h3>
				<p>Hola {{ data.name }} {{ data.last_name }}, Se ha registrado de forma exitosa la inscripción en esta competencia.</p>
				<p>
					<b>Estado del pago: </b>
					<span v-if="r.state_pay == 1">Ya fué aprobado su pago...</span>
					<span v-else>En espera de aprobación...</span>
				</p>
				<p>
					<b>Estado de Participación: </b>
					<span v-if="r.state == 1">Ya fué aprobada su participación en la competencia...</span>
					<span v-else>En espera de aprobación...</span>
				</p>
				<div class="row">
					<div class="col-md-12">
						<template v-for="p in r.prices">
							<span class="label label-info" style="display: inline; font-size: 1em; margin-right: 10px;">
								{{ cate(p.category_id) }} - {{ namePrice(p.id) }}
							</span>
							<wbr></wbr>
						</template>
					</div>
				</div>
				<hr>
				<p><a :href="'/inscritos/' + id" v-if="can('inscription.generate')" class="btn btn-black">Ver Lista de inscritos</a></p>
				<div v-if="r.method_pay == 1 && !r.state">
					<p style="font-size: 14px;">No te olvides de llevar a cabo la forma de pago seleccionada.</p>
					<p style="margin: 0">Banco: <b>Banco Sabadell</b></p>
					<p style="margin: 0">Cuenta: <b>IBAN : ES65 0081 0400 1100 0131 0241</b></p>
					<p style="margin: 0">Titular: <b>Kavarna</b></p>
					<p style="margin: 0">Monto: <b>{{ r.pay }} €</b></p>
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
	import Multiselect from 'vue-multiselect';
	export default {
		name: 'Inscription',
		components: {
			'rs-multiselect': Multiselect,
		},
		props: ['id'],
		data() {
			return {
				// option_prices: [],
				prices: [],
				pareja1: '',
				pareja2: '',
				r: true,
				data: {},
				tournament: {},
				msg: {
					febd_num_1: 'Pareja seleccionada.',
					febd_num_2: 'Pareja seleccionada.',
					method_pay: 'Señale el tipo de pago.',
				},
				inscription: {
					user_id: '',
					tournament_id: '',
					febd_num_1: '',
					last_name_1: '',
					name_1: '',
					febd_num_2: '',
					name_2: '',
					last_name_2: '',
					price: '',
					method_pay: '',
					pay: 0,
				}
			};
		},
		watch: {
			prices: function (val) {
				let price = 0;
				for(let i in val) {
					for(let o in this.tournament.prices) {
						if (this.tournament.prices[o].id == val[i]) {
							price += Number(this.tournament.prices[o].price);
							continue;
						}
					}
				}
				this.inscription.price = val;
				// console.log(Number(price));
				this.inscription.pay = Number(price);
			}
		},
		mounted() {
			this.inscription.tournament_id = this.id;
			setTimeout(() => {this.get();},300);
		},
		methods: {
			namePrice: function (id) {
				for(let o in this.tournament.prices) {
					if (this.tournament.prices[o].id == id) {
						return this.tournament.prices[o].level_text + ((this.tournament.prices[o].subcategory_text) ? ' - ' + this.tournament.prices[o].subcategory_text: '');
					}
				}
			},
			get: function () {
				axios.post('/get-data', {id: this.id})
				.then(response => {
					this.tournament = response.data.tournament;
					this.inscription.user_id = response.data.user.id;
					let price = response.data.tournament.prices;
					this.data = response.data.user;
					if (response.data.state) {
						this.r = response.data.state;
					}
					let pareja = response.data.user.parejas;
					if (pareja[0]) {
						this.pareja2 = ((pareja[0].febd_num) ? pareja[0].febd_num : '') + ' - ' + pareja[0].name + ' ' + pareja[0].last_name;
						this.inscription.febd_num_2 = pareja[0].febd_num;
						this.inscription.last_name_2 = pareja[0].last_name;
						this.inscription.name_2 = pareja[0].name;
					} else { this.msg.febd_num_2 = 'Agrege la pareja en el perfil'}
					if (this.can('inscription.store2')) {
						if (pareja[1]) {
							this.pareja1 = ((pareja[1].febd_num) ? pareja[1].febd_num : '') + ' - ' + pareja[1].name + ' ' + pareja[1].last_name;
							this.inscription.febd_num_1 = pareja[1].febd_num;
							this.inscription.last_name_1 = pareja[1].last_name;
							this.inscription.name_1 = pareja[1].name;
						} else { this.msg.febd_num_1 = 'Agrege la pareja en el perfil'}
					} else {
						this.pareja1 = ((this.data.febd_num) ? this.data.febd_num : '') + ' - ' + this.data.name + ' ' + this.data.last_name;
						this.inscription.febd_num_1 = this.data.febd_num;
						this.inscription.name_1 = this.data.name;
						this.inscription.last_name_1 = this.data.last_name;
					}
				});
			},
			cate: function (n) {
				if (n === 1) {
					return 'Open';
				} else if (n === 2) {
					return 'Latino';
				} else if (n === 3) {
					return 'Standard';
				}
			},
			changeType: function (num) {this.inscription.method_pay = num;},
			open: function () {
				$('#confirm').modal('show');
				setTimeout(function () {
					$('#confirm, body').css({'padding-right': '0px'});
				}, 200);
				$('.modal-backdrop').hide();
			},
			register: function () {
				toastr.info('Procesando Información, ¡por favor espere!');
				axios.post('/inscription', this.inscription)
				.then(response => {
					if (this.inscription.method_pay == 2) {
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
