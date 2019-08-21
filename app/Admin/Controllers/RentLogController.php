<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\Form\Form;
use App\Admin\Extensions\Grid\Tools\SendTmpMsg;
use App\Admin\Extensions\RentLogExporter;
use App\Models\House;
use App\Models\Region;
use App\Models\RentLog;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Overtrue\LaravelWeChat\Facade as Wechat;

class RentLogController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '水电费';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new RentLog);
        $grid->model()->orderBy('created_at', 'desc');

        $grid->house()->number('房号');
        $grid->house_rent('房费');
        $grid->last_electric_number('上月电表(度)');
        $grid->electric_number('本月电表');
        $grid->electric_cost('电费(元)');
        $grid->last_cold_water_number('上月冷水表(m3)');
        $grid->cold_water_number('本月冷水表');
        $grid->last_hot_water_number('上月热水表');
        $grid->hot_water_number('本月热水表');
        $grid->water_cost('水费');
        $grid->other_cost('其他费用');
        $grid->total_cost('总费用合计(元)');
        $grid->status('状态')->display(function ($v) {
            return $v ? '已发送' : '未发送';
        })->sortable();

        // filter($callback)方法用来设置表格的简单搜索框
        $grid->filter(function ($filter) {
            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            // 设置created_at字段的范围查询
            $filter->equal('house_number', '房间号');
        });

        $grid->exporter(new RentLogExporter());
        $grid->disableFilter();
        $grid->disableColumnSelector();
        $grid->tools(function (Grid\Tools $tools) {
            $tools->append(new SendTmpMsg());
        });

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(RentLog::findOrFail($id));

        $show->id('Id');
        $show->property_id('Property id');
        $show->house_id('House id');
        $show->house_number('House number');
        $show->house_rent('House rent');
        $show->last_electric_number('Last electric number');
        $show->electric_number('Electric number');
        $show->electric_cost('Electric cost');
        $show->last_cold_water_number('Last cold water number');
        $show->cold_water_number('Cold water number');
        $show->last_hot_water_number('Last hot water number');
        $show->hot_water_number('Hot water number');
        $show->water_cost('Water cost');
        $show->other_cost('Other cost');
        $show->total_cost('Total cost');
        $show->status('Status');
        $show->created_at('Created at');
        $show->updated_at('Updated at');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new RentLog);

        $form->select('region_id', '区域')
            ->options(Region::query()->pluck('name', 'id'))
            ->load('category_id', '/api/admin_api/categories', 'id', 'name');

        $form->select('category_id', '楼栋')
            ->load('house_id', '/api/admin_api/houses', 'id', 'number');

        $form->select('house_id', '房号');

        $form->decimal('last_electric_number', '上月电表(度)');
        $form->decimal('electric_number', '本月电表')->rules('gte:last_electric_number', [
            'gte' => '本月电表必须大于等于上月电表'
        ]);
        $form->decimal('last_cold_water_number', '上月冷水表(m3)');
        $form->decimal('cold_water_number', '本月冷水表')->rules('gte:last_cold_water_number', [
            'gte' => '本月冷水表必须大于等于上月冷水表'
        ]);
        $form->decimal('last_hot_water_number', '上月热水表');
        $form->decimal('hot_water_number', '本月热水表')->rules('gte:last_hot_water_number', [
            'gte' => '本月热水表必须大于等于上月热水表'
        ]);
        $form->decimal('other_cost', '其他费用');

        $form->saving(function (Form $form) {
            $house = House::query()->with('user:id,gzh_open_id')->find($form->house_id);
            $form->model()->user_id = $house->user->id;
            $form->model()->gzh_open_id = $house->user->gzh_open_id;
        });
        return $form;
    }

    /**
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     */
    public function sendTmpMsg(): void
    {
        $rentLogs = RentLog::query()->where('status', 0)->get();
        $app = Wechat::officialAccount();
        foreach ($rentLogs as $log) {
            $app->template_message->send([
                'touser' => $log->gzh_open_id,
                'template_id' => '5A2QS6xExcNtQVAUHAWDabdfgAoRL5F-ITFSCRxSKks',
                'miniprogram' => [
                    'appid' => config('wechat.default.app_id'),
                    'pagepath' => 'pages/order/payHouse',
                ],
                'data' => [
                    'first' => date('m') . '月份房租提醒！',
                    'keyword1' => $log['house_rent'],
                    'keyword2' => $log['other_cost'],
                    'keyword3' => $log['electric_cost'],
                    'keyword4' => $log['water_cost'],
                    'keyword5' => $log['total_cost'],
                    'remark' => '欢迎使用本系统，有问题请咨询人工！',
                ],
            ]);
            $log->status = 1;
            $log->save();
        }
    }
}
