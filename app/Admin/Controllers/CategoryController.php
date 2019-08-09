<?php

namespace App\Admin\Controllers;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Models\Layout;
use App\Models\Region;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class CategoryController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '楼栋';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Category);

        $grid->id('Id');
        $grid->region()->name('地区');
        $grid->name('名称');
        $grid->column('region.address', '地址');
        $grid->phone('电话');
        $grid->type('类型')->display(function ($value) {
            return Category::$typeMap[$value];
        });
        $grid->created_at('添加时间');

        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableView();
            $url = route('admin.categories.show', $actions->getKey());
            $actions->prepend("<a href=$url><i class='fa fa-home'></i></a>");
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
        $show = new Show(Category::findOrFail($id));

        //$show->id('Id');
        $show->region_id('地区')->as(function ($value) {
            return Region::getName($value);
        });

        $show->name('名称');

        $show->type('类型')->as(function ($value) {
            return Category::$typeMap[$value];
        });
        $show->created_at('添加时间');
        $show->updated_at('更新时间');

        $show->layouts('户型列表', function (Grid $grid) {

            $grid->resource('/admin/layouts');

            $grid->id('Id');
            $grid->property('物业');
            $grid->name('户型');
            $grid->rent('租金');
            $grid->image('封面图')->image();
            $grid->created_at('添加时间');

            $grid->disableTools();
            $grid->disableCreateButton();
            $grid->disableExport();

            $grid->actions(function (Grid\Displayers\Actions $actions){
                $actions->disableView();
                $actions->disableDelete();
                $actions->disableEdit();
                $url = route('admin.layouts.edit', $actions->getKey());
                $actions->prepend("<a href=$url>房间管理</a>");
            });
        });

        //$show->houses('房间列表',function (Grid $grid){
        //    $grid->resource('/admin/houses');
        //
        //    $grid->column('id', __('Id'));
        //    $grid->column('number', '房间号');
        //    $grid->column('layout.name', __('Layout id'));
        //    $grid->column('user_id', __('User id'));
        //    $grid->column('rent', __('Rent'));
        //    $grid->column('peoples', __('Peoples'));
        //    $grid->column('status', __('Status'));
        //    $grid->column('created_at', __('Created at'));
        //
        //    $grid->disableTools();
        //    $grid->disableCreateButton();
        //    $grid->disableExport();
        //    $grid->actions(function (Grid\Displayers\Actions $actions){
        //        $actions->disableView();
        //        $actions->disableEdit();
        //    });
        //});

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Category);

        $form->select('region_id', '地区')->options(Region::query()->pluck('name', 'id')->toArray());
        $form->text('name', '名称');
        $form->mobile('phone', '电话');
        $form->select('type', '类型')->options(Category::$typeMap);
        $form->multipleSelect('users', '网格员')->options(
            User::role('网格员')->pluck('name', 'id')//每栋楼可以设置网格员
        );

        $form->hasMany('layouts', '户型', function (Form\NestedForm $form) {
            $form->text('property', '物业');
            $form->text('name', '户型');
            $form->decimal('rent', '租金');
            $form->image('image', '封面图')
                ->removable()
                ->uniqueName();
            $form->multipleImage('carousel', '轮播图')
                ->uniqueName()
                ->removable()
                ->sortable();
            $form->textarea('description', '描述');
        });

        return $form;
    }
}
