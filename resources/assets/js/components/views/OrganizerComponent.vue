<template>
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Tabla de Organizadores:</h3>
            <button type="button"
            class="btn btn-default btn-xs"
            data-tooltip="tooltip"
            title="Registrar"
            @click="openform('plus')"
            v-if="can('organizer.store')"><span class="glyphicon glyphicon-plus"></span></button>
        </div>
        <div class="box-body">
            <div class="row" v-if="can(['organizer.store', 'organizer.update'])" v-show="form.ready">
                <div class="col-md-12">
                    <h4 class="text-center">{{ form.title }}</h4>
                    <div class="col-sm-8 col-md-offset-2">
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
                </div>
                <div class="col-md-12">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="bank" class="control-label">
                                <span class="fa fa-banko"></span> Banco:
                            </label>
                            <input id="bank" type="text" class="form-control" v-model="form.data.bank">
                            <small id="bankHelp" class="form-text text-muted">
                                <span v-text="msg.bank"></span>
                            </small>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="account" class="control-label">
                                <span class="fa fa-account"></span> Cuenta:
                            </label>
                            <input id="account" type="text" class="form-control" v-model="form.data.account">
                            <small id="accountHelp" class="form-text text-muted">
                                <span v-text="msg.account"></span>
                            </small>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="headline" class="control-label">
                                <span class="fa fa-headline"></span> Titular:
                            </label>
                            <input id="headline" type="text" class="form-control" v-model="form.data.headline">
                            <small id="headlineHelp" class="form-text text-muted">
                                <span v-text="msg.headline"></span>
                            </small>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="col-sm-4 col-sm-offset-2">
                        <div class="form-group">
                            <label for="paypal_client_id" class="control-label">
                                <span class="fa fa-paypal_client_id"></span> ID Client:
                            </label>
                            <input id="paypal_client_id" type="text" class="form-control" v-model="form.data.paypal_client_id">
                            <small id="paypal_client_idHelp" class="form-text text-muted">
                                <span v-text="msg.paypal_client_id"></span>
                            </small>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="paypal_client_secret" class="control-label">
                                <span class="fa fa-paypal_client_secret"></span> ID Client Secret:
                            </label>
                            <input id="paypal_client_secret" type="text" class="form-control" v-model="form.data.paypal_client_secret">
                            <small id="paypal_client_secretHelp" class="form-text text-muted">
                                <span v-text="msg.paypal_client_secret"></span>
                            </small>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 text-center">
                    <button class="btn btn-danger" 
                    @click="openform"
                    ><span class="fa fa-close"></span> Cancelar</button>
                    <button class="btn btn-success" 
                    @click="register"
                    ><span class="fa fa-plus"></span> Guardar</button>
                </div>
            </div>
            <rs-table id="organizer" :tabla="tabla" uri="/organizer" v-show="!form.ready"></rs-table>
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
                    bank: 'Nombre del banco.',
                    account: 'Número de Cuenta Bancaria',
                    headline: 'Titular de la Cuenta',
                    client_id: 'Código CLIENT ID proporcionado por paypal',
                    client_secret: 'Código CLIENT ID SECRET proporcionado por paypal',
                },
                tabla: {
                    columns: [
                    { title: 'N°', field: 'id', sortable: true },
                    { title: 'Nombre', field: 'name', sortable: true },
                    { title: 'Pagos Paypal', field: 'p', class: 'text-center' },
                    { title: 'Pagos Transferencias', field: 't', class: 'text-center' },
                    ],
                    options: [
                    { ico: 'fa fa-edit', class: 'btn-info', title: 'Editar', func: (id) => {this.openform('edit', id); }, action: 'organizer.update'},
                    { ico: 'fa fa-close', class: 'btn-danger', title: 'Borrar', func: (id) => {this.deleted('/organizer/'+id, this.$children[0].get); }, action: 'organizer.destroy'},
                    ]
                }
            };
        },
        methods: {
            openform: function (cond, id) {
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
                    this.form.ready = false;
                }
            },
            register: function () {
                this.restoreMsg(this.msg);
                if (this.form.cond == 'plus') {
                    axios.post(this.form.url, this.form.data)
                    .then(response => {
                        toastr.success('Registro Exitoso');
                        this.$children[0].get();
                        this.form.ready = false;
                    });
                } else if (this.form.cond == 'edit') {
                    axios.put(this.form.url, this.form.data)
                    .then(response => {
                        toastr.success('Actualización Exitosa');
                        this.$children[0].get('this');
                        this.form.ready = false;
                    });
                }
            }
        }
    }
</script>
