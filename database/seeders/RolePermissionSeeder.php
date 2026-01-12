<?php
namespace Database\Seeders;

use App\Models\Action;
use App\Models\Entity;
use App\Models\Role;
use App\Models\RolesRight;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // $permissions = [
        //     'admin' => [
        
        //         // User 
        //         'account' => ['show', 'edit', 'delete'],

        //         //security
        //         'system-module' => ['show'],
        //         'role-rights' => ['show'],
        //         'users' => ['show','approve','reject'], 
        //         'sessions' => ['show'],
        //         'security' => ['show'],
        //     ],
        //     'user' => [

        //         // User 
        //         'account' => ['show', 'edit', 'delete'],

        //     ],
        // ];

        // foreach ($permissions as $roleName => $entities) {
        //     $role = Role::where('RoleName', $roleName)->first();
        //     foreach ($entities as $entityName => $actions) {
        //         $entity = Entity::where('EntityName', $entityName)->first();
        //         foreach ($actions as $actionName) {
        //             $action = Action::where('ActionName', $actionName)->first();
        //             RolesRight::create([
        //                 'role_id' => $role->RoleID,
        //                 'entity_id' => $entity->EntityID,
        //                 'action_id' => $action->ActionID,
        //             ]);
        //         }
        //     }
        // }
    }
}
