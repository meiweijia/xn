<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentLog extends Model
{
    protected $fillable = [
        'house_number',
        'house_rent',
        'last_electric_number',
        'electric_number',
        'electric_cost',
        'last_cold_water_number',
        'cold_water_number',
        'last_hot_water_number',
        'hot_water_number',
        'water_cost',
        'other_cost',
        'total_cost',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();
        // 监听模型创建事件，在写入数据库之前触发
        static::saving(function ($model) {
            $model->house_rent = House::getRent($model->house_id);

            // 计算电费 (本月电表度数-上月电表度数) * 电费单价  电费单价从后台配置读取
            $model->electric_cost = ($model->electric_number - $model->last_electric_number) * config('electric_unit_price');

            // 计算水费费 (本月冷水度数-上月冷水度数) * 冷水单价 + (本月热水度数-上月热水度数) * 热水单价  水费单价从后台配置读取
            $model->water_cost = ($model->cold_water_number - $model->last_cold_water_number) * config('cold_water_unit_price') +
                ($model->hot_water_number - $model->last_hot_water_number) * config('hot_water_unit_price');

            //计算总费用(房费+电费+水费+其他费用)
            $model->total_cost = $model->house_rent + $model->electric_cost + $model->water_cost + $model->other_cost;
        });
    }

    public function house()
    {
        return $this->belongsTo(House::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function getHouseRentAttribute($value)
    {
        return $value / 100;
    }

    public function setHouseRentAttribute($value)
    {
        $this->attributes['house_rent'] = $value * 100;
    }

    public function getElectricCostAttribute($value)
    {
        return $value / 100;
    }

    public function setElectricCostAttribute($value)
    {
        $this->attributes['electric_cost'] = $value * 100;
    }

    public function getWaterCostAttribute($value)
    {
        return $value / 100;
    }

    public function setWaterCostAttribute($value)
    {
        $this->attributes['water_cost'] = $value * 100;
    }

    public function getOtherCostAttribute($value)
    {
        return $value / 100;
    }

    public function setOtherCostAttribute($value)
    {
        $this->attributes['other_cost'] = $value * 100;
    }

    public function getTotalCostAttribute($value)
    {
        return $value / 100;
    }

    public function setTotalCostAttribute($value)
    {
        $this->attributes['total_cost'] = $value * 100;
    }
}
