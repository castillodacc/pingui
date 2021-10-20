<template>
	<div class="box">
		<div class="box-header">
			<h3 class="box-title">Tabla de Roles: </h3>
			<button type="button"
			class="btn btn-default btn-xs"
			data-tooltip="tooltip"
			title="Registrar Rol"
			@click="openform('create')"
			v-if="can('rol.store')"><span class="glyphicon glyphicon-plus"></span></button>
			<rs-modal-form :formData="formData" @input="$children[1].get('this')"></rs-modal-form>
		</div>
		<div class="box-body">
			<rs-table id="rol" :tabla="tabla" uri="/admin/roles"></rs-table>
		</div>
	</div>
</template>

<script>
	import Tabla from './../partials/table.vue';
	import Modal from './../forms/modal-form-rol.vue';

	export default {
		name: 'Roles',
		components: {
			'rs-table': Tabla,
			'rs-modal-form': Modal,
		},
		data() {
			return {
				rol: null,
				formData: {
					ready: true,
					title: '',
					url: '',
					ico: '',
					cond: '',
					rol:  {
						name: '',
						slug: '',
						description: '',
						from_at: '',
						special: '',
						to_at: '',
						permissions: []
					}
				},
				tabla: {
					columns: [
					{ title: 'Nombre', field: 'name', sortable: true },
					{ title: 'Descripción', field: 'description', sortable: true },
					{ title: 'Activo', field: 'hours', sort: 'from_at', sortable: true },
					{ title: 'Acceso especial', field: 'special' },
					],
                    options: [
                    { ico: 'fa fa-edit', class: 'btn-info', title: 'Editar Rol', func: (id) => {this.openform('edit', id); }, action: 'rol.update'},
                    { ico: 'fa fa-close', class: 'btn-danger', title: 'Borrar Rol', func: (id) => {this.deleted('/admin/roles/'+id, this.$children[1].get, 'name'); }, action: 'rol.destroy'},
                    ]
				}
			};
		},
		methods: {
			openform: function (cond, id = null) {
				this.formData.ready = false;
				if (cond == 'create') {
					this.formData.title = 'Registrar Rol.';
					this.formData.url = '/admin/roles';
					this.formData.ico = 'plus';
					this.formData.rol = {
						name: '',
						slug: '',
						description: '',
						from_at: '',
						special: '',
						to_at: '',
						permissions: []
					};
					this.formData.ready = true;
				} else if (cond == 'edit') {
					this.formData.url = '/admin/roles/' + id;
					axios.get(this.formData.url)
					.then(response => {
						this.formData.ico = 'edit';
						this.formData.title = 'Editar Rol: ' + response.data.name;
						this.formData.rol = response.data;

						let permissions = response.data.permissions;
						let options = [];
						for (let permission in permissions){
							options.push(permissions[permission].id);
						}
						this.formData.rol.permissions = options;

						this.formData.ready = true;
					});
				}
				$('#rol-form').modal('show');
				this.formData.cond = cond;
			}
		}
	}
</script>
