<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'usrbase.php';
class Index extends Usrbase {
   
	/**
	 * Index Page for this controller.
	 *
	 */
  public function __construct(){
    parent::__construct();
    $this->load->model('indexmodel');
  }
  public function index()
  {
   // $this->load->model('testmodel');
    $data=$this->indexmodel->getdata();
    $data = array($data,get_client_ip());
    $this->load->view('welcome_message',array('data'=>$data));
  }
  public function insert($name){
   // $this->load->model('testmodel');
    $this->testModel->Insertdata($name);
  }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
