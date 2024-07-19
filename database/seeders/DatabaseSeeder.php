<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Permission;
use App\Models\Purchase;
use App\Models\Role;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

      Category::factory(3)->create();
      Supplier::factory(5)->create();
 // Create admin role
 $adminRole = Role::create([
  'name' => 'Admin',
  'description' => 'Administrator',
]);
$pharmacyRole = Role::create([
  'name' => 'pharmacy',
  'description' => 'pharmacyy',
]);

  // Create permissions
  $createUserPermission = Permission::create([
    'name' => 'show-employee',
    'description' => 'show-employee',
  ]);
  $createUserPermission1 = Permission::create([
    
    'name' => 'get-employee',
    'description' => 'get-employee',
]);
$createUserPermission2 = Permission::create([
  'name' => 'create-employee',
  'description' => 'create-employee',
]);
$createUserPermission3 = Permission::create([
  'name' => 'delete-employee',
  'description' => 'delete-employee',
]);
$createUserPermission4 = Permission::create([
  'name' => 'get-profit_percentage',
  'description' => 'get-profit_percentage',
]);
$createUserPermission5 = Permission::create([
  'name' => 'add-profit_percentage',
  'description' => 'add-profit_percentage',
]);
$createUserPermission6 = Permission::create([
  'name' => 'show-profit_percentage',
  'description' => 'show-profit_percentage',
]);
$createUserPermission7 = Permission::create([
  'name' => 'update-profit_percentage',
  'description' => 'update-profit_percentage',
]);
$createUserPermission8 = Permission::create([
  'name' => 'delete-profit_percentage',
  'description' => 'delete-profit_percentage',
]);
$createUserPermission9 = Permission::create([
  'name' => 'get-discount',
  'description' => 'get-discount',
]);
$createUserPermission10 = Permission::create([
  'name' => 'add-discount',
  'description' => 'add-discount',
]);
$createUserPermission11 = Permission::create([
  'name' => 'show-discount',
  'description' => 'show-discount',
]);
$createUserPermission12 = Permission::create([
  'name' => 'update-discount',
  'description' => 'update-discount',
]);
$createUserPermission13 = Permission::create([
  'name' => 'delete-discount',
  'description' => 'delete-discount',
]);

$createUserPermission14 = Permission::create([
    'name' => 'edit-user',
    'description' => 'Edit User',
]);
$createUserPermission15 = Permission::create([
    'name' => 'delete-supplier',
    'description' => 'Delete User',
]);

// Assign permissions to admin role
$adminRole->permissions()->attach([
    $createUserPermission->id,
    $createUserPermission1->id,
    $createUserPermission2->id,
    $createUserPermission3->id,
    $createUserPermission4->id,
    $createUserPermission5->id,  
    $createUserPermission6->id,
    $createUserPermission7->id,
    $createUserPermission8->id,
    $createUserPermission9->id,
    $createUserPermission10->id,
    $createUserPermission11->id,
    $createUserPermission12->id,
    $createUserPermission13->id,
    $createUserPermission14->id,
    $createUserPermission15->id,
]);
// Create admin user
$adminUser = User::create([
  'name' => 'Admin',
  'email' => 'admin@gmail.com',
  'password' => bcrypt('password'),
  'role_id' => $adminRole->id,
  'type' => 'admin',
]);

}




    //   Purchase::factory(10)->create();
    }

