<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HouseOut extends Model
{
    protected $casts = [
        'images' => 'array',
        'bedroom' => 'array',
    ];

    protected $fillable = [
        'house_id',
        'bathroom',//卫浴区 1正常 2有损 3有污渍 4严重损坏
        'parlour',//客厅区 1正常 2有损 3有污渍 4严重损坏
        'kitchen',//厨房区 1正常 2有损 3有污渍 4严重损坏
        'bedroom',//卧室区1 1正常 2有损 3有污渍 4严重损坏
        'images',//照片
    ];

    protected static function boot()
    {
        parent::boot();
        // 监听模型创建事件，审核通过时，把用户信息和房间关联
        static::updated(function ($model) {
            if ($model->approve == 1) {
                House::query()->where('id', $model->house_id)->update([
                    'user_id' => null,
                    'status' => 1
                ]);
                //注册成功 给予 guest 权限
                $user = User::query()->find($model->user_id);
                $user->syncRoles('游客');
            }
        });
    }

    public function house()
    {
        return $this->belongsTo(House::class);
    }
}
