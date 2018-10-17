<?php

namespace Home\Controller;

use Think\Controller;

class PayController extends BaseController
{
    /*薪酬管理-index*/
    public function index()
    {

    }

    /*薪酬管理-工资条*/
    public function payroll()
    {
        // 实例化User对象
        $model = M('wages');
        $curr = empty($_GET['p']) ? '0' : $_GET['p'];
        $limits = empty($_GET['limit']) ? '10' : $_GET['limit'];
        // 查询满足要求的总记录数
        $count = count($model->where('pay_id > 0')->group('pay_month')->select());
        // 实例化分页类 传入总记录数和每页显示的记录数(25)
        $Page = new \Think\Page($count, 10);
        $show = $Page->show();// 分页显示输出
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $list = $model->field(" FROM_UNIXTIME(pay_month,'%Y-%m') as s_month")->where('pay_id > 0')->group('s_month')->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $this->assign('curr', $curr);
        $this->assign('limits', $limits);
        $this->assign('count', $count);
        $this->assign('list', $list);// 赋值数据集
        $this->assign('page', $show);// 赋值分页输出
        $this->display(); // 输出模板
    }

    /*薪酬管理-上传文件(导入)*/
    public function pay_rocard_upload()
    {
        /*上传根目录*/
        $root_path = './Upload/';
        /*上传子目录*/
        $save_path = 'Pay/';
        /*上传后文件名称*/
        $file_name = rtrim($save_path, '/') . '_import_' . date('YmdHis');
        if (!file_exists($root_path . $save_path)) {
            mkdir($root_path . $save_path, 0777, true);
        }
        $result = $this->base_upload($file_name, $save_path, $root_path);
        $read_path = $root_path . '/' . $result['info']['file']['savepath'] . $result['info']['file']['savename'];

        /*读取Excel文件内容*/
        $Excelarr = $this->base_import($read_path);
        foreach ($Excelarr as $key => $value) {
            if (empty($value['B']) || $value['B'] == '姓名') {
                continue;
            }
            //月份
            $data['pay_month'] = strtotime($value['A']);
            //姓名
            $data['pay_username'] = $value['B'];
            //基本工资
            $data['pay_base_wage'] = $value['C'];
            //职位工资
            $data['pay_job_wage'] = $value['D'];
            //绩效工资
            $data['pay_performance_wage'] = $value['E'];
            //提成/奖金
            $data['pay_extract'] = $value['F'];
            //电脑补助
            $data['pay_subsidy_computer'] = $value['G'];
            //技术补助
            $data['pay_subsidy_technology'] = $value['H'];
            //通讯补助
            $data['pay_subsidy_comm'] = $value['I'];
            //交通补助
            $data['pay_subsidy_traffic'] = $value['J'];
            //事假天数
            $data['pay_day_number_sj'] = $value['K'];
            //病假天数
            $data['pay_day_number_bj'] = $value['L'];
            //调休天数
            $data['pay_day_number_tx'] = $value['M'];
            //计薪天数
            $data['pay_day_number'] = $value['N'];
            //系统工时（只填写实施人员）
            $data['pay_day_number_system'] = $value['O'];
            //带薪假期（不包括调休）
            $data['pay_day_number_workoff_money'] = $value['P'];
            //实际出勤天数
            $data['pay_day_number_infact'] = $value['Q'];
            //计薪工资
            $data['pay_wage_number'] = $value['R'];
            //餐补
            $data['pay_eat_money'] = $value['S'];
            //全勤奖
            $data['pay_all_work'] = $value['T'];
            //其他补发项目
            $data['pay_onther_money_add'] = $value['U'];
            //周报扣款
            $data['pay_weekr_report'] = $value['V'];
            //迟到未打卡扣款
            $data['pay_money_late_delete'] = $value['W'];
            //其他扣款
            $data['pay_money_delete'] = $value['X'];
            //个人扣款
            $data['pay_money_person_delete'] = $value['Y'];
            //应发工资
            $data['pay_wage_shouldbe'] = $value['Z'];
            //住房公积金
            $data['pay_money_housing'] = $value['AA'];
            //养老保险
            $data['pay_money_yl'] = $value['AB'];
            //失业保险
            $data['pay_money_lost_word'] = $value['AC'];
            //门诊/医疗保险
            $data['pay_money_mz'] = $value['AD'];
            //住院
            $data['pay_money_hospital'] = $value['AE'];
            //税前工资
            $data['pay_money_all'] = $value['AF'];
            //个税
            $data['pay_money_gs'] = $value['AG'];
            //实发工资
            $data['pay_wage_infact'] = $value['AH'];

            //录入时间
            $data['pay_create_timestamp'] = time();
            $insert_data[] = $data;

        }
        $model = M('wages');
        $where_delete = strtotime($_GET['timestamp']);
        /*执行添加之前,先清空表*/
        $result = array();
        $model->where("pay_month = '{$where_delete}'")->delete();

        if ($model->addAll($insert_data)) {
            $result['status'] = 'success';
            $result['describe'] = '数据添加成功';
        } else {
            $result['status'] = 'error';
            $result['describe'] = '数据添加失败,请联系管理员';
        }
        //echo $model->getLastSql();
        echo json_encode($result);
    }

