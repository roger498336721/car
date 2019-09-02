<?php
namespace app\admin\controller;
class Company extends Base
{
    public function add()
	 {
		$strcon = lcfirst(request()->controller());

		 if (request()->isPOST()) {
			
			$data = request()->except('file');

			$str = lcfirst(request()->controller().'_id');
			
			$data[$str]=md5(uniqid());	//添加ID
			
			$data[$strcon.'_addtimeinfo']=time();
			
			$data[$strcon.'_addtime']=date('Y/m/d H:i:s');
			
			
			$res = db(request()->controller())->insert($data);
 
			 if (!$res) {
 
				 return    $this->get_code(0, "添加失败");
			 }
			 return $this->get_code(1, '添加成功');
		 }
        
		 $data = db('region')->where('level',1)->select();

		 $this->assign('province',$data);
		 
		 return view();
     }
     


    public function region()
    {


		

      
	}
	
	public function uploads()
	{
		halt(request()->param());
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
  
}