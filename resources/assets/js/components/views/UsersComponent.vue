<template>
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Tabla de Usuarios:</h3>
            <button type="button"
            class="btn btn-default btn-xs"
            data-tooltip="tooltip"
            title="Registrar Usuario"
            @click="openform('create')"
            v-if="can('user.store')"><span class="glyphicon glyphicon-plus"></span></button>
            <rs-modal-form :formData="formData" @input="$children[1].get('this')" v-if="can(['user.store','user.update'])"></rs-modal-form>
        </div>
        <div class="box-body">
            <rs-table id="users" :tabla="tabla" uri="/admin/users"></rs-table>
        </div>
    </div>
</template>

<script>
    import Tabla from './../partials/table.vue';
    import Modal from './../forms/modal-form-user.vue';

    export default {
        name: 'Users',
        components: {
            'rs-table': Tabla,
            'rs-modal-form': Modal,
        },
        data() {
            return {
                formData: {
                    ready: true,
                    title: '',
                    url: '',
                    ico: '',
                    cond: '',
                    user:  {}
                },
                tabla: {
                    columns: [
                    { title: 'Usuario', field: 'user', sortable: true },
                    { title: 'Nombre y Apellido', field: 'fullName', sort: 'name', sortable: true },
                    { title: 'DNI', field: 'num_id', sortable: true },
                    { title: 'Correo', field: 'email', sortable: true },
                    { title: 'Rol', field: 'rol' },
                    ],
                    options: [
                    { ico: 'fa fa-edit', class: 'btn-info', title: 'Editar Usuario', func: (id) => {this.openform('edit', id); }, action: 'user.update'},
                    { ico: 'fa fa-close', class: 'btn-danger', title: 'Borrar Usuario', func: (id) => {this.deleted('/admin/users/'+id, this.$children[0].get, 'fullName'); }, action: 'user.destroy'},
                    ]
                }
            };
        },
        methods: {
            openform: function (cond, id = null) {
                this.formData.ready = false;
                if (cond == 'create') {
                    this.formData.title = ' Registrar Usuario.';
                    this.formData.url = '/admin/users';
                    this.formData.ico = 'plus';
                    this.formData.user = {
                        name: '',
                        last_name: '',
                        num_id: '',
                        email: '',
                        password: '',
                        phone: '',
                        web: '',
                        user: '',
                        password_confirmation: '',
                        approval_state: 1,
                        roles: [],
                    };
                    this.formData.ready = true;
                } else if (cond == 'edit') {
                    this.formData.url = '/admin/users/' + id;
                    axios.get(this.formData.url)
                    .then(response => {
                        this.formData.ico = 'edit';
                        this.formData.title = 'Editar Usuario: ' + response.data.fullName + '.';
                        this.formData.user = response.data;

                        let roles = response.data.roles;
                        let options = [];
                        for (let rol in roles){
                            options.push(roles[rol].name);
                        }
                        this.formData.user.roles = options;

                        this.formData.ready = true;
                    });
                }
                $('#user-form').modal('toggle');
                this.formData.cond = cond;
            }
        }
    }
</script>
