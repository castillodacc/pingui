<template>
	<div class="box">
		<div class="box-header">
			<h3 class="box-title">Mis Competencias: </h3>
		</div>
		<div class="box-body">
			<rs-table id="tournament" :tabla="tabla" uri="/tournament/user"></rs-table>
		</div>
	</div>
</template>

<script>
	import Tabla from './../partials/table.vue';

	export default {
		name: 'MyTournament',
		components: {
			'rs-table': Tabla,
		},
		data() {
			return {
				tabla: {
					columns: [
					{ title: 'Competencia', field: 'tournament', sort: 'name' },
					{ title: 'Participante', field: 'user', sort: 'name', sortable: true },
					{ title: 'Pareja', field: 'pareja', sort: 'name_2', sortable: true },
					{ title: 'Tipo de pago', field: 'type_pay', sort: 'name_2', sortable: true },
					{ title: 'Estado del pago', field: 'state_pay', sortable: true, class: 'text-center' },
					{ title: 'Estado de Participación', field: 'state', sortable: true, class: 'text-center' },
					],
					options: [
					{ ico: 'fa fa-list', class: 'btn-success', title: 'Lista Participantes', func: (id) => { this.$router.push({name: 'inscription.index', params: {id: id}}) }, action: 'tournament.inscription'},
					]
				}
			};
		},
	}
</script>
