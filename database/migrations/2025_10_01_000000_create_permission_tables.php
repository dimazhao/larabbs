<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 从配置文件获取表名（默认或自定义）
        $tableNames = config('permission.table_names');
        $columnNames = config('permission.column_names');
        $teams = config('permission.teams', false);

        // 检查配置文件是否存在
        if (empty($tableNames)) {
            throw new \Exception('请先发布权限包配置文件：php artisan vendor:publish --tag="permission-config"');
        }

        // 1. 创建权限表
        Schema::create($tableNames['permissions'], function (Blueprint $table) {
            $table->id();
            $table->string('name'); // 权限名称（如 manage_contents）
            $table->string('guard_name')->default('web'); // 守卫名称
            $table->timestamps();
            $table->unique(['name', 'guard_name']); // 防止重复权限
        });

        // 2. 创建角色表
        Schema::create($tableNames['roles'], function (Blueprint $table) use ($teams) {
            $table->id();
            // 团队功能（默认关闭）
            if ($teams) {
                $table->foreignId('team_id')->nullable()->index();
            }
            $table->string('name'); // 角色名称（如 Founder）
            $table->string('guard_name')->default('web'); // 守卫名称
            $table->timestamps();
            // 联合唯一索引（防止重复角色）
            if ($teams) {
                $table->unique(['name', 'guard_name', 'team_id']);
            } else {
                $table->unique(['name', 'guard_name']);
            }
        });

        // 3. 角色-权限关联表（多对多）
        Schema::create($tableNames['role_has_permissions'], function (Blueprint $table) use ($tableNames) {
            $table->foreignId('permission_id')
                ->constrained($tableNames['permissions'])
                ->cascadeOnDelete(); // 删除权限时同步删除关联

            $table->foreignId('role_id')
                ->constrained($tableNames['roles'])
                ->cascadeOnDelete(); // 删除角色时同步删除关联

            $table->primary(['permission_id', 'role_id']); // 联合主键
        });

        // 4. 模型（如用户）-角色关联表
        Schema::create($tableNames['model_has_roles'], function (Blueprint $table) use ($tableNames, $columnNames, $teams) {
            $table->foreignId('role_id')
                ->constrained($tableNames['roles'])
                ->cascadeOnDelete();

            $table->string('model_type'); // 模型类名（如 App\Models\User）
            $table->unsignedBigInteger($columnNames['model_morph_key']); // 模型ID（如用户ID）
            $table->index([$columnNames['model_morph_key'], 'model_type'], 'model_has_roles_index');

            // 团队功能支持
            if ($teams) {
                $table->foreignId('team_id')->nullable()->index();
                $table->primary(['role_id', $columnNames['model_morph_key'], 'model_type', 'team_id']);
            } else {
                $table->primary(['role_id', $columnNames['model_morph_key'], 'model_type']);
            }
        });

        // 5. 模型（如用户）-权限关联表
        Schema::create($tableNames['model_has_permissions'], function (Blueprint $table) use ($tableNames, $columnNames, $teams) {
            $table->foreignId('permission_id')
                ->constrained($tableNames['permissions'])
                ->cascadeOnDelete();

            $table->string('model_type');
            $table->unsignedBigInteger($columnNames['model_morph_key']);
            $table->index([$columnNames['model_morph_key'], 'model_type'], 'model_has_permissions_index');

            // 团队功能支持
            if ($teams) {
                $table->foreignId('team_id')->nullable()->index();
                $table->primary(['permission_id', $columnNames['model_morph_key'], 'model_type', 'team_id']);
            } else {
                $table->primary(['permission_id', $columnNames['model_morph_key'], 'model_type']);
            }
        });
    }

    public function down()
    {
        $tableNames = config('permission.table_names');

        if (empty($tableNames)) {
            throw new \Exception('请先发布权限包配置文件：php artisan vendor:publish --tag="permission-config"');
        }

        // 按依赖顺序删除表（避免外键约束错误）
        Schema::dropIfExists($tableNames['model_has_permissions']);
        Schema::dropIfExists($tableNames['model_has_roles']);
        Schema::dropIfExists($tableNames['role_has_permissions']);
        Schema::dropIfExists($tableNames['roles']);
        Schema::dropIfExists($tableNames['permissions']);
    }
};
