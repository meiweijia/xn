<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HouseIn extends Model
{
    protected $casts = [
        'id_card_images' => 'array',
    ];

    protected $fillable = [
        'house_id',
        'user_id',//住户
        'rent',//租金
        'deposit',//押金
        'start_time',//起租日期
        'end_time',//截止日期
        'peoples',//入住人数
        'names',//全部入住人姓名
        'id_card_images',//身份证图片
        'phone',//签约人电话
        'status',//'验收 1已验收 0未验收
        'electric_number',//电表度数
        'cold_water_number',//冷水表度数
        'hot_water_number',//热水表度数
    ];

    protected static function boot()
    {
        parent::boot();
        // 监听模型创建事件，审核通过时，把用户信息和房间关联
        static::updated(function ($model) {
            if ($model->approve == 1) {
                House::query()->where('id', $model->house_id)->update([
                    'user_id' => $model->user_id
                ]);
                //注册成功 给予 guest 权限
                $user = User::query()->find($model->user_id);
                $user->assignRole('租客');
            }
        });
    }

    public function house()
    {
        return $this->belongsTo(House::class);
    }
}
