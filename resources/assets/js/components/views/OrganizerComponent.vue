<template>
    <div class="box">
        <div class="box-header">
            <h3 class="box-title"><i class="fa fa-users"></i> Tabla de Organizadores:</h3>
            <button type="button"
            class="btn btn-default btn-xs"
            data-tooltip="tooltip"
            title="Registrar"
            @click="openform('plus')"
            v-if="can('organizer.store')"><span class="glyphicon glyphicon-plus"></span></button>
        </div>
        <div class="box-body">
            <div id="form-organizer" class="col-md-8 col-md-offset-2" v-if="can(['organizer.store', 'organizer.update'])"">
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
                    title="Guardar" 
                    data-tooltip="tooltip"
                    @click="register"
                    ><span class="fa fa-plus"></span></button>
                    <button class="btn btn-danger btn-xs" 
                    title="Cancelar" 
                    data-tooltip="tooltip"
                    @click="openform"
                    ><span class="fa fa-close"></span></button>
                </div>
            </div>
        </div>
        <rs-table id="organizer" :tabla="tabla" uri="/organizer"></rs-table>
    </div>
</div>
</template>

<script>
    import Tabla from './../partials/table.vue';

    export default {
        name: 'organizer',
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
                    name: 'Nombre del Organizador.',
                },
                tabla: {
                    columns: [
                    { title: 'N°', field: 'id', sortable: true },
                    { title: 'Nombre', field: 'name', sortable: true },
                    ],
                    options: [
                    { ico: 'fa fa-edit', class: 'btn-info', title: 'Editar', func: (id) => {this.openform('edit', id); }, action: 'organizer.update'},
                    { ico: 'fa fa-close', class: 'btn-danger', title: 'Borrar', func: (id) => {this.deleted('/organizer/'+id, this.$children[0].get); }, action: 'organizer.destroy'},
                    ]
                }
            };
        },
        mounted() {
            $('#form-organizer').addClass('hide');
        },
        methods: {
            openform: function (cond, id) {
                $('#form-organizer').removeClass('hide');
                this.form.ready = false;
                this.form.cond = cond;
                if (cond == 'plus') {
                    this.form.title = 'Registrar Organizador.';
                    this.form.url = '/organizer';
                    this.form.data = {name: ''};
                    this.form.ready = true;
                } else if (cond == 'edit') {
                    this.form.url = '/organizer/' + id;
                    axios.get(this.form.url)
                    .then(response => {
                        this.form.title = 'Editar Organizador: ' + response.data.name + '.';
                        this.form.data = response.data;
                        this.form.ready = true;
                    });
                } else {
                    $('#form-organizer').addClass('hide');
                }
            },
            register: function () {
                this.restoreMsg(this.msg);
                if (this.form.cond == 'plus') {
                    axios.post(this.form.url, this.form.data)
                    .then(response => {
                        toastr.success('Registro Exitoso');
                        this.$children[0].get();
                        $('#form-organizer').addClass('hide');
                    });
                } else if (this.form.cond == 'edit') {
                    axios.put(this.form.url, this.form.data)
                    .then(response => {
                        toastr.success('Actualización Exitosa');
                        this.$children[0].get('this');
                        $('#form-organizer').addClass('hide');
                    });
                }
            }
        }
    }
</script>
