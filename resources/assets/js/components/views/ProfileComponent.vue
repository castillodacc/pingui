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
                        <!-- auto-deleted -->
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
                    <li :class="{'active': show == 4}"><a href="#pareja" @click.prevent="change(4)">Datos Pareja</a></li>
                    <li :class="{'active': show == 5}" v-if="can('inscription.store2')"><a href="#pareja2" @click.prevent="change(5)">Datos Pareja 2</a></li>
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
                                    <select for="category_l" id="category_lat" class="form-control" v-model="user.category_l">
                                        <option value="T1">T1</option>
                                        <option value="T2">T2</option>
                                        <option value="AI">AI</option>
                                        <option value="AN">AN</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="F">F</option>
                                        <option value="No bailo">No bailo</option>
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
                                        <option value="Adulto 1">Adulto 1</option>
                                        <option value="Adulto 2">Adulto 2</option>
                                        <option value="Junior 1">Junior 1</option>
                                        <option value="Junior 2">Junior 2</option>
                                        <option value="JUVENIL 1, con las parejas hasta 9 años">JUVENIL 1, con las parejas hasta 9 años</option>
                                        <option value="JUVENIL 2, con las parejas que cumplen 10 y 11 años a lo largo de 2018">JUVENIL 2, con las parejas que cumplen 10 y 11 años a lo largo de 2018</option>
                                        <option value="Senior 1">Senior 1</option>
                                        <option value="Senior 2">Senior 2</option>
                                        <option value="Senior 3">Senior 3</option>
                                        <option value="Senior 4">Senior 4</option>
                                        <option value="Top Senior">Top Senior</option>
                                        <option value="Youth">Youth</option>
                                    </select>
                                    <small id="group_lHelp" class="form-text"></small>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label for="category_s" class="col-sm-3 control-label">Categoría Standar:</label>
                                <div class="col-sm-9">
                                    <select id="category_s" class="form-control" v-model="user.category_s">
                                        <option value="T1">T1</option>
                                        <option value="T2">T2</option>
                                        <option value="AI">AI</option>
                                        <option value="AN">AN</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="F">F</option>
                                        <option value="Girls std">Girls std</option>
                                        <option value="No_bailo">No_bailo</option>
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
                                        <option value="Adulto 1">Adulto 1</option>
                                        <option value="Adulto 2">Adulto 2</option>
                                        <option value="Junior 1">Junior 1</option>
                                        <option value="Junior 2">Junior 2</option>
                                        <option value="JUVENIL 1, con las parejas hasta 9 años">JUVENIL 1, con las parejas hasta 9 años</option>
                                        <option value="JUVENIL 2, con las parejas que cumplen 10 y 11 años a lo largo de 2018.">JUVENIL 2, con las parejas que cumplen 10 y 11 años a lo largo de 2018.</option>
                                        <option value="Senior 1">Senior 1</option>
                                        <option value="Senior 2">Senior 2</option>
                                        <option value="Senior 3">Senior 3</option>
                                        <option value="Senior 4">Senior 4</option>
                                        <option value="Top Senior">Top Senior</option>
                                        <option value="Youth">Youth</option>
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
                                <label for="birthdate" class="col-sm-3 control-label">Fecha de Nacimiento:</label>
                                <div class="col-sm-9">
                                    <date-picker id="birthdate" v-model="pareja.birthdate" :config="{format: 'DD/MM/YYYY', useCurrent: false, locale: 'es'}"></date-picker>
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
                                <label for="birthdate2" class="col-sm-3 control-label">Fecha de Nacimiento:</label>
                                <div class="col-sm-9">
                                    <date-picker id="birthdate2" v-model="pareja.birthdate2" :config="{format: 'DD/MM/YYYY', useCurrent: false, locale: 'es'}"></date-picker>
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
            pareja: {},
            club: [],
            pareja: {},
            pareja2: {},
            user: {
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
        axios.get('/profile')
        .then(response => {
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
            this.user = response.data.user;
            this.club = response.data.club;
        });
    },
    methods: {
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
                p_name: this.pareja2.p_name2,
                p_last_name: this.pareja2.p_last_name2,
                p_email: this.pareja2.p_email2,
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
            axios.post('/update-user', data)
            .then(response => {
                toastr.success('Datos Actualizados');
                window.location.href = '/perfil/3';
            });
        }
    }
}
</script>
