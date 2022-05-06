
<style>
  .contact-btn:hover {
    color: #ffffff!important;
    background-color: orangered!important;
    border-color: orangered!important;
}
</style>
<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Resource extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_basic');
		$this->load->model('resource_model');
	}
	public function live()
	{
		$data['up_webinar']=$this->resource_model->get_all_front_webinar_up();
		$data['past_webinar']=$this->resource_model->get_all_front_webinar_past();
		//$data['banner']=$this->resource_model->getSelectedData('banner','*',array('status'=>1,'banner_page_name'=>'webinars'));

		//$data['meta_tags']=$this->modelbasic->getValue('widgets','description',array('id'=>'32','status'=>1));
		//$data['meta_desc']=$this->modelbasic->getValue('widgets','description',array('id'=>'33','status'=>1));
		//$data['page_name']=$this->modelbasic->getValue('widgets','description',array('id'=>'34','status'=>1));
      	//echo "<pre/>"; print_r($data); die;
        $data['meta_title'] = 'Know the insights of Design Learning at Creonow';
        $data['meta_description'] = 'Master your designing skills with the experts! - Attend Free webinar sessions on various Design Learning and exclusive industry insights at Creonow.'; 
        $data['meta_keywords'] = 'Design learning, Live seminars, Live graphic desgning seminars, Live photoshop learning, Live illustrator learning, Video editor workshops, Illustrator workshops, Photoshop workshops, Photshop illustrator course, CorelDraw tutorials, graphic design software learning, Blender tutorials, graphic design software tutorials.';
      	//echo "<pre/>"; print_r($data); die;
		$this->load->view('webinar_view', $data);
	}
  
  	public function get_webinar($type)
	{
      	$redirect_page_name = 'live_sessions';
		if($type==1)
		{
			$webinar=$this->resource_model->get_all_front_webinar_up();
		}
		else
		{
			$webinar=$this->resource_model->get_all_front_webinar_past();
		}
		if(!empty($webinar))
		{
				$html='';

			foreach ($webinar as $wd) {
              //$html .= '<article class="isotopeElement post_format_standard odd flt_8" style="width: 390px;"><div class="isotopePadding bg_post"><a title="Detail" href="'.base_url().'resource/detailwebinars/'.$wd['webinar_title'].'"><div class="thumb hoverIncrease hoverTwo inited" data-link="#" data-image="'.base_url().'uploads/webinar/'.$wd['image'].'" data-title="'.$wd['webinar_title'].'"><img alt="'.$wd['webinar_title'].'" src="'.base_url().'uploads/webinar/'.$wd['image'].'"><span class="hoverShadow"></span></div><div class="post_wrap"><h4><a href="'.base_url().'resource/detailwebinars/'.$wd['webinar_title'].'">'.$wd['webinar_title'].'</a></h4><div class="post_format_wrap postStandard"></div></div></a></div></article>';
              $html .= '<article class="col-lg-4 col-sm-6 mb-2 mb-lg-0 px-1 isotopeElement" style="padding-bottom: 30px;"><div class="isotopePadding bg_post"><div class="thumb hoverIncrease hoverTwo inited" data-link="#" data-image="'.base_url().'uploads/webinar/'.$wd['image'].'" data-title="'.$wd['webinar_title'].'"><img alt="'.$wd['webinar_title'].'" src="'.base_url().'uploads/webinar/'.$wd['image'].'"><span class="hoverShadow"></span></div><div class="post_wrap"><h4>'.$wd['webinar_title'].'</h4>';
              /*if(!empty($wd['description'])){
                if(strlen($wd['description']) > 75)
                {
                  $html .= '<div class="post_format_wrap postStandard">'.substr($wd['description'], 0, 75).'...</div>';
                }
                else
                {
                  $html .= '<div class="post_format_wrap postStandard">'.substr($wd['description'], 0, 75).'</div>';
                }
              }
              else{
              	$html .= '<div class="post_format_wrap postStandard"></div>';
              }*/
              if($type==1){
                if(!empty($this->session->userdata('front_user_id'))) { 
                  $html .= '<a href="'.base_url().'resource/detailwebinars/'.$wd['webinar_title'].'" class="squareButton sc_button_style_accent_2 accent_2 big contact-btn regBtn" style="padding: 15px; margin-bottom: 15px;">Attend</a>';
                } else{
                    $html .= '<a href="'.base_url().'my_default/index/'.$redirect_page_name.'" class="squareButton sc_button_style_accent_2 accent_2 big contact-btn regBtn" style="padding: 15px; margin-bottom: 15px;">Register</a>';
                }
              }
              else{
              	if(!empty($this->session->userdata('front_user_id'))) { 
                  $html .= '<a href="'.base_url().'resource/detailwebinars/'.$wd['webinar_title'].'" class="squareButton sc_button_style_accent_2 accent_2 big contact-btn regBtn" style="padding: 15px; margin-bottom: 15px;">View</a>';
                  if(!empty($wd['video'])){
                    
                  	$html .= '&nbsp;&nbsp;<a href="'.base_url().'resource/detailwebinarsvideo/'.$wd['webinar_title'].'" class="squareButton sc_button_style_accent_2 accent_2 big contact-btn regBtn" style="padding: 15px; margin-bottom: 15px;">Watch Video</a>';
                  }
                } else{
                    $html .= '<a href="'.base_url().'my_default/index/'.$redirect_page_name.'" class="squareButton sc_button_style_accent_2 accent_2 big contact-btn regBtn" style="padding: 15px; margin-bottom: 15px;">Register</a>';
                }
              }
              $html .= '</div></div></article>';
			}
			echo $html;
		}
		else {
			if($type==1)
				{
					echo 'No upcoming Sessions, take look of past sessions by clicking on "Past Sessions”.';
				}
				else
				{
					echo 'No past Sessions, take look of upcoming sessions by clicking on "Upcoming Sessions”.';
				}
		}

		
	}
  
  public function detailwebinars($name)
	{
		$title_presentation =urldecode($name);
  	
  	if(!empty($this->session->userdata('front_user_id')) && ($this->session->userdata('front_user_id') != ''))
  	{
      $data['webinar']=$this->resource_model->getSelectedData('webinar','*',array('webinar_title'=>$title_presentation,'status'=>1),$orderBy='',$dir='',$groupBy='',$limit='',$offset='',$resultMethod='');
      $this->load->view('detail_webinar_view', $data);
    }
  	else
  	{
    	redirect(base_url()."my_default/index/live_sessions");
    }

	}
  	
  	public function detailwebinarsvideo($name)
	{
		$title_presentation =urldecode($name);
		$data['webinar']=$this->resource_model->getSelectedData('webinar','*',array('webinar_title'=>$title_presentation,'status'=>1),$orderBy='',$dir='',$groupBy='',$limit='',$offset='',$resultMethod='');
		$this->load->view('video_webinar_view', $data);

	}
  
    public function add_detail()
	{
	    //echo "<pre>";print_r($_POST);exit;
        $this->load->library('form_validation');
	    $this->form_validation->set_rules('name','Full Name','trim|xss_clean');
	    //$this->form_validation->set_rules('lname','Last Name','trim|xss_clean|required|alpha');
	    $this->form_validation->set_rules('contact','Contact Number','trim|xss_clean');
	    $this->form_validation->set_rules('organization','Company Name','trim|xss_clean');
	    $this->form_validation->set_rules('email','Email','trim|xss_clean|required|valid_email'); 
        $this->form_validation->set_rules('message','Message','required|trim|xss_clean');  
      
	    if($this->form_validation->run())
	    {
	    	//echo "in"; exit;
	    	$data = array(
	    	                 'name' => $_POST['name'],
	    	                'contact' => $_POST['contact'],
	    	                'organization' => $_POST['organization'],
	    	                 'email' => $_POST['email'],
                             'message'=>$_POST['message'],
	    	                 'created' => date("Y-m-d H:i:s"));	   
	    	                 
	    	$res = $this->model_basic->_insert('view_demo_details',$data);
           // exit;
	    	if($res > 0)
	    	{
	    		//$session_data=array('session_id'=>$res,'project_id'=>$_POST['project_id']);
	    		//$insert_session_data = $this->modelbasic->_insert('session_demo_detail_relation',$session_data);
	    		//if($_POST['project_id']!=0)
	    		//{
	    			//$this->session->set_userdata('SessionDemoRelationId',$res);
	    			//$this->load->model('frontend_model');
	    			//$adminData=$this->frontend_model->get_admin_detail();
	    			//echo "<pre>";print_r($adminData);exit;
	    			
	    			$admin_email="connectwithus@creonow.com";
	    			//$messages='Following user is intrested in your portfolio :-<br/>Name : '.$_POST['name'].' <br />Email Id : '.$_POST['email'].'<br />Contact Number : '.$_POST['contact'].'<br />Company Name : '.$_POST['organization'];
              
                     $templatemessage ='Hello <b>Admin</b>,<br /><br />Following user is interested to contact you. :-<br/><br/>Name : '.$_POST['name'].' <br />Email Id : '.$_POST['email'].'<br />Contact Number : '.$_POST['contact'].'<br />Company Name : '.$_POST['organization'].'<br />Message : '.$_POST['message'];
              
	    			$emailData = array('to'=>$admin_email,'fromEmail'=>$_POST['email'],'subject'=>'Someone is intrested in your portfolio','template'=>$templatemessage);
	    			$res = $this->model_basic->sendMailToAdmin($emailData);
                    $this->session->set_flashdata('success', 'Request Submitted Successfully');
                    redirect(base_url().'resource/live/');
	    			
	    	}
	    	else
	    	{
	    		$this->session->set_flashdata('error', 'Failed to insert data, please fill the form again.');
	    		redirect('resource');
	    	}
	    }
	    else
	    {
	        echo "out"; exit;
	    	$this->session->set_flashdata('error', 'Please fill out all required fields.');
	    	redirect('portfolio');
	    }
	}
}














