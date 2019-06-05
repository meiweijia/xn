<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 重置角色和权限缓存
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        // 创建权限
        Permission::create(['name' => 'view']);//查看权限
        Permission::create(['name' => 'apply']);//提交申请权限
        Permission::create(['name' => 'all']);//所有权限

        // 创建角色并分配创建的权限
        $role = Role::create(['name' => 'grade1']);//一级会员
        $role->givePermissionTo('view');

        $role = Role::create(['name' => 'grade2']);//二级会员
        $role->givePermissionTo(['view', 'apply']);

        $role = Role::create(['name' => 'grade3']);//三级会员
        $role->givePermissionTo(Permission::all());
    }
}
