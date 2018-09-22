<template>
	<div class="box">
		<div class="box-header">
			<h3 class="box-title">Tabla de Competencias: </h3>
			<router-link :to="{ name: 'tournament.store' }"
			class="btn btn-default btn-xs"
			data-tooltip="tooltip"
			title="Registrar Competencia"
			v-if="can('tournament.store')"><span class="glyphicon glyphicon-plus"></span></router-link>
		</div>
		<div class="box-body">
			<rs-table id="tournament" :tabla="tabla" uri="/tournament"></rs-table>
		</div>
	</div>
</template>

<script>
	import Tabla from './../partials/table.vue';

	export default {
		name: 'Tournament',
		components: {
			'rs-table': Tabla,
		},
		data() {
			return {
				tabla: {
					columns: [
					{ title: 'Titulo', field: 'name', sortable: true },
					{ title: 'Descripción', field: 'description', sortable: true },
					{ title: 'Inscripciones', field: 'inscription', sortable: true, class: 'text-center' },
					{ title: 'Fecha inicio', field: 'start', sortable: true, class: 'text-center' },
					{ title: 'Fecha final', field: 'end', sortable: true, class: 'text-center' },
					],
					options: [
					{ ico: 'fa fa-list', class: 'btn-success', title: 'Lista Inscritos', func: (id) => { this.$router.push({name: 'inscription.index', params: {id: id}}) }, action: 'tournament.inscription'},
					{ ico: 'fa fa-edit', class: 'btn-info', title: 'Editar', func: (id) => { this.$router.push({name: 'tournament.update', params: { id: id }})}, action: 'tournament.update'},
					{ ico: 'fa fa-close', class: 'btn-danger', title: 'Eliminar', func: (id) => { this.deleted('/tournament/'+id, this.$children[1].get, 'name'); }, action: 'tournament.destroy'},
					]
				}
			};
		},
	}
</script>
