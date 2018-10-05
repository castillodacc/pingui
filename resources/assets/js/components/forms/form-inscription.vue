<template>
	<div class="col-md-8" v-if="can('inscription.store')">
		<form @submit.prevent="register" v-if="r === true">
			<h4>Datos de pareja</h4>
			<div class="col-md-6">
				<div class="form-group">
					<label for="name_1" class="control-label">
						<span class="fa fa-name_1"></span> Bailarín:
					</label>
					<input id="name_1" type="text" class="form-control" v-model="pareja1" disabled="">
					<small id="name_1Help" class="form-text text-muted" v-text="msg.name_1"></small>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="name_2" class="control-label">
						<span class="fa fa-name_2"></span> Bailarina:
					</label>
					<input id="name_2" type="text" class="form-control" v-model="pareja2" disabled="">
					<small id="name_2Help" class="form-text text-muted" v-text="msg.name_2"></small>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="row">
						<h4>Seleccione la modalidad que desea bailar:</h4>
						<div class="col-md-4">
							<p>Standard:</p>
							<div class="form-inline" v-for="p in tournament.prices" v-if="p.category_id == 3 && data.category_s == p.level_id && data.group_s == p.subcategory_id">
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
						<h4>Total a Pagar: <b>{{ inscription.pay }} €</b></h4>
					</div>
					<div class="col-md-12" v-show="inscription.price.length">
						<p>Seleccione el tipo de pago:</p>
						<div class="col-md-12">
							<div class="col-md-4 btn borde" :class="{'btn-black': inscription.method_pay == 1}" @click="changeType(1)" v-if="tournament.organizer && (tournament.organizer.headline && tournament.organizer.account && tournament.organizer.bank)">
								Transferencia
							</div>
							<div class="col-md-4 btn borde" :class="{'btn-black': inscription.method_pay == 2}" @click="changeType(2)" v-if="tournament.organizer.paypal_client_id && tournament.organizer.paypal_client_secret">
								Paypal
							</div>
							<div class="col-md-4 btn borde" :class="{'btn-black': inscription.method_pay == 3}" @click="changeType(3)" v-if="tournament.organizer.t_publishable_key && tournament.organizer.t_secret_key">
								Tarjeta
							</div>
						</div>
						<small id="method_payHelp" class="form-text text-muted" v-text="msg.method_pay"></small>
						<div class="col-md-12" v-if="inscription.method_pay == 1 && (tournament.organizer.bank && tournament.organizer.headline && tournament.organizer.account)">
							<p style="font-size: 14px;">Guarde los datos bancarios y deposite la cantidad acordada.</p>
							<p style="margin: 0">Banco: <b>{{ tournament.organizer.bank }}</b></p>
							<p style="margin: 0">Cuenta: <b>{{ tournament.organizer.account }}</b></p>
							<p style="margin: 0">Titular: <b>{{ tournament.organizer.headline }}</b></p>
							<p style="margin: 0">Total: <b>{{ inscription.pay }} €</b></p>
						</div>
						<div id="payment-form" class="form-row" v-show="inscription.method_pay == 3 && (tournament.organizer.t_publishable_key && tournament.organizer.t_secret_key)">
							<div class="form-row">
								<label for="card-element">
									Tarjeta de Débito y Crédito
								</label>
								<div id="card-element">
									<!-- A Stripe Element will be inserted here. -->
								</div>
								<!-- Used to display form errors. -->
								<div id="card-errors" role="alert"></div>
							</div>
						</div>
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
							<h4 class="modal-title">¿Esta Seguro de Registrar su participación en esta competición?</h4>
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
								<span v-if="inscription.method_pay == 3">Tarjeta</span>
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
		<div class="col-md-12" v-else>
			<div class="alert alert-success">
				<h3 class="text-center">Tu registro a la competición se ha finalizado correctamente..</h3>
				<p>Hola {{ data.name }} {{ data.last_name }}, Se ha registrado correctamente en la competición.</p>
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
				<p><a :href="'/lista/' + tournament.slug" v-if="can('inscription.index')" class="btn btn-black">Ver Lista de inscritos</a></p>
				<div v-if="r.method_pay == 1 && !r.state">
					<p style="font-size: 14px;">No te olvides de llevar a cabo la forma de pago seleccionada.</p>
					<p style="margin: 0">Banco: <b>{{ tournament.organizer.bank }}</b></p>
					<p style="margin: 0">Cuenta: <b>{{ tournament.organizer.account }}</b></p>
					<p style="margin: 0">Titular: <b>{{ tournament.organizer.headline }}</b></p>
					<p style="margin: 0">Total: <b>{{ r.pay }} €</b></p>
				</div>
			</div>
		</div>
	</div>
