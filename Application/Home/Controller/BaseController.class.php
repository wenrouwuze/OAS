<?php

namespace Home\Controller;

use Think\Controller;

class BaseController extends Controller
{

    /*基础控制器-构造函数*/
    public function __construct()
    {
        parent::__construct();
        if ($_SESSION['username'] && $_SESSION['expirytime'] > time()) {

            $username = $_SESSION['username'];
            $uid = $_SESSION['uid'];
            $this->assign('uid', $uid);
            $this->assign('username', $username);
            $this->assign('title', C('OSA_title'));
            //$this->assign('test', C('C_test'));
        } else {
            $this->accessexit();
        }
    }

    /*基础控制器-index*/
    public function index()
    {
        /*此处是直接return false   还是定义一个方法防止外人访问index*/
        /*1.直接return false*/
        /*return false;*/
        /*2.调用成员*/
        $this->accessexit();
    }

    /*基础控制器-获取部门树形结构数据*/
    public function departmenttree()
    {
        $department = M('department');
        $data = $department->field('CONCAT(department_name,\'(\',department_size,\'人)\') as text,department_id,department_superiorid as nodes')->select();

        $data = $this->gettree($data, '0');
        return json_encode($data);
    }

    /*基础控制器-获取子代*/
    public function gettree($data, $pid)
    {

        $tree = '';
        foreach ($data as $k => $v) {

            if ($v['nodes'] == $pid) {        //父亲找到儿子

                $v['nodes'] = $this->getTree($data, $v['department_id']);
                //unset($v['department_id']);
                $tree[] = $v;
                //unset($data[$k]);
            }
        }
        return $tree;
    }

    /*公共退出方法 用于各种非法访问退出*/
    public function accessexit()
    {
        $this->error('请勿直接访问，谢谢', U('Home/Login/loginShow'), 1);
    }

    /*基础控制器-数据导出*/
    function base_export($title = array(), $data = array(), $fileName = '', $savePath = './', $isDown = false)
    {
        error_reporting(0);
        /*include('PHPExcel.php');*/
        vendor('PHPExcel.Classes.PHPExcel');
        $obj = new \PHPExcel();

        //横向单元格标识
        $cellName = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ');

        $obj->getActiveSheet(0)->setTitle('sheet名称');   //设置sheet名称
        $_row = 1;   //设置纵向单元格标识
        if ($title) {
            $_cnt = count($title);
            $obj->getActiveSheet(0)->mergeCells('A' . $_row . ':' . $cellName[$_cnt - 1] . $_row);   //合并单元格
            $obj->setActiveSheetIndex(0)->setCellValue('A' . $_row, '数据导出：' . date('Y-m-d H:i:s'));  //设置合并后的单元格内容
            $_row++;
            $i = 0;
            foreach ($title AS $v) {   //设置列标题
                $obj->setActiveSheetIndex(0)->setCellValue($cellName[$i] . $_row, $v);
                $i++;
            }
            $_row++;
        }

        //填写数据
        if ($data) {
            $i = 0;
            foreach ($data AS $_v) {
                $j = 0;
                foreach ($_v AS $_cell) {
                    $obj->getActiveSheet(0)->setCellValue($cellName[$j] . ($i + $_row), $_cell);
                    $j++;
                }
                $i++;
            }
        }

        //文件名处理
        if (!$fileName) {
            $fileName = uniqid(time(), true);
        }

        $objWrite = \PHPExcel_IOFactory::createWriter($obj, 'Excel2007');

        if ($isDown) {   //网页下载
            header('pragma:public');
            header("Content-Disposition:attachment;filename=$fileName.xlsx");
            $objWrite->save('php://output');
            exit;
        }

        $_fileName = iconv("utf-8", "gb2312", $fileName);   //转码
        $_savePath = $savePath . $_fileName . '.xlsx';
        $objWrite->save($_savePath);

        return $savePath . $fileName . '.xlsx';
    }

