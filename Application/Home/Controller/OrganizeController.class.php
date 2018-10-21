<?php

namespace Home\Controller;
use Think\Controller;

class OrganizeController extends BaseController
{
    /*组织管理-index*/
    public function index()
    {
        $this->accessexit();
    }

    /*组织管理-组织架构*/
    public function organize_recard_show()
    {
        /*左侧部门信息*/
        $this->assign('departmenttree', $this->departmenttree());
        /*右侧员工信息*/
        $where = 'em_id >0';
        $curr = empty($_GET['p']) ? '0' : $_GET['p'];
        $limits = empty($_GET['limit']) ? '10' : $_GET['limit'];
        /*实例化User对象*/
        $User = M('employee');
        /* 查询满足要求的总记录数 */
        $count = $User->where($where)->count();
        /*实例化分页类 传入总记录数和每页显示的记录数(10)*/
        $Page = new \Think\Page($count, $limits);
        /*分页显示输出*/
        $show = $Page->show();//
        /*进行分页数据查询 注意limit方法的参数要使用Page类的属性*/
        $list = $User->where($where)->order('em_id asc')->limit($Page->firstRow . ',' . $Page->listRows)->select();
        foreach ($list as $key => $value) {
            $department_id = empty($value['em_department_third']) ? empty($value['em_department_second']) ? $value['em_department_first'] : $value['em_department_second'] : $value['em_department_third'];
            $department = M('department')->field('department_boss')->where("department_id = '{$department_id}'")->find();
            if (empty($department['department_boss']) || $department['department_boss'] == 'first') {
                $department['department_boss'] = '暂无';
            }
            $list[$key]['department_boss'] = $department['department_boss'];
        }
        $this->assign('curr', $curr);
        $this->assign('limits', $limits);
        $this->assign('count', $count);
        $this->assign('list', $list);// 赋值数据集
        $this->assign('page', $show);// 赋值分页输出
        $this->display(); // 输出模板
    }

    /*组织管理-导出*/
    public function organize_recard_export()
    {

        $export_data = M('department')->select();

        $array_title = array('部门名称', '部门负责人', '部门大小');

        /*记录导出时间*/
        $export_time = date('YmdHis');
        $filename = "组织管理-组织架构-" . $export_time;
        $count = 1;
        $array_data = array();
        foreach ($export_data as $key => $value) {
            //部门名称
            $array_data[$count][] = $value['department_name'];
            $array_data[$count][] = $value['department_boss'] == 'first' ? '暂无' : $value['department_boss'];
            $array_data[$count][] = $value['department_size'];
            $count++;
        }
        $this->base_export($array_title, $array_data, $filename, './', true);
    }

    /*组织管理-统计各个部门人数*/
    public function organize_recard_department_size()
    {
        $model = M('employee');
        /*三级部门统计人数*/
        $department_third_id = $model->field('em_department_third')->group('em_department_third')->select();
        foreach ($department_third_id as $key => $value) {
            if (empty($value['em_department_third'])) {
                continue;
            }
            $department_third_size = $model->field('em_id')->where("em_department_third = '{$value['em_department_third']}'")->count();
            $data['department_size'] = $department_third_size['tp_count '];
            $data['department_id'] = $value['em_department_third'];
            if (M('department')->save($data)) {
                echo 1;
            } else {
                echo 2;
            }
        }
        /*二级部门人数统计*/
        $department_second_id = $model->field('em_department_second')->group('em_department_second')->select();
        foreach ($department_second_id as $key => $value) {
            if (empty($value['em_department_second'])) {
                continue;
            }
            $department_second_size = $model->field('em_id')->where("em_department_second = '{$value['em_department_second']}'")->count();
            $data['department_size'] = $department_second_size['tp_count '];
            $data['department_id'] = $value['em_department_second'];
            if (M('department')->save($data)) {
                echo 1;
            } else {
                echo 2;
            }
        }
        /*一级部门人数统计*/
        $department_first_id = $model->field('em_department_first')->group('em_department_first')->select();
        foreach ($department_first_id as $key => $value) {
            if (empty($value['em_department_first'])) {
                continue;
            }
            $department_first_size = $model->field('em_id')->where("em_department_first = '{$value['em_department_first']}'")->count();
            $data['department_size'] = $department_first_size['tp_count '];
            $data['department_id'] = $value['em_department_first'];
            if (M('department')->save($data)) {
                echo 1;
            } else {
                echo 2;
            }
        }
    }

    /*组织管理-根据搜索值搜索数据*/
    public function organize_recard_search(){
        if(!I('post.query_name')){
            $this->accessexit();
        }
        $query_name = I('post.query_name');
        $model = M('employee');
        $list = $model->join('osa_department on (osa_employee.em_department_first = osa_department.department_id
	OR osa_employee.em_department_second = osa_department.department_id
	OR osa_employee.em_department_third = osa_department.department_id)')->where("em_username = '{$query_name}' or department_name = '{$query_name}'")->group('em_id')->select();
        $this->assign('list', $list);// 赋值数据集
        $this->display();
    }
    /*组织管理-旺盛了。  */
}