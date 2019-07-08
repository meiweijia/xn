<?php

namespace App\Admin\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('用户管理')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
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
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User);

        $grid->id('Id');
        $grid->name('姓名');
        $grid->tel('电话');
        $grid->avatar('头像')->image();
        $grid->type('Type')->display(function ($value) {
            return $value == 1 ? '员工' : '租户';
        });
        $grid->roles('角色')->display(function ($roles) {
            $roles = array_map(function ($role) {
                return "<span class='label label-success'>{$role['name']}</span>";
            }, $roles);

            return join('&nbsp;', $roles);
        });
        $grid->created_at('创建时间');

        $grid->actions(function ($actions) {
            $actions->disableView();
        });
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(User::findOrFail($id));

        $show->id('Id');
        $show->name('Name');
        $show->tel('Tel');
        $show->email('Email');
        $show->email_verified_at('Email verified at');
        $show->password('Password');
        $show->api_token('Api token');
        $show->open_id('Open id');
        $show->avatar('Avatar');
        $show->remember_token('Remember token');
        $show->type('Type');
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
        $form = new Form(new User);
        $form->ignore(['role']);

        $form->text('name', '姓名');
        $form->text('tel', '电话');
        $form->password('password', '密码');
        $form->image('avatar', '头像');
        $form->select('type', '类型')->options([
            1 => '租户',
            2 => '员工'
        ])->default(1);
        $form->multipleSelect('roles', '权限')->options(Role::all()->pluck('name', 'id'));

        $form->disableViewCheck();
        $form->tools(function (Form\Tools $tools){
            $tools->disableView();
        });

        $form->saving(function (Form $form) {
            if ($form->password && $form->model()->password != $form->password) {
                $form->password = bcrypt($form->password);
            }
        });
        return $form;
    }
}
