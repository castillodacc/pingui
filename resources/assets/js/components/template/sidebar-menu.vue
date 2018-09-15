<template>
    <ul class="sidebar-menu" data-widget="tree">
        <li class="header">Menú de Navegación</li>
        <!-- <li>
            <router-link :to="{ name: 'dashboard' }">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            </router-link>
        </li> -->
        <li class="treeview" v-if="can(['user.index','rol.index','permission.index'])">
            <a href="#">
                <i class="fa fa-laptop"></i>
                <span>Administración</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li v-if="can('user.index')">
                    <router-link :to="{ name: 'user.index' }">
                        <i class="fa fa-users"></i> Usuarios
                    </router-link>
                </li>
                <li v-if="can('rol.index')">
                    <router-link :to="{ name: 'rol.index' }">
                        <i class="glyphicon glyphicon-compressed"></i> Roles
                    </router-link>
                </li>
                <li v-if="can('permission.index')">
                    <router-link :to="{ name: 'permission.index' }">
                        <i class="glyphicon glyphicon-th"></i> Permisos
                    </router-link>
                </li>
            </ul>
        </li>
        <li class="treeview" v-if="can(['categories_l.index','categories_o.index','categories_s.index'])">
            <a href="#">
                <i class="fa fa-laptop"></i>
                <span>Categorias</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li v-if="can('categories_l.index')">
                    <router-link :to="{ name: 'categories_l.index' }">
                        <i class="fa fa-list"></i> Latinas
                    </router-link>
                </li>
                <li v-if="can('categories_o.index')">
                    <router-link :to="{ name: 'categories_o.index' }">
                        <i class="fa fa-list"></i> Opens
                    </router-link>
                </li>
                <li v-if="can('categories_s.index')">
                    <router-link :to="{ name: 'categories_s.index' }">
                        <i class="fa fa-list"></i> Standard
                    </router-link>
                </li>
            </ul>
        </li>
        <li v-if="can('club.index')">
            <router-link :to="{ name: 'club.index' }">
                <i class="fa fa-td"></i> <span>Clubes</span>
            </router-link>
        </li>
        <li v-if="can('referee.index')">
            <router-link :to="{ name: 'referee.index' }">
                <i class="fa fa-td"></i> <span>Referees</span>
            </router-link>
        </li>
        <li v-if="can('organizer.index')">
            <router-link :to="{ name: 'organizer.index' }">
                <i class="fa fa-td"></i> <span>Organizadores</span>
            </router-link>
        </li>
        <li v-if="can('tournament.index')">
            <router-link :to="{ name: 'tournament.index' }">
                <i class="fa fa-td"></i> <span>Competencias</span>
            </router-link>
        </li>
        <li v-if="can('tournament.user')">
            <router-link :to="{ name: 'tournament.user' }">
                <i class="fa fa-td"></i> <span>Mis Competencias</span>
            </router-link>
        </li>
    </ul>
</template>

<script>
    export default {}
</script>


