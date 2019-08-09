<?php

namespace App\Admin\Controllers;

use App\Models\House;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Input;

class HouseController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '房间';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $category_id = Input::get('category_id');

        $grid = new Grid(new House);

        $grid->model()->where('category_id', $category_id);

        $grid->column('id', __('Id'));
        $grid->column('number', __('Number'));
        $grid->column('category_id', __('Category id'));
        $grid->column('layout_id', __('Layout id'));
        $grid->column('user_id', __('User id'));
        $grid->column('rent', __('Rent'));
        $grid->column('peoples', __('Peoples'));
        $grid->column('status', __('Status'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

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
        $show = new Show(House::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('number', __('Number'));
        $show->field('category_id', __('Category id'));
        $show->field('layout_id', __('Layout id'));
        $show->field('user_id', __('User id'));
        $show->field('rent', __('Rent'));
        $show->field('peoples', __('Peoples'));
        $show->field('status', __('Status'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new House);

        $form->number('number', __('Number'));
        $form->number('category_id', __('Category id'));
        $form->number('layout_id', __('Layout id'));
        $form->number('user_id', __('User id'));
        $form->number('rent', __('Rent'));
        $form->switch('peoples', __('Peoples'));
        $form->switch('status', __('Status'))->default(1);

        return $form;
    }
}
