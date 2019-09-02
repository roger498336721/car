<?php 
	namespace app\common\validate;

	use think\Validate;

	class Verify extends Validate
	{
		protected $rule = [
			'mobile' => 'require|length:11',
			'verify_code' => 'require|length:4'
		];

		protected $message = [
			'phone.require' => '手机号码必须',
			'phone.length'  => '手机号码长度11位',
			'verify_code.require' => '验证码必须的',
			'verify_code.length'  => '验证码长度必须4位'
		];
	}
 ?>