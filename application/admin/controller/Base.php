<?php

namespace app\admin\controller;



use think\Controller;

use gmars\rbac\Rbac;

use think\Request;

use think\Db;

use Session;

class Base extends Controller

{

	protected $childControllerName = '';//子类控制器名字

	protected $childActionName = '';

	/**

	 * [initialize 控制器初始化]

	 * @Author   fjn

	 * @DateTime 2018-11-15T18:16:07+0800

	 * @return   [type]                   [description]

	 */

	 public function initialize()
	 {
		 if (!session('?userinfo')) {
 
			 $this->error('您未登陆无权访问，请先登陆', url('Login/index'));
		 }
	 }

	/**

	 * [index 通用单表index首页]

	 * @Author   Roger

	 * @DateTime 2018-11-19T13:45:24+0800

	 * @return   [type]                   [description]

	 */

	public function index(){

		$strcon = lcfirst(request()->controller());

		$time =	$strcon.'_addtimeinfo';

		$list = db($strcon)->order($time,'desc')->select();
	
		$this->assign('list',$list);

		$num = count($list);

        $this->assign('num', $num);

		return view();

	}




	/**

	 * [add description]

	 * @Author   roger

	 * @DateTime 2018-11-19T15:37:32+0800

	 */

	
	 public function add()
	 {
		$strcon = lcfirst(request()->controller());

		 if (request()->isPOST()) {
			
			 $data = request()->except('file');
 
			$str = $strcon.'_id';
			
			$data[$str]=md5(uniqid());	//添加ID
			
			$data[$strcon.'_addtimeinfo']=time();
			
			$data[$strcon.'_addtime']=date('Y/m/d H:i:s');

			$res = db(request()->controller())->insert($data);
			
			 if (!$res) {
				
				 return    $this->get_code(0, "添加失败");
			 }

			 return $this->get_code(1, '添加成功');
		 }
		
 
		 return view();
	 }


	 	/**

	 * [edit description]

	 * @Author   roger

	 * @DateTime 2018-11-19T15:37:32+0800

	 */


	public function edit(){ 
		
		$strcon = lcfirst(request()->controller());

		$str = lcfirst(request()->controller().'_id');
		
		$id = input('id');

		$arr = [$str=>$id];
		// halt($arr);
        $list = db(request()->controller());
		// halt( $list->where($arr)->find());
        $this->assign('list', $list->where($arr)->find());

        if (request()->ISPOST()) {

            $data = request()->except(['id','file']);
			// halt($data);
			$data[$strcon.'_updatetime'] = time();
			
			$redata = array_merge($arr,$data);
			
			$res = $list->update($redata);
			
            if (!$res) {
                return $this->get_code(0, "更新失败");
            }
            return $this->get_code(1, "更新成功");
        }

        return view();
		
	}

	/**
	 * [delete 删除]
	 * 
	 * @Author   roger
	 * 
	 * @DateTime 2019-01-18
	 * 
	 * @return   [mixed]     [description]
	 */
	public function delete(){
		
		$str = lcfirst(request()->controller().'_id');
		
		$id = input('id');
		// halt($id);
		$arr = [$str=>$id];

        $dele = db(request()->controller())->where($arr);

        $delefile = $dele->find();
		
        $delepic = $dele->delete();

        if (!$delepic) {
            return $this->get_code(0, '删除失败');
        } else {

            return  $this->get_code(1, '删除成功');
        }
	}


	/**

	 * [msg 返回标准json消息]

	 * @Author   fjn

	 * @DateTime 2018-11-14T18:07:37+0800

	 * @param    integer                  $code [消息code]

	 * @param    [string]                 $msg  [返回消息]

	 * @param    array                    $data [返回数据]

	 * @return   [json]                         [返回消息]

	 */

	protected function msg($code = 0,$msg = null,$data = []){

		$arr = [

				'code'    => $code,

				'message' => $msg,

				'data'    => $data

		];

		return json($arr);

	}

	/**
  * @description: 	pic上传
  * @param {type} 
  * @return: 
  */ 
 
  public function upload()
  {

	  $file = request()->file('file');
		
	  $id = input();

	  $info = $file->validate(['size' => 15000000, 'ext' => 'jpg,png,gif,jpeg'])->move('../public/admin/uploads');

	  if (!$info) {

		  return $this->get_code(0, '上传失败');
	  } else {

		  $adress = $info->getSaveName();

		  $adds = str_replace('\\', '/', $adress);

		  return $this->get_code(1, '上传成功', $adds);
	  }
  }

    /**
     * @description: get_code
     * @param {type}  后台返回数据
     * @return:  
     */    
    public function get_code($code = '200', $msg = '', $data = [])
    {
        return  json([

            'code' => $code,
            'msg' => $msg,
            'data' => $data
        ]);
    }
 
	public function changestates()
	{
		
		if (request()->ISPOST()) {

			$lei = lcfirst(request()->controller());

			$str = $lei.'_id'; //定义当前的Id字段
			
			$state = $lei.'_state'; //定义当前的state字段 

			$id = input('id');

			$restate = input('state');

			$arr = [$str=>$id,$state=>$restate];

			if($arr[$state]==2){
				$arr[$state] = 1;
			}else{
				$arr[$state] = 2;
			}
			
			$arr['updatetime'] = time();

			$list = db(request()->controller());
			halt($arr);
			$res = $list->update($arr);
			
           
        }
		if (!$res) {
			return $this->get_code(0, "更新失败");
		}
		return $this->get_code(1, "修改成功");
		
	}

}