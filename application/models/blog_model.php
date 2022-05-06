<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Blog_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	public function getAllData($search_term='')
	{
		$this->db->select('A.id,A.title,A.picture,A.description,A.keywords,A.created,A.posted_by');
		$this->db->from('blog as A');
		if($search_term != '')
		{
			$this->db->where("(description LIKE '%".$search_term."%'|| keywords LIKE '%".$search_term."%'|| title LIKE '%".$search_term."%')");
		}
		$this->db->where('A.status',1);
		$this->db->limit(4);
		$this->db->order_by('A.created','desc');
		return $this->db->get()->result_array();
	}
	public function getSingleBlogData($id)
	{
		$this->db->select('A.id,A.title,A.picture,A.description,A.keywords,A.created,A.posted_by');
		$this->db->from('blog as A');
		$this->db->where('A.id',$id);
		return $this->db->get()->result_array();
	}
	
	public function more_data($limit,$page,$search_term)
	{
	 	$start=($page-1)*$limit;
		$this->db->select('id,title,picture,description,keywords,created,posted_by');
		$this->db->from('blog');
		$this->db->where('status',1);
		if($search_term != '')
		{
			$this->db->where("(description LIKE '%".$search_term."%'|| keywords LIKE '%".$search_term."%'|| title LIKE '%".$search_term."%')");
		}
		$this->db->limit($limit);
		$this->db->offset($start);
		$this->db->order_by('created','desc');
	    $data = $this->db->get()->result_array();
	   if(!empty($data))
		{
			$i = 0; 
			foreach($data as $row)
			{
				$data[$i]['created'] = date("j F Y", strtotime($row['created']));
				$i++;
			}
				
		 	echo json_encode($data);
	    }
	    else
	    {
	     	echo '';
	    }
	}
	public function getAllComment($id)
	{
		//echo $id;die;
		$this->db->select('A.comment,A.created,B.firstName,B.lastName,B.profileImage,B.id as userId');
		$this->db->from('blog_comment as A');
		$this->db->join('users as B','B.id=A.userId');
		$this->db->where('A.blogId',$id);
		return $this->db->get()->result_array();
	}
	public function submit_blog_comment($data)
	{
		return $this->db->insert('blog_comment',$data);
	}
	
	public function getResentBlog($id)
	{
		$this->db->select('A.id,A.title,A.picture,A.description,A.keywords,A.created');
		$this->db->from('blog as A');
		$this->db->where('A.status',1);
		$this->db->where('A.id !=',$id);
		$this->db->limit(8);
		return $this->db->get()->result_array();
	}
}
