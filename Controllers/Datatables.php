<?php
namespace Controllers;
use Resources, Models, Libraries;

class Datatables extends Resources\Controller
{   

	public function __construct(){
		parent::__construct();
		$this->session    = new Resources\Session;
		$this->rest       = new Resources\Rest;
		$this->request    = new Resources\Request;
		$this->DT         = new Libraries\Datatables;
		$this->table      = new Models\Datatables;
		$this->validation = new Models\FormValidation;
	}
	
	public function index(){
		$data['title']   = 'Datatables';
		$data['halaman'] ='datatables';
		$data['form']    = false;
		$this->output('default/template',$data);
	}	
	
	/**
	 * method untuk mengambil data 
	 * @param  string $action [default read: membaca data dan ditampilkan di datatables]
	 * @return [type]         [description]
	 */
	public function init($action='read'){    
		if (IS_AJAX) {
			$action = $this->request->post('action');
			switch ($action){
				default:
				$this->_read();
				break;
				case 'read':
				$this->_read();
				break;
				case 'remove':
				$this->_delete($this->request->post('data'));
				break;
			}
		}
	}
	
	/**
	 * method untuk tambah data
	 */
	public function add(){
		$data['title']   = 'Create Dosen'; 
		$data['halaman'] = 'datatables';
		$data['form']    = true;
		$data['action']  ='create';
		$data['style']   = "";
		
		$this->validation->ruleConfig = array(
			'NIDNNTBDOS' => array('validate' => 'NUMBER', 'label' => 'NIDN', 'rules' => array('callback' => 'nidnExists')), 
			'NMDOSTBDOS' => array('validate' => 'STRING', 'label' => 'Nama Dosen' )
		);

		$data ['validate']['rules'] = $this->validation->setRules(); // debug NB: bisa di matikan

		if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
			if( $this->validation->validate() ){
				$data ['validate']['valPost']= $this->validation->value(); // debug NB: bisa di matikan
				// $data ['validate']['lastInsert'] = $this->table->Create($this->validation->value()); // debug NB: bisa di matikan
				
				/* jika insert sukses tampilkan pesan */
				if ($this->table->Create($this->validation->value())) { 
					$data['messages'] = 'Data sukses di simpan';
				}else{ 
					$data['messages'] = 'Data Gagal di simpan';
				}
			}
			$data ['validate']['validasi'] = $this->validation; // debug NB: bisa di matikan
		}
		$data['validasi'] = $this->validation;
		$this->output('default/template',$data);
	}
	
	/**
	 * method untuk edit data berdasarkan id
	 * @param  integer $id [parameter id]
	 * @return [type]      [description]
	 */
	public function edit($id=0){
		$data['title']   = 'Update Dosen'; 
		$data['halaman'] = 'datatables';
		$data['form']    = true;
		$data['action']  ='edit';
		$data['value']   = Resources\Tools::objectToArray($this->table->getOne(array("IDTBDOS"=>$id)));
		$data['style']   = "";
		
		if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
			$this->validation->checkNIDN = false;
			
			if( $this->validation->validate() ){
				$data ['validate']['valPost']= $this->validation->value();
				// $data ['validate']['lastUpdate'] = $this->table->Update($this->validation->value(), array("IDTBDOS"=>$id));
				$data ['style'] = "has-success";
			}else{
				$data ['style'] = "has-error";
			}
		}
		$data['validasi'] = $this->validation;

		$this->output('default/template',$data);
	}
	
	/**
	 * [method untuk mengenerate data yang akan ditampilkan di datatables]
	 * @return [JSON] [return berupa JSON]
	 */
	private function _read(){	
		$this->DT
		->primary("IDTBDOS")
		->select(array('NIDNNTBDOS','NOKTPTBDOS','NMDOSTBDOS','TPLHRTBDOS','TGLHRTBDOS'))
			//->select(array('KDKMKTBKMK','NAKMKTBKMK','NMDOSTBDOS'))
		->from('tbdos')
			//->join('tbdos','NODOSTBKMK','NIDNNTBDOS')
		// ->where ('KDKMKTBKMK','=','DMI201');
		->where ('TPLHRTBDOS','=','wonosobo');
		echo $this->DT->generate();
		
	}
	
	/**
	 * method untuk delete data
	 * @param  [type] $dowhere [berupa array]
	 * @return [type]          [description]
	 */
	private function _delete($dowhere){
		$data = $this->rest->getRequest();
		$data['requestMethod'] = $this->rest->requestMethod;
		$this->table->delete($dowhere);
		$this->outputJSON($data, 200);
	}
} 