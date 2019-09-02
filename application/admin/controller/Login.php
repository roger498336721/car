<?php
namespace app\admin\controller;

use think\captcha\Captcha;

class Login extends Base
{
	// 初始化
	public function initialize()
    {
        if(session('?userinfo')){

            $this->redirect(url('Index/index'));

        }
    }
    public function index(){
		
		return $this->fetch();

    }
    
    //验证码
    public function verify()

    {

    	$captcha = new Captcha();

        return $captcha->entry();    

    }

    /**
     * @description: 验证码验证
     * @param {type} 
     * @return: 
     */    
    public function verifyCheck(){

		$value = input('post.verifycode');

		$captcha = new Captcha();

		if( !$captcha->check($value))

		{

			return $this->msg(config('admin.return_code.code_1'),config('admin.return_msg.success'));

		}

    }  
    	/**

	 * [loginCheck 登录用户校验]

	 * @Author   fjn

	 * @DateTime 2018-11-14T16:09:14+0800

	 * @return   [type]                   [description]

	 */

	public function loginCheck(){



		if(!request()->isAjax()){//验证请求类型

			return $this->error('请求类型错误，必须ajax');

		}else{



			$data = input('post.'); //获取AJAX提交数据

            // halt($data);

			$captcha = new Captcha();

			//校验验证码

			if(!$captcha->check($data['verify'])){

				

				return $this->msg(config('admin.return_code.code_0'),config('admin.return_msg.yzmerror'));

			}

			unset($data['verify']);

			

			//验证器验证

			$res = validate('Usera')->check($data);

			

			if($res == false){

				return $this->msg(config('admin.return_code.code_0'),validate('Usera')->getError());

			}


			try{

				//数据库验证用户密码
                
                $info =db('adminuser')->where(['user_name'=>$data['user_name']])->find();
                
			}catch(\Exception $e){

				return $this->error($e->getMessage());

			}

		

			//验证空数据

			if($info == null){

				return $this->msg(config('admin.return_code.code_0'),config('admin.return_msg.usernull'));

			}

			if($info['password'] != md5($data['password'])){

				return $this->msg(config('admin.return_code.code_0'),config('admin.return_msg.pswerror'));

			}



			//session设置

			session(config('admin.session_cfg.info'),$info);



			return $this->msg(config('admin.return_code.code_1'),config('admin.return_msg.login'));

		}

	}  
    

}