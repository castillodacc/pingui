<template>
	<footer class="main-footer">
		<div class="row">
			<div class="pull-right hidden-xs">
				<strong><span v-html="all.credits"></span></strong>.
			</div>
			<div class="col-sm-3">
				<b>Version</b> {{ all.version }}
			</div>
		</div>
	</footer>
</template>

<script>
	export default {
		name: 'v-footer',
		props: ['all']
	}
</script>
