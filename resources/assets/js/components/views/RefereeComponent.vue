<template>
    <div class="box">
        <div class="box-header">
            <h3 class="box-title"><i class="fa fa-users"></i> Tabla de Referees:</h3>
            <button type="button"
            class="btn btn-default btn-xs"
            data-tooltip="tooltip"
            title="Registrar Referee"
            @click="openform('plus')"
            v-if="can('referee.store')"><span class="glyphicon glyphicon-plus"></span></button>
        </div>
        <div class="box-body">
            <div id="form-referee" class="col-md-8 col-md-offset-2" v-if="can(['referee.store', 'referee.update'])"">
                <div class="row" v-show="form.ready">
                    <h4 v-text="form.title"></h4>
                    <div class="col-sm-10">
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
                    <div class="col-sm-2 text-center" style="padding-top: 32px;">
                        <button class="btn btn-success btn-xs" 
                        title="Registrar Referee" 
                        data-tooltip="tooltip"
                        v-if="form.cond == 'plus'"
                        @click="register"
                        ><span class="fa fa-plus"></span></button>
                        <button class="btn btn-info btn-xs" 
                        title="Editar Referee" 
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
            <rs-table id="referees" :tabla="tabla" uri="/referees"></rs-table>
        </div>
    </div>
</template>

<script>
    import Tabla from './../partials/table.vue';

    export default {
        name: 'Referee',
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
                    name: 'Nombre del Referee.',
                },
                tabla: {
                    columns: [
                    { title: 'N°', field: 'id', sortable: true },
                    { title: 'Nombre', field: 'name', sortable: true },
                    ],
                    options: [
                    { ico: 'fa fa-edit', class: 'btn-info', title: 'Editar Referee', func: (id) => {this.openform('edit', id); }, action: 'referee.update'},
                    { ico: 'fa fa-close', class: 'btn-danger', title: 'Borrar Referee', func: (id) => {this.deleted('/referees/'+id, this.$children[0].get); }, action: 'referee.destroy'},
                    ]
                }
            };
        },
        mounted() {
            $('#form-referee').addClass('hide');
        },
        methods: {
            openform: function (cond, id) {
                $('#form-referee').removeClass('hide');
                this.form.ready = false;
                this.form.cond = cond;
                if (cond == 'plus') {
                    this.form.title = 'Registrar Referee.';
                    this.form.url = '/referees';
                    this.form.data = {name: ''};
                    this.form.ready = true;
                } else if (cond == 'edit') {
                    this.form.url = '/referees/' + id;
                    axios.get(this.form.url)
                    .then(response => {
                        this.form.title = 'Editar Referee: ' + response.data.name + '.';
                        this.form.data = response.data;
                        this.form.ready = true;
                    });
                } else {
                    $('#form-referee').addClass('hide');
                }
            },
            register: function () {
                this.restoreMsg(this.msg);
                if (this.form.cond == 'plus') {
                    axios.post(this.form.url, this.form.data)
                    .then(response => {
                        toastr.success('Registro Exitoso');
                        this.$children[0].get();
                        $('#form-referee').addClass('hide');
                    });
                } else if (this.form.cond == 'edit') {
                    axios.put(this.form.url, this.form.data)
                    .then(response => {
                        toastr.success('Actualización Exitosa');
                        this.$children[0].get('this');
                        $('#form-referee').addClass('hide');
                    });
                }
            }
        }
    }
</script>
