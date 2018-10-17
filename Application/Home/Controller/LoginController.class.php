<?php

namespace Home\Controller;

use Think\Controller;

class LoginController extends Controller
{
    /*登录-index*/
    public function index()
    {
       return false;
    }

    /*登录-登录页显示*/
    public function loginShow()
    {
        $this->display();
    }

    /*登录-登录验证*/
    public function loginPro()
    {
        /*用户名和密码不得为空*/
        if (!empty(I('post.m_username')) && !empty(I('post.m_password'))) {
            $model = M('manager');
            $username = I('post.m_username');
            $password = md5(I('post.m_password'));
            $result = $model->field('uid,username')->where("username = '{$username}' and password = '{$password}'")->find();
            if (!empty($result)) {
                /*账号密码无误*/
                $data['login_time_last'] = time();
                $data['uid'] = $result['uid'];
                if ($model->save($data)) {
                    /*操作无误*/
                    $_SESSION['username'] = $username;
                    $_SESSION['uid'] = $data['uid'];
                    $_SESSION['expirytime'] = time() + 7200;
                } else {
                    /*未能修改登录时间*/
                }
                /*进入主页面*/
                $this->success('登录成功', U('Home/Main/main_workplace_show'), 1);

            } else {
                $this->error('用户名密码错误', U('Home/Login/loginShow'), 1);
            }
        } else {
            $this->error('用户名密码错误', U('Home/Login/loginShow'), 1);
        }
    }

    /*登录-注销账号*/
    public function login_out()
    {
        /*判断来处*/
        /*此处判断,目前只要判断有来源地址即可,后续会把所有方法集中在一个数组中来判断是否来自本系统的请求*/
        if ($_SERVER['HTTP_REFERER']) {
            unset($_SESSION['username']);
            unset($_SESSION['uid']);
            unset($_SESSION['expirytime']);
            $this->success('已退出当前账号,请重新登录',U('Home/Login/loginShow'),1);
            return true;
        }
    }
}