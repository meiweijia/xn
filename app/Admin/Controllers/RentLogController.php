<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\RentLogExporter;
use App\Models\Region;
use App\Models\RentLog;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class RentLogController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     *
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('水电费结算')
            ->description('列表')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     *
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            ->description('description')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     *
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Edit')
            ->description('description')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     *
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('水电费结算')
            ->body($this->form());
    }

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
        $form->ignore(['region', 'category', 'layout']);//忽略的字段

        $form->select('region', '区域')
            ->options(Region::query()->pluck('name', 'id'))
            ->load('category', '/api/admin_api/categories', 'id', 'name');
        $form->select('category', '楼栋')
            ->load('layout', '/api/admin_api/layouts', 'id', 'name');
        $form->select('layout', '户型')
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
        return $form;
    }
}
