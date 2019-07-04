<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const PAY_STATUS_PENDING = 'pending';
    const PAY_STATUS_PROCESSING = 'processing';
    const PAY_STATUS_SUCCESS = 'success';
    const PAY_STATUS_FAILED = 'failed';
    public static $orderStatusMap = [
        self::PAY_STATUS_PENDING => '待支付',
        self::PAY_STATUS_PROCESSING => '进行中',
        self::PAY_STATUS_SUCCESS => '已完成',
        self::PAY_STATUS_FAILED => '已取消',
    ];

    protected static function boot()
    {
        parent::boot();
        // 监听模型创建事件，在写入数据库之前触发
        static::creating(function ($model) {
            // 如果模型的 no 字段为空
            if (!$model->no) {
                // 调用 findAvailableNo 生成订单流水号
                $model->no = static::findAvailableNo();
                // 如果生成失败，则终止创建订单
                if (!$model->no) {
                    return false;
                }
            }
        });
    }

    public static function findAvailableNo()
    {
        // 订单流水号前缀
        $prefix = date('YmdHis');
        for ($i = 0; $i < 10; $i++) {
            // 随机生成 6 位的数字
            $no = $prefix . generate_code(6);
            // 判断是否已经存在
            if (!static::query()->where('no', $no)->exists()) {
                return $no;
            }
            usleep(100);
        }
        \Log::warning(sprintf('find order no failed'));

        return false;
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function getTotalAmountAttribute($value)
    {
        return $value / 100;
    }

    public function setTotalAmountAttribute($value)
    {
        $this->attributes['total_amount'] = $value * 100;
    }
}