</template>

<style>
.borde {border: 1px solid;}
p {font-size: 1.3em;}
.StripeElement {
	background-color: white;
	height: 40px;
	padding: 10px 12px;
	border-radius: 4px;
	border: 1px solid transparent;
	box-shadow: 0 1px 3px 0 #e6ebf1;
	-webkit-transition: box-shadow 150ms ease;
	transition: box-shadow 150ms ease;
}
.StripeElement--focus {box-shadow: 0 1px 3px 0 #cfd7df;}
.StripeElement--invalid {border-color: #fa755a;}
.StripeElement--webkit-autofill {background-color: #fefde5 !important;}
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
				stripe_objec: {},
				card: {},
				prices: [],
				pareja1: '',
				pareja2: '',
				r: true,
				data: {},
				tournament: {
					organizer: {}
				},
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
				let price = 0, test = 0;
				for(let i in val) {
					for(let o in this.tournament.prices) {
						if (this.tournament.prices[o].id == val[i]) {
							if (this.tournament.prices[o].category_id == 1) {
								price += Number(this.tournament.prices[o].price);
							}
							if ((this.tournament.prices[o].category_id == 2 || this.tournament.prices[o].category_id == 3) && test == 0) {
								price += Number(this.tournament.prices[o].price);
								test++;
							}
							continue;
						}
					}
				}
				this.inscription.price = val;
				this.inscription.pay = Number(price);
			}
		},
		mounted() {
			setTimeout(() => {
				this.inscription.tournament_id = this.id;
				this.get();
			}, 300);
		},
		methods: {
			namePrice: function (id) {
				for(let o in this.tournament.prices) {
					if (this.tournament.prices[o].id == id) {
						return this.tournament.prices[o].level_text + ((this.tournament.prices[o].subcategory_text) ? ' - ' + this.tournament.prices[o].subcategory_text : '');
					}
				}
			},
			get: function () {
				axios.post('/get-data', {id: this.id})
				.then(response => {
					if(this.can('inscription.store')) {
						this.tournament = response.data.tournament;
						this.inscription.user_id = response.data.user.id;
						let price = response.data.tournament.prices;
						this.data = response.data.user;
						if (response.data.state) {
							this.r = response.data.state;
						}
						let pareja = response.data.user.parejas;
						if (this.can('inscription.store2')) {
							if (pareja[0]) {
								this.pareja1 = ((pareja[0].febd_num) ? pareja[0].febd_num : '') + ' - ' + pareja[0].name + ' ' + pareja[0].last_name;
								this.inscription.febd_num_1 = pareja[0].febd_num;
								this.inscription.last_name_1 = pareja[0].last_name;
								this.inscription.name_1 = pareja[0].name;
							} else { this.msg.febd_num_1 = 'Agrege la pareja en el perfil'}
							if (pareja[1]) {
								this.pareja2 = ((pareja[1].febd_num) ? pareja[1].febd_num : '') + ' - ' + pareja[1].name + ' ' + pareja[1].last_name;
								this.inscription.febd_num_2 = pareja[1].febd_num;
								this.inscription.last_name_2 = pareja[1].last_name;
								this.inscription.name_2 = pareja[1].name;
							} else { this.msg.febd_num_2 = 'Agrege la pareja en el perfil'}
						} else {
							if (this.data.sex == 0) {
								this.pareja2 = ((this.data.febd_num) ? this.data.febd_num : '') + ' - ' + this.data.name + ' ' + this.data.last_name;
								this.inscription.febd_num_2 = this.data.febd_num;
								this.inscription.name_2 = this.data.name;
								this.inscription.last_name_2 = this.data.last_name;
								if (pareja[0]) {
									this.pareja1 = ((pareja[0].febd_num) ? pareja[0].febd_num : '') + ' - ' + pareja[0].name + ' ' + pareja[0].last_name;
									this.inscription.febd_num_1 = pareja[0].febd_num;
									this.inscription.last_name_1 = pareja[0].last_name;
									this.inscription.name_1 = pareja[0].name;
								} else { this.msg.febd_num_1 = 'Agrege la pareja en el perfil'}
							} else {
								this.pareja1 = ((this.data.febd_num) ? this.data.febd_num : '') + ' - ' + this.data.name + ' ' + this.data.last_name;
								this.inscription.febd_num_1 = this.data.febd_num;
								this.inscription.name_1 = this.data.name;
								this.inscription.last_name_1 = this.data.last_name;
								if (pareja[0]) {
									this.pareja2 = ((pareja[0].febd_num) ? pareja[0].febd_num : '') + ' - ' + pareja[0].name + ' ' + pareja[0].last_name;
									this.inscription.febd_num_2 = pareja[0].febd_num;
									this.inscription.last_name_2 = pareja[0].last_name;
									this.inscription.name_2 = pareja[0].name;
								} else { this.msg.febd_num_2 = 'Agrege la pareja en el perfil'}
							}
						}
						if (this.tournament.organizer.t_publishable_key && this.tournament.organizer.t_secret_key) {
							this.stripe(this.tournament.organizer.t_publishable_key);
						}
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
				setTimeout(function () {$('#confirm, body').css({'padding-right': '0px'});}, 100);
				$('.modal-backdrop').hide();
			},
			register: function (event) {
				if (this.inscription.method_pay == 3) {
					this.stripe_objec.createToken(this.card).then((result) => {
						if (result.error) {
							// Inform the user if there was an error.
							var errorElement = document.getElementById('card-errors');
							errorElement.textContent = result.error.message;
							toastr.info('Error En la conexión');
						} else {
							// Send the token to your server.
							this.inscription.stripeToken = result.token.id;
							// this.stripeTokenHandler(result.token);
							this.send();
						}
					});
				} else {
					this.send();
				}
			},
			send: function () {
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
			},
			stripe: function (public_key) {
				// Create a Stripe client.
				this.stripe_objec = Stripe(public_key);
				// Create an instance of Elements.
				var elements = this.stripe_objec.elements();
				// Custom styling can be passed to options when creating an Element.
				// (Note that this demo uses a wider set of styles than the guide below.)
				var style = {
					base: {
						color: '#32325d',
						lineHeight: '18px',
						fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
						fontSmoothing: 'antialiased',
						fontSize: '16px',
						'::placeholder': {
							color: '#aab7c4'
						}
					},
					invalid: {
						color: '#fa755a',
						iconColor: '#fa755a'
					}
				};
				// Create an instance of the card Element.
				var card = elements.create('card', {style: style});

				// Add an instance of the card Element into the `card-element` <div>.
				card.mount('#card-element');

				// Handle real-time validation errors from the card Element.
				card.addEventListener('change', function(event) {
					var displayError = document.getElementById('card-errors');
					if (event.error) {
						displayError.textContent = event.error.message;
					} else {
						displayError.textContent = '';
					}
				});
				this.card = card;
			}
		}
	}
</script>
