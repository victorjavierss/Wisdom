<?php
class Catalog_Controller extends Wisdom_Widget_Abstract{

	public function display(){
		$req = $this->getRequest();
		$entity = $req->entity;

		if(!$entity){
			throw new Exception("No entity was especified por catalog");
		}

		$this->setViewVar('url', URL . "catalog/retrievedata/entity/{$entity}/page/1");

		$model = Wisdom_Utils::factory($entity.'_Model');

		$fields = $model->getFields();

		$headers = array();

		foreach($fields as $field){
			$headers[] = $field['label'];
		}

		//$options = $model->getCatalogOptions();

		$page_size = $req->page_size;
		
		$page_size = $page_size ? $page_size : 10;

		$select = $model->getSelect();

		$select->limit($page_size);
		
		$data        = $model->fetchAll($select);

		$total       = $model->rowCount();

		$total_pages = ceil( $total / $page_size);  

		$this->setViewVar('headers',$headers);
		
		$this->setViewVar('fieldsNum',count($headers));

		$render = $this->renderData($fields,$data);
		
		$this->setViewVar('data',$render);
		
		$this->setViewVar('total_pages',$total_pages);
		
	}

	public function display2(){
		$req = $this->getRequest();
		$entity = $req->entity;
		if(!$entity){
			throw new Exception("No entity was especified por catalog");
		}
			
		$this->setViewVar('url', URL . "catalog/retrievedata/entity/{$entity}/page/1/search/text");
			
		$model = Wisdom_Utils::factory($entity.'_Model');
		$fields = $model->getFields();
			
	 $headers = array();
	  
	 foreach($fields as $field){
	 	$headers[] = $field['label'];
	 }

	 $this->setViewVar('headers',$headers);
	  
	}

	public function retrieveData(){
		$req   = $this->getRequest();
		if($req->isAjax() || DEBUG){
			$entity = $req->entity;
			if(!$entity){
				throw new Exception("No entity was especified por catalog");
			}
			$page  = $req->page;
			$model = Wisdom_Utils::factory($entity.'_Model');
			$order = $req->order ? $req->order : $model->getPrimary();
		}else{
			throw new Exception('This function only available via ajax',2);
		}
		
		$this->noRender();
	}

	private function renderData($fields, $data){
		
		$rendered_table = '';
		
		$row_par = FALSE;
		
		foreach($data as $row){
			$clase_css = ($row_par) ? 'odd' : 'even';
			$row_par = ($row_par) ? FALSE : TRUE; 
			$rendered_table .= "<tr class='{$clase_css}'>";
			foreach($fields as $name=>$field){
				$value = $row->$name;
				if( isset($field['helper']) ){
					$helper = Wisdom_Utils::factory('Wisdom_Helper');
					$value  = call_user_func(array($helper, $field['helper']),$value);
				}
				$rendered_table .= "<td>{$value}</td>";
			}
			$rendered_table .= '</tr>';
		}
		return $rendered_table;
	}

	public function edit($id){
		$data = $this->_Model->findHashId($id,'sha1');
	}

	public function newRecord(){
		echo "Nuevo registro";
	}

	public function init(){
		$module = current(current(func_get_args()));
		$this->url = URL . "catalog/display/entity/$module";
	}
}
?>
