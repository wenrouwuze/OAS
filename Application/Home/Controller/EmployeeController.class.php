<?php

namespace Home\Controller;

use Think\Controller;

class EmployeeController extends BaseController
{
    /*员工管理-index*/
    public function index()
    {
        $this->accessexit();
    }

    /*员工管理-花名册展示*/
    public function employee_roster_show()
    {
        /*左侧部门信息*/
        $department_tree = $this->departmenttree();
        $this->assign('departmenttree', $department_tree);

        /*右侧员工信息*/
        $where = 'em_id >0';
        if (!empty($_GET['employee_status'])) {
            $employee_status = $_GET['employee_status'];
            $where .= $_GET['employee_status'] == 4 ? ' and em_workstatus = 4' : ' and em_workstatus !=4';
            $this->assign('employee_status', $employee_status);
        } else {
            $where .= " and em_workstatus !=4 ";
        }
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
        $list = $User->where($where)->order('em_id desc')->limit($Page->firstRow . ',' . $Page->listRows)->select();


        $this->assign('curr', $curr);
        $this->assign('limits', $limits);
        $this->assign('count', $count);
        $this->assign('list', $list);// 赋值数据集
        $this->assign('page', $show);// 赋值分页输出
        $this->display(); // 输出模板
    }

    /*员工管理-新增员工*/
    public function employee_roster_add()
    {
        /*工号*/
        $worknumber = M('employee')->max('em_id') + 1;
        $worknumber = $worknumber >= 10 ? $worknumber : '0' . $worknumber;

        /*部门数据*/
        $this->assign('departmentdata', $this->departmenttree());
        /*一级部门*/
        $this->assign("department", $this->departmentdata('0'));
        $this->assign('worknumber', $worknumber);
        /*岗位费用金蝶归属部门*/
        $this->assign('kingdeedepartment', $this->base_kingdeedepartment());
        /*金蝶核算口径*/
        $this->assign('kingdee', $this->base_kingdee());
        /*薪资归属*/
        $this->assign('wageAscription', $this->base_wageAscription());
        /*各大银行*/
        $this->assign('bank', $this->base_bank());
        /*民族*/
        $this->assign('nation', $this->base_nation());
        /*政治面貌*/
        $this->assign('political', $this->base_political());
        /*所属公司*/
        $this->assign('company', $this->base_companyname());

        $this->display();
    }