    /*基础控制器-民族数据*/
    public function base_nation()
    {
        return array('汉族', '壮族', '满族', '回族', '苗族', '维吾尔族', '土家族', '彝族', '蒙古族', '藏族', '布依族', '侗族', '瑶族', '朝鲜族', '白族', '哈尼族', '哈萨克族', '黎族', '傣族', '畲族', '傈僳族', '仡佬族', '东乡族', '高山族', '拉祜族', '水族', '佤族', '纳西族', '羌族', '土族', '仫佬族', '锡伯族', '柯尔克孜族', '达斡尔族', '景颇族', '毛南族', '撒拉族', '塔吉克族', '阿昌族', '普米族', '鄂温克族', '怒族', '京族', '基诺族', '德昂族', '保安族', '俄罗斯族', '裕固族', '乌兹别克族', '门巴族', '鄂伦春族', '独龙族', '塔塔尔族', '赫哲族', '珞巴族', '布朗族');
    }

    /*基础控制器-岗位费用金蝶归属部门*/
    public function base_kingdeedepartment()
    {
        return array('董事会办公室', '总裁办', '南方公司-综合管理部-综合部', '北方公司-综合管理部', '按照费用承担部门选择', '南方公司-综合管理部-项目审计部', '南方公司-东莞事业部-销售部', '南方公司-东莞事业部-售前支持部', '南方公司-东莞事业部-实施服务部', '南方公司-广州事业部-售前支持部', '南方公司-扬州事业部-销售部', '南方公司-扬州事业部-售前支持部', '南方公司-扬州事业部-实施服务部', '南方公司-云产品事业部-售前支持部', '南方公司-政务服务事业部-销售部', '南方公司-政务服务事业部-实施服务部', '南方公司-政务服务事业部-运行维护部', '北方公司-企业服务事业部-销售部', '北方公司-政企事业部-销售部', '北方公司-政企事业部-云交付部', '北方公司-智慧事业部-销售一部', '北方公司-智慧事业部-销售二部', '北方公司-智慧事业部-云交付二部', '北方公司-西南事业部-实施服务部-本地实施', '北方公司-西南事业部-实施服务部-云实施');
    }

    /*基础控制器-金蝶核算口径*/
    public function base_kingdee()
    {
        return array('董事会办公室', '总裁办', '不单独核算', '南方公司-综合管理部总经理', '南方公司-综合管理部-系统安全部', '南方公司-综合管理部-项目审计部', '南方公司-东莞事业部-销售部', '南方公司-东莞事业部-售前支持部', '南方公司-东莞事业部-实施服务部', '南方公司-广州事业部-销售部', '南方公司-广州事业部-售前支持部', '南方公司-广州事业部-实施服务部', '南方公司-扬州事业部-销售部', '南方公司-扬州事业部-售前支持部', '南方公司-扬州事业部-实施服务部', '南方公司-云产品事业部-销售部', '南方公司-云产品事业部-售前支持部', '南方公司-云产品事业部-实施服务部', '南方公司-政务服务事业部-销售部', '南方公司-政务服务事业部-售前支持部', '南方公司-政务服务事业部-实施服务部', '南方公司-政务服务事业部-运行维护部', '北方公司-企业服务事业部-销售部', '北方公司-政企事业部-销售部', '北方公司-政企事业部-云交付部', '北方公司-智慧事业部-销售一部', '北方公司-智慧事业部-销售二部', '北方公司-智慧事业部-云交付一部', '北方公司-智慧事业部-云交付二部', '北方公司-西南事业部-销售部', '北方公司-西南事业部-实施服务部-本地实施', '北方公司-西南事业部-实施服务部-云实施', '北方公司-项目实施部', '北方公司-项目实施部-智慧实施部', '北方公司-售前支持部', '财务运营中心', '研发中心-产品市场部', '研发中心-产品市场部-市场部', '研发中心-本地业务研发部', '研发中心-公共支撑部', '研发中心-云业务研发部', '研发中心-公共技术部', '人力行政中心');
    }

    /*基础控制器-薪资归属*/
    public function base_wageAscription()
    {
        return array('管理费用', '本地实施', '销售费用', '云实施', '实施成本', '云监测研发', '云搜索研发', '集约化研发-网站集约化', '集约化-统一信息资源库研究及产业化推广', '集约化研发-全程电子化', '云监测云搜索');
    }

