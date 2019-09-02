<?php 
	namespace app\common\validate;

	use think\Validate;

	class Usera extends Validate
	{
		protected $rule =   [
	        'user_name'  => ['require','length:2,20'],
	        'password'   => ['require','length:5,32'],
	        // 'email'    => 'email',
		    // 'mobile'    => 'require'
	    ];
	   
	    protected $message  =   [
	   		'user_name.require'  => '用户名必须',
	   		'user_name.length'  => '名字长度为2-20',
	   		'password.require'  => '密码名必须',
	   		'password.length'  => '密码长度为5-32',
	   		// 'email'  =>  "邮箱格式错误请重新输入",
	   		// 'mobile'  => '手机号码格式错误',
	   		// 'id'   => 'id必须是数字类型' 	 
	   	];

	   	public function sceneLogin()
   	    {
   	    	return $this->only(['username','password']);
   	    }

	   	/**
	   	 * [sceneEdit 定义增加数据场景]
	   	 * @Author   fjn
	   	 * @DateTime 2018-11-19T15:45:02+0800
	   	 * @return   [type]                   [description]
	   	 */
	   	public function sceneAdd()
   	    {
   	    	return $this->only(['user_name','password','email','phone']);
   	    }


	   	/**
	   	 * [sceneEdit 定义编辑场景]
	   	 * @Author   fjn
	   	 * @DateTime 2018-11-19T15:45:02+0800
	   	 * @return   [type]                   [description]
	   	 */
	   	public function sceneEdit()
   	    {
   	    	return $this->only(['user_name','password','email','phone'])
   	    				->append('id','require|number');
   	    } 

   	    public function sceneDelete()
   	    {
   	    	return $this->only(['id'])
   	    				->append('id','require|number');
   	    } 

	}
 ?>