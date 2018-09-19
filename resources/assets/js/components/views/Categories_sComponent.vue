<template>
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Tabla de Categorias Standard:</h3>
            <button type="button"
            class="btn btn-default btn-xs"
            data-tooltip="tooltip"
            title="Registrar Categoría"
            @click="openform('plus', 1)"
            v-if="can('categories_s.store')"><span class="glyphicon glyphicon-plus"></span></button>
            <button type="button"
            class="btn btn-default btn-xs"
            data-tooltip="tooltip"
            title="Registrar Subcategoría"
            @click="openform('plus', 2)"
            v-if="can('categories_s.store')"><span class="glyphicon glyphicon-plus"></span></button>
        </div>
        <div class="box-body">
            <div id="form-categories_s" class="col-md-8 col-md-offset-2" v-if="can(['categories_s.store', 'categories_s.update'])"">
                <div class="row" v-show="form.ready">
                    <h4 v-text="form.title"></h4>
                    <div class="col-sm-5" v-if="form.view == 1 || form.view == 3">
                        <div class="form-group">
                            <label for="category" class="control-label">
                                <span class="fa fa-name"></span> Categoria:
                            </label>
                            <input id="category" type="text" class="form-control" v-model="form.data.category">
                            <small id="categoryHelp" class="form-text text-muted">
                                <span v-text="msg.category"></span>
                            </small>
                        </div>
                    </div>
                    <div class="col-sm-5" v-if="form.view == 2">
                        <div class="form-group">
                            <label for="category_id" class="control-label">
                                <span class="fa fa-name"></span> Categoria:
                            </label>
                            <select id="category_id" type="text" class="form-control" v-model="form.data.category_id">
                                <option value="" selected="">Seleccione una categoria</option>
                                <option v-for="c in categories" :value="c.id" v-text="c.name"></option>
                            </select>
                            <small id="category_idHelp" class="form-text text-muted">
                                <span v-text="msg.category_id"></span>
                            </small>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label for="subcategory" class="control-label">
                                <span class="fa fa-subcategory"></span> Subcategoria:
                            </label>
                            <input id="subcategory" type="text" class="form-control" v-model="form.data.subcategory">
                            <small id="subcategoryHelp" class="form-text text-muted">
                                <span v-text="msg.subcategory"></span>
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
            <rs-table id="categories_s" :tabla="tabla" uri="/category-s"></rs-table>
        </div>
    </div>
</template>

<script>
    import Tabla from './../partials/table.vue';

    export default {
        name: 'categories_s',
        components: {
            'rs-table': Tabla,
        },
        data() {
            return {
                categories: [],
                form: {
                    view: null,
                    ready: false,
                    data:  {}
                },
                msg: {
                    category: 'Nombre de la Categoría.',
                    category_id: 'Seleccione el Nombre de la Categoría.',
                    subcategory: 'Nombre de la subcategoría.',
                },
                tabla: {
                    columns: [
                    { title: 'N°', field: 'id', sortable: true },
                    { title: 'Categoría', field: 'category_standar_id', sortable: true },
                    { title: 'Subcategoría', field: 'name', sortable: true },
                    ],
                    options: [
                    { ico: 'fa fa-edit', class: 'btn-info', title: 'Editar Categoría', func: (id) => {this.openform('edit', 3, id); }, action: 'categories_s.update'},
                    { ico: 'fa fa-close', class: 'btn-danger', title: 'Borrar Categoría', func: (id) => {this.deleted('/category-s/'+id, this.$children[0].get, 'subcategory'); }, action: 'categories_s.destroy'},
                    ]
                }
            };
        },
        mounted() {
            this.get();
        },
        methods: {
            get: function () {
                axios.post('/categories-s')
                .then(response => {
                    this.categories = response.data.categories;
                });
            },
            openform: function (cond, view, id) {
                this.restoreMsg(this.msg);
                this.form.ready = false;
                this.form.cond = cond;
                this.form.view = view;
                if (view == 1) {
                    this.form.title = 'Registrar Categoría.';
                    this.form.url = '/category-s';
                    this.form.data = {category: '', subcategory: ''};
                    this.form.ready = true;
                } else if (view == 2) {
                    this.form.title = 'Registrar Subcategoría.';
                    this.form.url = '/category-s';
                    this.form.data = {category_id: '', subcategory: ''};
                    this.form.ready = true;
                } else if (view == 3) {
                    this.form.url = '/category-s/' + id;
                    axios.get(this.form.url)
                    .then(response => {
                        this.form.title = 'Editar Subcategoría: ' + response.data.name + '.';
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
                        this.get();
                        this.form.ready = false;
                    });
                } else if (this.form.cond == 'edit') {
                    axios.put(this.form.url, this.form.data)
                    .then(response => {
                        toastr.success('Actualización Exitosa');
                        this.$children[0].get('this');
                        this.get();
                        this.form.ready = false;
                    });
                }
            }
        }
    }
</script>
