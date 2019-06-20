<?php

namespace App\Admin\Controllers;

use App\Models\Category;
use App\Models\Layout;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class LayoutController extends Controller
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
            ->header('户型列表')
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
            ->header('户型详情')
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
            ->header('户型编辑')
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
            ->header('新增')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Layout);

        $grid->id('Id');
        $grid->category()->name('楼栋');
        $grid->property('物业');
        $grid->name('户型');
        $grid->rent('租金');
        $grid->image('封面图')->image();
        $grid->created_at('添加时间');

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
        $show = new Show(Layout::findOrFail($id));

        $show->id('Id');
        $show->category_id('楼栋')->as(function ($value) {
            return Category::getName($value);
        });
        $show->property('物业');
        $show->name('户型');
        $show->rent('租金');
        $show->image('封面图')->image();;
        $show->carousel('轮播图')->image();;
        $show->description('描述');
        $show->created_at('添加时间');
        $show->updated_at('更新时间');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Layout);

        $form->select('category_id', '楼栋')->options(Category::query()->pluck('name', 'id'));
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

        $form->hasMany('houses', '房间列表', function (Form\NestedForm $form) {
            $form->text('number', '房号')->rules('required');
            $form->decimal('rent', '租金(默认继承自户型)');
            $form->number('peoples', '入住人数')->rules('required');
            $form->select('status', '可入住')->options([
                '否',
                '是',
            ])->rules('required|numeric');
        });

        return $form;
    }
}
