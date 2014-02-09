<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Webbase extends CI_Controller {
  public $viewData = array();
  protected $userInfo = array('uid'=>0,'uname'=>'','isvip'=>0);
  public $adminList = array(3);
  protected $isadmin = 0; 
  
  public function __construct(){
    parent::__construct();
    //解析UID
    $uid = getSynuserUid();
    $uinfo = getSynuserInfo($uid);
    var_dump($uinfo);exit;
    $this->userInfo = $this->usermodel->getUserInfo($uinfo);
    $this->assign(array('domain'=>$this->config->item('domain'),
                'base_url'=>$this->config->item('base_url'),'css_url'=>$this->config->item('css_url'),
                'img_url'=>$this->config->item('img_url'),'js_url'=>$this->config->item('js_url'),
                'toptips'=>$this->config->item('toptips'),'web_title'=>$this->config->item('web_title')
                ,'version'=>20140109,'login_url'=>$this->config->item('login_url'),'uinfo'=>$this->userInfo

    ));
  }
  
  public function checkLogin(){
    if(isset($this->userInfo['uid']) &&$this->userInfo['uid']>0){
      return true;
    }else{
      return false;
    }
  }
  public function checkIsadmin(){
    if(!$this->checkLogin()){
      redirect($this->config->item('login_url').$this->config->item('base_url'));
    }
    if(in_array($this->userInfo['groupid'],$this->adminList)){
      return true;
    }
    foreach($this->userInfo['groups'] as $gid){
      if(in_array($gid,$this->adminList)){
        return true;
      }
    }
      return false;
  }
  public function assign($data){
    foreach($data as $key => $val){
      $this->viewData[$key] = $val;
    }
  }
}
