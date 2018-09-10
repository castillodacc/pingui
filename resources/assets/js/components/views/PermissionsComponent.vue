<template>
	<div class="box">
		<div class="box-header">
			<h3 class="box-title">Tabla de Permisos: </h3>
			<!-- <button type="button" class="btn btn-default btn-xs" data-tooltip="tooltip" title="Editar Permiso" @click="openform('edit')" v-show="permission"><span class="glyphicon glyphicon-edit"></span></button> -->
			<rs-modal-form :formData="formData" @input="$children[1].get('this')"></rs-modal-form>
		</div>
		<div class="box-body">
			<rs-table id="permission" :tabla="tabla" uri="/admin/permissions"></rs-table>
		</div>
	</div>
</template>

<script>
	import Tabla from './../partials/table.vue';
	import Modal from './../forms/modal-form-permission.vue';

	export default {
		name: 'Permissions',
		components: {
			'rs-table': Tabla,
			'rs-modal-form': Modal,
		},
		data() {
			return {
				// permission: null,
				formData: {
					ready: true,
					title: '',
					url: '',
					ico: '',
					cond: '',
					permission:  {}
				},
				tabla: {
					columns: [
					{ title: 'Nombre', field: 'name', sortable: true },
					{ title: 'Descripción', field: 'description', sortable: true },
					{ title: 'Activo', field: 'active', sort: 'deleted_at', sortable: true, class: 'text-center' }
					],
                    options: [
                    { ico: 'fa fa-edit', class: 'btn-info', title: 'Editar Permiso', func: (id) => {this.openform('edit', id); }, action: 'permission.update'},
                    ]
				}
			};
		},
		methods: {
			openform: function (cond, id = null) {
				this.formData.ready = false;
				if (cond == 'edit') {
					this.formData.url = '/admin/permissions/' + id;
					axios.get(this.formData.url)
					.then(response => {
						this.formData.ico = 'edit';
						this.formData.title = 'Editar Rol: ' + response.data.name;
						this.formData.permission = response.data;
						$('#permission-form').modal('show');
						this.formData.ready = true;
					});
				}
				this.formData.cond = cond;
			}
		}
	}
</script>
