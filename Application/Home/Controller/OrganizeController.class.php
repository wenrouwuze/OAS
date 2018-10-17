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
    public function organize_recard_show(){
        /*左侧部门信息*/
        $this->assign('departmenttree',$this->departmenttree());
        /*右侧员工信息*/
        $where = 'em_id >0';
        $curr = empty($_GET['p']) ? '0' : $_GET['p'];
        $limits =   empty($_GET['limit']) ? '10' : $_GET['limit'];
        /*实例化User对象*/
        $User = M('employee');
        /* 查询满足要求的总记录数 */
        $count      = $User->where($where)->count();
        /*实例化分页类 传入总记录数和每页显示的记录数(10)*/
        $Page       = new \Think\Page($count,$limits);
        /*分页显示输出*/
        $show       = $Page->show();//
        /*进行分页数据查询 注意limit方法的参数要使用Page类的属性*/
        $list = $User->where($where)->order('em_id asc')->limit($Page->firstRow.','.$Page->listRows)->select();
        foreach($list as $key => $value){
              $department_id = empty($value['em_department_third']) ? empty($value['em_department_second']) ? $value['em_department_first'] : $value['em_department_second'] : $value['em_department_third'];
             $department = M('department')->field('department_boss')->where("department_id = '{$department_id}'")->find();
             if(empty($department['department_boss']) || $department['department_boss'] == 'first'){
                 $department['department_boss'] = '暂无';
             }
             $list[$key]['department_boss'] = $department['department_boss'];
        }
        $this->assign('curr',$curr);
        $this->assign('limits',$limits);
        $this->assign('count',$count);
        $this->assign('list',$list);// 赋值数据集
        $this->assign('page',$show);// 赋值分页输出
        $this->display(); // 输出模板
    }

    /*组织管理-导出*/
    public function organize_recard_export(){

        $export_data = M('department')->select();

        $array_title = array('部门名称','部门负责人','部门大小' );

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

}