    /*薪酬管理-下载文件*/
    public function pay_rocard_download()
    {
        if (!empty($_GET['timestamp'])) {
            $model = M('wages');
            $timestamp = strtotime($_GET['timestamp']);
            $pay_data = $model->where("pay_month = '{$timestamp}'")->select();

            /*设计表头*/
            $array_title = array('月份', '姓名', '基本工资', '职位工资', '绩效工资', '提成/奖金', '电脑补助', '技术补助', '通讯补助', '交通补助', '事假天数', '病假天数', '调休天数', '计薪天数', '系统工时（只填写实施人员）', '带薪假期（不包括调休）', '实际出勤天数', '计薪工资', '餐补', '全勤奖', '其他补发项目', '周报扣款', '迟到未打卡扣款', '其他扣款', '个人扣款', '应发工资', '住房公积金', '养老保险', '失业保险', '门诊/医疗保险', '住院', '税前工资', '个税', '实发工资');
            /*记录导出时间*/


            $export_time = date('YmdHis');
            $filename = "社保管理-社保记录-" . $export_time;
            $count = 1;
            $array_data = array();
            foreach ($pay_data as $key => $value) {
                //月份
                $array_data[$count][] = date('Y-m', $value['pay_month']);
                //姓名
                $array_data[$count][] = $value['pay_username'];
                //基本工资
                $array_data[$count][] = $value['pay_base_wage'];
                //职位工资
                $array_data[$count][] = $value['pay_job_wage'];
                //绩效工资
                $array_data[$count][] = $value['pay_performance_wage'];
                //提成/奖金
                $array_data[$count][] = $value['pay_extract'];
                //电脑补助
                $array_data[$count][] = $value['pay_subsidy_computer'];
                //技术补助
                $array_data[$count][] = $value['pay_subsidy_technology'];
                //通讯补助
                $array_data[$count][] = $value['pay_subsidy_comm'];
                //交通补助
                $array_data[$count][] = $value['pay_subsidy_traffic'];
                //事假天数
                $array_data[$count][] = $value['pay_day_number_sj'];
                //病假天数
                $array_data[$count][] = $value['pay_day_number_bj'];
                //调休天数
                $array_data[$count][] = $value['pay_day_number_tx'];
                //计薪天数
                $array_data[$count][] = $value['pay_day_number'];
                //系统工时（只填写实施人员）
                $array_data[$count][] = $value['pay_day_number_system'];
                //带薪假期（不包括调休）
                $array_data[$count][] = $value['pay_day_number_workoff_money'];
                //实际出勤天数
                $array_data[$count][] = $value['pay_day_number_infact'];
                //计薪工资
                $array_data[$count][] = $value['pay_wage_number'];
                //餐补
                $array_data[$count][] = $value['pay_eat_money'];
                //全勤奖
                $array_data[$count][] = $value['pay_all_work'];
                //其他补发项目
                $array_data[$count][] = $value['pay_onther_money_add'];
                //周报扣款
                $array_data[$count][] = $value['pay_weekr_report'];
                //迟到未打卡扣款
                $array_data[$count][] = $value['pay_money_late_delete'];
                //其他扣款
                $array_data[$count][] = $value['pay_money_delete'];
                //个人扣款
                $array_data[$count][] = $value['pay_money_person_delete'];
                //应发工资
                $array_data[$count][] = $value['pay_wage_shouldbe'];
                //住房公积金
                $array_data[$count][] = $value['pay_money_housing'];
                //养老保险
                $array_data[$count][] = $value['pay_money_yl'];
                //失业保险
                $array_data[$count][] = $value['pay_money_lost_word'];
                //门诊/医疗保险
                $array_data[$count][] = $value['pay_money_mz'];
                //住院
                $array_data[$count][] = $value['pay_money_hospital'];
                //税前工资
                $array_data[$count][] = $value['pay_money_all'];
                //个税
                $array_data[$count][] = $value['pay_money_gs'];
                //实发工资
                $array_data[$count][] = $value['pay_wage_infact'];

                $count++;
            }
            $this->base_export($array_title, $array_data, $filename, './', true);
        } else {
            $this->accessexit();
        }
    }

