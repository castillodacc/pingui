<template>
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Tabla de Categorias Opens:</h3>
            <button type="button"
            class="btn btn-default btn-xs"
            data-tooltip="tooltip"
            title="Registrar Categoría"
            @click="openform('plus')"
            v-if="can('categories_o.store')"><span class="glyphicon glyphicon-plus"></span></button>
        </div>
        <div class="box-body">
            <div id="form-categories_o" class="col-md-8 col-md-offset-2" v-if="can(['categories_o.store', 'categories_o.update'])"">
                <div class="row" v-show="form.ready">
                    <h4 v-text="form.title"></h4>
                    <div class="col-sm-10">
                        <div class="form-group">
                            <label for="name" class="control-label">
                                <span class="fa fa-name"></span> Categoria:
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
                        v-if="form.cond == 'plus'"
                        @click="register"
                        ><span class="fa fa-plus"></span></button>
                        <button class="btn btn-info btn-xs" 
                        title="Editar Categoria" 
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
            <rs-table id="categories_o" :tabla="tabla" uri="/category-o"></rs-table>
        </div>
    </div>
</template>

<script>
    import Tabla from './../partials/table.vue';

    export default {
        name: 'categories_o',
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
                    name: 'Nombre de la Categoría.',
                },
                tabla: {
                    columns: [
                    { title: 'N°', field: 'id', sortable: true },
                    { title: 'Categoría', field: 'name', sortable: true },
                    ],
                    options: [
                    { ico: 'fa fa-edit', class: 'btn-info', title: 'Editar Categoría', func: (id) => {this.openform('edit', id); }, action: 'categories_o.update'},
                    { ico: 'fa fa-close', class: 'btn-danger', title: 'Borrar Categoría', func: (id) => {this.deleted('/category-o/'+id, this.$children[0].get); }, action: 'categories_o.destroy'},
                    ]
                }
            };
        },
        methods: {
            openform: function (cond, id) {
                this.restoreMsg(this.msg);
                this.form.ready = false;
                this.form.cond = cond;
                if (cond == 'plus') {
                    this.form.title = 'Registrar Categoría.';
                    this.form.url = '/category-o';
                    this.form.data = {name: ''};
                    this.form.ready = true;
                } else if (cond == 'edit') {
                    this.form.url = '/category-o/' + id;
                    axios.get(this.form.url)
                    .then(response => {
                        this.form.title = 'Editar Categoría: ' + response.data.name + '.';
                        this.form.data = response.data;
                        this.form.ready = true;
                    });
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