    /*员工管理-新增员工验证*/
    public function employee_roster_addpro()
    {
        if (I()) {
            $data['em_username'] = I('post.em_username');   //员工姓名
            $data['em_birthday'] = strtotime(I('post.em_birthday'));    //出生年月
            $data['em_company'] = I('post.em_company');    //所属公司
            $data['em_nation'] = I('post.em_nation');     //民族
            $data['em_mobile'] = I('post.em_mobile');     //手机号码
            $data['em_email'] = I('post.em_email');      //邮箱
            $data['em_province'] = I('post.em_province');   //籍贯
            $data['em_register_place'] = I('post.em_register_place'); //户口所在地
            $data['em_marital_status'] = I('post.em_marital_status'); //婚姻状况
            $data['em_baby_birthday'] = strtotime(I('post.em_baby_birthday'));   //孩子出生年月
            $data['em_sex'] = I('post.em_sex') == '男' ? '1' : '2';    //性别
            $data['em_age'] = I('post.em_age');        //年龄
            $data['em_political_face'] = I('post.em_political_face'); //政治面貌
            $data['em_idcard'] = I('post.em_idcard');     //身份证号码
            $data['em_wxnumber'] = I('post.em_wxnumber');   //微信号码
            $data['em_registerplace_type'] = I('post.em_registerplace_type'); //户口类型
            $data['em_addressnow'] = I('post.em_addressnow'); //现住址
            $data['em_reproductive_status'] = I('post.em_reproductive_status');    //生育状况
            $data['em_worknumber'] = I('post.em_worknumber'); //工号
            $data['em_workplace'] = I('post.em_workplace');  //工作地区
            $data['em_duties'] = I('post.em_duties');     //职务
            $data['em_firstleader'] = I('post.em_firstleader');    //直属领导
            $data['em_createtime'] = strtotime(I('post.em_createtime'));  //入职时间
            $data['em_formaltime'] = strtotime(I('post.em_formaltime'));  //转正时间
            $data['em_renew'] = I('post.em_renew');  //续签次数
            $data['em_workstatus'] = I('post.em_workstatus'); //状态
            $data['em_endtime'] = strtotime(I('post.em_endtime'));     //合同到期时间
            $data['em_workage'] = I('post.em_workage');    //司龄
            $data['em_graduateschool'] = I('post.em_graduateschool'); //毕业学校
            $data['em_major'] = I('post.em_major');  //专业
            $data['em_professional_title'] = I('post.em_professional_title'); //职称
            $data['em_graduatetime'] = strtotime(I('post.em_graduatetime'));    //毕业时间
            $data['em_degreeofeducation'] = I('post.em_degreeofeducation');  //文化程度
            $data['em_qualificationCertificate'] = I('post.em_qualificationCertificate');   //资质证书
            $data['em_banknumber'] = I('post.em_banknumber');     //银行卡号
            $data['em_kingdee'] = I('post.em_kingdee');    //金蝶核算口径（薪资）
            $data['em_kingdeedepartment'] = I('post.em_kingdeedepartment'); //岗位费用金蝶归属部门
            $data['em_computersubsidy'] = I('post.em_computersubsidy');    //电脑补助
            $data['em_skillsubsidy'] = I('post.em_skillsubsidy');   //技术补助
            $data['em_basewage'] = I('post.em_basewage');   //基本工资
            $data['em_standard_performance_wage'] = I('post.em_standard_performance_wage');  //标准绩效工资
            $data['em_bankname'] = I('post.em_bankname');   //银行名称
            $data['em_wageascription'] = I('post.em_wageascription'); //薪资归属
            $data['em_telsubsidy'] = I('post.em_telsubsidy'); //通讯补助
            $data['em_tracfficsidy'] = I('post.em_tracfficsidy');   //交通补助
            $data['em_wage'] = I('post.em_wage');   //工资
            $data['em_positionwage'] = I('post.em_positionwage');   //职位工资
            /*部门id*/
            if (I('em_department_first')) {
                $department_first = explode('-', I('em_department_first'));
                $data['em_department_first'] = $department_first[1];
            }
            if (I('em_department_second')) {
                $department_second = explode('-', I('em_department_second'));
                $data['em_department_second'] = $department_second[1];
            }
            if (I('em_department_third')) {
                $department_third = explode('-', I('em_department_third'));
                $data['em_department_third'] = $department_third[1];
            }
            /*部门录入数据*/
            $data['em_register_time'] = time();

            $model = M('employee');
            if ($model->add($data)) {
                $this->success('添加成功', U('Home/Employee/employee_roster_show'), 1);
            } else {
                $this->error('添加失败', U('Home/Employee/employee_roster_add'), 1);
            }
        } else {
            $this->accessexit();
        }
    }

    /*员工管理-部门数据查询*/
    public function departmentdata($parents = 0)
    {
        if (I('post.parents')) {
            $parents = I('post.parents');
            $data = M('department')->field('department_id,department_name')->where("department_superiorid = '{$parents}'")->select();
            $str = '';
            foreach ($data as $key => $val) {
                $str .= "<option value='{$val['department_id']}'>{$val['department_name']}</option>";
            }
            echo $str;
        } else {
            $data = M('department')->field('department_id,department_name')->where("department_superiorid = '{$parents}'")->select();
            return ($data);
        }

    }

    /*员工管理-编辑界面显示*/
    public function employee_roster_edit()
    {
        if (I('get.em_id')) {
            $em_id = I('get.em_id');
            $employee = M('employee')->where("em_id = '{$em_id}'")->select();

            /*一级部门*/
            $em_department_firstname = M('department')->field('department_name,department_id')->where("department_id = '{$employee[0]['em_department_first']}'")->find()['department_name'];
            $employee[0]['em_department_firstname'] = empty($em_department_firstname) ? '暂无' : $em_department_firstname;
            /*二级部门*/
            $em_department_secondname = M('department')->field('department_name,department_id')->where("department_id = '{$employee[0]['em_department_second']}'")->find()['department_name'];
            $employee[0]['em_department_secondname'] = empty($em_department_secondname) ? '暂无' : $em_department_firstname;
            /*三级级部门*/
            $em_department_thirdname = M('department')->field('department_name,department_id')->where("department_id = '{$employee[0]['em_department_third']}'")->find()['department_name'];
            $employee[0]['em_department_thirdname'] = empty($em_department_thirdname) ? '暂无' : $em_department_thirdname;
            /*政治面貌*/
            $this->assign('political', $this->base_political());
            /*金蝶核算口径*/
            $this->assign('kingdee', $this->base_kingdee());
            /*岗位费用金蝶归属部门*/
            $this->assign('kingdeedepartment', $this->base_kingdeedepartment());
            /*各大银行*/
            $this->assign('bank', $this->base_bank());
            /*薪资归属*/
            $this->assign('wageAscription', $this->base_wageAscription());
            $this->assign('em_id', $em_id);
            $this->assign('employee', $employee);
            $this->display();
        } else {
            $this->accessexit();
        }
    }