    /*薪酬管理-发送邮件*/
    public function pay_recard_email_send()
    {
        /*检测是否拿到对应时间*/
        if (empty($_POST['timestamp'])) {
            $this->accessexit();
        }
        $timestamp = strtotime($_POST['timestamp']);
        $model = M('wages');
        $data = $model->where("pay_month = '{$timestamp}'")->select();
        $string = htmlcode();

        foreach ($data as $key => $value) {
            $stringdata = sprintf($string,
                //月份
                $value['pay_month'] = strtotime($value['A']),
                //姓名
                $value['pay_username'],
                //基本工资
                number_format($value['pay_base_wage'], 2),
                //职位工资
                number_format($value['pay_job_wage'], 2),
                //绩效工资
                number_format($value['pay_performance_wage'], 2),
                //提成/奖金
                number_format($value['pay_extract'], 2),
                //电脑补助
                number_format($value['pay_subsidy_computer'], 2),
                //技术补助
                number_format($value['pay_subsidy_technology'], 2),
                //通讯补助
                number_format($value['pay_subsidy_comm'], 2),
                //交通补
                number_format($value['pay_subsidy_traffic'], 2),
                //事假天数
                number_format($value['pay_day_number_sj'], 2),
                //病假天数
                number_format($value['pay_day_number_bj'], 2),
                //调休天数
                number_format($value['pay_day_number_tx'], 2),
                //计薪天数
                number_format($value['pay_day_number'], 2),
                //系统工时（只填写实施人员）
                number_format($value['pay_day_number_system'], 2),
                //带薪假期（不包括调休）
                number_format($value['pay_day_number_workoff_money'], 2),
                //实际出勤天
                number_format($value['pay_day_number_infact'], 2),
                //计薪工资
                number_format($value['pay_wage_number'], 2),
                //餐补
                number_format($value['pay_eat_money'], 2),
                //全勤奖
                number_format($value['pay_all_work'], 2),
                //其他补发项目
                number_format($value['pay_onther_money_add'], 2),
                //周报扣款
                number_format($value['pay_weekr_report'], 2),
                //迟到未打卡扣款
                number_format($value['pay_money_late_delete'], 2),
                //其他扣款
                number_format($value['pay_money_delete'], 2),
                //个人扣款
                number_format($value['pay_money_person_delete'], 2),
                //应发工资
                number_format($value['pay_wage_shouldbe'], 2),
                //住房公积金
                number_format($value['pay_money_housing'], 2),
                //养老保险
                number_format($value['pay_money_yl'], 2),
                //失业保险
                number_format($value['pay_money_lost_word'], 2),
                //门诊/医疗保
                number_format($value['pay_money_mz'], 2),
                //住院
                number_format($value['pay_money_hospital'], 2),
                //税前工资
                number_format($value['pay_money_all'], 2),
                //个税
                number_format($value['pay_money_gs'], 2),
                //实发工资
                number_format($value['pay_wage_infact'], 2)
            );
            sendMail('chengwl@ucap.com.cn', $stringdata);
            die;
        }
    }

