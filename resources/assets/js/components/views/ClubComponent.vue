<template>
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Tabla de Clubes:</h3>
            <button type="button"
            class="btn btn-default btn-xs"
            data-tooltip="tooltip"
            title="Registrar Club"
            @click="openform('plus')"
            v-if="can('club.store')"><span class="glyphicon glyphicon-plus"></span></button>
        </div>
        <div class="box-body">
            <div id="form-clubes" class="col-md-8 col-md-offset-2" v-if="can(['club.store', 'club.update'])"">
                <div class="row" v-show="form.ready">
                    <h4 v-text="form.title"></h4>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="name" class="control-label">
                                <span class="fa fa-name"></span> Nombre:
                            </label>
                            <input id="name" type="text" class="form-control" v-model="form.data.name">
                            <small id="nameHelp" class="form-text text-muted">
                                <span v-text="msg.name"></span>
                            </small>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label for="province" class="control-label">
                                <span class="fa fa-province"></span> Provincia:
                            </label>
                            <input id="province" type="text" class="form-control" v-model="form.data.province">
                            <small id="provinceHelp" class="form-text text-muted">
                                <span v-text="msg.province"></span>
                            </small>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label for="population" class="control-label">
                                <span class="fa fa-population"></span> Población:
                            </label>
                            <input id="population" type="text" class="form-control" v-model="form.data.population">
                            <small id="populationHelp" class="form-text text-muted">
                                <span v-text="msg.population"></span>
                            </small>
                        </div>
                    </div>
                    <div class="col-sm-2 text-center" style="padding-top: 32px;">
                        <button class="btn btn-success btn-xs" 
                        title="Registrar Club" 
                        data-tooltip="tooltip"
                        v-if="form.cond == 'plus'"
                        @click="register"
                        ><span class="fa fa-plus"></span></button>
                        <button class="btn btn-info btn-xs" 
                        title="Editar Club" 
                        data-tooltip="tooltip"
                        v-if="form.cond == 'edit'"
                        @click="register"
                        ><span class="fa fa-edit"></span></button>
                        <button class="btn btn-danger btn-xs" 
                        title="Cancelar" 
                        data-tooltip="tooltip"
                        @click="openform"
                        ><span class="fa fa-close"></span></button>
                    </div>
                </div>
            </div>
            <rs-table id="clubes" :tabla="tabla" uri="/clubs"></rs-table>
        </div>
    </div>
</template>

<script>
    import Tabla from './../partials/table.vue';

    export default {
        name: 'Clubs',
        components: {
            'rs-table': Tabla,
        },
        data() {
            return {
                form: {
                    ready: false,
                    data:  {}
                },
                msg: {
                    name: 'Nombre del Club.',
                    population: 'Población donde se encuentra.',
                    province: 'Provincia donde se encuentra.'
                },
                tabla: {
                    columns: [
                    { title: 'Nombre', field: 'name', sortable: true },
                    { title: 'Provincia', field: 'province', sortable: true },
                    { title: 'Población', field: 'population', sortable: true },
                    ],
                    options: [
                    { ico: 'fa fa-edit', class: 'btn-info', title: 'Editar Club', func: (id) => {this.openform('edit', id); }, action: 'club.update'},
                    { ico: 'fa fa-close', class: 'btn-danger', title: 'Borrar Club', func: (id) => {this.deleted('/clubs/'+id, this.$children[0].get); }, action: 'club.destroy'},
                    ]
                }
            };
        },
        mounted() {
            $('#form-clubes').addClass('hide');
        },
        methods: {
            openform: function (cond, id) {
                $('#form-clubes').removeClass('hide');
                this.form.ready = false;
                this.form.cond = cond;
                if (cond == 'plus') {
                    this.form.title = 'Registrar Club.';
                    this.form.url = '/clubs';
                    this.form.data = {
                        name: '',
                        population: '',
                        province: '',
                    };
                    this.form.ready = true;
                } else if (cond == 'edit') {
                    this.form.url = '/clubs/' + id;
                    axios.get(this.form.url)
                    .then(response => {
                        this.form.title = 'Editar Club: ' + response.data.name + '.';
                        this.form.data = response.data;
                        this.form.ready = true;
                    });
                } else {
                    $('#form-clubes').addClass('hide');
                }
            },
            register: function () {
                this.restoreMsg(this.msg);
                if (this.form.cond == 'plus') {
                    axios.post(this.form.url, this.form.data)
                    .then(response => {
                        toastr.success('Registro Exitoso');
                        this.$children[0].get('this');
                        $('#form-clubes').addClass('hide');
                    });
                } else if (this.form.cond == 'edit') {
                    axios.put(this.form.url, this.form.data)
                    .then(response => {
                        toastr.success('Actualización Exitosa');
                        this.$children[0].get('this');
                        $('#form-clubes').addClass('hide');
                    });
                }
            }
        }
    }
</script>
