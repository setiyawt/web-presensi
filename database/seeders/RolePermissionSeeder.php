<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;


class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'view teacher presence',
            'view student presence',
            'create class',
            'edit presence',
            'delete presence',
            'view schedules',        
            'view students',          
            'create qrcode',          
            'scan qrcode',            
            'view status presence' 
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        $teacherRole = Role::create(['name' => 'teacher']);
        $teacherRole->givePermissionTo(['view schedules', 'view students', 'create qrcode', 'edit presence', 'delete presence']);

        $studentRole = Role::create(['name' => 'student']);
        $studentRole->givePermissionTo(['view schedules', 'view status presence', 'scan qrcode']);

        // membuat data user super admin
        $user = User::create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => bcrypt('123456'),
        ]);

        $user->assignRole($adminRole);
        $user->assignRole($studentRole);
    }
}