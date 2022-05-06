<?php

class MY_Controller extends CI_Controller

{

	public function __construct($props = array())

	{

		parent::__construct($props);

		$this->load->model('modelbasic');

	}



	protected function send_a_mail($data)

	{

	      	if($this->input->server('HTTP_HOST', TRUE)=='localhost')

	      	{

	      		/*$config = Array(

			'protocol' => 'smtp',

			'smtp_host' => 'ssl://smtp.googlemail.com',

			'smtp_port' => 465,

			'smtp_user' => 'test.unichronic@gmail.com', // change it to yours

			'smtp_pass' => 'Uspl@12345',

			'mailtype' => 'html',

	            'charset'  => 'iso-8859-1',

	            'validate'  => TRUE ,

	            'newline'   => "\r\n",

	            'wordwrap' => TRUE

	            );*/

	      	}

	      	else

	      	{

	      		$config = Array(

	      		'mailtype' => 'html',

	            'charset'  => 'iso-8859-1',

	            'validate'  => TRUE ,

	            'newline'   => "\r\n",

	            'wordwrap' => TRUE

	            );

	      	}



		$this->load->library('email');

		$this->email->initialize($config);

		$this->email->from($data['from']);

		$this->email->to($data['to']);

		$this->email->subject($data['subject']);

		$this->email->message($data['message']);

		$return = $this->email->send();

            if($return == 1)

			   return true;

 	       else

			   return false;

   }





   protected function send_a_mail_with_attachment($data)

   {

	      	if($this->input->server('HTTP_HOST', TRUE)=='localhost')

	      	{

	      		/*$config = Array(

			'protocol' => 'smtp',

			'smtp_host' => 'ssl://smtp.googlemail.com',

			'smtp_port' => 465,

			'smtp_user' => 'test.unichronic@gmail.com', // change it to yours

			'smtp_pass' => 'Uspl@12345',

			'mailtype' => 'html',

	            'charset'  => 'iso-8859-1',

	            'validate'  => TRUE ,

	            'newline'   => "\r\n",

	            'wordwrap' => TRUE

	            );*/

	      	}

	      	else

	      	{

	      		$config = Array(

	      		'mailtype' => 'html',

	            'charset'  => 'iso-8859-1',

	            'validate'  => TRUE ,

	            'newline'   => "\r\n",

	            'wordwrap' => TRUE

	            );

	      	}

			$this->load->library('email');

			$this->email->initialize($config);

			$this->email->from($data['from']);

			$this->email->to($data['to']);

			$this->email->subject($data['subject']);

			$this->email->message($data['message']);

			$this->email->attach($data['file_path']);

			$return = $this->email->send();



            if($return == 1)

			   return true;

 	       else

			   return false;

   	}





   	protected function upload_image($data)

	{

		if(!is_dir(file_upload_s3_path().$data['folder_name']))

		{

			mkdir(file_upload_s3_path().$data['folder_name'], 0777, TRUE);

		}

		$config['upload_path']=file_upload_s3_path().$data['folder_name'];

		$config['allowed_types'] = 'jpg|png|jpeg';

		$this->load->library('upload',$config);



		if($this->upload->do_upload($data['input_name']))

		{

			$img_data=$this->upload->data();

		}

		else

		{

			$img_data['img_error']=$this->upload->display_errors();

		}

		return $img_data;

    }





	protected function image_resize($data)

	{

		if(!is_dir(file_upload_s3_path().$data['folder_name'].'/thumbs'))

		{

			mkdir(file_upload_s3_path().$data['folder_name'].'/thumbs', 0777, TRUE);

		}



		$config['image_library'] = 'gd2';

		$config['source_image'] = file_upload_s3_path().$data['folder_name'].'/'.$data['file_name'];

		$config['create_thumb'] = FALSE;

		$config['maintain_ratio'] = FALSE;

		$config['width'] = $data['width'];

		$config['height'] = $data['height'];

		$config['new_image'] = file_upload_s3_path().$data['folder_name'].'/thumbs/'.$data['file_name'];

		$this->load->library('image_lib',$config);

		$return = $this->image_lib->resize();



		if($return == TRUE )

			return true;

		else

			return false;

   }



	function get($order_by,$table)

	{

		$query = $this->modelbasic->get($order_by,$table);

		return $query;

	}



	function getValue($getColumn,$fieldName, $fieldValue, $table)

	{

		$query = $this->modelbasic->getValue($getColumn,$fieldName, $fieldValue, $table);

		return $query;

	}



	function get_with_limit($limit, $offset, $order_by,$table) {

		$query = $this->modelbasic->get_with_limit($limit, $offset, $order_by,$table);

		return $query;

	}



	function get_where($id,$table){

		$query = $this->modelbasic->get_where($id,$table);

		return $query;

	}



	function get_where_custom($col, $value,$table) {

		$query = $this->modelbasic->get_where_custom($col, $value,$table);

		return $query;

	}



	function _insert($data,$table){

		return $this->modelbasic->_insert($data,$table);

	}



	function _update($id, $data,$table){

		$this->modelbasic->_update($id, $data,$table);

	}



	function _delete($id,$table){

		$this->modelbasic->_delete($id,$table);

	}



	function count_where($column, $value,$table) {

		$count = $this->modelbasic->count_where($column, $value,$table);

		return $count;

	}



	function get_max($table) {

		$max_id = $this->modelbasic->get_max($table);

		return $max_id;

	}



	function _custom_query($mysql_query,$table) {

		$query = $this->modelbasic->_custom_query($mysql_query,$table);

		return $query;

	}



}

?>