<?php

namespace Home\Controller;

use Think\Controller;

class MainController extends BaseController
{
    /*工作台-index*/
    public function index()
    {
        $this->accessexit();
    }

    /*工作台-页面展示*/
    public function main_workplace_show()
    {
        /*本月生日的员工*/
        $this->assign('employee_birthday',$this->main_employee_birthday(2));
        /*半月内转正的员工*/
        $this->assign("employee_formal",$this->main_employee_formal_half_a_month(2));
        /*两个月内合同到期的月供*/
        $this->assign("employee_end",$this->main_employee_end(2));
        /*员工信息等待审核*/
        $this->assign("employee_waitcheck",$this->main_employee_check(2));
        $this->display();
    }

    /*本月生日的员工*/
    public function main_employee_birthday($postion = 1)
    {
        $model = M('employee');
        $date = date('Y-m',time());

        $curr = empty($_GET['p']) ? '0' : $_GET['p'];
        $limits = empty($_GET['limit']) ? '10' : $_GET['limit'];
        /*工作台请求的数据*/
        if($postion == 2){
            $number = $model->field('em_id')->join('osa_department on em_department_first = department_id')->where("FROM_UNIXTIME(em_birthday,'%Y-%m') = '{$date}'")->count();
            return $number;
        }
        // 查询满足要求的总记录数
        $count      = $model->field('em_id')->join('osa_department on em_department_first = department_id')->where("FROM_UNIXTIME(em_birthday,'%Y-%m') = '{$date}'")->count();

        // 实例化分页类 传入总记录数和每页显示的记录数(25)
        $Page       = new \Think\Page($count,10);
        // 分页显示输出
        $show       = $Page->show();
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $list = $model->join('osa_department on em_department_first = department_id')->where("FROM_UNIXTIME(em_birthday,'%Y-%m') = '{$date}'")->order('em_id desc')->limit($Page->firstRow.','.$Page->listRows)->select();

        $this->assign('curr', $curr);
        $this->assign('limits', $limits);
        $this->assign('count', $count);
        // 赋值数据集

        $this->assign('list',$list);

        // 赋值分页输出
        $this->assign('page',$show);
        // 输出模板
        $this->display();
    }

    /*工作台-半个月内转正的员工*/
    public function main_employee_formal_half_a_month($postion = 1)
    {
        $model = M('employee');
        $timestamp = time();

        $curr = empty($_GET['p']) ? '0' : $_GET['p'];
        $limits = empty($_GET['limit']) ? '10' : $_GET['limit'];
        /*工作台请求的数据*/
        if($postion == 2){
            $number = $model->field('em_id')->join('osa_department on em_department_first = department_id')->where("(em_formaltime -{$timestamp})/3600/24 < 15 and em_workstatus = 1")->count();
            return $number;
        }
        // 查询满足要求的总记录数
        $count      = $model->field('em_id')->join('osa_department on em_department_first = department_id')->where("(em_formaltime -{$timestamp})/3600/24 < 15 and em_workstatus = 1")->count();

        // 实例化分页类 传入总记录数和每页显示的记录数(25)
        $Page       = new \Think\Page($count,10);
        // 分页显示输出
        $show       = $Page->show();
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $list = $model->join('osa_department on em_department_first = department_id')->where("(em_formaltime -{$timestamp})/3600/24 < 15 and em_workstatus = 1")->order('em_id desc')->limit($Page->firstRow.','.$Page->listRows)->select();

        $this->assign('curr', $curr);
        $this->assign('limits', $limits);
        $this->assign('count', $count);
        // 赋值数据集

        $this->assign('list',$list);

        // 赋值分页输出
        $this->assign('page',$show);
        // 输出模板
        $this->display();
    }

    /*工作台-两个月内合同到期的员工*/
    public function main_employee_end($postion = 1)
    {
        $model = M('employee');
        $timestamp = time();

        $curr = empty($_GET['p']) ? '0' : $_GET['p'];
        $limits = empty($_GET['limit']) ? '10' : $_GET['limit'];
        /*工作台请求的数据*/
        if($postion == 2){
            $number = $model->field('em_id')->join('osa_department on em_department_first = department_id')->where("(em_endtime -{$timestamp})/3600/24 < 60 and em_workstatus != 4")->count();
            return $number;
        }
        // 查询满足要求的总记录数
        $count      = $model->field('em_id')->join('osa_department on em_department_first = department_id')->where("(em_endtime -{$timestamp})/3600/24 < 30 and em_workstatus != 4")->count();


        // 实例化分页类 传入总记录数和每页显示的记录数(25)
        $Page       = new \Think\Page($count,10);
        // 分页显示输出
        $show       = $Page->show();
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $list = $model->join('osa_department on em_department_first = department_id')->where("(em_endtime -{$timestamp})/3600/24 < 30 and em_workstatus != 4")->order('em_id desc')->limit($Page->firstRow.','.$Page->listRows)->select();

        $this->assign('curr', $curr);
        $this->assign('limits', $limits);
        $this->assign('count', $count);
        // 赋值数据集
        $this->assign('list',$list);
        // 赋值分页输出
        $this->assign('page',$show);
        // 输出模板
        $this->display();
    }

    /*工作台-员工信息查询*/
    public function main_employee_check($postion = 1)
    {
        if ($postion == '2') {

            return 0;
        }

        $this->display();
    }
}