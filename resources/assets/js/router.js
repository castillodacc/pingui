import VueRouter from 'vue-router';
import Dashboard from './components/views/DashboardComponent.vue';
import Profile from './components/views/profileComponent.vue';
import Users from './components/views/UsersComponent.vue';
import Roles from './components/views/RolesComponent.vue';
import Permissions from './components/views/PermissionsComponent.vue';
import Club from './components/views/ClubComponent.vue';
import Categories_l from './components/views/Categories_lComponent.vue';
import Categories_s from './components/views/Categories_sComponent.vue';
import Categories_o from './components/views/Categories_oComponent.vue';
import Referee from './components/views/RefereeComponent.vue';
import Organizer from './components/views/OrganizerComponent.vue';
import Tournament from './components/views/TournamentComponent';
import MyTournament from './components/views/MyTournamentComponent';
import TournamentF from './components/forms/form-tournament.vue';
import Inscription from './components/views/InscriptionComponent.vue';
import NotFound from './components/views/NotFoundComponent.vue';

const router = new VueRouter({
	mode: 'history',
	hashbang: false,
	routes: [
	{
		path: '/dashboard',
		name: 'dashboard',
		component: Dashboard,
	},
	{
		path: '/perfil/:num?',
		name: 'profile',
		component: Profile,
	},
	{
		path: '/club',
		name: 'club.index',
		component: Club
	},
	{
		path: '/mis-competencias',
		name: 'tournament.user',
		component: MyTournament
	},
	{
		path: '/inscritos/:id',
		name: 'inscription.index',
		component: Inscription
	},
	{
		path: '/referee',
		name: 'referee.index',
		component: Referee
	},
	{
		path: '/organizador',
		name: 'organizer.index',
		component: Organizer
	},
	{
		path: '/torneos',
		name: 'tournament.index',
		component: Tournament
	},
	{
		path: '/torneos/form',
		name: 'tournament.store',
		component: TournamentF
	},
	{
		path: '/torneos/:id/edit',
		name: 'tournament.update',
		component: TournamentF
	},
	{
		path: '/administracion/',
		component: {template: `<router-view></router-view>`},
		children: [
		{
			path: 'usuarios',
			name: 'user.index',
			component: Users,
		},
		{
			path: 'roles',
			name: 'rol.index',
			component: Roles,
		},
		{
			path: 'permisos',
			name: 'permission.index',
			component: Permissions,
		},
		{
			path: '*',
			component: NotFound,
		}
		]
	},
	{
		path: '/categorias/',
		component: {template: `<router-view></router-view>`},
		children: [
		{
			path: 'latino',
			name: 'categories_l.index',
			component: Categories_l,
		},
		{
			path: 'opens',
			name: 'categories_o.index',
			component: Categories_o,
		},
		{
			path: 'standard',
			name: 'categories_s.index',
			component: Categories_s,
		},
		{
			path: '*',
			component: NotFound,
		}
		]
	},
	{ 
		path: '*', 
		name: 'error',
		component: NotFound
	}
	],
});

router.beforeEach((to, from, next) => {
	let permission = to.name;
	if (to.path == '/') {next(	); return;}
	if (location.href.indexOf('/login') > 0) return;
	if (location.href.indexOf('/registro') > 0) return;
	if (to.path.indexOf('.jpg') > 0 ||
		to.path.indexOf('.jpeg') > 0 ||
		to.path.indexOf('.png') > 0 ||
		to.path.indexOf('.min') > 0) {
		next('/perfil');
		return;
	}
	if (permission == undefined) {next('error'); return;}
	if (permission == undefined) {next('error'); return;}

	setTimeout(() => {
		if (this.a.app.can(permission)) {
			next(); return;
		} else if (permission.indexOf('-') != -1) {
			let split = permission.split('-');
			for(let i in split) {
				if (split[i].indexOf('.index') != -1) {
					if (this.a.app.can(split[i])) {
						next(); return;
					}
				} else {
					if (this.a.app.can(split[i] + '.index')) {
						next(); return;
					}
				}
			}
		}
		axios.post('/admin/app', {p: permission})
		.then(response => {
			if (response.data) {next(); return;}
			next(false);
		});
	}, 10);
});

router.afterEach((to, from, next) => {
	setTimeout(function () {
		$('[data-tooltip="tooltip"]').tooltip();
	}, 1000);
});

export default router;