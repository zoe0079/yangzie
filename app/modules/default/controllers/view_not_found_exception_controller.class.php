<?php
/**
 *
 * @version $Id$
 * @package default
 */
class View_Not_Found_Exception_Controller extends Resource_Controller {
		
	public function get(){
		//TODO
		$this->set_View_Data(Yangzie_Const::PAGE_TITLE,	__("未找到视图"));
	}
			
	public function post(){
		//TODO
		
	}
			
	public function delete(){
		//TODO
		
	}
			
	public function put(){
		//TODO
		
	}
	
    protected $module_name = "default";
    protected $models = array();
    private $exception;
	public function set_exception(Exception $e){
		$this->exception = $e;
	}
}
?>