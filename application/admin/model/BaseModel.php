<?php 

	namespace app\common\model;



	use think\Model;

	use think\Request;

	class BaseModel extends Model

	{

		static protected $modelName = '';//定义当前模型名



		protected $autoWriteTimestamp = true; //自动写入时间戳 针对create_time  update_time

		/**

		 * [initialize 初始化 获取当前模型名]

		 * @Author   fjn

		 * @DateTime 2018-11-19T09:24:01+0800

		 * @return   [type]                   [description]

		 */

		protected static function init()

		{

		    self::$modelName =  get_called_class();//获取调用子类的命名空间   



		    if(is_string(self::$modelName) && strpos(self::$modelName,'\\')){


		    	$name = array_reverse(explode('\\', self::$modelName))[0];

		    	
		    	self::$modelName = $name; //获取模型名


		    }

		}





		//实例化继承模型

		protected function example(){
			
			return model(self::$modelName);

		}



		/**

		 * [getList 获取简单模型数据list]

		 * @Author   fjn

		 * @DateTime 2018-11-19T09:11:41+0800

		 * @return   [type]                   [description]

		 */

		public function dataList($map,$where=[],$p=0){


			
			if($p == 0){

				
				$list = $this->example()->where($map)->order('id desc')->paginate(config('admin.page'),false,['query' => request()->param(),'type' => 'page\Page','var_page'  => 'page']);
				// echo $this->example()->getLastSql();die();

			}else{


				$list = $this->example()->where($map)->order('id desc')->paginate($p,false,['query' => request()->param(),'type' => 'page\Page','var_page'  => 'page']);


			}

			

			return $list;

		}



		/**

		 * [dataAdd 数据增加]

		 * @Author   fjn

		 * @DateTime 2018-11-19T14:38:32+0800

		 * @param    [type]                   $data [description]

		 * @return   [type]                         [description]

		 */

		public function dataAdd($data){

			$res = $this->example()->save($data);

			// $res = $this->example()->data($data,true)->save();

			return $this->example()->id;



		}



		/**

		 * [dataEdit 编辑查询]

		 * @Author   fjn

		 * @DateTime 2018-12-22T16:31:53+0800

		 * @param    [type]                   $id [description]

		 * @return   [type]                       [description]

		 */

		public function dataEdit($id){

			$list = $this->example()->get($id);

			return $list;

		}

		/**

		 * [dataAdd 修改]

		 * @Author   fjn

		 * @DateTime 2018-11-19T14:38:32+0800

		 * @param    [type]                   $data [description]

		 * @return   [type]                         [description]

		 */

		public function dataSave($data,$id){	


			// $this->example()->data($data,true)->save();
			$this->example()->save($data,$id);

		

			return true;

		}



		//删除

		public function dataDelete($id,array $where=NULL){



				isset($id['id']) == true ? $id = $id['id'] : $id = $id;



				if($where == NUll){



					$this->example()->destroy($id); //真删除



				}else if(in_array($where, ['isdelete' => 1])){



					$this->example()->save(['id' => $id,$where]); //假删除



				}

			

			return true;

		}



		public  function dataStatus($data){



			echo 1;

			

			// halt($this->example());

			

			// $this->example()->where('id',$data['id'])->save(['status' => $data['status']]);



			// return $this->example();

		}



	}



 ?>

