<?php
namespace Controllers;
use Resources, Models;

class Home extends Resources\Controller{

	public function __construct(){
        
        parent::__construct();
    }
	
	/**
	 * load pertama controler 
	 * template dinamis							
	 * @param  string $pages [halaman yang diload liat: di view/default]
	 * @return array $data   [description]
	 */
    public function index($pages='dashboard'){
        $data['title'] = 'PANADA DATATABLES';
		$data['halaman']= (file_exists(TEMPLATE.$pages.'.php')) ? $pages : '404';
		$this->output('default/template', $data);
    }
}