    /*员工管理-编辑员工验证*/
    public function employee_roster_edit_pro()
    {
        if (I()) {
            $employee_id = empty(I('post.em_id')) ? $this->accessexit() : I('post.em_id');
            $model = M('employee');
            $data = $model->create();
            $data['em_birthday'] = strtotime(I('post.em_birthday'));
            $data['em_baby_birthday'] = strtotime(I('post.em_baby_birthday'));
            $data['em_createtime'] = strtotime(I('post.em_createtime'));
            $data['em_formaltime'] = strtotime(I('post.em_formaltime'));
            $data['em_endtime'] = strtotime(I('post.em_endtime'));
            $data['em_graduatetime'] = strtotime(I('post.em_graduatetime'));
            $data['em_sex'] = I('post.em_sex') == '男' ? '1' : '2';
            if ($model->where("em_id = '{$employee_id}'")->save($data)) {
                $this->success('修改成功', U('Home/Employee/employee_roster_show'), 1);
            } else {
                $this->error('没有被修改的选项', '', 1);
            }
        } else {
            $this->accessexit();
        }
    }

    /*员工管理-花名册导出*/
    public function employee_roster_export()
    {
        $export_data = M('employee')->select();
        $array_title = array("序号", "姓名", "工号", "状态", "工作地区", "所属公司", "一级部门", "二级部门", "三级部门", "金蝶核算口径（薪金）", "薪金归属", "岗位费用金蝶归属部门", "职务", "直属领导", "入职时间", "转正时间", "司龄", "合同到期日期", "续签次数", "身份证号码", "性别", "出生年月", "年龄", "户口类型", "户口所在地", "籍贯", "民族", "工资卡号", "银行", "联系方式", "邮箱", "微信号", "毕业学校", "毕业时间", "专业", "文化程度", "职称", "资质证书", "政治面貌", "婚姻状况", "生育状态", "孩子出生年月", "现住址");
        $filename = "员工管理-花名册";
        $count = 1;
        foreach ($export_data as $key => $value) {
            //序号
            $array_data[$count][] = $value['em_id'];
            //姓名
            $array_data[$count][] = $value['em_username'];
            //工作状态
            $array_data[$count][] = $value['em_worknumber'];
            /*员工状态*/
            switch ($value['em_workstatus']) {
                case '1':
                    $array_data[$count][] = '试用期';
                    break;
                case '2':
                    $array_data[$count][] = '实习期';
                    break;
                case '3':
                    $array_data[$count][] = '正式';
                    break;
                case '4':
                    $array_data[$count][] = '离职';
                    break;
                default:
                    $array_data[$count][] = '暂无';
            }
            //工作地区
            $array_data[$count][] = $value['em_workplace'];
            //所属公司
            $array_data[$count][] = $value['em_company'];
            //一级部门
            if (!empty($value['em_department_first'])) {
                $em_department_first = M('department')->field('department_name')->where("department_id = '{$value['em_department_first']}'")->find();
                $array_data[$count][] = $em_department_first['department_name'];
            } else {
                $array_data[$count][] = '暂无';
            }

            //二级部门
            if (!empty($value['em_department_second'])) {
                $em_department_second = M('department')->field('department_name')->where("department_id = '{$value['em_department_second']}'")->find();
                $array_data[$count][] = $em_department_second['department_name'];
            } else {
                $array_data[$count][] = '暂无';
            }
            //三级部门
            if (!empty($value['em_department_third'])) {
                $em_department_third = M('department')->field('department_name')->where("department_id = '{$value['em_department_third']}'")->find();
                $array_data[$count][] = $em_department_third['department_name'];
            } else {
                $array_data[$count][] = '暂无';
            }
            //金蝶核算口径（薪金）
            $array_data[$count][] = mb_substr($value['em_kingdee'], 0, mb_strripos($value['em_kingdee'], '-'));
            //薪金归属
            $array_data[$count][] = $value['em_wageascription'];
            //岗位费用金蝶归属部门
            $array_data[$count][] = mb_substr($value['em_kingdeedepartment'], 0, mb_strripos($value['em_kingdeedepartment'], '-'));
            //职务
            $array_data[$count][] = $value['em_duties'];
            //直属领导
            $array_data[$count][] = $value['em_firstleader'];
            //入职时间
            $array_data[$count][] = date('Y-m-d', $value['em_createtime']);
            //转正时间
            $array_data[$count][] = date('Y-m-d', $value['em_formaltime']);
            //司龄
            $array_data[$count][] = $value['em_workage'];
            //合同到期日期
            $array_data[$count][] = date('Y-m-d', $value['em_endtime']);
            //续签次数
            $array_data[$count][] = $value['em_renew'];
            //身份证号码
            $array_data[$count][] = $value['em_idcard'];
            //性别
            $array_data[$count][] = $value['department_size'] == '1' ? '男' : '女';
            //出生年月
            $array_data[$count][] = date('Y-m-d', $value['em_birthday']);
            //年龄
            $array_data[$count][] = $value['em_age'];
            //户口类型
            $array_data[$count][] = $value['em_registerplace_type'] == '1' ? '城镇' : '农村';
            //户口所在地
            $array_data[$count][] = $value['em_register_place'];
            //籍贯
            $array_data[$count][] = $value['em_province'];
            //民族
            $array_data[$count][] = $value['em_nation'];
            //工资卡号
            $array_data[$count][] = $value['em_banknumber'];
            //银行
            $array_data[$count][] = $value['em_bankname'];
            //联系方式
            $array_data[$count][] = $value['em_mobile'];
            //邮箱
            $array_data[$count][] = $value['em_email'];
            //微信号
            $array_data[$count][] = $value['em_wxnumber'];
            //毕业学校
            $array_data[$count][] = $value['em_graduateschool'];
            //毕业时间
            $array_data[$count][] = date('Y-m-d', $value['em_graduatetime']);
            //专业
            $array_data[$count][] = $value['em_major'];
            //文化程度
            $array_data[$count][] = $value['em_degreeofeducation'];
            //职称
            $array_data[$count][] = $value['em_professional_title'];
            //资质证书
            $array_data[$count][] = $value['em_qualificationcertificate'];
            //政治面貌
            $array_data[$count][] = $value['em_political_face'];
            //婚姻状况
            switch ($value['em_marital_status']) {
                case 1:
                    $array_data[$count][] = '未婚';
                    break;
                case 2:
                    $array_data[$count][] = '已婚';
                    break;
                case 3:
                    $array_data[$count][] = '离异';
                    break;
                case 4:
                    $array_data[$count][] = '丧偶';
                    break;
                default:
                    $array_data[$count][] = '暂未定义';
            }
            //生育状态
            $array_data[$count][] = $value['em_reproductive_status'] == 1 ? '已育' : '未育';
            //孩子出生年月
            $array_data[$count][] = date('Y-m-d', $value['em_baby_birthday']);
            //现住址
            $array_data[$count][] = $value['em_addressnow'];
            $count++;
        }
        $this->base_export($array_title, $array_data, $filename, './', true);
    }

    /*员工管理-离职操作*/
    public function employee_roster_remove(){
        if(I()){
            $id = empty(I('post.remove_id')) ? $this->accessexit() : I('post.remove_id');
            $model = M('employee');
            $data['em_workstatus'] = '4';
            $data['em_remove_worktime_last'] = strtotime(I('post.remove_worktime_last'));
            $data['em_remove_social_insurance_payment_last'] = strtotime(I('post.remove_social_insurance_payment_last'));
            $data['em_remove_accumulation_fund_payment_last'] = strtotime(I('post.remove_accumulation_fund_payment_last'));

            if($model->where("em_id = '{$id}'")->save($data)){
                // echo $model->getLastSql();die;
                $this->success('修改成功','',1);
            }else{
                $this->error('没有被修改的选项','',1);
            }
        }else{
            $this->accessexit();
        }
    }

    /*员工管理-搜索*/
    public function employee_roster_search(){
        /*暂定*/
    }
}