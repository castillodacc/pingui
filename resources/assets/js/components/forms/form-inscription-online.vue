<template>
	<div class="row">
		<form class="row" @submit.prevent="register" v-if="r == true">
			<div class="col-md-12">
				<h4>Registration Information:</h4>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="email" class="control-label">
						<span class="fa fa-email"></span> E-mail:
					</label>
					<input id="email" type="text" class="form-control" v-model="form.email">
					<small id="emailHelp" class="form-text text-muted" v-text="msg.email"></small>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="phone" class="control-label">
						<span class="fa fa-phone"></span> Telephone (Preferably with whatsapp):
					</label>
					<input id="phone" type="text" class="form-control" v-model="form.phone">
					<small id="phoneHelp" class="form-text text-muted" v-text="msg.phone"></small>
				</div>
			</div>
			<div class="col-md-6" style="height: 76px">
				<div class="form-group">
					<label for="category_id" class="control-label">
						<span class="fa fa-category_id"></span> Category:
					</label>
					<label class="form-inline col-xs-6">
						<input type="radio" id="category_id" value="1" v-model="form.category_id">
						Single
					</label>
					<label class="form-inline col-xs-6">
						<input type="radio" id="category_id" value="2" v-model="form.category_id">
						Couple
					</label>
					<small id="category_idHelp" class="form-text text-muted" v-text="msg.category_id"></small>
				</div>
			</div>
			<div class="col-md-6" v-show="form.category_id == 1" style="height: 76px">
				<div class="form-group">
					<label for="sex_id" class="control-label">
						<span class="fa fa-sex_id"></span> Sex:
					</label>
					<label class="form-inline col-xs-6">
						<input type="radio" id="sex_id" value="1" v-model="form.sex_id">
						Hombre
					</label>
					<label class="form-inline col-xs-6">
						<input type="radio" id="sex_id" value="2" v-model="form.sex_id">
						Dama
					</label>
					<small id="sex_idHelp" class="form-text text-muted" v-text="msg.sex_id"></small>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="name" class="control-label">
						<span class="fa fa-name"></span> Name:
					</label>
					<input id="name" type="text" class="form-control"  v-model="form.name">
					<small id="nameHelp" class="form-text text-muted" v-text="msg.name"></small>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="last_name" class="control-label">
						<span class="fa fa-last_name"></span> Last Name:
					</label>
					<input id="last_name" type="text" class="form-control"  v-model="form.last_name">
					<small id="last_nameHelp" class="form-text text-muted" v-text="msg.last_name"></small>
				</div>
			</div>
			<!-- <div class="col-md-6" v-if="form.category_id == 2">
				<div class="form-group">
					<label for="name_couple" class="control-label">
						<span class="fa fa-name_couple"></span> Name couple:
					</label>
					<input id="name_couple" type="text" class="form-control" v-model="form.name_couple">
					<small id="name_coupleHelp" class="form-text text-muted" v-text="msg.name_couple"></small>
				</div>
			</div>
			<div class="col-md-6" v-if="form.category_id == 2">
				<div class="form-group">
					<label for="last_name_couple" class="control-label">
						<span class="fa fa-last_name_couple"></span> Last naeme couple:
					</label>
					<input id="last_name_couple" type="text" class="form-control" v-model="form.last_name_couple">
					<small id="last_name_coupleHelp" class="form-text text-muted" v-text="msg.last_name_couple"></small>
				</div>
			</div> -->
			<div class="col-md-6">
              <div class="form-group">
                <label for="birthdate" class="control-label">
                  <span class="edit"></span> Birthdate:
                </label>
                <date-picker id="birthdate"
                :config="config"
                v-model="form.birthdate"/>
                <small id="birthdateHelp"
                class="form-text text-muted"
                v-text="msg.birthdate"></small>
              </div>
            </div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="club" class="control-label">
						<span class="fa fa-club"></span> Club:
					</label>
					<input id="club" type="text" class="form-control" v-model="form.club">
					<small id="clubHelp" class="form-text text-muted" v-text="msg.club"></small>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="coach" class="control-label">
						<span class="fa fa-coach"></span> Coach:
					</label>
					<input id="coach" type="text" class="form-control" v-model="form.coach">
					<small id="coachHelp" class="form-text text-muted" v-text="msg.coach"></small>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="country" class="control-label">
						<span class="fa fa-country"></span> Country:
					</label>
					<input id="country" type="text" class="form-control" v-model="form.country">
					<small id="countryHelp" class="form-text text-muted" v-text="msg.country"></small>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="age_group" class="control-label">
						<span class="fa fa-age_group"></span> Age Group (You can join more than one):
					</label>
					<label :for="'age_group'+i" class="form-inline col-xs-6" v-for="(a, i) in age_groups">
						<input type="checkbox" :id="'age_group'+i" :value="i" v-model="form.age_group">
						{{ a }}
					</label>
					<small id="age_groupHelp" class="form-text text-muted" v-text="msg.age_group"></small>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="dance" class="control-label">
						<span class="fa fa-dance"></span> Dance:
					</label>
					<label :for="'dance'+i" class="form-inline col-xs-6" v-for="(a, i) in dances">
						<input type="checkbox" :id="'dance'+i" :value="i" v-model="form.dance">
						{{ a }}
					</label>
					<small id="danceHelp" class="form-text text-muted" v-text="msg.dance"></small>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<!-- <div class="row">
						<h4>Seleccione la modalidad que desea bailar:</h4>
						<div class="col-md-4">
							<p>Standard:</p>
							<div class="form-inline"
							v-if="p.category_id == 3"
							v-for="(p, i) in tournament.prices">
								<label :for="p.id">
									<input type="checkbox"
									:id="p.id"
									:value="p"
									v-model="prices">
									{{ p.level_text }} - 
									{{ p.subcategory_text }} - 
									{{ p.price }} €
								</label>
							</div>
						</div>
						<div class="col-md-4">
							<p>Latino:</p>
							<div class="form-inline"
							v-for="(p, i) in tournament.prices"
							v-if="p.category_id == 2">
								<label :for="p.id">
									<input type="checkbox"
									:id="p.id"
									:value="p"
									v-model="prices">
									{{ p.level_text }} - 
									{{ p.subcategory_text }} - 
									{{ p.price }} €
								</label>
							</div>
						</div>
						<div class="col-md-4">
							<p>Open:</p>
							<div class="form-inline"
							v-for="(p, i) in tournament.prices"
							v-if="p.category_id == 1">
								<label :for="p.id">
									<input type="checkbox"
									:id="p.id"
									:value="p"
									v-model="prices">
									{{ p.level_text }} - {{ p.price }} €
								</label>
							</div>
						</div>
					</div> -->
					<div class="row">
						<div class="col-md-12">
							<h4>Total to pay: <b>{{ pay }} €</b></h4>
						</div>
					</div>
					<div class="col-md-12">
						<p>Select type of payment:</p>
						<div class="col-md-12">
							<div class="col-md-4 btn borde"
							:class="{'btn-black': form.method_pay == 1}"
							@click="form.method_pay = 1"
							v-if="tournament.organizer.headline && tournament.organizer.account && tournament.organizer.bank">
								Transfor
							</div>
							<div class="col-md-4 btn borde"
							:class="{'btn-black': form.method_pay == 2}"
							@click="form.method_pay = 2"
							v-if="tournament.organizer.paypal_client_id && tournament.organizer.paypal_client_secret">
								Paypal
							</div>
							<div class="col-md-4 btn borde"
							:class="{'btn-black': form.method_pay == 3}"
							@click="form.method_pay = 3"
							v-if="tournament.organizer.t_publishable_key && tournament.organizer.t_secret_key">
								Card
							</div>
						</div>
						<small id="method_payHelp" class="form-text text-muted" v-text="msg.method_pay"></small>
						<div class="col-md-12" v-if="form.method_pay == 1">
							<p style="font-size: 14px;">Save bank details and deposit agreed amount.</p>
							<p style="margin: 0">Bank: <b>{{ tournament.organizer.bank }}</b></p>
							<p style="margin: 0">Account: <b>{{ tournament.organizer.account }}</b></p>
							<p style="margin: 0">Headline: <b>{{ tournament.organizer.headline }}</b></p>
							<p style="margin: 0">Total: <b>{{ form.pay }} €</b></p>
						</div>
						<div id="payment-form"
						class="form-row"
						v-show="form.method_pay == 3 && (tournament.organizer.t_publishable_key && tournament.organizer.t_secret_key)">
							<div class="form-row">
								<label for="card-element">
									debit and credit card
								</label>
								<div id="card-element"></div>
								<div id="card-errors" role="alert"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="span pull-right" style="padding: 15px">
					<button type="button" class="btn btn-black" @click="open">Register</button>
				</div>
			</div>
			<div id="confirm" class="modal fade" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
				<div class="modal-dialog" role="document" style="top: 100px">
					<div class="modal-content">
						<div class="modal-header btn-black">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title">Are you sure to register your participation in this competition?</h4>
						</div>
						<div class="modal-body">
							<p>
								Member: {{ form.name }} {{ form.last_name }}
								<!-- <template v-if="form.category_id == 1"> -->
									<!-- Integrante: {{ form.name }} -->
								<!-- </template> -->
								<!-- <template v-else-if="form.category_id == 2"> -->
									<!-- Integrantes: {{ form.name }} y {{ form.name_couple }} -->
								<!-- </template> -->
							</p>
							<small id="nameHelp" class="form-text text-muted"></small>
							<small id="name_coupleHelp" class="form-text text-muted"></small>
							<!-- <p>
								Categorias: 
								<span class="label label-info" v-for="p in prices" style="margin: 3px">
									{{ p.level_text }}
									<template v-if="p.subcategory_text">
										- {{ p.subcategory_text }}
									</template>
								</span>
							</p> -->
							<small id="priceHelp" class="form-text text-muted"></small>
							<p>
								Payment method:
								<span v-if="form.method_pay == 1">Transferencia</span>
								<span v-if="form.method_pay == 2">PayPal</span>
								<span v-if="form.method_pay == 3">Tarjeta</span>
							</p>
							<small id="method_payHelp" class="form-text text-muted"></small>
							<p> Total to pay: {{ form.pay }} € </p>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
							<button type="submit" class="btn btn-success">Confirm</button>
						</div>
					</div>
				</div>
			</div>
		</form>
		<div class="col-md-12" v-if="r == false">
			<div class="alert alert-success">
				<h3 class="text-center" style="margin: 0">Your registration to the competition has been successfully completed.</h3>
				<p>Hello {{ data.name_1 }} {{ data.last_name_1 }}, You have successfully entered the competition.</p>
				<p>
					<b>Payment status: </b>
					<span v-if="data.state_pay == 1">Your payment has already been approved...</span>
					<span v-else>Awaiting approval...</span>
				</p>
				<p>
					<b>Participation Status: </b>
					<span v-if="data.state == 1">Your participation in the competition has already been approved...</span>
					<span v-else>Awaiting approval...</span>
				</p>
				<div class="row">
					<div class="col-md-12">
						<template v-for="d in data.dance">
							<span class="label label-info" style="display: inline; font-size: 1em; margin-right: 10px;">
								{{ dances[d] }}
							</span>
							<wbr></wbr>
						</template>
					</div>
				</div>
				<hr>
				<p>
					<a :href="'/lista/' + tournament.slug" class="btn btn-black">Registered List</a>
					<a href="/clean/" class="btn btn-danger">Close Message</a>
				</p>
				<div v-if="data.method_pay == 1 && !data.state">
					<p style="font-size: 14px;">Do not forget to carry out the selected payment method.</p>
					<p style="margin: 0">Bank: <b>{{ tournament.organizer.bank }}</b></p>
					<p style="margin: 0">Account: <b>{{ tournament.organizer.account }}</b></p>
					<p style="margin: 0">Owner: <b>{{ tournament.organizer.headline }}</b></p>
					<p style="margin: 0">Total: <b>{{ data.pay }} €</b></p>
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
	import DatePicker from 'vue-bootstrap-datetimepicker';
	import 'eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css';
	export default {
		name: 'inscription-online',
		components: { DatePicker },
		props: ['id'],
		data() {
			return {
				age_groups: [
				'JUVENIL 13 years old',
				'Under 16',
				'Under 21',
				'Under 35',
				'Over 35',
				],
				dances: [
				'Cha cha cha',
				'English Walts',
				'Jive',
				'Paso doble',
				'Quickstep',
				'Rumba',
				'Samba',
				'Slow Foxtrot',
				'Tango',
				'Viennese Waltz',
				],
				stripe_objec: {},
				card: {},
				prices: [],
		// 		t: {},
				config: {
					format: 'DD/MM/YYYY',
					useCurrent: true,
					showClear: true,
					showClose: true
				},
				r: null,
				// data: {},
				form: {
// email: 'rennyarmando@gmail.com',
// phone: '04147264958',
// category_id: 1,
// sex_id: 1,
// name: 'Renny',
// last_name: 'Suarez',
// name_couple: 'Renny2',
// last_name_couple: 'Suarez2',
// birthdate: '05/05/2020',
// club: 'club',
// coach: 'entrenador',
// country: 'pais',
					pay: 0,
					method_pay: 0,
					// name: '',
					// name_couple: '',
					age_group: [],
					dance: [],
					price: [],
				},
				tournament: {
					organizer: {}
				},
				msg: {
					// email: 'Email asociado.',
					// phone: 'Telefono de contacto.',
					// category_id: 'Categoria a competir.',
					// sex_id: 'Genero del participante.',
					// name: 'Nombre del participante.',
					// last_name: 'Apellido del participante.',
					// name_couple: 'Nombre de la pareja.',
					// last_name_couple: 'Apellido de la pareja.',
					// birthdate: 'Fecha de Nacimiento.',
					// club: 'Club del participante.',
					// coach: 'Entrenador de baila.',
					// country: 'Pais donde reside.',
				},
		// 		inscription: {
		// 			user_id: '',
		// 			tournament_id: '',
		// 			febd_num_1: '',
		// 			last_name_1: '',
		// 			name_1: '',
		// 			febd_num_2: '',
		// 			name_2: '',
		// 			last_name_2: '',
		// 			price: '',
		// 			method_pay: '',
		// 			pay: 0,
		// 		}
			};
		},
		computed: {
			pay: function () {
				let pay = 0;
				if (this.form.category_id == 1) {
					pay = 5
				} else if (this.form.category_id == 2) {
					pay = 10
				}
				if (this.form.age_group.length == 1) {
					if (this.form.age_group.indexOf(0) != -1) {
						pay = 3
					}
				}
				return this.form.pay = this.form.dance.length * pay
			}
		},
		// watch: {
		// 	prices: function (prices) {
		// 		let price = 0, add_pay = 0, ids = []
		// 		for(let p of prices) {
		// 			ids.push(p.id)
		// 			if (p.category_id == 1) {
		// 				price += Number(p.price);
		// 			}
		// 			if ((p.category_id == 2 || p.category_id == 3) && add_pay == 0) {
		// 				price += Number(p.price);
		// 				add_pay++;
		// 			}
		// 		}
		// 		this.form.price = ids;
		// 		this.form.pay = Number(price);
		// 	},
		// },
		mounted() {
			axios.post('/get-data', { id: this.id })
			.then(response => {
				let user = response.data.user
				let organizer = response.data.tournament.organizer

				this.data = response.data.state
				this.form.tournament_id = this.id
				this.r = ! response.data.state.id
				this.tournament = response.data.tournament

				if (organizer.t_publishable_key && organizer.t_secret_key) {
					this.stripe(organizer.t_publishable_key);
				}
				if (user) {
					this.form.email = user.email
					this.form.phone = user.phone
					this.form.name = user.name + ' ' + user.last_name
					this.form.birthdate = user.birthdate
				}
		// 				this.inscription.user_id = response.data.user.id;
		// 				this.t = response.data.state;
		// 				let pareja = response.data.user.parejas;
		// 				if (this.can('inscription.store2')) {
		// 					if (pareja[0]) {
		// 						this.pareja1 = ((pareja[0].febd_num) ? pareja[0].febd_num : '') + ' - ' + pareja[0].name + ' ' + pareja[0].last_name;
		// 						this.inscription.febd_num_1 = pareja[0].febd_num;
		// 						this.inscription.last_name_1 = pareja[0].last_name;
		// 						this.inscription.name_1 = pareja[0].name;
		// 					} else { this.msg.febd_num_1 = 'Agrege la pareja en el perfil'}
		// 					if (pareja[1]) {
		// 						this.pareja2 = ((pareja[1].febd_num) ? pareja[1].febd_num : '') + ' - ' + pareja[1].name + ' ' + pareja[1].last_name;
		// 						this.inscription.febd_num_2 = pareja[1].febd_num;
		// 						this.inscription.last_name_2 = pareja[1].last_name;
		// 						this.inscription.name_2 = pareja[1].name;
		// 					} else { this.msg.febd_num_2 = 'Agrege la pareja en el perfil'}
		// 				} else {
		// 					if (this.data.sex == 0) {
								// this.pareja2 = ((this.data.febd_num) ? this.data.febd_num : '') + ' - ' + this.data.name + ' ' + this.data.last_name;
		// 						this.inscription.febd_num_2 = this.data.febd_num;
								// this.inscription.name_2 = this.data.name;
		// 						this.inscription.last_name_2 = this.data.last_name;
		// 						if (pareja[0]) {
		// 							this.pareja1 = ((pareja[0].febd_num) ? pareja[0].febd_num : '') + ' - ' + pareja[0].name + ' ' + pareja[0].last_name;
		// 							this.inscription.febd_num_1 = pareja[0].febd_num;
		// 							this.inscription.last_name_1 = pareja[0].last_name;
		// 							this.inscription.name_1 = pareja[0].name;
		// 						} else { this.msg.febd_num_1 = 'Agrege la pareja en el perfil'}
		// 					} else {
		// 						this.pareja1 = ((this.data.febd_num) ? this.data.febd_num : '') + ' - ' + this.data.name + ' ' + this.data.last_name;
		// 						this.inscription.febd_num_1 = this.data.febd_num;
		// 						this.inscription.name_1 = this.data.name;
		// 						this.inscription.last_name_1 = this.data.last_name;
		// 						if (pareja[0]) {
		// 							this.pareja2 = ((pareja[0].febd_num) ? pareja[0].febd_num : '') + ' - ' + pareja[0].name + ' ' + pareja[0].last_name;
		// 							this.inscription.febd_num_2 = pareja[0].febd_num;
		// 							this.inscription.last_name_2 = pareja[0].last_name;
		// 							this.inscription.name_2 = pareja[0].name;
		// 						} else { this.msg.febd_num_2 = 'Agrege la pareja en el perfil'}
		// 					}
		// 				}
		// 			}
				});
		},
		methods: {
			namePrice: function (id) {
				for(let o in this.tournament.prices) {
					if (this.tournament.prices[o].id == id) {
						return this.tournament.prices[o].level_text + ((this.tournament.prices[o].subcategory_text) ? ' - ' + this.tournament.prices[o].subcategory_text : '');
					}
				}
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
			open: function () {
				$('#confirm').modal('show');
				setTimeout(function () {$('#confirm, body').css({'padding-right': '0px'});}, 100);
				$('.modal-backdrop').hide();
			},
			register: function (event) {
				if (this.form.method_pay == 3) {
					this.stripe_objec.createToken(this.card).then((result) => {
						if (result.error) {
							// Inform the user if there was an error.
							var errorElement = document.getElementById('card-errors');
							errorElement.textContent = result.error.message;
							toastr.info('Error En la conexión');
						} else {
							// Send the token to your server.
							this.form.stripeToken = result.token.id;
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
				axios.post('/inscription-online', this.form)
				.then(response => {
					if (this.form.method_pay == 2) {
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
				setTimeout(() => {
					card.mount('#card-element');
				}, 1000);

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