    /*基础控制器-各大银行*/
    public function base_bank()
    {
        return array('国家开发银行', '中国进出口银行', '中国农业发展银行', '中国工商银行', '中国农业银行', '中国银行', '中国建设银行', '交通银行', '中信银行', '中国光大银行', '华夏银行', '中国民生银行', '招商银行', '兴业银行', '广发银行', '平安银行', '上海浦东发展', '恒丰银行', '浙商银行', '渤海银行', '中国邮政储蓄银行');
    }

    /*基础控制器-政治面貌*/
    public function base_political()
    {
        return array('中共党员', '中共预备党员', '共青团员', '民革党员', '民盟盟员', '民建会员', '民进会员', '农工党党员', '致公党党员', '九三学社社员', '台盟盟员', '无党派人士', '群众');
    }

    /*基础控制器-公司名称*/
    public function base_companyname()
    {
        return array('广东开普', '广东北分', '北京开普', '成都开普');
    }

    /*基础控制器-上传文件*/
    public function base_upload($file_name='',$save_path = '', $root_path = './Upload/', $max_size = '3145728', $exts = array('jpg', 'gif', 'png', 'jpeg','xlsx','xls'))
    {
        //文件名称检测
        $file_name = !empty($file_name) ? $file_name : rtrim($save_path,'/').'_import_'.date('YmdHis');
        // 实例化上传类
        $upload = new \Think\Upload();
        // 设置附件上传大小
        $upload->maxSize = $max_size;
        // 设置附件上传类型
        $upload->exts = $exts;
        // 设置附件上传根目录
        $upload->rootPath = $root_path;
        // 设置附件上传（子）目录
        $upload->savePath = $save_path;
        // 设置附件上传后保存的文件名称
        $upload->saveName = $file_name;
        // 上传文件
        $info = $upload->upload();
        if (!$info) {// 上传错误提示错误信息
            return array(
                'status' => 'error',
                'describe' => $upload->getError()
            );
        } else {// 上传成功
            return array(
                'status' => 'success',
                'describe' => '上传成功',
                'info' =>$info,
            );
        }
    }

    /*基础控制器-数据导入*/
    public function base_import($filename='./test.xlsx')
    {
        header('Content-type: text/html; charset=utf-8');

        vendor('PHPExcel.Classes.PHPExcel');
        $Excel = new \PHPExcel();
        // 如果excel文件后缀名为.xls
        if(substr(strrchr($filename,'.'), 1) == 'xls'){
            // vendor("PHPExcel.Classes.PHPExcel.Reader.Excel5");
            vendor("PHPExcel.Classes.PHPExcel.Reader.Excel5");
            $PHPReader=new \PHPExcel_Reader_Excel5();
        }
        // 如果excel文件后缀名为.xlsx
        if(substr(strrchr($filename,'.'), 1) == 'xlsx'){
            //vendor("PHPExcel.Classes.PHPExcel.Reader.Excel2007");
            vendor("PHPExcel.Classes.PHPExcel.Reader.Excel2007");
            $PHPReader = new \PHPExcel_Reader_Excel2007();
        }
        // 载入文件
        $Excel = $PHPReader->load($filename);

        //获取表中的第一个工作表，如果要获取第二个，把0改为1，依次类推
        $currentSheet = $Excel->getSheet(0);
        //获取总列数
        $allColumn = $currentSheet->getHighestColumn();
        ++$allColumn;
        //获取总行数
        $allRow = $currentSheet->getHighestRow();
        //循环获取表中的数据，$currentRow表示当前行，从哪行开始读取数据，索引值从0开始
        for ($currentRow = 1; $currentRow <= $allRow; $currentRow++) {
            //从哪列开始，A表示第一列
            for ($currentColumn = 'A'; $currentColumn != $allColumn; $currentColumn++) {
                //数据坐标
                $address = $currentColumn . $currentRow;
                //读取到的数据，保存到数组$arr中
                $arr[$currentRow][$currentColumn] = $currentSheet
                    ->getCell($address)
                    ->getFormattedValue();
            }

        }
        //echo "<pre>";
        //var_export($arr);
        return $arr;
    }


}