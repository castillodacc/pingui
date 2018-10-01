<template>
    <div class="row">
        <div class="col-md-3">
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle" :src="user.logoPath" :alt="user.fullName">

                    <h3 class="profile-username text-center" v-text="user.fullName"></h3>

                    <p class="text-muted text-center" v-for="rol in user.roles">{{ rol.name }}<br></p>
                    <p class="text-center">
                        <button type="button" class="btn btn-danger" @click="baja(1)">Darse de Baja</button>
                    </p>
                    <div id="auto_deleted" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-red">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" v-if="!del">Esta seguro de eliminar su cuenta para siempre?</h4>
                                </div>
                                <div class="modal-body">
                                    <p v-if="del">Su pertición fue realizada con éxito...</p>
                                </div>
                                <div class="modal-footer" v-if="!del">
                                    <button type="button" class="btn btn-success" data-dismiss="modal">No</button>
                                    <button type="button" class="btn btn-danger" @click="baja(2)">Si</button>
                                </div>
                                <div class="modal-footer" v-else>
                                    <button type="button" class="btn btn-danger" @click="baja(3)">Continuar</button>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li :class="{'active': show == 1}"><a href="#settings" @click.prevent="change(1)">Configuraciones</a></li>
                    <li :class="{'active': show == 2}"><a href="#changePass" @click.prevent="change(2)">Cambio de Contraseña</a></li>
                    <li :class="{'active': show == 3}"><a href="#bailarin" @click.prevent="change(3)">Datos de Baile</a></li>

                    <li :class="{'active': show == 4}" v-if="!can('inscription.store2')"><a href="#pareja" @click.prevent="change(4)">Datos de Pareja</a></li>
                    <li :class="{'active': show == 4}" v-if="can('inscription.store2')"><a href="#pareja" @click.prevent="change(4)">Datos de bailarín</a></li>
                    <li :class="{'active': show == 5}" v-if="can('inscription.store2')"><a href="#pareja2" @click.prevent="change(5)">Datos de bailarina</a></li>
                </ul>
                <div class="tab-content">
                    <div id="settings" class="tab-pane" :class="{'active': show == 1}">
                        <form class="form-horizontal" enctype="multipart/form-data" @submit.prevent="updateUser">
                            <div class="form-group">
                                <label for="user" class="col-sm-2 control-label">Usuario:</label>
                                <div class="col-sm-10">
                                    <input id="user" type="text" class="form-control" v-model="user.user" disabled="">
                                    <small id="userHelp" class="form-text"></small>
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="name" class="col-sm-2 control-label">Nombres:</label>
                                <div class="col-sm-10">
                                    <input id="name" type="text" class="form-control" placeholder="Nombres" v-model="user.name">
                                    <small id="nameHelp" class="form-text"></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="last_name" class="col-sm-2 control-label">Apellidos:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="last_name" placeholder="Apellidos" v-model="user.last_name">
                                    <small id="last_nameHelp" class="form-text"></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email" class="col-sm-2 control-label">Correo:</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" id="email" placeholder="Correo@dominio.com" v-model="user.email">
                                    <small id="emailHelp" class="form-text"></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="num_id" class="col-sm-2 control-label">D.N.I:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="num_id" placeholder="Cédula" v-model="user.num_id">
                                    <small id="num_idHelp" class="form-text"></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="birthdate" class="col-sm-2 control-label">Fecha de Nacimiento:</label>
                                <div class="col-sm-10">
                                    <date-picker id="birthdate4" v-model="user.birthdate" :config="{format: 'DD/MM/YYYY', useCurrent: false, locale: 'es'}"></date-picker>
                                    <small id="birthdateHelp" class="form-text"></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="sex" class="col-sm-2 control-label">Sexo:</label>
                                <div class="col-sm-10">
                                    <select id="sex" class="form-control" v-model="user.sex">
                                        <option value="">Seleccione el Sexo</option>
                                        <option value="0">Femenino</option>
                                        <option value="1">Masculino</option>
                                    </select>
                                    <small id="sexHelp" class="form-text"></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="phone" class="col-sm-2 control-label">Teléfono:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="phone" placeholder="Teléfono" v-model="user.phone">
                                    <small id="phoneHelp" class="form-text"></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="web" class="col-sm-2 control-label">Web:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="web" placeholder="Web" v-model="user.web">
                                    <small id="webHelp" class="form-text"></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="imagen" class="col-sm-2 control-label">Imagen:</label>
                                <div class="col-sm-10">
                                    <input type="file" id="image" class="form-control" name="image" @change="getImage" accept="image/*">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-success"> Guardar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div id="changePass" class="tab-pane" :class="{'active': show == 2}">
                        <form class="form-horizontal" @submit.prevent="changePass">
                            <div class="form-group">
                                <label for="passwordOld" class="col-sm-3 control-label">Contraseña Actual:</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" id="passwordOld" placeholder="********" v-model="pass.passwordOld">
                                    <small id="passwordOldHelp" class="form-text"></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-sm-3 control-label">Nueva Contraseña:</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" id="password" placeholder="********" v-model="pass.password">
                                    <small id="passwordHelp" class="form-text"></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation" class="col-sm-3 control-label">Confirmar Contraseña:</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" id="password_confirmation" placeholder="********" v-model="pass.password_confirmation">
                                    <small id="password_confirmationHelp" class="form-text"></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <button type="submit" class="btn btn-success"> Guardar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div id="bailarin" class="tab-pane" :class="{'active': show == 3}">
                        <form class="form-horizontal" @submit.prevent="data_baile">
                            <div class="form-group">
                                <label for="club_id" class="col-sm-3 control-label">Club:</label>
                                <div class="col-sm-9">
                                    <select class="form-control" id="club_id" v-model="user.club_id">
                                        <option :value="null">Seleccione el club al que pertenece</option>
                                        <option v-for="c in club" :value="c.id" v-text="c.name"></option>
                                    </select>
                                    <small id="club_idHelp" class="form-text"></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="febd_num" class="col-sm-3 control-label">Número de FEBD:</label>
                                <div class="col-sm-9">
                                    <input type="text" id="febd_num" class="form-control" v-model="user.febd_num">
                                    <small id="febd_numHelp" class="form-text"></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="international_id" class="col-sm-3 control-label">Internacional ID:</label>
                                <div class="col-sm-9">
                                    <input type="text" id="international_id" class="form-control" v-model="user.international_id">
                                    <small id="international_idHelp" class="form-text"></small>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label for="category_l" class="col-sm-3 control-label">Categoría Latino:</label>
                                <div class="col-sm-9">
                                    <select for="category_l" id="category_lat" class="form-control" v-model="user.category_l" @change="charge(1)">
                                        <option :value="c.id" v-for="c in categories_latino" v-text="c.name"></option>
                                    </select>
                                    <small id="category_lHelp" class="form-text"></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="trainer_l" class="col-sm-3 control-label">Entrenador Latino:</label>
                                <div class="col-sm-9">
                                    <input type="text" id="trainer_l" class="form-control" v-model="user.trainer_l">
                                    <small id="trainer_lHelp" class="form-text"></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="group_l" class="col-sm-3 control-label">Grupo Latino:</label>
                                <div class="col-sm-9">
                                    <select id="group_l" class="form-control" v-model="user.group_l">
                                        <option :value="s.id" v-for="s in subcategories_latino" v-text="s.name"></option>
                                    </select>
                                    <small id="group_lHelp" class="form-text"></small>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label for="category_s" class="col-sm-3 control-label">Categoría Standar:</label>
                                <div class="col-sm-9">
                                    <select id="category_s" class="form-control" v-model="user.category_s" @change="charge(2)">
                                        <option :value="c.id" v-for="c in categories_standar" v-text="c.name"></option>
                                    </select>
                                    <small id="category_sHelp" class="form-text"></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="trainer_s" class="col-sm-3 control-label">Entrenador Standar:</label>
                                <div class="col-sm-9">
                                    <input type="text" id="trainer_s" class="form-control" v-model="user.trainer_s">
                                    <small id="trainer_sHelp" class="form-text"></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="group_s" class="col-sm-3 control-label">Grupo Standar:</label>
                                <div class="col-sm-9">
                                    <select id="group_s" class="form-control" v-model="user.group_s">
                                        <option :value="s.id" v-for="s in subcategories_standar" v-text="s.name"></option>
                                    </select>
                                    <small id="group_sHelp" class="form-text"></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <button type="submit" class="btn btn-warning"> Siguiente</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div id="pareja" class="tab-pane" :class="{'active': show == 4}">
                        <form class="form-horizontal" @submit.prevent="pare">
                            <div class="form-group">
                                <label for="p_name" class="col-sm-3 control-label">Nombre:</label>
                                <div class="col-sm-9">
                                    <input type="text" id="p_name" class="form-control" v-model="pareja.p_name">
                                    <small id="p_nameHelp" class="form-text"></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="p_last_name" class="col-sm-3 control-label">Apellido:</label>
                                <div class="col-sm-9">
                                    <input type="text" id="p_last_name" class="form-control" v-model="pareja.p_last_name">
                                    <small id="p_last_nameHelp" class="form-text"></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="sexp" class="col-sm-3 control-label">Sexo:</label>
                                <div class="col-sm-9">
                                    <select id="sexp" class="form-control" v-model="pareja.sex" disabled="can('inscription.store2')">
                                        <option value="">Seleccione el Sexo</option>
                                        <option value="0">Femenino</option>
                                        <option value="1">Masculino</option>
                                    </select>
                                    <small id="sexHelp" class="form-text"></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="birthdate" class="col-sm-3 control-label">Fecha de Nacimiento:</label>
                                <div class="col-sm-9">
                                    <date-picker id="birthdate3" v-model="pareja.birthdate" :config="{format: 'DD/MM/YYYY', useCurrent: false, locale: 'es'}"></date-picker>
                                    <small id="birthdateHelp" class="form-text"></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="p_email" class="col-sm-3 control-label">Email:</label>
                                <div class="col-sm-9">
                                    <input type="text" id="p_email" class="form-control" v-model="pareja.p_email">
                                    <small id="p_emailHelp" class="form-text"></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="p_febd_num" class="col-sm-3 control-label">Número de FEBD:</label>
                                <div class="col-sm-9">
                                    <input type="text" id="p_febd_num" class="form-control" v-model="pareja.p_febd_num">
                                    <small id="p_febd_numHelp" class="form-text"></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <button type="submit" class="btn btn-success" v-if="!can('inscription.store2')"> Guardar</button>
                                    <button type="submit" class="btn btn-warning" v-else> Siguiente</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div id="pareja2" class="tab-pane" :class="{'active': show == 5}" v-if="can('inscription.store2')">
                        <form class="form-horizontal" @submit.prevent="pare2">
                            <div class="form-group">
                                <label for="p_name2" class="col-sm-3 control-label">Nombre:</label>
                                <div class="col-sm-9">
                                    <input type="text" id="p_name2" class="form-control" v-model="pareja2.p_name2">
                                    <small id="p_nameHelp" class="form-text"></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="p_last_name2" class="col-sm-3 control-label">Apellido:</label>
                                <div class="col-sm-9">
                                    <input type="text" id="p_last_name2" class="form-control" v-model="pareja2.p_last_name2">
                                    <small id="p_last_nameHelp" class="form-text"></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="sexp2" class="col-sm-3 control-label">Sexo:</label>
                                <div class="col-sm-9">
                                    <select id="sexp2" class="form-control" v-model="pareja2.sex" disabled="can('inscription.store2')">
                                        <option value="">Seleccione el Sexo</option>
                                        <option value="0">Femenino</option>
                                        <option value="1">Masculino</option>
                                    </select>
                                    <small id="sexHelp" class="form-text"></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="birthdate2" class="col-sm-3 control-label">Fecha de Nacimiento:</label>
                                <div class="col-sm-9">
                                    <date-picker id="birthdate2" v-model="pareja2.birthdate" :config="{format: 'DD/MM/YYYY', useCurrent: false, locale: 'es'}"></date-picker>
                                    <small id="birthdateHelp" class="form-text"></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="p_email2" class="col-sm-3 control-label">Email:</label>
                                <div class="col-sm-9">
                                    <input type="text" id="p_email2" class="form-control" v-model="pareja2.p_email2">
                                    <small id="p_emailHelp" class="form-text"></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="p_febd_num2" class="col-sm-3 control-label">Número de FEBD:</label>
                                <div class="col-sm-9">
                                    <input type="text" id="p_febd_num2" class="form-control" v-model="pareja2.p_febd_num2">
                                    <small id="p_febd_numHelp" class="form-text"></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <button type="submit" class="btn btn-success"> Guardar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
  import DatePicker from 'vue-bootstrap-datetimepicker';
  import 'eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css';

  export default {
    name: 'Profile',
    components: {
        DatePicker
    },
    data() {
        return {
            del: false,
            show: 1,
            club: [],
            categories_latino: [],
            subcategories_latino: [],
            categories_standar: [],
            subcategories_standar: [],
            pareja: {},
            pareja2: {},
            user: {
                sex: '',
                club_id: '',
                fullName: '',
                module: '',
                image: '',
            },
            pass: {
                passwordOld: '',
                password: '',
                password_confirmation: ''
            }
        }
    },
    created() {
        if (this.can('inscription.store2')) {
            if (this.$route.params.num && this.$route.params.num < 6) {
                this.show = this.$route.params.num
            }
        } else {
            if (this.$route.params.num && this.$route.params.num < 5) {
                this.show = this.$route.params.num
            }
        }
        axios.get('/profile?id=' + ((this.$route.params.num2) ? this.$route.params.num2 : ''))
        .then(response => {
            this.categories_latino = response.data.category_latino;
            this.categories_standar = response.data.category_standar;
            this.user = response.data.user;
            this.pass.id = this.user.id;
            this.club = response.data.club;
            this.pareja.sex = '';
            if (this.can('inscription.store2')) {
                this.pareja.sex = 1;
                this.pareja2.sex = 0;
            } else {
                if (response.data.user.sex == 1) {
                    this.pareja.sex = 0;
                } else if (response.data.user.sex == 0) {
                    this.pareja.sex = 1;
                }
            }
            this.pareja2.user_id = this.user.id;
            this.pareja.user_id = this.user.id;
            if (response.data.pareja) {
                this.pareja.p_email = response.data.pareja.email;
                this.pareja.p_febd_num = response.data.pareja.febd_num;
                this.pareja.id = response.data.pareja.id;
                this.pareja.p_last_name = response.data.pareja.last_name;
                this.pareja.p_name = response.data.pareja.name;
            }
            if (response.data.pareja2) {
                this.pareja2.p_email2 = response.data.pareja2.email;
                this.pareja2.p_febd_num2 = response.data.pareja2.febd_num;
                this.pareja2.id = response.data.pareja2.id;
                this.pareja2.p_last_name2 = response.data.pareja2.last_name;
                this.pareja2.p_name2 = response.data.pareja2.name;
            }
            this.charge(1);
            this.charge(2);
        });
    },
    methods: {
        charge(select) {
            let cat = '';
            if (select == 1) {
                cat = this.user.category_l;
            } else {
                cat = this.user.category_s;
            }
            axios.post('/subcategories', {id: select, cat: cat})
            .then(response => {
                if (select == 1) {
                    this.subcategories_latino = response.data.subcategories;
                } else {
                    this.subcategories_standar = response.data.subcategories;
                }
            });
        },
        baja(n) {
            if (n == 1) {
                $('#auto_deleted').modal('show');
            } else if (n == 2) {
                axios.post('/auto-deleted')
                .then(response => {
                    this.del = true;
                });
            } else if (n == 3) {
                window.location.href =  '/';
            }
        },
        getImage(e){
            this.user.image = e.target.files[0];
        },
        change(num) {
            this.show = num;
        },
        changePass() {
            axios.post('/change-pass', this.pass)
            .then(response => {
                this.pass.passwordOld = '';
                this.pass.password = '';
                this.pass.password_confirmation = '';
                toastr.success('Contraseña Actualizada');
            });
        },
        pare() {
            axios.post('/update-pareja', this.pareja)
            .then(response => {
                toastr.success('Datos Actualizados');
                if (this.can('inscription.store2')) {
                    this.show = 5;
                } else {
                    this.show = 1;
                }
            });
        },
        pare2() {
            axios.post('/update-pareja', {
                user_id: this.pareja2.user_id,
                p_name: this.pareja2.p_name2,
                p_last_name: this.pareja2.p_last_name2,
                id: this.pareja2.id,
                p_email: this.pareja2.p_email2,
                sex: this.pareja2.sex,
                p_febd_num: this.pareja2.p_febd_num2,
            })
            .then(response => {
                toastr.success('Datos Actualizados');
                this.show = 1;
            });
        },
        data_baile() {
            let data = {
                club_id: this.user.club_id,
                febd_num: this.user.febd_num,
                category_l: this.user.category_l,
                trainer_l: this.user.trainer_l,
                group_l: this.user.group_l,
                category_s: this.user.category_s,
                trainer_s: this.user.trainer_s,
                group_s: this.user.group_s,
                international_id: this.user.international_id
            };
            axios.post('/update-bailarin/' + this.user.id, data)
            .then(response => {
                toastr.success('Datos Actualizados');
                this.show = 4;
            });
        },
        updateUser() {
            var data = new  FormData();
            data.append('image', this.user.image);
            data.append('name', this.user.name);
            data.append('last_name', this.user.last_name);
            data.append('email', this.user.email);
            data.append('num_id', this.user.num_id);
            data.append('user', this.user.user);
            data.append('phone', this.user.phone);
            data.append('web', this.user.web);
            data.append('sex', this.user.sex);
            data.append('id', this.user.id);
            data.append('birthdate', this.user.birthdate);
            axios.post('/update-user', data)
            .then(response => {
                toastr.success('Datos Actualizados');
                if (this.$route.params.num2) {
                    this.show = 3;
                } else {
                    window.location.href = '/perfil/3';
                }
            });
        }
    }
}
</script>
