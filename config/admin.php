<?php 

	return [

		'page'  => 10 ,//默认分页条数

		// 'table' => [

		// 	1 => 'news',

		// 	2 => 'video',

		// 	3 => 'charm'

		// ],
		

		//状态码配置

		'status_code' => [

			'ok'       => 1,

			'no'       => 0

		],

		//session 配置

		'session_cfg' => [

			'info'     => 'userinfo'

		],

		//返回消息 code配置

		'return_code' => [

			'code_0'   => 0, //失败

			'code_1'   => 1, //成功

		],

		//返回提示信息配置

		'return_msg' => [

			'Invalid'  => '无效的参数',

			'usernull' => '用户名不存在',

			'login'    => '登录中...', //成功登录

			'pswerror' => '密码错误',

			'success'  => '操作成功',

			'error'    => '操作失败',

			'null'     => '数据为空',

			'yzmerror' => '验证码错误',

			'ajax'     => '请求方法必须AJAX',

			'post'     => '请求方法必须POST',

			'get'      => '请求方法必须GET',

			'delcate'  => '请删除完下一级菜单载删除此菜单',

			'role'	   =>'没有该操作的权限'

		],

		//验证码配置

		'verify' => [

			// 验证码字体大小

			'fontSize'    =>    16,    

			// 验证码位数

			'length'      =>    4,   

			// 关闭验证码杂点

			'useNoise'    =>    true, 

		],

		//文件路径配置

		'imgUrl' => request()->domain().'/car/public/',


	];



 ?>