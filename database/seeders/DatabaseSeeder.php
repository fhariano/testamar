<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Enum\PermissionsEnum;
use App\Enum\RolesEnum;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $userRole = Role::create(['name' => RolesEnum::User->value]);
        $adminRole = Role::create(['name' => RolesEnum::Admin->value]);

        $manageProductsPermission = Permission::create([
            'name' => PermissionsEnum::ManageProducts->value,
        ]);

        $manageUsersPermission = Permission::create([
            'name' => PermissionsEnum::ManageUsers->value,
        ]);

        $userRole->syncPermissions([$manageProductsPermission]);
        $adminRole->syncPermissions([
            $manageProductsPermission,
            $manageUsersPermission,
        ]);

        User::factory()->create([
            'name' => 'User 01',
            'email' => 'user@example.com',
        ])->assignRole(RolesEnum::User);

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ])->assignRole(RolesEnum::Admin);

        // criar 5 produtos
        Product::factory(5)->create();

        // associar uma ou mais imagens para cada produto criado, arquivos já na pasta!
        ProductImage::create([
            'product_id' => 1,
            'image_path' => 'products/1-1.png',
        ]);

        ProductImage::create([
            'product_id' => 2,
            'image_path' => 'products/2-1.png',
        ]);
        ProductImage::create([
            'product_id' => 3,
            'image_path' => 'products/3-1.png',
        ]);
        ProductImage::create([
            'product_id' => 3,
            'image_path' => 'products/3-2.png',
        ]);
        ProductImage::create([
            'product_id' => 4,
            'image_path' => 'products/4-1.png',
        ]);
        ProductImage::create([
            'product_id' => 5,
            'image_path' => 'products/5-1.png',
        ]);
        ProductImage::create([
            'product_id' => 5,
            'image_path' => 'products/5-2.png',
        ]);
    }
}
