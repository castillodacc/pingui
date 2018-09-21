<?php

use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Permisos de usuarios
         */
        App\Models\Permisologia\Permission::create([
            'name' => 'Ver Usuarios',
            'module' => 'user',
            'action' => 'index',
            'description' => 'Permiso para Ver usuarios'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Crear Usuarios',
            'module' => 'user',
            'action' => 'store',
            'description' => 'Permiso para registrar usuarios'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Ver Usuario',
            'module' => 'user',
            'action' => 'show',
            'description' => 'Permiso para Ver usuario'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Editar Usuarios',
            'module' => 'user',
            'action' => 'update',
            'description' => 'Permiso para editar usuarios'
        ]);

        App\Models\Permisologia\Permission::create([
        	'name' => 'Borrar Usuarios',
        	'module' => 'user',
        	'action' => 'destroy',
        	'description' => 'Permiso para borrar usuarios'
        ]);

        App\Models\Permisologia\Permission::create([
        	'name' => 'Cambiar usuario',
        	'module' => 'user',
        	'action' => 'initWithOneUser',
        	'description' => 'Permiso para Iniciar sesion con otro usuario'
        ]);

        /**
         * Permisos de Roles
         */
        App\Models\Permisologia\Permission::create([
        	'name' => 'Ver Roles',
        	'module' => 'rol',
        	'action' => 'index',
        	'description' => 'Permiso para ver roles'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Crear Roles',
            'module' => 'rol',
            'action' => 'store',
            'description' => 'Permiso para registrar roles'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Ver Rol',
            'module' => 'rol',
            'action' => 'show',
            'description' => 'Permiso para ver un rol'
        ]);

        App\Models\Permisologia\Permission::create([
        	'name' => 'Actualizar Roles',
        	'module' => 'rol',
        	'action' => 'update',
        	'description' => 'Permiso para actualizar roles'
        ]);

        App\Models\Permisologia\Permission::create([
        	'name' => 'Eliminar Roles',
        	'module' => 'rol',
        	'action' => 'destroy',
        	'description' => 'Permiso para Eliminar roles'
        ]);

        /**
         * Permisos de Permisos
         */
        App\Models\Permisologia\Permission::create([
            'name' => 'Ver Permisos',
            'module' => 'permission',
            'action' => 'index',
            'description' => 'Permiso para Ver Permisos'
        ]);

        App\Models\Permisologia\Permission::create([
        	'name' => 'Ver Permiso',
        	'module' => 'permission',
        	'action' => 'show',
        	'description' => 'Permiso para Ver un Permiso'
        ]);

        App\Models\Permisologia\Permission::create([
        	'name' => 'Modificar Permisos',
        	'module' => 'permission',
        	'action' => 'update',
        	'description' => 'Permiso para Eliminar Permisos'
        ]);

        /**
         * Permisos de Clubes
         */
        App\Models\Permisologia\Permission::create([
            'name' => 'Ver Clubes',
            'module' => 'club',
            'action' => 'index',
            'description' => 'Permiso para ver Clubes'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Crear Club',
            'module' => 'club',
            'action' => 'store',
            'description' => 'Permiso para registrar Club'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Ver Club',
            'module' => 'club',
            'action' => 'show',
            'description' => 'Permiso para ver un Club'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Actualizar Club',
            'module' => 'club',
            'action' => 'update',
            'description' => 'Permiso para actualizar Club'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Eliminar Club',
            'module' => 'club',
            'action' => 'destroy',
            'description' => 'Permiso para Eliminar Club'
        ]);

        /**
         * Permisos de Referees
         */
        App\Models\Permisologia\Permission::create([
            'name' => 'Ver Referees',
            'module' => 'referee',
            'action' => 'index',
            'description' => 'Permiso para ver Referees'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Crear Referee',
            'module' => 'referee',
            'action' => 'store',
            'description' => 'Permiso para registrar Referee'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Ver Referee',
            'module' => 'referee',
            'action' => 'show',
            'description' => 'Permiso para ver un Referee'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Actualizar Referee',
            'module' => 'referee',
            'action' => 'update',
            'description' => 'Permiso para actualizar Referee'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Eliminar Referee',
            'module' => 'referee',
            'action' => 'destroy',
            'description' => 'Permiso para Eliminar Referee'
        ]);

        /**
         * Permisos de Categorias Latinas
         */
        App\Models\Permisologia\Permission::create([
            'name' => 'Ver Categorias Latinas',
            'module' => 'categories_l',
            'action' => 'index',
            'description' => 'Permiso para ver Categorias Latinas'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Crear Categoria Latina',
            'module' => 'categories_l',
            'action' => 'store',
            'description' => 'Permiso para registrar Categoria Latina'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Ver Categoria Latina',
            'module' => 'categories_l',
            'action' => 'show',
            'description' => 'Permiso para ver un Categoria Latina'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Actualizar Categoria Latina',
            'module' => 'categories_l',
            'action' => 'update',
            'description' => 'Permiso para actualizar Categoria Latina'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Eliminar Categoria Latina',
            'module' => 'categories_l',
            'action' => 'destroy',
            'description' => 'Permiso para Eliminar Categoria Latina'
        ]);

        /**
         * Permisos de Categorias Opens
         */
        App\Models\Permisologia\Permission::create([
            'name' => 'Ver Categorias Opens',
            'module' => 'categories_o',
            'action' => 'index',
            'description' => 'Permiso para ver Categorias Opens'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Crear Categoria Open',
            'module' => 'categories_o',
            'action' => 'store',
            'description' => 'Permiso para registrar Categoria Open'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Ver Categoria Open',
            'module' => 'categories_o',
            'action' => 'show',
            'description' => 'Permiso para ver un Categoria Open'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Actualizar Categoria Open',
            'module' => 'categories_o',
            'action' => 'update',
            'description' => 'Permiso para actualizar Categoria Open'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Eliminar Categoria Open',
            'module' => 'categories_o',
            'action' => 'destroy',
            'description' => 'Permiso para Eliminar Categoria Open'
        ]);

        /**
         * Permisos de Categorias Standard
         */
        App\Models\Permisologia\Permission::create([
            'name' => 'Ver Categorias Standards',
            'module' => 'categories_s',
            'action' => 'index',
            'description' => 'Permiso para ver Categorias Standards'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Crear Categoria Standard',
            'module' => 'categories_s',
            'action' => 'store',
            'description' => 'Permiso para registrar Categoria Standard'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Ver Categoria Standard',
            'module' => 'categories_s',
            'action' => 'show',
            'description' => 'Permiso para ver un Categoria Standard'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Actualizar Categoria Standard',
            'module' => 'categories_s',
            'action' => 'update',
            'description' => 'Permiso para actualizar Categoria Standard'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Eliminar Categoria Standard',
            'module' => 'categories_s',
            'action' => 'destroy',
            'description' => 'Permiso para Eliminar Categoria Standard'
        ]);

        /**
         * Permisos de Torneos
         */
        App\Models\Permisologia\Permission::create([
            'name' => 'Ver Torneos',
            'module' => 'tournament',
            'action' => 'index',
            'description' => 'Permiso para ver Torneos'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Crear Torneo',
            'module' => 'tournament',
            'action' => 'store',
            'description' => 'Permiso para registrar Torneo'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Ver Torneo',
            'module' => 'tournament',
            'action' => 'show',
            'description' => 'Permiso para ver un Torneo'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Actualizar Torneo',
            'module' => 'tournament',
            'action' => 'update',
            'description' => 'Permiso para actualizar Torneo'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Eliminar Torneo',
            'module' => 'tournament',
            'action' => 'destroy',
            'description' => 'Permiso para Eliminar Torneo'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Ver Torneos Inscrito',
            'module' => 'tournament',
            'action' => 'user',
            'description' => 'Permiso para los torneos en los que se ha inscrito'
        ]);

        /**
         * Permisos de Organizadores
         */
        App\Models\Permisologia\Permission::create([
            'name' => 'Ver Organizadores',
            'module' => 'organizer',
            'action' => 'index',
            'description' => 'Permiso para ver Organizadores'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Crear Organizador',
            'module' => 'organizer',
            'action' => 'store',
            'description' => 'Permiso para registrar Organizador'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Ver Organizador',
            'module' => 'organizer',
            'action' => 'show',
            'description' => 'Permiso para ver un Organizador'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Actualizar Organizador',
            'module' => 'organizer',
            'action' => 'update',
            'description' => 'Permiso para actualizar Organizador'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Eliminar Organizador',
            'module' => 'organizer',
            'action' => 'destroy',
            'description' => 'Permiso para Eliminar Organizador'
        ]);

        /**
         * Permisos de Inscripciones
         */
        App\Models\Permisologia\Permission::create([
            'name' => 'Ver Inscritos',
            'module' => 'inscription',
            'action' => 'index',
            'description' => 'Permiso para ver Inscritos'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Crear Inscripción',
            'module' => 'inscription',
            'action' => 'store',
            'description' => 'Permiso para registrar Inscripción'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Ver Inscripción',
            'module' => 'inscription',
            'action' => 'show',
            'description' => 'Permiso para ver un Inscripción'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Actualizar Inscripción',
            'module' => 'inscription',
            'action' => 'update',
            'description' => 'Permiso para actualizar Inscripción'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Eliminar Inscripción',
            'module' => 'inscription',
            'action' => 'destroy',
            'description' => 'Permiso para Eliminar Inscripción'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Registrar Parejas',
            'module' => 'inscription',
            'action' => 'store2',
            'description' => 'Permiso para Parejas'
        ]);
    }
}
