<?php

namespace App\Admin\Controllers;

use App\Model\RegModel;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

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
            ->header('Index')
            ->description('description')
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
        $grid = new Grid(new RegModel);

        $grid->id('Id');
        $grid->pusername('企业名称');
        $grid->username('法人名称');
        $grid->number('税务号');
        $grid->pubnum('对公账号');
        $grid->phoon('执照')->image('/storage/');
        $grid->appid('Appid');
        $grid->key('Key');
        $grid->status('审核')->display(function($status){
            if($status==1){
                return '审核通过';
            }else{
                return '审核未通过
                ';
            }
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
        $show = new Show(RegModel::findOrFail($id));

        $show->id('Id');
        $show->pusername('Pusername');
        $show->username('Username');
        $show->number('Number');
        $show->pubnum('Pubnum');
        $show->phoon('Phoon');
        $show->appid('Appid');
        $show->key('Key');
        $show->status('Status');
        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new RegModel);

        $form->text('pusername', 'Pusername');
        $form->text('username', 'Username');
        $form->number('number', 'Number');
        $form->number('pubnum', 'Pubnum');
        $form->text('phoon', 'Phoon');
        $form->text('appid', 'Appid');
        $form->text('key', 'Key');
        $form->text('status','status');
        return $form;
    }
}
