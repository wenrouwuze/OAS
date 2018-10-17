<?php

namespace Home\Controller;

use Think\Controller;

class SocialSecurityController extends BaseController
{
    /*社保管理-index*/
    public function index()
    {

    }

    /*社保管理-社保记录*/
    public function socialsecurity_record_show()
    {
        // 实例化User对象
        $model = M('social_security');
        $curr = empty($_GET['p']) ? '0' : $_GET['p'];
        $limits = empty($_GET['limit']) ? '10' : $_GET['limit'];
        // 查询满足要求的总记录数
        $count = count($model->where('s_id > 0')->group('FROM_UNIXTIME(s_import_time,\'%Y-%m\')')->select());
        // 实例化分页类 传入总记录数和每页显示的记录数(25)
        $Page = new \Think\Page($count, 10);
        $show = $Page->show();// 分页显示输出
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $list = $model->field(" FROM_UNIXTIME(s_import_time,'%Y-%m') as s_month")->where('s_id > 0')->group('s_month')->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $this->assign('curr', $curr);
        $this->assign('limits', $limits);
        $this->assign('count', $count);
        $this->assign('list', $list);// 赋值数据集
        $this->assign('page', $show);// 赋值分页输出
        $this->display(); // 输出模板
    }

    /*社保管理-导出考勤记录*/
    public function socialsecurity_record_export()
    {
        if (!empty($_GET['times'])) {
            $timestamp = $_GET['times'];
            if ($timestamp == 'all') {
                $export_data = M('social_security')->order('s_import_time asc')->select();
            } else {
                $export_data = M('social_security')->where("FROM_UNIXTIME(s_import_time,'%Y-%m') = '{$timestamp}'")->select();
            }
            $array_title = array('序号', '姓名', '一级部门', '二级部门', '三级部门', '岗位', '考勤地区', '社保地区', '养老基数', '养老单位', '养老个人', '失业基数', '失业单位', '失业个人', '工伤基数', '工伤单位', '门诊基数', '门诊单位', '门诊个人', '住院基数', '住院单位', '住院个人', '生育基数', '生育单位', '合计', '单位承担', '个人承担', '公积金地区', '公积金基数', '单位比例', '单位承担', '个人比例', '个人承担', '公积金合计', '社保公积金单位合计', '社保公积金个人合计', '费用归属');
            /*记录导出时间*/
            $export_time = date('YmdHis');
            $filename = "社保管理-社保记录-" . $export_time;
            $count = 1;
            $array_data = array();
            foreach ($export_data as $key => $value) {
                //序号
                $array_data[$count][] = $count;
                //用户姓名
                $array_data[$count][] = $value['e_username'];
                //一级部门
                if (!empty($value['s_department_first'])) {
                    $department_id = explode('-', $value['s_department_first'])[1];
                    $department_first = M('department')->field('department_name')->where("department_id = '{$department_id}'")->find();
                    if (!empty($department_first)) {
                        $array_data[$count][] = $department_first['department_name'];
                    } else {
                        $array_data[$count][] = '暂无';
                    }
                } else {
                    $array_data[$count][] = '暂无';
                }
                //二级部门
                if (!empty($value['s_department_second'])) {
                    $department_id = explode('-', $value['s_department_second'])[1];
                    $department_second = M('department')->field('department_name')->where("department_id = '{$department_id}'")->find();
                    if (!empty($department_second)) {
                        $array_data[$count][] = $department_second['department_name'];
                    } else {
                        $array_data[$count][] = '暂无';
                    }
                } else {
                    $array_data[$count][] = '暂无';
                }
                //三级部门
                if (!empty($value['s_department_third'])) {
                    $department_id = explode('-', $value['s_department_third'])[1];
                    $department_third = M('department')->field('department_name')->where("department_id = '{$department_id}'")->find();
                    if (!empty($department_third)) {
                        $array_data[$count][] = $department_second['department_name'];
                    } else {
                        $array_data[$count][] = '暂无';
                    }
                } else {
                    $array_data[$count][] = '暂无';
                }
                //岗位
                $array_data[$count][] = $value['s_station'];
                //考勤地区
                $array_data[$count][] = $value['s_attendance_area'];
                //社保地区
                $array_data[$count][] = $value['s_social_area'];
                //养老基数
                $array_data[$count][] = $value['s_endowment_base_number'];
                //养老单位
                $array_data[$count][] = $value['s_endowment_company'];
                //养老个人
                $array_data[$count][] = $value['s_endownent_personal'];
                //失业基数
                $array_data[$count][] = $value['s_worklost_base_number'];
                //失业单位
                $array_data[$count][] = $value['s_worklost_company'];
                //失业个人
                $array_data[$count][] = $value['s_worklost_personal'];
                //工伤基数
                $array_data[$count][] = $value['s_workinjury_base_number'];
                //工伤单位
                $array_data[$count][] = $value['s_workinjury_company'];
                //门诊基数
                $array_data[$count][] = $value['s_outpatient_base_number'];
                //门站单位
                $array_data[$count][] = $value['s_outpatient_company'];
                //门诊个人
                $array_data[$count][] = $value['s_outpatient_personal'];
                //住院基数
                $array_data[$count][] = $value['s_hospital_base_number'];
                //住院单位
                $array_data[$count][] = $value['s_hospital_company'];
                //住院个人
                $array_data[$count][] = $value['s_hospital_personal'];
                //生育基数
                $array_data[$count][] = $value['s_birth_base_number'];
                //生育单位
                $array_data[$count][] = $value['s_birth_company'];
                //合计
                $array_data[$count][] = $value['s_total'];
                //单位承担
                $array_data[$count][] = $value['s_company_commitment'];
                //个人承担
                $array_data[$count][] = $value['s_personal_commitment'];
                //公积金地区
                $array_data[$count][] = $value['s_gjj_area'];
                //公积金基数
                $array_data[$count][] = $value['s_gjj_base_number'];
                //单位比例
                $array_data[$count][] = $value['s_gjj_company_proportion'];
                //单位承担
                $array_data[$count][] = $value['s_gjj_company_commitment'];
                //个人比例
                $array_data[$count][] = $value['s_gjj_personal_proportion'];
                //个人承担
                $array_data[$count][] = $value['s_gjj_personal_commitment'];
                //公积金合计
                $array_data[$count][] = $value['s_gjj_total'];
                //社保公积金单位合计
                $array_data[$count][] = $value['s_gjj_social_total_company'];
                //社保公积金个人合计
                $array_data[$count][] = $value['s_gjj_social_total_personal'];
                //费用归属
                $array_data[$count][] = $value['s_cost_attribution'];
                $count++;
            }
            $this->base_export($array_title, $array_data, $filename, './', true);
        } else {
            $this->accessexit();
        }
    }