    /*薪酬管理-生成工资表*/
    public function pay_recard_wage_create()
    {
        /* $timestamp = $_GET['timestamp'];
         $timestamp = '2018-08';
         $timestamp = strtotime($timestamp);*/

        $wage_infact = '';
        $wage_should = '';
        /*月计薪天数*/
        $timestamp = strtotime(empty($_POST['timestamp']) ? '2018-08' : $_POST['timestamp']);

        $month = getdates($timestamp);
        $work = get_weekend_days($month['start'], $month['end']);
        $workday = $work['total_days'] - $work['total_relax'];
        /*实际出勤天数*/
        $workday_infact = 0;
        /*病假天数*/
        $workoff_bj = 0;
        /*绩效系数*/
        $coefficient = 1;
        /*是否全勤*/
        $workday_all = 0;
        /*全勤奖   $workday_all为0  则代表 不是全勤 如果不为0 代表全勤 奖励200*/
        $workday_all_money = $workday_all == 0 ? 0 : 200;
        /*餐补*/
        $eating_money = 0;
        /*奖金|提成*/
        $bonus = 0;
        /*其他补发*/
        $onther_money_bf = 0;
        /*迟到未打卡*/
        $late_and_no_hit_card = 0;
        /*其他扣款*/
        $onther_money_lost = 0;
        /*个人扣款*/
        $person_lost = 0;
        /*周报扣款*/
        $week_report_lost = 0;

        /*离职补偿金*/
        $quit_money = 0;

        /*借款*/
        $loan = 0;
        $model_employee = M('employee');
        $employee_data = $model_employee->where("em_workstatus !=4")->select();
        /*
       * 计算公式
       *   实发工资=应发工资-个人养老-个人医疗-个人失业-个人公积金-住院-个税-离职补偿金-借款
       *   应发工资= (基本工资+岗位工资+绩效工资*绩效系数+提成|奖金+电脑补助+技术补助+通讯补助+交通补助)/月计薪天数*(计薪天数-病假天数
       *           )+病假天数*80+餐补标准*实际出勤天数+全勤奖+其他补发-迟到未打卡扣款-其他扣款-个人扣款-周报扣款
       */

        foreach ($employee_data as $key => $value) {
            /*应发工资*/
            /* $wage_should = ($value['em_basewage'] + $value['em_positionwage'] + $value['em_standard_performance_wage'] * $coefficient + $bonus + $value['em_computersubsidy'] + $value['em_skillsubsidy'] + $value['em_telsubsidy'] + $value['em_tracfficsidy']) / $workday * ($workday - $workoff_bj ) + $workoff_bj * 80 + $eating_money + $workday_infact + $workday_all_money + $onther_money_bf - $late_and_no_hit_card - $onther_money_lost - $person_lost - $week_report_lost;*/

            $S = M('social_security')->where("s_import_time = '{$timestamp}' and e_username = '{$value['em_username']}'")->find();

            $wage_infact = $wage_should - $S['s_endownent_personal'] - $S['s_outpatient_personal'] - $S['s_worklost_personal'] - $S['s_gjj_personal_commitment'] - $S['s_hospital_personal'] - $quit_money - $loan;

            //月份
            $data['pay_month'] = $timestamp;
            //姓名
            $data['pay_username'] = $value['em_username'];
            //基本工资
            $data['pay_base_wage'] = $value['em_basewage'];
            //职位工资
            $data['pay_job_wage'] = $value['em_positionwage'];
            //绩效工资
            $data['pay_performance_wage'] = $value['em_standard_performance_wage'];
            //提成/奖金
            $data['pay_extract'] = $bonus;;
            //电脑补助
            $data['pay_subsidy_computer'] = $value['em_computersubsidy'];
            //技术补助
            $data['pay_subsidy_technology'] = $value['em_skillsubsidy'];
            //通讯补助
            $data['pay_subsidy_comm'] = $value['em_telsubsidy'];
            //交通补助
            $data['pay_subsidy_traffic'] = $value['em_tracfficsidy'];
            //事假天数
            $data['pay_day_number_sj'] = 0;
            //病假天数
            $data['pay_day_number_bj'] = 0;
            //调休天数
            $data['pay_day_number_tx'] = 0;
            //计薪天数
            $data['pay_day_number'] = $workday;
            //系统工时（只填写实施人员）
            $data['pay_day_number_system'] = 0;
            //带薪假期（不包括调休）
            $data['pay_day_number_workoff_money'] = 0;
            //实际出勤天数
            $data['pay_day_number_infact'] = 0;
            //计薪工资
            $data['pay_wage_number'] = 0;
            //餐补
            $data['pay_eat_money'] = 0;
            //全勤奖
            $data['pay_all_work'] = 0;
            //其他补发项目
            $data['pay_onther_money_add'] = 0;
            //周报扣款
            $data['pay_weekr_report'] = 0;
            //迟到未打卡扣款
            $data['pay_money_late_delete'] = 0;
            //其他扣款
            $data['pay_money_delete'] = 0;
            //个人扣款
            $data['pay_money_person_delete'] = 0;
            //应发工资
            $data['pay_wage_shouldbe'] = 0;
            //住房公积金
            $data['pay_money_housing'] = 0;
            //养老保险
            $data['pay_money_yl'] = 0;
            //失业保险
            $data['pay_money_lost_word'] = 0;
            //门诊/医疗保险
            $data['pay_money_mz'] = 0;
            //住院
            $data['pay_money_hospital'] = 0;
            //税前工资
            $data['pay_money_all'] = 0;
            //个税
            $data['pay_money_gs'] = 0;
            //实发工资
            $data['pay_wage_infact'] = 0;

            /*个人对应邮箱*/
            $data['pay_person_email'] = $value['em_email'];
            //录入时间
            $data['pay_create_timestamp'] = time();
            $insert_data[] = $data;
        }
        $model = M('wages');
        $where_delete = $_GET['import_time'];
        /*执行添加之前,先清空表*/
        $result = array();
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