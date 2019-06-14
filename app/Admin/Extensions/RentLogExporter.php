<?php

namespace App\Admin\Extensions;

use Encore\Admin\Grid\Exporters\ExcelExporter;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class RentLogExporter extends ExcelExporter implements WithStrictNullComparison
{
    protected $fileName = '水电费结算.xlsx';

    protected $columns = [
        'property' => '物业',
        'house_number' => '房号',
        'house_rent' => '房费',
        'last_electric_number' => '上月电表(度)',
        'electric_number' => '本月电表',
        'electric_cost' => '电费(元)',
        'last_cold_water_number' => '上月冷水表(m3)',
        'cold_water_number' => '本月冷水表',
        'last_hot_water_number' => '上月热水表',
        'hot_water_number' => '本月热水表',
        'water_cost' => '水费',
        'other_cost' => '其他费用',
        'total_cost' => '总费用合计(元)',
        'status' => '状态',
    ];
}
