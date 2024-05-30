<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use File;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       // Todo::truncate();
  
        // $json = File::get("resources/data/menus/horizontal-menu.json");

        // $menuData = json_decode($json);

        // $menus =  $menuData->menu;
  
        // foreach ($menus as $menu) {
        //     Permission::create([
        //         "name" => $menu->name,
        //         "guard_name" => 'web',
        //     ]);
        // }

        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'Tableau de bord']);
        Permission::create(['name' => 'Suivi des plans actions']);
        Permission::create(['name' => 'Gestion des utilisateurs']);
        Permission::create(['name' => 'Gestion des exigences']);
        Permission::create(['name' => 'Gestion des exigences > regles de securite']);

        Permission::create(['name' => 'Gestion des exigences > Exigences']);
        Permission::create(['name' => 'famille exigence']);
        Permission::create(['name' => 'Gestion des chapîtres']);
        Permission::create(['name' => 'Solicitation de mission']);
        Permission::create(['name' => 'Gerer mes missions']);

        Permission::create(['name' => 'Pole gouvernance']);
        Permission::create(['name' => 'Gestion plan-d-action']);
        Permission::create(['name' => 'Gerer mon compte']);
        Permission::create(['name' => 'Parametres > Equipe']);

        Permission::create(['name' => 'Parametres > Type de mission']);

        // create roles and assign created permissions  

        // this can be done as separate statements

        // or may be done by chaining

        $role = Role::create(['name' => 'super-admin-role']);

        $role->givePermissionTo(Permission::all());

       $user = User::create([
            'name' => 'testadmin',
            'email' => 'testadmin@test.co',
            'super_role' => '1',
            'password' => Hash::make('testadmin'),
        ]);

        $user->assignRole([$role->id]);
    }
}