    /*社保管理-上传文件*/
    public function socialsecurity_record_upload()
    {

        /*上传根目录*/
        $root_path = './Upload/';
        /*上传子目录*/
        $save_path = 'socialsecurity/';
        /*上传后文件名称*/
        $file_name = rtrim($save_path,'/').'_import_'.date('YmdHis');
        if(!file_exists($root_path.$save_path)){
            mkdir($root_path.$save_path,0777,true);
        }
        $result = $this->base_upload($file_name,$save_path,$root_path);
        $read_path = $root_path.'/'.$result['info']['file']['savepath'].$result['info']['file']['savename'];

        /*读取Excel文件内容*/
        $Excelarr = $this->base_import($read_path);

        foreach ($Excelarr as $key => $value) {
            /*空行跳过 - 判断条件  b列为空或者 b列值等于姓名*/
            if (empty($value['B']) || $value['B'] == '姓名') {
                continue;
            }
            //用户姓名
            $data['e_username'] = $value['B'];
            //一级部门
            if (!empty($value['C'])) {
                $department_first = M('department')->field('department_id')->where("department_name = '{$value['C']}'")->find();
                if (empty($department_first)) {
                    $data['s_department_first'] = $value['C'] . '-未找到对应部门id';
                } else {
                    $data['s_department_first'] = $value['C'] . '-' . $department_first['department_id'];
                }
            }
            //二级部门
            if (!empty($value['D'])) {
                $department_second = M('department')->field('department_id')->where("department_name = '{$value['D']}'")->find();
                if (empty($department_second)) {
                    $data['s_department_second'] = $value['D'] . '-未找到对应部门id';
                } else {
                    $data['s_department_second'] = $value['D'] . '-' . $department_second['department_id'];
                }
            }
            //三级部门
            if (!empty($value['D'])) {
                $department_third = M('department')->field('department_id')->where("department_name = '{$value['E']}'")->find();
                if (empty($department_third)) {
                    $data['s_department_third'] = $value['E'] . '-未找到对应部门id';
                } else {
                    $data['s_department_third'] = $value['E'] . '-' . $department_third['department_id'];
                }
            }
            //岗位
            $data['s_station'] = $value['F'];
            //考勤地区
            $data['s_attendance_area'] = $value['G'];
            //社保地区
            $data['s_social_area'] = $value['H'];
            //养老基数
            $data['s_endowment_base_number'] = $value['I'];
            //养老单位
            $data['s_endowment_company'] = $value['J'];
            //养老个人
            $data['s_endownent_personal'] = $value['K'];
            //失业基数
            $data['s_worklost_base_number'] = $value['L'];
            //失业单位
            $data['s_worklost_company'] = $value['M'];
            //失业个人
            $data['s_worklost_personal'] = $value['N'];
            //工伤基数
            $data['s_workinjury_base_number'] = $value['O'];
            //工伤单位
            $data['s_workinjury_company'] = $value['P'];
            //门诊基数
            $data['s_outpatient_base_number'] = $value['Q'];
            //门站单位
            $data['s_outpatient_company'] = $value['R'];
            //门诊个人
            $data['s_outpatient_personal'] = $value['S'];
            //住院基数
            $data['s_hospital_base_number'] = $value['T'];
            //住院单位
            $data['s_hospital_company'] = $value['U'];
            //住院个人
            $data['s_hospital_personal'] = $value['V'];
            //生育基数
            $data['s_birth_base_number'] = $value['W'];
            //生育单位
            $data['s_birth_company'] = $value['X'];
            //合计
            $data['s_total'] = $value['Y'];
            //单位承担
            $data['s_company_commitment'] = $value['Z'];
            //个人承担
            $data['s_personal_commitment'] = $value['AA'];
            //公积金地区
            $data['s_gjj_area'] = $value['AB'];
            //公积金基数
            $data['s_gjj_base_number'] = $value['AC'];
            //单位比例
            $data['s_gjj_company_proportion'] = $value['AD'];
            //单位承担
            $data['s_gjj_company_commitment'] = $value['AE'];
            //个人比例
            $data['s_gjj_personal_proportion'] = $value['AF'];
            //个人承担
            $data['s_gjj_personal_commitment'] = $value['AG'];
            //公积金合计
            $data['s_gjj_total'] = $value['AH'];
            //社保公积金单位合计
            $data['s_gjj_social_total_company'] = $value['AI'];
            //社保公积金个人合计
            $data['s_gjj_social_total_personal'] = $value['AJ'];
            //费用归属
            $data['s_cost_attribution'] = $value['AK'];
            /*数据导入时间*/
            $data['s_import_time'] = strtotime($_POST['t']);
            /*数据创建时间*/
            $data['s_create_time'] = time();

            $insert_data[] = $data;
        }

        $model = M('social_security');
        $where_delete = $_GET['import_time'];
        /*执行添加之前,先清空表*/
        $result=array();
        //$model->where("FROM_UNIXTIME(s_import_time,'%Y%m') = '{$where_delete}'")->delete();
        if ($model->addAll($insert_data)) {
            $result['status'] = 'success';
            $result['describe'] = '数据添加成功';
        } else {
            $result['status'] = 'error';
            $result['describe'] = '数据添加失败,请联系管理员';
        }
        echo json_encode($result);
    }
}