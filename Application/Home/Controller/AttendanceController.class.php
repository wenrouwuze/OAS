<?php

namespace Home\Controller;

use Think\Controller;

class AttendanceController extends BaseController
{
    /*考勤管理-index*/
    public function index()
    {
        $this->accessexit();
    }

    /*考勤管理-考勤记录*/
    public function attendance_record_show()
    {
        // 实例化User对象
        $model = M('attendance');
        $curr = empty($_GET['p']) ? '0' : $_GET['p'];
        $limits = empty($_GET['limit']) ? '10' : $_GET['limit'];
        // 查询满足要求的总记录数
        $count = count($model->where('att_id > 0')->group('FROM_UNIXTIME(att_import_time,\'%Y-%m\')')->select());
        // 实例化分页类 传入总记录数和每页显示的记录数(25)
        $Page = new \Think\Page($count, 10);
        $show = $Page->show();// 分页显示输出
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $list = $model->field(" FROM_UNIXTIME(att_import_time,'%Y-%m') as s_month")->where('att_id > 0')->group('s_month')->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $this->assign('curr', $curr);
        $this->assign('limits', $limits);
        $this->assign('count', $count);
        $this->assign('list', $list);// 赋值数据集
        $this->assign('page', $show);// 赋值分页输出
        $this->display(); // 输出模板
    }

    /*考勤管理-上传文件*/
    public function attendance_record_uoload()
    {
        /*上传根目录*/
        $root_path = './Upload/';
        /*上传子目录*/
        $save_path = 'attendance/';
        /*上传后文件名称*/
        $file_name = rtrim($save_path, '/') . '_import_' . date('YmdHis');
        if (!file_exists($root_path . $save_path)) {
            mkdir($root_path . $save_path, 0777, true);
        }
        //$result = $this->base_upload($file_name,$save_path,$root_path);
        //$read_path = $root_path.'/'.$result['info']['file']['savepath'].$result['info']['file']['savename'];
        $read_path = "./Upload//attendance/2018-09-29/attendance_import_20180929111837.xls";
        /*读取Excel文件内容*/
        $Excelarr = $this->base_import($read_path);
        $count = 1;
        foreach ($Excelarr as $key => $value) {
            if ($key == 1) {
                continue;
            }
            /*考勤号码*/
            $data['att_number'] = $value['A'];
            //姓名
            $data['att_username'] = $value['B'];
            //时间
            $data['att_times'] = strtotime($value['C']);
            //签到时间
            $data['att_sign_in'] = $value['D'];
            //签退时间
            $data['att_sign_out'] = $value['E'];
            //迟到时间
            $data['att_late_times'] = $value['F'];
            //早退时间
            $data['att_early_retreat'] = $value['G'];
            //部门
            $data['att_department_name'] = $value['H'];
            //平时
            $data['att_peacetime'] = $value['I'];
            //周末
            $data['att_weekend'] = $value['J'];
            //考勤表对应的时间
            $data['att_import_time'] = strtotime($_POST['t']);
            //数据创建时间
            $data['att_create_time'] = time();
            $insert_data[] = $data;
        }
        $model = M('attendance');
        $where_delete = strtotime($_POST['t']);
        /*执行添加之前,先清空表*/
        $result = array();
        $model->where("att_import_time = '{$where_delete}'")->delete();
        if ($model->addAll($insert_data)) {
            $result['status'] = 'success';
            $result['describe'] = '数据添加成功';
        } else {
            $result['status'] = 'error';
            $result['describe'] = '数据添加失败,请联系管理员';
        }
        echo json_encode($result);
    }

    /*考勤管理-下载文件*/
    public function attendance_record_download()
    {
        if (!empty($_GET['times'])) {
            $timestamp = $_GET['times'];
            if ($timestamp == 'all') {
                $export_data = M('attendance')->order('att_import_time asc')->select();
            } else {
                $export_data = M('attendance')->where("FROM_UNIXTIME(att_import_time,'%Y-%m') = '{$timestamp}'")->order('att_number asc')->select();
            }
            $array_title = array('序号', '姓名', '日期', '签到时间', '签退时间', '迟到时间', '早退时间', '部门', '平日', '周末');
            /*记录导出时间*/
            $export_time = date('YmdHis');
            $filename = "考勤管理-考勤记录-" . $export_time;
            $count = 1;
            $array_data = array();
            foreach ($export_data as $key => $value) {
                //考勤号码
                $array_data[$count][] = $value['att_number'];
                //姓名
                $array_data[$count][] = $value['att_username'];
                //日期
                $array_data[$count][] = date('Y/m',$value['att_times']);
                //签到时间
                $array_data[$count][] = $value['att_sign_in'];
                //签退时间
                $array_data[$count][] = $value['att_sign_out'];
                //迟到时间
                $array_data[$count][] = $value['att_late_times'];
                //早退时间
                $array_data[$count][] = $value['att_early_retreat'];
                //部门
                $array_data[$count][] = $value['att_department_name'];
                //平日
                $array_data[$count][] = $value['att_peacetime'];
                //周末
                $array_data[$count][] = $value['att_weekend'];
                $count++;
            }
            $this->base_export($array_title, $array_data, $filename, './', true);
        } else {
            $this->accessexit();
        }
    }

}