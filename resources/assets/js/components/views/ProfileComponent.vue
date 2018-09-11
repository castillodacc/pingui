<template>
    <div class="row">
        <div class="col-md-3">
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle" :src="user.logoPath" :alt="user.fullName">

                    <h3 class="profile-username text-center" v-text="user.fullName"></h3>

                    <p class="text-muted text-center" v-for="rol in user.roles">{{ rol.name }}<br></p>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#settings" data-toggle="tab" aria-expanded="true">Configuraciones</a></li>
                    <li><a href="#changePass" data-toggle="tab" aria-expanded="true">Cambio de Contraseña</a></li>
                    <li><a href="#bailarin" data-toggle="tab" aria-expanded="true">Datos de Baile</a></li>
                    <li><a href="#pareja" data-toggle="tab" aria-expanded="true">Datos Pareja</a></li>
                </ul>
                <div class="tab-content">
                    <div id="settings" class="tab-pane active">
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
                    <div id="changePass" class="tab-pane">
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
                    <div id="bailarin" class="tab-pane">
                        <form class="form-horizontal" @submit.prevent="data_baile">
                            <div class="form-group">
                                <label for="club_id" class="col-sm-3 control-label">Club:</label>
                                <div class="col-sm-9">
                                    <select class="form-control" id="club_id" v-model="user.club_id">
                                        <option value="">Seleccione el club al que pertenece</option>
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
                                    <input type="text" id="category_l" class="form-control" v-model="user.category_l">
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
                                    <input type="text" id="group_l" class="form-control" v-model="user.group_l">
                                    <small id="group_lHelp" class="form-text"></small>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label for="category_s" class="col-sm-3 control-label">Categoría Standar:</label>
                                <div class="col-sm-9">
                                    <input type="text" id="category_s" class="form-control" v-model="user.category_s">
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
                                    <input type="text" id="group_s" class="form-control" v-model="user.group_s">
                                    <small id="group_sHelp" class="form-text"></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <button type="submit" class="btn btn-success"> Guardar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div id="pareja" class="tab-pane">
                        <form class="form-horizontal" @submit.prevent="pare">
                            <div class="form-group">
                                <label for="p_name" class="col-sm-3 control-label">Nombre:</label>
                                <div class="col-sm-9">
                                    <input type="text" id="p_name" class="form-control" v-model="pareja.name">
                                    <small id="p_nameHelp" class="form-text"></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="p_last_name" class="col-sm-3 control-label">Apellido:</label>
                                <div class="col-sm-9">
                                    <input type="text" id="p_last_name" class="form-control" v-model="pareja.last_name">
                                    <small id="p_nameHelp" class="form-text"></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="p_febd_num" class="col-sm-3 control-label">Número de FEBD:</label>
                                <div class="col-sm-9">
                                    <input type="text" id="p_febd_num" class="form-control" v-model="pareja.febd_num">
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
    export default {
        data() {
            return {
                club: [],
                pareja: {},
                user: {
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
            axios.get('profile')
            .then(response => {
                this.user = response.data.user;
                this.club = response.data.club;
            });
        },
        methods: {
            getImage(e){
                this.user.image = e.target.files[0];
            },
            changePass() {
                axios.post('change-pass', this.pass)
                .then(response => {
                    this.pass.passwordOld = '';
                    this.pass.password = '';
                    this.pass.password_confirmation = '';
                    toastr.success('Contraseña Actualizada');
                });
            },
            pare() {

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
                    window.location.reload();
                });
            }
        }
    }
</script>
