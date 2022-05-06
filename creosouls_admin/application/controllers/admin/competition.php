<?php

if (!defined('BASEPATH'))

    exit('No direct script access allowed');



/*

*	@author : Santosh Badal

*	date	: 05 August, 2015

*	http://unichronic.com

*	Unichronic - Master Admin

*/

class Competition extends MY_Controller
{

	function __construct()
	{
    	parent::__construct();
    	if($this->session->userdata('admin_level')==3)
	    {
			redirect(base_url());
		}

    	$this->load->library('form_validation');

    	$this->load->library('upload');

    	$this->load->library('image_lib');

    	$this->load->model('modelbasic');

    	$this->load->model('admin/competition_model');

    	$this->load->model('admin/project_model');

	}



	public function index()
	{
		$data['countries']=$this->competition_model->getAllCountry();
		$data['institutedata']=$this->competition_model->getregionwiseinstitute();
		//echo $this->db->last_query();
		//print_r($data);die;
		$this->load->view('admin/competition/manage_competition',$data);
	}



	public function getAutocompleteInstituteData()

	{

		echo $this->competition_model->getAutocompleteInstituteData();

	}





	function get_ajaxdataObjects()

	{

		$this->competition_model->markCompletedCompetions();



		$_POST['columns']='A.id,A.profile_image,A.name,A.created,A.status,A.banner,A.end_date,A.start_date,A.evaluation_end_date,A.evaluation_start_date,A.award,A.jury,A.eligibility,A.rule,A.instituteId,A.addedBy'; //userStatus,B.id,B.email,admin_name,

		$requestData= $_REQUEST;

		//print_r($requestData);die;

		$columns=explode(',',$_POST['columns']);



		$selectColumns="A.id,A.profile_image,A.name,A.created,A.status,A.banner,A.end_date,A.start_date,A.evaluation_end_date,A.evaluation_start_date,A.award,A.jury,A.eligibility,A.rule,A.instituteId,A.addedBy";

		//CONCAT(B.firstName, ' ',B.lastName) as admin_name,B.status as userStatus,B.id as userId,B.email,B.profileImage,

		//print_r($columns);die;

		//get total number of data without any condition and search term

		  if($this->session->userdata('admin_level')==2)

			{

				$condition=array('instituteId'=>$this->session->userdata('instituteId'));

			}

			else

			{

				$condition=array();

			}



		$totalData=$this->modelbasic->count_all_only('competitions',$condition);

		//print_r($totalData);die;

		$totalFiltered=$totalData;



		//pass concatColumns only if you want search field to be fetch from concat

		    $concatColumns=''; //B.firstName,B.lastName

			$result=$this->competition_model->run_query('competitions',$requestData,$columns,$selectColumns,$concatColumns,''); //admin_name

			//print_r($result);die;

			if( !empty($requestData['search']['value']) )

			{

				$totalFiltered=count($result);

			}

			$data = array();



			if(!empty($result))

			{

				$i=1;

				foreach ($result as $row)

				{

				  $nestedData=array();



				    $competition_projects=$this->modelbasic->get_where_custom('project_master','competitionId',$row['id']);



				    $html='';

				    $det = $competition_projects->result_array();

				    if(!empty($det))

				  	{

				  		$j=1;

				  		foreach($det as $dt)

				  		{

				  			$coverImage=$this->project_model->getProjectCoverImage($dt['id']);

				  			if($coverImage <> '')

				  			{

				  				if(file_exists(file_upload_absolute_path().'project/thumbs/'.$coverImage))

				  				{

				  					$projectCoverImage = '<img width="135" src="'.file_upload_base_url().'project/thumbs/'.$coverImage.'">';

				  				}

				  				else

				  				{

				  					$projectCoverImage= '<img width="135" src="'.base_url().'backend_assets/img/noimage.png">';

				  				}

				  			}

				  			else

				  			{

				  				$projectCoverImage = '<img width="135" src="'.base_url().'backend_assets/img/noimage.png">';

				  			}

				  			$rating='<a data-controls-modal="ratingsModal" data-backdrop="static" data-keyboard="false" data-target="#ratingsModal" id="viewRating" data-id="'.$dt['id'].'" data-cid="'.$row["id"].'" data-toggle="modal"><span class="label label-success" style="cursor: pointer;">See Ratings</span></a>';



				  			$html.='<tr>

				  					  <td>'.$j.'</td>'.

				                        '<td>'.$dt['projectName'].'</td>'.

				                  	  '<td>'.$projectCoverImage.'</td>'.

				                  	  '<td>'.$rating.'</td>

				                     </tr>';

				               $j++;

				  		}

				  	}

				  	$nestedData['competition_projects']=$html;





					if($row['status'] == 1)

					{

						$userStatusHtml='<span class="label label-success" style="cursor: auto;">Active</span>';

					}

					else

					{

						$userStatusHtml='<span class="label label-danger" style="cursor: auto;">Deactive</span>';

					}



					/*if($row['admin_name'] == ' ')

					{

						$userName=ucwords('No Name');

					}

					else

					{

						$userName=ucwords($row["admin_name"]);

					}*/



					$competitionCoverImage=$row["banner"];

					//echo $instituteCoverImage;die;



					if($competitionCoverImage <> '')

					{

						if(file_exists(file_upload_absolute_path().'competition/banner/thumbs/'.$competitionCoverImage))

						{

							$competitionCoverImage = '<img width="135" src="'.file_upload_base_url().'competition/banner/thumbs/'.$competitionCoverImage.'">';

						}

						else

						{

							$competitionCoverImage = '<img width="135" src="'.base_url().'backend_assets/img/noimage1.png">';

						}

					}

					else

					{

						$competitionCoverImage = '<img width="135" src="'.base_url().'backend_assets/img/noimage1.png">';

					}



					$competitionLogo=$row["profile_image"];

					//echo $instituteCoverImage;die;

					if($competitionLogo <> '')

					{

						if(file_exists(file_upload_absolute_path().'competition/profile_image/thumbs/'.$competitionLogo))

						{

							$competitionLogo = '<img width="100" height="100" src="'.file_upload_base_url().'competition/profile_image/thumbs/'.$competitionLogo.'">';

						}

						else

						{

							$competitionLogo = '<img width="100" height="100" src="'.base_url().'backend_assets/img/noimage1.png">';

						}

					}

					else

					{

						$competitionLogo = '<img width="100" height="100" src="'.base_url().'backend_assets/img/noimage1.png">';

					}



					//$profileImage = '<img width="50" height="50" src="'.file_upload_base_url().'users/thumbs/'.$row['profileImage'].'">';

					$nestedData['chk'] = '<input type="checkbox" class="case" id="check" name="checkall['.$row["id"].']" data-index="'.$row["id"].'">';

					$nestedData['id'] =$i+$requestData['start'];

					$nestedData['competitionName'] =$competitionLogo.'<br/>'.' <a target="_blank" href="'.front_base_url().'competition/get_competition/'.$row["id"].'">'.$row["name"].'</a>';

					$nestedData['competitionDetails'] = '<b>Competition Id: </b>'.$row["id"].'<br/><b>Cover Image: </b>'.$competitionCoverImage;



					//$nestedData['admin_name'] = $profileImage.'<br/><a target="_blank" href="'.front_base_url().'user/userDetail/'.$row["userId"].'">'.$userName.'</a><br/><b>User Id: </b>'.$row["userId"].'<br/><b>Status: </b>'.$userStatusHtml.'<br/>';

				//$nestedData['profileImage'] = '<img style="border-radius:50px;cursor: pointer;" width="70" src="'.file_upload_base_url().'institutes/thumbs/'.$row['profileImage'].'">';

					$nestedData['start_date'] = date("d-M-Y", strtotime($row["start_date"]));

					$nestedData['end_date'] = date("d-M-Y", strtotime($row["end_date"]));

					$evaluationStartDate=date("Y-m-d", strtotime($row["evaluation_start_date"]));

					$evaluationEndDate=date("Y-m-d", strtotime($row["evaluation_end_date"]));



					$todayDate=date('Y-m-d');



					if($row["status"]==2)

					{



						$button='<span class="btn label-success" style="font-size:10px;padding:3px 7px;" onclick="emailToJury('.$row['id'].')">Send Reminder</span>';

					}

					else

					{



						$button='';

					}

					$checkWinnerEntry=$this->modelbasic->getValue('competition_winning_projects','projectId','competitionId',$row["id"]);

					if($row["status"]==3)

					{

						$declareResult='<span class="btn label-success" style="font-size:10px;padding:3px 7px;" onclick="declareResult('.$row['id'].')">Declare Result</span>';

					}

					else

					{

						$declareResult='';

					}

					$nestedData['award'] = $row["award"];

					$nestedData['jury'] = $row["jury"];

					$nestedData['eligibility'] = $row["eligibility"];

					$nestedData['rule'] = $row["rule"];

					//$nestedData['created'] = date("d-M-Y", strtotime($row["created"]));

					if($row["status"]==1)

					{

						$nestedData['status'] = '<span class="label label-success">Inprogress</span>';

					}

					elseif($row["status"]==0)

					{

						/*$nestedData['status'] = '<span class="label label-danger" onclick="change_status('.$row['id'].')" style="cursor: pointer;">Deactive</span>';*/

						$nestedData['status'] = '<span class="label label-danger" >Pending</span>';

					}

					elseif ($row["status"]==2)

					{

						$nestedData['status'] = '<span class="label label-primary" >Evaluating</span>';

					}

					elseif ($row["status"]==3)

					{

						$nestedData['status'] = '<span class="label label-info" >Evaluated</span>';

					}

					elseif ($row["status"]==4)

					{

						$nestedData['status'] = '<span class="label label-danger" >Completed</span>';

					}

					elseif ($row["status"]==5)

					{

						$nestedData['status'] = '<span class="label label-danger" >Expired</span>';

					}

					/*else

					{

						if($todayDate >=$evaluationEndDate && $checkWinnerEntry!='')

						{

							$nestedData['status'] = '<span class="label label-danger" >Completed</span>';

						}

						else

						{

							if($todayDate >=$evaluationEndDate && $checkWinnerEntry=='')

							{

								$nestedData['status'] = '<span class="label label-info" >Evaluated</span>';

							}

							else

							{

								$nestedData['status'] = '<span class="label label-primary" >Evaluating</span>';

							}



						}

					}*/
					if($this->session->userdata('admin_level')==2 && $row["addedBy"]==4)
					{
						$editAction='';
					}else{
						if($row["status"]==4)

						{

							$editAction='';

						}

						else

						{

							$editAction='<a onclick="openEditForm('.$row['id'].')" style="cursor:pointer" class="btn menu-icon vd_bd-yellow vd_yellow" data-placement="top" data-toggle="tooltip" data-original-title="edit"> <i class="fa fa-pencil"></i> </a>';

						}
					}
					if($this->session->userdata('admin_level')==2 && $row["addedBy"]==4)
					{
						$nestedData['action'] = '<a onclick="showDetails(this)" data-original-title="view" data-toggle="tooltip" data-placement="top" class="btn menu-icon vd_bd-green vd_green"> <i class="fa fa-eye"></i> </a>'.$editAction.$button.$declareResult;
					}else{
						$nestedData['action'] = '<a class="btn menu-icon vd_bd-red vd_red" style="cursor:pointer" onclick="delete_confirm('.$row['id'].')" data-original-title="delete" data-toggle="tooltip" data-placement="top"><i class="fa fa-times"></i></a><a onclick="showDetails(this)" data-original-title="view" data-toggle="tooltip" data-placement="top" class="btn menu-icon vd_bd-green vd_green"> <i class="fa fa-eye"></i> </a>'.$editAction.$button.$declareResult;
					}
					

					$data[] = $nestedData;

					$i++;

				}

			}





			$json_data = array(

					"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.

					"recordsTotal"    => intval( $totalData ),  // total number of records

					"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData

					"data"            => $data   // total data array

					);

			echo json_encode($json_data);

	}



	function reorderRows()

	{

		$startPosition=$_POST['sPosition'];

		$endPosition=$_POST['ePosition'];



		if($startPosition > $endPosition)

		{

			$this->modelbasic->_update_custom('employee','order',$startPosition,array('order'=>0));

			$result=$this->modelbasic->getAllWhere('employee','order',array('order >='=>$endPosition),'order','desc');

			foreach ($result as $value)

			{

				$this->modelbasic->_update_custom('employee','order',$value['order'],array('order'=>$value['order']+1));

			}

			$this->modelbasic->_update_custom('employee','order',0,array('order'=>$endPosition));

		}

		else

		{

			$this->modelbasic->_update_custom('employee','order',$startPosition,array('order'=>0));

			$result=$this->modelbasic->getAllWhere('employee','order',array('order >'=>$startPosition,'order <='=> $endPosition),'order','asc');



			foreach ($result as $value)

			{

				$this->modelbasic->_update_custom('employee','order',$value['order'],array('order'=>$value['order']-1));

			}

			$this->modelbasic->_update_custom('employee','order',0,array('order'=>$endPosition));

		}

		echo 'true';

	}



	function addedit_user()

	{

		$this->load->view('admin/institutes/addedit_view');

	}



	function multiselect_action()

	{

		if(isset($_POST['submit'])){



			$check = $_POST['checkall'];



			//echo "<pre>";print_r($_POST);die;



			foreach ($check as $key => $value) {



				if($_POST['listaction'] == '1')

				{

					$status = array('status'=>'1');

					$this->modelbasic->_update('competitions',$key,$status);

					$this->session->set_flashdata('success', 'Competitions activated successfully');



				}else if($_POST['listaction'] == '2')

				{

					$status = array('status'=>'0');

					$this->modelbasic->_update('competitions',$key,$status);

					$this->session->set_flashdata('success', 'Competitions deactivated successfully');

				}

				else if($_POST['listaction'] == '3')

				{

				 		$query=$this->modelbasic->getValue('competitions','banner','id',$key);

				 		$path2 = file_upload_s3_path().'competition/banner/';

						$path3 = file_upload_s3_path().'competition/banner/thumbs/';

						if(!empty($query))

						{

							if(file_exists($path2.$query))

							{

								unlink( $path2 . $query);

							}

							if(file_exists($path3.$query)) {

								unlink( $path3 . $query);

							}

				        }



	        	 		$query=$this->modelbasic->getValue('competitions','profile_image','id',$key);

	        			$path2 = file_upload_s3_path().'competition/profile_image/';

	        			$path3 = file_upload_s3_path().'competition/profile_image/thumbs/';

			    		if(!empty($query))

			    		{

			    			if(file_exists($path2.$query))

			    			{

			    				unlink( $path2 . $query);

			    			}

			    			if(file_exists($path3.$query))

			    			{

			    				unlink( $path3 . $query);

			    			}

		            	}



			           // $this->modelbasic->_update_custom('users','instituteId',$key,array('instituteId'=>0));

				        $this->modelbasic->_delete('competitions',$key);

				        $this->session->set_flashdata('success', 'Competitions deleted successfully');

				}

			}



			redirect('admin/competition');

		}

	}



	function change_status($id = NULL)

	{

		$result = $this->modelbasic->getValue('competitions','status','id',$id);

		if($result == 1)

		{

			$data = array('status'=>'0');

			$this->session->set_flashdata('success', 'Competition deactivated successfully.');

	    }

		else

		if($result == 0)

		{

			$data = array('status'=>'1');

			$this->session->set_flashdata('success', 'Competition activated successfully.');

		}

		$this->modelbasic->_update('competitions',$id, $data);

		redirect('admin/competition');

	}



	function emailToJury($competitionId = 0)

	{

		$jury=$this->competition_model->getCompetitionJury($competitionId);

		foreach($jury as $key)

		{

			$data=array('competitionId'=>$competitionId,'juryId'=>$key['id']);

			$rating=$this->competition_model->checkRating($data);

			//print_r($rating);die;

			if(empty($rating))

			{

				$competitionName=$this->modelbasic->getValue('competitions','name','id',$competitionId);

				$todayDate=date_create(date('Y-m-d'));

				$evaluationEndDate=$this->modelbasic->getValue('competitions','evaluation_end_date','id',$competitionId);

				$evaluationStartDate=$this->modelbasic->getValue('competitions','evaluation_start_date','id',$competitionId);

				$evaluationEndDate=date_create(date("Y-m-d", strtotime($evaluationEndDate)));

				$evaluationStartDate=date_create(date("Y-m-d", strtotime($evaluationStartDate)));

				$remainingDays=date_diff($evaluationEndDate,$todayDate);

				$remainingDays=$remainingDays->format("%a");

				if($todayDate==$evaluationStartDate)

				{

					$subject='Competition evaluation is just started';

					$info=' Evaluation time has been started today';

				}

				else

				{

					if($todayDate==$evaluationEndDate)

					{

						$subject='Hurry Up...!! Today is last day for competition evaluation';

						$info=' Evaluation time has been started and today is last day for submitting your rating';

					}

					else

					{

						$subject='Hurry Up...!! Only ' .$remainingDays.' days are remaing to submit rating';

						$info=' Evaluation time has been started and only  "<b>' .$remainingDays.'</b>" days are remaining';

					}

				}

				$template='Hello <b>'.$key['name']. '</b>,<br />The competition "<b>' .$competitionName.'</b>" whose you are jury on creosouls.' .$info.', please submit your rating." <br /><a href="'.front_base_url().'competition/get_competition/'.$competitionId.'/'.$key['id'].'">Click here</a>  to view the competition detail.<br /><br /><br />Thanks,<br />Team creosouls<br /><a href="http://www.creosouls.com">www.creosouls.com</a>';
				$emailFrom = $this->modelbasic->getValueArray("settings","description",array('settings_id'=>7,'type'=>'from_email'));
				$emailData=array('to'=>$key['email'],'fromEmail'=>$emailFrom,'subject'=>$subject,'template'=>$template);
				//$this->modelbasic->sendMail($emailData);
			}
		}

		$this->session->set_flashdata('success', 'Competition evaluation reminder send successfully to jury.');
		redirect('admin/competition');
	}



	function declareResult($competitionId = 0)
	{
		$allCompetitionData = $this->modelbasic->getSelectedData('competitions','winnerCount,category_wise_winner,competition_type',array('id'=>$competitionId),$orderBy='',$dir='',$groupBy='',$limit='',$offset='',$resultMethod='row_array');

		$numberOfWinner=$allCompetitionData['winnerCount'];

		if($allCompetitionData['competition_type'] == 3){
			if($allCompetitionData['category_wise_winner'] == 1)
			{
				$winnerDetail=$this->competition_model->declareWinnersCategorywiseLevelComp($competitionId,$numberOfWinner);
				if(!empty($winnerDetail))
				{
					foreach ($winnerDetail as $wd)
					{
						if(!empty($wd))
						{
							$i=1;
							foreach ($wd as $key)
							{
								$data=array('competitionId'=>$key['competitionId'],'projectId'=>$key['projectId'],'project_category'=>$key['project_category'],'created'=>date('Y-m-d H:i:s'));
								$this->modelbasic->_insert('competition_level_winning_projects',$data);
								$i++;
								//$this->sendCertificateToWinner($key['competitionId'],$key['projectId']);
							}
						}
					}
				}
			}
			else
			{
				$winnerDetail=$this->competition_model->declareWinnersLevelComp($competitionId,$numberOfWinner);
				if(!empty($winnerDetail))
				{
					$i=1;
					foreach ($winnerDetail as $wd)
					{
						if(!empty($wd))
						{
							$data=array('competitionId'=>$wd['competitionId'],'projectId'=>$wd['projectId'],'project_category'=>$wd['project_category'],'created'=>date('Y-m-d H:i:s'));
							$this->modelbasic->_insert('competition_level_winning_projects',$data);
							$i++;
							//$this->sendCertificateToWinner($wd['competitionId'],$wd['projectId']);
						}

					}
				}
			}
		}else{
			if($allCompetitionData['category_wise_winner'] == 1)
			{
				$winnerDetail=$this->competition_model->declareWinnersCategorywise($competitionId,$numberOfWinner);
				if(!empty($winnerDetail))
				{
					foreach ($winnerDetail as $wd)
					{
						if(!empty($wd))
						{
							$i=1;
							foreach ($wd as $key)
							{
								$data=array('competitionId'=>$key['competitionId'],'projectId'=>$key['projectId'],'avgRating'=>$key['avgRating'],'rank'=>$i,'project_category'=>$key['project_category']);
								$this->modelbasic->_insert('competition_winning_projects',$data);
								$i++;
								$this->sendCertificateToWinner($key['competitionId'],$key['projectId']);
							}
						}
					}
				}
			}
			else
			{
				$winnerDetail=$this->competition_model->declareWinners($competitionId,$numberOfWinner);
				if(!empty($winnerDetail))
				{
					$i=1;
					foreach ($winnerDetail as $wd)
					{
						if(!empty($wd))
						{
							$data=array('competitionId'=>$wd['competitionId'],'projectId'=>$wd['projectId'],'avgRating'=>$wd['avgRating'],'rank'=>$i,'project_category'=>$wd['project_category']);
							$this->modelbasic->_insert('competition_winning_projects',$data);
							$i++;
							$this->sendCertificateToWinner($wd['competitionId'],$wd['projectId']);
						}

					}
				}
			}
		}
		

		$status=array('status'=>4);
		$view_status=array('view_status'=>'Y');
		$valudeata=array('competitionId'=>$competitionId);
		$this->modelbasic->_update('competitions',$competitionId,$status);;

		$this->db->where('competitionId',$competitionId);
		$this->db->update('project_master',$view_status);
		if($allCompetitionData['competition_type'] == 3){
			$this->session->set_flashdata('success','Competition winners selected for next level.');
		}else{
			$this->session->set_flashdata('success','Competition winner certificate is sent successfully to respective winners.');
		}
		redirect(base_url().'admin/competition/');

	}





	function delete_confirm($key = NULL)

	{

			$query=$this->modelbasic->getValue('competitions','banner','id',$key);

	 		$path2 = file_upload_s3_path().'competition/banner/';

			$path3 = file_upload_s3_path().'competition/banner/thumbs/';

			if(!empty($query))

			{

				if(file_exists($path2.$query))

				{

					unlink( $path2 . $query);

				}

			   if(file_exists($path3.$query)) {

					unlink( $path3 . $query);

				}

	        }



 		$query=$this->modelbasic->getValue('competitions','profile_image','id',$key);

		$path2 = file_upload_s3_path().'competition/profile_image/';

		$path3 = file_upload_s3_path().'competition/profile_image/thumbs/';

    		if(!empty($query))

    		{

    			if(file_exists($path2.$query))

    			{

    				unlink( $path2 . $query);

    			}

    			if(file_exists($path3.$query))

    			{

    				unlink( $path3 . $query);

    			}

        	}



           // $this->modelbasic->_update_custom('users','instituteId',$key,array('instituteId'=>0));

	        $this->modelbasic->_delete('competitions',$key);

	        $this->session->set_flashdata('success', 'Competitions deleted successfully');

	        redirect('admin/competition');

	}



	public function processJuryForm()

	{

		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');

		$this->form_validation->set_rules('juryName', 'Jury name', 'trim|xss_clean|required');

		$this->form_validation->set_rules('juryEmail', 'Jury email', 'trim|xss_clean|required|valid_email');

		$this->form_validation->set_rules('juryWriteUp', 'Jury writeup', 'trim|xss_clean|required');

		$this->form_validation->set_rules('juryPhoto', 'Jury picture', 'callback_validateJuryPhoto');

		if ($this->form_validation->run())

		{

			$juryData=array('name'=>ucwords($this->input->post('juryName',true)),'email'=>$this->input->post('juryEmail',true),'photo'=>$_POST['juryPhoto']['file_name'],'writeup'=>$this->input->post('juryWriteUp',true),'status'=>1);

			$checkJuryEmail=$this->modelbasic->getValue('competition_jury','id','email',$this->input->post('juryEmail',true));

			if(isset($checkJuryEmail) && $checkJuryEmail > 0)

			{

				$data=array('status'=>'fail','message'=>'Jury with this email is already exists.');

			}

			else

			{

				$juryId=$this->modelbasic->_insert('competition_jury',$juryData);

				if(isset($juryId) && $juryId > 0)

				{

					$data=array('status'=>'success','for'=>'add','message'=>'New Jury added successfully.');

				}

				else

				{

					$data=array('status'=>'fail','message'=>'Error occurred while adding new jury please try again....');

				}

			}





			echo json_encode($data);

		}

		else

		{

			echo $this->form_validation->get_json();

		}

	}



	function validatepageName()

	{

		$pageName=$this->input->post('pageName',TRUE);

		$competitionId=$this->input->post('competitionId',TRUE);

		$val=$this->modelbasic->getValueWhere('competitions','pageName',array('id !='=>$competitionId,'pageName'=>$pageName));

		if($val <> '')

		{

			$this->form_validation->set_message('validatepageName', 'Display name is already used, use unique display name.');

			return false;

		}

		else

		{

			return true;

		}

	}









	public function processForm()
	{

		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules('name', 'Competition name', 'required');
		$this->form_validation->set_rules('contactEmail', 'Contact Email ID', 'required|valid_email');
		$this->form_validation->set_rules('description', 'Description', 'required');
		$this->form_validation->set_rules('award', 'Award', 'required');
		if($this->input->post('competitionId',TRUE) > 0)
		{
			$this->form_validation->set_rules('pageName', 'Competition page display name', 'required|alpha_numeric|callback_validatepageName');
		}
		else
		{
			$this->form_validation->set_rules('pageName', 'Competition page display name', 'required|alpha_numeric|is_unique[competitions.pageName]');
		}

		$this->form_validation->set_rules('eligibility', 'Eligibility', 'required');
		$this->form_validation->set_rules('rule', 'Rule', 'required');
		$this->form_validation->set_rules('start_date', 'Start Date', 'required');
		$this->form_validation->set_rules('end_date', 'End Date', 'required');
		if($this->session->userdata('admin_level')!=4){
			$this->form_validation->set_rules('jury[]', 'Competition jury', 'required');
		}
		//
		$this->form_validation->set_rules('evaluation_start_date', 'Evaluation Start Date', 'required');
		$this->form_validation->set_rules('evaluation_end_date', 'Evaluation End Date', 'required');
		 $this->form_validation->set_rules('profile_image', 'Competition logo', 'callback_validateCompetitionLogo');
		$this->form_validation->set_rules('banner', 'Competition cover picture', 'callback_validateCoverImage');
		$this->form_validation->set_rules('winnerCount', 'Number of Winner', 'required|integer');
	//	$this->form_validation->set_rules('institutename', 'Institute Name', 'required');
		//print_r($_POST);die;

		if ($this->form_validation->run())
		{
			if($this->input->post('competitionId',TRUE) > 0)
			{
				if(isset($_POST['hidename']) && $_POST['hidename'] == 'on')
				{
					$hidename=1;
				}
				else
				{
					$hidename=0;
				}

				if(isset($_POST['certificate']) && $_POST['certificate'] == 'on')
				{
					$certificate=1;
				}
				else
				{
					$certificate=0;
				}
				if(isset($_POST['category_wise_winner']) && $_POST['category_wise_winner'] == 'on')
				{
					$category_wise_winner=1;
				}
				else
				{
					$category_wise_winner=0;
				}
				$competitionId=$this->input->post('competitionId',TRUE);
				$data=array('name'=>$this->input->post('name',TRUE),'contactEmail'=>$this->input->post('contactEmail',TRUE),'description'=>$this->input->post('description',TRUE),'hidename'=>$hidename,'start_date'=>date("Y-m-d", strtotime($this->input->post('start_date',TRUE))),'end_date'=>date("Y-m-d", strtotime($this->input->post('end_date',TRUE))),'evaluation_start_date'=>date("Y-m-d", strtotime($this->input->post('evaluation_start_date',TRUE))),'evaluation_end_date'=>date("Y-m-d", strtotime($this->input->post('evaluation_end_date',TRUE))),'created'=>date('Y-m-d H:i:s'),'status'=>1,'award'=>$this->input->post('award',TRUE),'eligibility'=>$this->input->post('eligibility',TRUE),'rule'=>$this->input->post('rule',TRUE),'countryId'=>$this->input->post('country',TRUE),'cityId'=>$this->input->post('city',TRUE),'certificate'=>$certificate,'winnerEmail'=>$_POST['winnerEmail'],'winnerCount'=>$_POST['winnerCount'],'pageName'=>$this->input->post('pageName',TRUE),'category_wise_winner'=>$category_wise_winner, 'competition_type' => $_POST['ctype']);
				$res=$this->competition_model->deleteOldRankTitle($competitionId);

				if(isset($_POST['profile_image']['file_name']) && $_POST['profile_image']['file_name'] <> '')
				{

					$data['profile_image']=$_POST['profile_image']['file_name'];
					$query=$this->modelbasic->getValue('competitions','profile_image','id',$competitionId);
					$path2 = file_upload_s3_path().'competition/profile_image/';
					$path3 = file_upload_s3_path().'competition/profile_image/thumbs/';
		    		if(!empty($query))
		    		{
		    			if(file_exists($path2.$query))
		    			{
		    				unlink( $path2 . $query);
		    			}
		    			if(file_exists($path3.$query))
		    			{
		    				unlink( $path3 . $query);
		    			}
		        	}
				}

				if(isset($_POST['banner']['file_name']) && $_POST['banner']['file_name'] <> '')
				{
					$data['banner']=$_POST['banner']['file_name'];
					$query=$this->modelbasic->getValue('competitions','banner','id',$competitionId);
			 		$path2 = file_upload_s3_path().'competition/banner/';
					$path3 = file_upload_s3_path().'competition/banner/thumbs/';
					if(!empty($query))
					{
						if(file_exists($path2.$query))
						{
							unlink( $path2 . $query);
						}
						if (file_exists($path3.$query)) {
							unlink( $path3 . $query);
						}
			        }
				}



				if(isset($_FILES['pdf_file']) && $_FILES['pdf_file']['size'] != 0)
				{
					$query=$this->modelbasic->getValue('competitions','pdf_file','id',$competitionId);
			 		$path2 = file_upload_s3_path().'competition/pdf_file/';
					if(!empty($query))
					{
						if(file_exists($path2.$query))
						{
							unlink( $path2 . $query);
						}
			        }

					$upload_dir = file_upload_s3_path().'competition/pdf_file/';
					if (!is_dir($upload_dir))
					{
					     mkdir($upload_dir, 0777, TRUE);
					}
					$config['upload_path']   = $upload_dir;
					$config['allowed_types'] = 'pdf';
					$config['file_name']     = 'pdf_file_'.substr(md5(rand()),0,7);
					$this->upload->initialize($config);

					if (!$this->upload->do_upload('pdf_file'))
					{
						$this->form_validation->set_message($functionName, $this->upload->display_errors());
						return false;
					}
					else
					{
						$_POST['pdf_file'] =  $this->upload->data();
						$config['source_image'] = file_upload_s3_path().'competition/'.'pdf_file'.'/'.$_POST['pdf_file']['file_name'];
					}
				}


				if(isset($_POST['video_link']) && $_POST['video_link'] != '')
				{
					$data['video_link']=$_POST['video_link'];
				}
				if(isset($_POST['pdf_file']['file_name']) && $_POST['pdf_file']['file_name'] <> '')
				{
					$data['pdf_file']=$_POST['pdf_file']['file_name'];
				}

				  if($this->session->userdata('admin_level')==1)
					{

					 /* if(isset($_POST['open_for_all']) && $_POST['open_for_all']=='on')

						{*/

							//$data['instituteId']= 0;

							//$data['open_for_all']= 1;

						/*}

						else

						{

							$data['instituteId']= $this->input->post('instituteId',TRUE);

							$data['open_for_all']= 0;

						}*/

				    }
				    else   if($this->session->userdata('admin_level')==4)
					{
							//$data['instituteId']= 0;

							//$data['open_for_all']= 1;
				    }
				    else
				    {
						if(isset($_POST['open_for_all']) && $_POST['open_for_all']=='on')
						{
							$data['open_for_all']= 1;
						}
						else
						{
							$data['open_for_all']= 0;
						}
					}

					if(isset($_POST['institutename']) && !empty($_POST['institutename']))
					{
						$data['instituteId']=$institutename;
					}

				$res=$this->modelbasic->_update('competitions',$competitionId,$data);

				$userDataEdit=$this->modelbasic->getAllUser();
				$notificationEditEntry=array('title'=>'Some changes in competition','msg'=>'Some changes in competition '.ucwords($this->input->post('name')).' posted in creosouls.','link'=>'competition/'.$this->input->post('pageName',TRUE),'imageLink'=>'competition/profile_image/thumbs/'.$_POST['profile_image']['file_name'],'created'=>date('Y-m-d H:i:s'),'typeId'=>7,'redirectId'=>$competitionId);
				//$notificationEditId=$this->modelbasic->_insert('header_notification_master',$notificationEditEntry);
				if(!empty($userDataEdit))
				{
					foreach($userDataEdit as $val)
					{
						$eligibility = $this->competition_model->checkUserEligible($val['instituteId'],$competitionId);
						if(!empty($eligibility))
						{
							$emailSetting=$this->modelbasic->getValueArray('user_email_notification_relation','new_competition',array('userId'=>$val['id']));
							if($emailSetting == 1)
							{
								$emailFrom = $this->modelbasic->getValueArray("settings","description",array('settings_id'=>7,'type'=>'from_email'));
								$creUserDetail   = $this->modelbasic->loggedInUserInfoById($val['id']);
								$creUserName     = ucwords($creUserDetail['firstName'].' '.$creUserDetail['lastName']);
								$creUserEmail    = $creUserDetail['email'];
								$from               = $emailFrom;
								$subject          = 'Some changes in competition "'.$this->input->post('name').'" on creosouls';
								$template    = 'Hello <b>'.$creUserName. '</b>,<br />Some changes in competition "<b>' .$this->input->post('name').'</b>" on creosouls.<br /><a href="'.base_url().'competition/'.$this->input->post('pageName',TRUE).'">Click here</a>  to see the competition detail.<br /><br /><br />Thanks,<br />Team creosouls<br /><a href="http://www.creosouls.com">www.creosouls.com</a>';
								$sendEmailToCreUser = array('to'=>$creUserEmail,'subject'  =>$subject,'template' =>$template,'fromEmail'=>$from);
								//$this->modelbasic->sendMail($sendEmailToCreUser);
							}
							$notificationToCreUserEdit=array('notification_id'=>$notificationEditId,'user_id'=>$val['id']);
							//$this->modelbasic->_insert('header_notification_user_relation',$notificationToCreUserEdit);

							$msg['notificationImageUrl'] = '';

							$msg['notificationTitle'] = 'New Competition Posted';

							$msg['notificationMessage']  = ucwords($this->input->post('name',TRUE));

							$msg['notificationType']   = 4;

						    $msg['notificationId']     = $competitionId;

						    $msg['type']     = 0;

							$this->sendGcmToken($val['id'],$msg);

						}

					}

				}


				$y=1;
				foreach ($_POST['rankTitle'] as $value)
				{
					$rankTitle=$value;
					$rankData=array('competitionId'=>$competitionId,'rankTitle'=>$rankTitle,'rankNumber'=>$y);
					$this->competition_model->insertRankTitle($rankData);
					$y++;
				}
				//$this->modelbasic->_delete_with_condition('competition_jury_relation','competitionId',$competitionId);

				$juryData=array();
				if(!empty($_POST['jury']))
				{
					foreach ($this->input->post('jury',TRUE) as $juryId)
					{
						$juryExists=$this->modelbasic->getValueWhere('competition_jury_relation','juryId',array('competitionId'=>$competitionId,'juryId'=>$juryId));
											//$adminEmail='santoshbadal1111@gmail.com';
						if($juryExists != $juryId)
						{
							/*$juryData=array('competitionId'=>$competitionId,'juryId'=>$juryId);
							$this->modelbasic->_insert('competition_jury_relation',$juryData);*/
							$emailFrom = $this->modelbasic->getValueArray("settings","description",array('settings_id'=>7,'type'=>'from_email'));
							$juryDetail=$this->competition_model->getJuryDetail($juryId);
							$from=$emailFrom;
							$subject='Appointed as Jury on creosouls';
							$template='Hello <b>'.$juryDetail[0]['name']. '</b>,<br />You have been appointed as Jury of the competition "<b>' .$this->input->post('name',TRUE).'</b> on creosouls." <br /><a href="'.front_base_url().'competition/get_competition/'.$competitionId.'/'.$juryId.'">Click here</a>  to view the competition detail.<br /><br /><br />Thanks,<br />Team creosouls<br /><a href="http://www.creosouls.com">www.creosouls.com</a>';
							$juryEmailDetail=array('to'=>$juryDetail[0]['email'],'subject'=>$subject,'template'=>$template,'fromEmail'=>$from);
							//$this->modelbasic->sendMail($juryEmailDetail);
						}
					}

					/*  update jurry */

					$DetleteOldAllJury = $this->competition_model->deleteOldJury($competitionId);
					foreach ($this->input->post('jury',TRUE) as $juryId)
					{
						$juryData=array('competitionId'=>$competitionId,'juryId'=>$juryId);
						$this->modelbasic->_insert('competition_jury_relation',$juryData);
					}
				}

				if($res)
				{
					$data1=array('status'=>'success','for'=>'edit','message'=>'Competition updated successfully.');
				}
				else
				{
					$data1=array('status'=>'fail','message'=>'Error occurred while updating competition please try again....');
				}
			}
			else
			{
				if(isset($_POST['hidename']) && $_POST['hidename'] == 'on')
				{
					$hidename=1;
				}
				else
				{
					$hidename=0;
				}
				if(isset($_POST['certificate']) && $_POST['certificate'] == 'on')
				{
					$certificate=1;
				}
				else
				{
					$certificate=0;
				}
				if(isset($_POST['category_wise_winner']) && $_POST['category_wise_winner'] == 'on')
				{
					$category_wise_winner=1;
				}
				else
				{
					$category_wise_winner=0;
				}
				if(isset($_FILES['pdf_file']) && $_FILES['pdf_file']['size'] != 0)
				{

					$upload_dir = file_upload_s3_path().'competition/pdf_file/';
					if (!is_dir($upload_dir))
					{
					     mkdir($upload_dir, 0777, TRUE);
					}
					$config['upload_path']   = $upload_dir;
					$config['allowed_types'] = 'pdf';
					$config['file_name']     = 'pdf_file_'.substr(md5(rand()),0,7);
					$this->upload->initialize($config);

					if (!$this->upload->do_upload('pdf_file'))
					{
						$this->form_validation->set_message($functionName, $this->upload->display_errors());
						return false;
					}
					else
					{
						$_POST['pdf_file'] =  $this->upload->data();
						$config['source_image'] = file_upload_s3_path().'competition/'.'pdf_file'.'/'.$_POST['pdf_file']['file_name'];
					}
				}
				$data=array('name'=>$this->input->post('name',TRUE),'pageName'=>$this->input->post('pageName',TRUE),'contactEmail'=>$this->input->post('contactEmail',TRUE),'description'=>$this->input->post('description',TRUE),'hidename'=>$hidename,'start_date'=>date("Y-m-d", strtotime($this->input->post('start_date',TRUE))),'end_date'=>date("Y-m-d", strtotime($this->input->post('end_date',TRUE))),'evaluation_start_date'=>date("Y-m-d", strtotime($this->input->post('evaluation_start_date',TRUE))),'evaluation_end_date'=>date("Y-m-d", strtotime($this->input->post('evaluation_end_date',TRUE))),'created'=>date('Y-m-d H:i:s'),'status'=>1,'award'=>$this->input->post('award',TRUE),'eligibility'=>$this->input->post('eligibility',TRUE),'rule'=>$this->input->post('rule',TRUE),'countryId'=>$this->input->post('country',TRUE),'cityId'=>$this->input->post('city',TRUE),'certificate'=>$certificate,'winnerEmail'=>$_POST['winnerEmail'],'winnerCount'=>$_POST['winnerCount'],'category_wise_winner'=>$category_wise_winner, 'competition_type' => $_POST['ctype']);
				if(isset($_POST['profile_image']['file_name']) && $_POST['profile_image']['file_name'] <> '')
				{
					$data['profile_image']=$_POST['profile_image']['file_name'];
				}
				if(isset($_POST['pdf_file']['file_name']) && $_POST['pdf_file']['file_name'] <> '')
				{
					$data['pdf_file']=$_POST['pdf_file']['file_name'];
				}
				if(isset($_POST['video_link']) && $_POST['video_link'] != '')
				{
					$data['video_link']=$_POST['video_link'];
				}

				if(isset($_POST['banner']['file_name']) && $_POST['banner']['file_name'] <> '')
				{
					$data['banner']=$_POST['banner']['file_name'];
				}
				if($this->session->userdata('admin_level')==2)
				{
					$data['userId']= $this->session->userdata('admin_id');
					$data['instituteId']= $this->session->userdata('instituteId');
		    		$data['addedBy']= 2;
		    		if(isset($_POST['open_for_all']) && $_POST['open_for_all']=='on')
					{
						$data['open_for_all']= 1;
					}
					else
					{
						$data['open_for_all']= 0;
					}
			    }
			    else  if($this->session->userdata('admin_level')==4)
				{
					$instituteIds = $_POST['institutename'];
					$data['userId']= $this->session->userdata('admin_id');
					$data['instituteId']= (isset($_POST['institutename']) && !empty($_POST['institutename'])?$_POST['institutename']:0);
		    		$data['addedBy']= 4;
					$data['open_for_all']= (isset($_POST['institutename']) && !empty($_POST['institutename'])?0:1);
					$instituteIdCount = count($instituteIds);
			    }
				else
				{
					$data['userId']= $this->session->userdata('admin_id');
					$data['addedBy']= 1;
					$data['instituteId']= 0;
					$data['open_for_all']= 1;
			    }


			    $notification_open_for_all=$data['open_for_all'];
			    $notification_instituteId=$data['instituteId'];
				if($instituteIdCount >= 1){
					foreach ($instituteIds as $value)
					{
						$data['instituteId'] = $value;
						$instituteIdName = $this->modelbasic->getValueArray("institute_master","instituteName",array('id'=>$data['instituteId']));
						$data['name'] = $this->input->post('name',TRUE)."(".$instituteIdName.")";
						$data['pageName'] = $this->input->post('pageName',TRUE).$value;
						$competitionId=$this->modelbasic->_insert('competitions',$data);
						$z=1;
						foreach ($_POST['rankTitle'] as $value)
						{

							$rankTitle=$value;
							$rankData=array('competitionId'=>$competitionId,'rankTitle'=>$rankTitle,'rankNumber'=>$z);
							$this->competition_model->insertRankTitle($rankData);
							$z++;
						}

						$juryData=array();
						if(!empty($_POST['jury']))
						{
							$instituteAdminId = $this->modelbasic->getValueArray("institute_master
				","adminId",array('id'=>$data['instituteId']));
							$adminEmailId = $this->modelbasic->getValueArray("users
				","email",array('id'=>$instituteAdminId));
							$checkEmailIdInJury = $this->modelbasic->getValueArray("competition_jury
				","email",array('email'=>$adminEmailId));
							$checkRAHIdInJury = $this->modelbasic->getValueArray("competition_jury
				","email",array('email'=>$this->session->userdata('admin_email')));
							    			//echo "jury Email".$checkEmailIdInJury;
							if(empty($checkEmailIdInJury)){
								$adminDetails   = $this->modelbasic->loggedInUserInfoById($instituteAdminId);
							    $adminUserName     = ucwords($adminDetails['firstName'].' '.$adminDetails['lastName']);
							    $adinJuryData = array('name' =>$adminUserName,'email'=>$adminDetails['email'],'photo'=>$adminDetails['profileImage'],'writeup'=>'Institute Admin Jury');
							    //print_r($adinJuryData);
							    $juryAdminId = $this->modelbasic->_insert('competition_jury',$adinJuryData);
							    $juryList = $_POST['jury'];
							    array_push($juryList,$juryAdminId);
							    
							}else{
								
							    $adminJuryId = $this->modelbasic->getValueArray("competition_jury
							    				","id",array('email'=>$adminEmailId));
							    $juryList = $_POST['jury'];
							    array_push($juryList,$adminJuryId);
							    
							}
							if(empty($checkRAHIdInJury)){
								//echo "RAH email ".$this->session->userdata('admin_email');
								$RAHDetails   = $this->modelbasic->loggedInUserInfoByEmailId($this->session->userdata('admin_email'));
								//echo "rah email ".
								//print_r($RAHDetails);
							    $RAHUserName     = ucwords($RAHDetails['firstName'].' '.$RAHDetails['lastName']);
							    	$RAHJuryData = array('name' =>$RAHUserName,'email'=>$RAHDetails['email'],'photo'=>$RAHDetails['profileImage'],'writeup'=>'RAH Jury');
							    	//print_r($RAHJuryData);
							    	$juryRAHId = $this->modelbasic->_insert('competition_jury',$RAHJuryData);
							    	array_push($juryList,$juryRAHId);
							    	
							}else{
								$RAHJuryId = $this->modelbasic->getValueArray("competition_jury
							    				","id",array('email'=>$this->session->userdata('admin_email')));
							    array_push($juryList,$RAHJuryId);
							    
							}
							
							foreach ($juryList as $juryId)
							{

							    $juryData=array('competitionId'=>$competitionId,'juryId'=>$juryId);
							    
							    $this->modelbasic->_insert('competition_jury_relation',$juryData);
							    $juryDetail=$this->competition_model->getJuryDetail($juryId);
							    $emailFrom = $this->modelbasic->getValueArray("settings","description",array('settings_id'=>7,'type'=>'from_email'));
							    $from=$emailFrom;
							    $subject='Appointed as Jury on creosouls';
							    $template='Hello <b>'.$juryDetail[0]['name']. '</b>,<br />You have been appointed as Jury of the competition "<b>' .$this->input->post('name',TRUE).'</b> on creosouls." <br /><a href="'.front_base_url().'competition/get_competition/'.$competitionId.'/'.$juryId.'">Click here</a>  to view the competition detail.<br /><br /><br />Thanks,<br />Team creosouls<br /><a href="http://www.creosouls.com">www.creosouls.com</a>';
							    $juryEmailDetail=array('to'=>$juryDetail[0]['email'],'subject'=>$subject,'template'=>$template,'fromEmail'=>$from);
							    				//$this->modelbasic->sendMail($juryEmailDetail);
							}
						}else{
							
								$instituteAdminId = $this->modelbasic->getValueArray("institute_master
							","adminId",array('id'=>$data['instituteId']));
								$adminEmailId = $this->modelbasic->getValueArray("users
							","email",array('id'=>$instituteAdminId));
								$checkEmailIdInJury = $this->modelbasic->getValueArray("competition_jury
							","email",array('email'=>$adminEmailId));
								$checkRAHIdInJury = $this->modelbasic->getValueArray("competition_jury
							","email",array('email'=>$this->session->userdata('admin_email')));
										    			//echo "jury Email".$checkEmailIdInJury;
								if(empty($checkEmailIdInJury)){
									$adminDetails   = $this->modelbasic->loggedInUserInfoById($instituteAdminId);
									$adminUserName     = ucwords($adminDetails['firstName'].' '.$adminDetails['lastName']);
									$adinJuryData = array('name' =>$adminUserName,'email'=>$adminDetails['email'],'photo'=>$adminDetails['profileImage'],'writeup'=>'Institute Admin Jury');
										    //print_r($adinJuryData);
									$juryAdminId = $this->modelbasic->_insert('competition_jury',$adinJuryData);
										    $juryList = array();
									array_push($juryList,$juryAdminId);
										    
								}else{
											
									$adminJuryId = $this->modelbasic->getValueArray("competition_jury
										    				","id",array('email'=>$adminEmailId));
									$juryList = array();
									array_push($juryList,$adminJuryId);
										    
								}
								if(empty($checkRAHIdInJury)){
											//echo "RAH email ".$this->session->userdata('admin_email');
									$RAHDetails   = $this->modelbasic->loggedInUserInfoByEmailId($this->session->userdata('admin_email'));
											//echo "rah email ".
											//print_r($RAHDetails);
									$RAHUserName     = ucwords($RAHDetails['firstName'].' '.$RAHDetails['lastName']);
									$RAHJuryData = array('name' =>$RAHUserName,'email'=>$RAHDetails['email'],'photo'=>$RAHDetails['profileImage'],'writeup'=>'RAH Jury');
										    	//print_r($RAHJuryData);
									$juryRAHId = $this->modelbasic->_insert('competition_jury',$RAHJuryData);
										    	array_push($juryList,$juryRAHId);
										    	
									}else{
										$RAHJuryId = $this->modelbasic->getValueArray("competition_jury
										    				","id",array('email'=>$this->session->userdata('admin_email')));
										array_push($juryList,$RAHJuryId);
										    
									}
										
									foreach ($juryList as $juryId)
									{

										$juryData=array('competitionId'=>$competitionId,'juryId'=>$juryId);
										    
										$this->modelbasic->_insert('competition_jury_relation',$juryData);
										$juryDetail=$this->competition_model->getJuryDetail($juryId);
										$emailFrom = $this->modelbasic->getValueArray("settings","description",array('settings_id'=>7,'type'=>'from_email'));
										$from=$emailFrom;
										$subject='Appointed as Jury on creosouls';
										$template='Hello <b>'.$juryDetail[0]['name']. '</b>,<br />You have been appointed as Jury of the competition "<b>' .$this->input->post('name',TRUE).'</b> on creosouls." <br /><a href="'.front_base_url().'competition/get_competition/'.$competitionId.'/'.$juryId.'">Click here</a>  to view the competition detail.<br /><br /><br />Thanks,<br />Team creosouls<br /><a href="http://www.creosouls.com">www.creosouls.com</a>';
										$juryEmailDetail=array('to'=>$juryDetail[0]['email'],'subject'=>$subject,'template'=>$template,'fromEmail'=>$from);
										    				//$this->modelbasic->sendMail($juryEmailDetail);
									}

						}
							    		
						if($competitionId > 0)
						{
							    			
							    $data1=array('status'=>'success','for'=>'add','message'=>'Competition added successfully.');
							    $userData=$this->modelbasic->getAllUser();
							    $notificationEntry=array('title'=>'New competition added','msg'=>'New competition '.ucwords($this->input->post('name')).' posted in creosouls.','link'=>'competition/'.$this->input->post('pageName',TRUE).$data['instituteId'],'imageLink'=>'competition/profile_image/thumbs/'.$_POST['profile_image']['file_name'],'created'=>date('Y-m-d H:i:s'),'typeId'=>4,'redirectId'=>$competitionId);
							    $notificationId=$this->modelbasic->_insert('header_notification_master',$notificationEntry);
							    if(!empty($userData))
							    {
							    				
							    	foreach($userData as $val)
							    	{
							    		if(($val['instituteId'] !='' && $notification_open_for_all==1) || ($val['instituteId'] !='' && $data['instituteId'] == $val['instituteId']))
							    		{
							    			/*$emailSetting=$this->modelbasic->getValueArray('user_email_notification_relation','new_competition',array('userId'=>$val['id']));
							    			if($emailSetting == 1)
							    			{
							    				$emailFrom = $this->modelbasic->getValueArray("settings","description",array('settings_id'=>7,'type'=>'from_email'));
							    				$creUserDetail   = $this->modelbasic->loggedInUserInfoById($val['id']);
							    				$creUserName     = ucwords($creUserDetail['firstName'].' '.$creUserDetail['lastName']);
							    				$creUserEmail    = $creUserDetail['email'];
							    				$from               = $emailFrom;
							    				$subject          = 'New competition "'.$this->input->post('name').'" posted on creosouls';
							    				$template    = 'Hello <b>'.$creUserName. '</b>,<br />New competition "<b>' .$this->input->post('name').'</b>" posted on creosouls.<br /><a href="'.front_base_url().'competition/'.$this->input->post('pageName',TRUE).'">Click here</a>  to see the competition detail.<br /><br /><br />Thanks,<br />Team creosouls<br /><a href="http://www.creosouls.com">www.creosouls.com</a>';
							    				$sendEmailToCreUser = array('to'=>$creUserEmail,'subject'=>$subject,'template'=>$template,'fromEmail'=>$from);
							    				//print_r($sendEmailToCreUser);die;
							    				//$this->modelbasic->sendMail($sendEmailToCreUser);
							    			}*/
							    								
							    			$notificationToCreUser=array('notification_id'=>$notificationId,'user_id'=>$val['id']);
							    			$this->modelbasic->_insert('header_notification_user_relation',$notificationToCreUser);
							    			$msg['notificationImageUrl'] = '';
							    			$msg['notificationTitle'] = 'New Competition Posted';
							    			$msg['notificationMessage']  = ucwords($this->input->post('name',TRUE));
							    			$msg['notificationType']   = 4;
							    			$msg['notificationId']     = $competitionId;
							    			$msg['type']     = 0;
							    			$this->sendGcmToken($val['id'],$msg);
							    			$msg = array ('body' 	=> '','title'	=> '',			    'aboutNotification'	=>ucwords($this->input->post('name',TRUE)),'notificationTitle'	=> 'New Competition Posted','notificationType'	=> 4,'notificationId'	=> $competitionId,'notificationImageUrl'	=> ''
							    								);
							    			$this->modelbasic->sendNotification($val['id'],$msg);
							    		}
							    					
							    					
							    	}
							    }
						}
						else
						{
							$data1=array('status'=>'fail','message'=>'Error occurred while creating competition please try again....');
						}
							    		
					}

					}else{
							    	
						$competitionId=$this->modelbasic->_insert('competitions',$data);
						$z=1;
						foreach ($_POST['rankTitle'] as $value)
						{

							$rankTitle=$value;
							$rankData=array('competitionId'=>$competitionId,'rankTitle'=>$rankTitle,'rankNumber'=>$z);
							$this->competition_model->insertRankTitle($rankData);
							$z++;
						}

							$juryData=array();
						if(!empty($_POST['jury']))
						{
							foreach ($this->input->post('jury',TRUE) as $juryId)
							{
							    $juryData=array('competitionId'=>$competitionId,'juryId'=>$juryId);
							    			$this->modelbasic->_insert('competition_jury_relation',$juryData);
							    $juryDetail=$this->competition_model->getJuryDetail($juryId);
							    $emailFrom = $this->modelbasic->getValueArray("settings","description",array('settings_id'=>7,'type'=>'from_email'));
							    $from=$emailFrom;
							    $subject='Appointed as Jury on creosouls';
							    $template='Hello <b>'.$juryDetail[0]['name']. '</b>,<br />You have been appointed as Jury of the competition "<b>' .$this->input->post('name',TRUE).'</b> on creosouls." <br /><a href="'.front_base_url().'competition/get_competition/'.$competitionId.'/'.$juryId.'">Click here</a>  to view the competition detail.<br /><br /><br />Thanks,<br />Team creosouls<br /><a href="http://www.creosouls.com">www.creosouls.com</a>';
							    $juryEmailDetail=array('to'=>$juryDetail[0]['email'],'subject'=>$subject,'template'=>$template,'fromEmail'=>$from);
							    			//$this->modelbasic->sendMail($juryEmailDetail);
							}
						}

						if($competitionId > 0)
						{
							$data1=array('status'=>'success','for'=>'add','message'=>'Competition added successfully.');
							$userData=$this->modelbasic->getAllUser();
							$notificationEntry=array('title'=>'New competition added','msg'=>'New competition '.ucwords($this->input->post('name')).' posted in creosouls.','link'=>'competition/'.$this->input->post('pageName',TRUE),'imageLink'=>'competition/profile_image/thumbs/'.$_POST['profile_image']['file_name'],'created'=>date('Y-m-d H:i:s'),'typeId'=>4,'redirectId'=>$competitionId);
							$notificationId=$this->modelbasic->_insert('header_notification_master',$notificationEntry);

							if($_POST['ctype'] != 3){
								if(!empty($userData))
								{
								    foreach($userData as $val)
								    {
								    	if(($val['instituteId'] !='' && $notification_open_for_all==1) || ($val['instituteId'] !='' && $notification_instituteId == $val['instituteId']))
								    	{
								    		$emailSetting=$this->modelbasic->getValueArray('user_email_notification_relation','new_competition',array('userId'=>$val['id']));
								    		if($emailSetting == 1)
								    		{
								    			$emailFrom = $this->modelbasic->getValueArray("settings","description",array('settings_id'=>7,'type'=>'from_email'));
								    			$creUserDetail   = $this->modelbasic->loggedInUserInfoById($val['id']);
								    			$creUserName     = ucwords($creUserDetail['firstName'].' '.$creUserDetail['lastName']);
								    			$creUserEmail    = $creUserDetail['email'];
								    			$from               = $emailFrom;
								    			$subject          = 'New competition "'.$this->input->post('name').'" posted on creosouls';
								    			$template    = 'Hello <b>'.$creUserName. '</b>,<br />New competition "<b>' .$this->input->post('name').'</b>" posted on creosouls.<br /><a href="'.front_base_url().'competition/'.$this->input->post('pageName',TRUE).'">Click here</a>  to see the competition detail.<br /><br /><br />Thanks,<br />Team creosouls<br /><a href="http://www.creosouls.com">www.creosouls.com</a>';
								    			$sendEmailToCreUser = array('to'=>$creUserEmail,'subject'=>$subject,'template'=>$template,'fromEmail'=>$from);
								    									//print_r($sendEmailToCreUser);die;
								    									//$this->modelbasic->sendMail($sendEmailToCreUser);
								    		}
								    		$notificationToCreUser=array('notification_id'=>$notificationId,'user_id'=>$val['id']);
								    		$this->modelbasic->_insert('header_notification_user_relation',$notificationToCreUser);
								    		$msg['notificationImageUrl'] = '';
								    		$msg['notificationTitle'] = 'New Competition Posted';
								    		$msg['notificationMessage']  = ucwords($this->input->post('name',TRUE));
								    		$msg['notificationType']   = 4;
								    		$msg['notificationId']     = $competitionId;
								    		$msg['type']     = 0;
								    		$this->sendGcmToken($val['id'],$msg);
								    		$msg = array (
								    									'body' 	=> '',
								    									'title'	=> '',
								    									'aboutNotification'	=>ucwords($this->input->post('name',TRUE)),
								    									'notificationTitle'	=> 'New Competition Posted',
								    									'notificationType'	=> 4,
								    									'notificationId'	=> $competitionId,
								    									'notificationImageUrl'	=> ''
								    						        );
								    								$this->modelbasic->sendNotification($val['id'],$msg);
								    	}
								    }
								}
							}
						}
						else
						{
							$data1=array('status'=>'fail','message'=>'Error occurred while creating competition please try again....');
						}			    	
					}
			}
			echo json_encode($data1);

		}
		else
		{
			if($this->input->is_ajax_request())
			{
				echo $this->form_validation->get_json();
			}
			else
			{
				$this->load->view('admin/competition/addedit_view');
			}
		}
	}



	function validateCompetitionLogo()

	{

		return $this->image_upload('profile_image','validateCompetitionLogo','200','200');

	}



	function validateJuryPhoto()

	{

		return $this->image_upload('juryPhoto','validateJuryPhoto','200','200');

	}

   public function getAllCities($country)
	{

		$this->load->model('competition_model');

		$data=$this->competition_model->getAllCities($country);

		//print_r($data);die;

		?>





		<?php

		foreach($data as $val)

		{

		?>

		<option value="<?php echo $val['id'];?>"><?php echo $val['name'];?></option>

		<?php

		}

	}

	function validateCoverImage()

	{

		return $this->image_upload('banner','validateCoverImage','945','470');

	}



	function image_upload($folderName,$functionName,$width,$height)

	{

		if(isset($_FILES[$folderName]) && $_FILES[$folderName]['size'] != 0)

		{

			$upload_dir = file_upload_s3_path().'competition/'.$folderName.'/';

			if (!is_dir($upload_dir))

			{

			     mkdir($upload_dir, 0777, TRUE);

			}

			$config['upload_path']   = $upload_dir;

			$config['allowed_types'] = 'jpg|png|jpeg';

			$config['file_name']     = $folderName.'_'.substr(md5(rand()),0,7);

			$config['max_size']	 = '2000';

			if($folderName=='banner')

			{

				$config['maintain_ratio'] = TRUE;
				$config['width']=945;
				$config['height']=470;

			}

			$this->upload->initialize($config);

			if (!$this->upload->do_upload($folderName))

			{

				$this->form_validation->set_message($functionName, $this->upload->display_errors());

				return false;

			}

			else

			{

				$_POST[$folderName] =  $this->upload->data();

		        	if(!is_dir(file_upload_s3_path().'competition/'.$folderName.'/thumbs'))

				{

					mkdir(file_upload_s3_path().'competition/'.$folderName.'/thumbs', 0777, TRUE);

				}

		        	$config['image_library'] = 'gd2';

				$config['source_image'] = file_upload_s3_path().'competition/'.$folderName.'/'.$_POST[$folderName]['file_name'];

				$config['create_thumb'] = FALSE;

				$config['maintain_ratio'] = TRUE;

				$config['width'] = $width;

				$config['height'] = $height;

				$config['new_image'] = file_upload_s3_path().'competition/'.$folderName.'/thumbs/'.$_POST[$folderName]['file_name'];

				/*$this->image_lib->initialize($config);

				$return = $this->image_lib->resize();

				$this->image_lib->clear();*/

				/*if($folderName == 'instituteLogo')

				{*/

					$this->modelbasic->uniResize($config['source_image'], $config['new_image'], $width, $height, $quality = 100, $wmsource = false);

				/*}*/

				return true;

			}

		}





		if(isset($_POST['competitionId'])&&$_POST['competitionId'] > 0)

		{

			return true;

		}

	    else

		{

			$this->form_validation->set_message($functionName,'Image required');

			return false;

		}



	}



	/*function validatepageName()

	{

		$pageName=$this->input->post('pageName',TRUE);

		$instituteId=$this->input->post('instituteId',TRUE);

		$val=$this->modelbasic->getValueWhere('institute_master','pageName',array('id !='=>$instituteId,'pageName'=>$pageName));

		if($val <> '')

		{

			$this->form_validation->set_message('validatepageName', 'Display name is already in use use unique display name.');

			return false;

		}

		else

		{

			return true;

		}

	}*/





	function setFlashdata($function)

	{

		if($function == 'add')

		{

			$this->session->set_flashdata('success','Competition created successfully.');

			redirect(base_url().'admin/competition/');

		}

		else

		{

			$this->session->set_flashdata('success','Competition updated successfully.');

			redirect(base_url().'admin/competition/');

		}

	}



	public function getAllCitiesOfCountry($country,$cityId)

	{

		$this->load->model('competition_model');

		$data=$this->competition_model->getAllCities($country);

		return $data;

	}



	function getEditFormData()

	{

		$competitionId=$this->input->post('competitionId',true);

		$data=$this->competition_model->getEditFormData($competitionId);

		$data['jury']=$this->competition_model->getCompetitionJury($competitionId);

		$cities=$this->getAllCitiesOfCountry($data['countryId'],$data['cityId']);

		$html='';

		foreach($cities as $city)

		{

			$html.='<option'.($city['id'] == $data['cityId'] ? ' selected': '').' value="'.$city['id'].'">'.$city['name'].'</option>';

		}

		$data['cityId']=$html;

		$rankTitles=$this->competition_model->getAllRankTitle($competitionId);

		//print_r($rankTitle);die;

		$html_new='';

		$i=1;

		foreach($rankTitles as $rank)

		{

			$html_new.='<div class="label-wrapper" id="winnerTitles_'.$i.'"><label class="control-label" for="rankTitle">Rank '.$i.' : </label> (<span class="requiredClass"> * </span>) &nbsp;&nbsp;<div class="vd_input-wrapper light-theme" id="winnerCount-input-wrapper"><input type="text" id="p_scnt" size="50" name="rankTitle[]" value="'.$rank['rankTitle'].'" placeholder="Rank '.$i.' Winner Title" class="required"/></div></div>';

			$i++;

		}

		$data['rankTitleName']=$html_new;
		$data['pdf_file']='';
		echo json_encode($data);

	}





	function getCompetitionJury()

	{

		$searchTerm=$this->input->get('search',true);

		$data=$this->modelbasic->getCompetitionJury($searchTerm);

		$dataArray=array();

		if(!empty($data))

		{

			foreach ($data as $key => $value) {

				$dataArray[]=array('value'=>$value['id'],'text'=>$value['email']);



			}

		}

		echo json_encode($dataArray);

	}



	public function upload_image()

	{

		       // $this->load->library('cropAvatar');

		$cropDetails=json_decode(stripslashes($_POST['avatar_data']));

		$data=array('folder_name'=>'avatars','input_name'=>'avatar_file');



		$upload_data=$this->uploadImage($data);

		$image_config['image_library'] = 'gd2';

		$image_config['source_image'] = file_upload_s3_path().'avatars/'.$upload_data["file_name"];

		$image_config['new_image'] = file_upload_s3_path().'avatars/thumbs/'.$upload_data["file_name"];

		$image_config['quality'] = "100%";

		$image_config['maintain_ratio'] = FALSE;

		$image_config['width'] = $cropDetails->width;

		$image_config['height'] = $cropDetails->height;

		$image_config['x_axis'] = $cropDetails->x;

		$image_config['y_axis'] = $cropDetails->y;



		$this->image_lib->clear();

		$this->image_lib->initialize($image_config);



		if ($this->image_lib->crop()){

		  $response = array(

		    'state'  => 200,

		    'message' => 'File Uploaded Successfully',

		    'result' =>file_upload_base_url().'avatars/thumbs/'.$upload_data["file_name"]

		  );

		  echo json_encode($response);

		}

	}



	protected function uploadImage($data)

	{

	   if(!is_dir(file_upload_s3_path().$data['folder_name']))

	   {

	     mkdir(file_upload_s3_path().$data['folder_name'], 0777, TRUE);

	   }

	    $config['upload_path']=file_upload_s3_path().$data['folder_name'];

	    $config['allowed_types'] = 'jpg|png|jpeg';

	    $this->load->library('upload');

	    $this->upload->initialize($config);



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



	public function sendCertificateToWinner($competitionId,$projectId)

	{

		//$competitionId=1;

		$winnerDetail=$this->competition_model->getWinnerDetail($competitionId,$projectId);

		$rankName=$this->modelbasic->getValuewithCondition('competition_rank_title','rankTitle',"competitionId = '".$competitionId."' AND  `rankNumber` = '".$winnerDetail[0]['rank']."'");

		//print_r($winnerDetail);die;

		$string ='<div style="width:900px;font-size: 36px; font-family:Verdana, Geneva, sans-serif;text-align:center;color:#ffffff;min-height:150px; background:#0085c3">

		<span style="font-size:40px;">Certificate of Excellence</span>

		</div>

		<div style="width:900px; border:solid 1px #000;  font-family:Verdana, Geneva, sans-serif;">



			<table width="100%" cellspacing="0" cellpadding="0" border="0">

		            <tbody>

			            <tr style="text-align:center">

						<td width="100%" align="center" style="font-size: 36px"><br />

							<span style="font-size: 24px">The creosouls team certifies that</span><br /><br />

							<span style="color:#0085C3;">'.$winnerDetail[0]['firstName'].' '.$winnerDetail[0]['lastName'].'</span> <br /><br />

							<span style="font-size: 24px">HAS DECLARED WINNER WITH</span><br/><br />

							<span style="color:#0085C3;">'.$rankName.'</span><br /><br />

							<span style="font-size: 24px">OF THE COMPETITION</span><br/><br />

							<span style="color:#0085C3;">'.$winnerDetail[0]['name'].'</span><br /><br />



						</td>

			            </tr>

			            <tr>

			            		<td>

			            			<table width="100%" cellspacing="0" cellpadding="0" border="0">

			            				<tbody>

			            					<tr style="text-align:center">

										<td width="33%" align="center"><br/>

											<img src="'.base_url().'backend_assets/img/sign.png"/><br/><br/>

											<img src="'.base_url().'backend_assets/img/line.png"/><br/>

											Tushar Desai<br/>

											Emmersive Infotech,<br/>

											Pune

										</td>

										<td width="33%" align="center">



											<strong><span>'.date("l, j F Y",strtotime(date('Y-m-d'))).'</span></strong><br/><br/>

										<img src="'.base_url().'backend_assets/img/line.png"/ style="margin-top: 2px"><br/>

										Date

										</td>

										<td width="34%" align="center">

										<img src="'.base_url().'backend_assets/img/tenant_logo.png"/>

										</td>

									</tr>



								</tbody>

							</table>

							<br />

						</td>

			            </tr>

		          </tbody>

		       </table>



		</div>';



		//echo $string;die;

			$competitionName=$this->modelbasic->getValue('competitions','name','id',$competitionId);

			$subject='Winner Certificate for Competition "'.$competitionName.'"';

			$this->load->library('MPDF53/mpdf');

			$file_name = 'creosouls_'.time().'.pdf';

			$paper	=	'A4';

			$mpdf	=	new mPDF('utf-8',$paper);

			$mpdf->WriteHTML($string);

			//echo $string;die;

			$mpdf->Output(file_upload_s3_path().'winner_certificate/'.$file_name,'F');

			$data=array('to'=>$winnerDetail[0]['email'],'from'=>$winnerDetail[0]['contactEmail'],'subject'=>$subject,'template'=>$winnerDetail[0]['winnerEmail'],'attachment'=>'./uploads/winner_certificate/'.$file_name);

			//$this->modelbasic->sendMailWithAttachment($data);



	}





	public function getRating()

	{

	    	if(isset($_POST['projectId']) && $_POST['projectId'] > 0 && isset($_POST['competitionId']) && $_POST['competitionId'])

		{

			$data = $this->competition_model->get_project_jury_ratings($_POST['projectId'],$_POST['competitionId']);

			$totalRating=0;

			$newArray=array();



			if(!empty($data))

			{

				$i=0;

				$table='<table class="table"><thead string="text-align:center;"><tr><th>Jury Name</th><th>Rating</th><th>Comment</th></tr></thead><tbody>';



				foreach ($data as $value)

				{

					$juryName=$this->modelbasic->getValue('competition_jury','name','id',$value["juryId"]);

					$totalRating+=$value['rating'];

					$table.='<tr><td>'.$juryName.'</td><td>'.$value['rating'].'</td><td>'.$value['rate_comment'].'</td></tr>';

					$i++;

				}

				$table.='</tbody></table>';

				$newArray['juryRatings']=$table;

				$newArray['avgRating']=round($totalRating/$i,2);

			}

			else

			{

				$newArray['avgRating']=0;

			}



			echo json_encode($newArray);

		}

	}





	public function sendGcmToken($userId,$msg)
	{
	 	$API_ACCESS_KEY='AIzaSyCAVHevvPy-yAZUbJdRRF2RLf8DTQcDcGw';
	    $deviceId = $this->modelbasic->getValue('users','deviceId',"id",$userId);
		if(isset($deviceId)&&$deviceId!='')
		{
		    $gcmToken = $this->modelbasic->getValue('gcm','gcmToken',"deviceId",$deviceId);
			if(isset($gcmToken)&& $gcmToken!='')
			{
					$gcmId = array($gcmToken);
					$fields = array
					(
						'registration_ids' 	=> $gcmId,
						'data'			=>  array('default'=>$msg)
					);
					$headers = array
					(
						'Authorization: key=' . $API_ACCESS_KEY,
						'Content-Type: application/json'
					);
					$ch = curl_init();
					curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
					curl_setopt( $ch,CURLOPT_POST, true );
					curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
					curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
					curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
					curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
					$result = curl_exec($ch );
					curl_close( $ch );
			}
		}
       return;
	}

	public function linkStudent(){
		if(empty($_POST)){
			$data['countries']=$this->competition_model->getAllCountry();
			$data['institutedata']=$this->competition_model->getregionwiseinstitute();
			$this->load->view('admin/competition/manage_competition_student',$data);
		}else{
			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			$this->form_validation->set_rules('competition', 'Competition', 'required');
			$this->form_validation->set_rules('student', 'Select Student', 'required');
			$this->form_validation->set_rules('institute', 'Select Institute', 'required');
			$this->form_validation->set_rules('region', 'Select Region', 'required');
			$this->form_validation->set_rules('zone', 'Select Zone', 'required');
			if ($this->form_validation->run())
			{
				if(isset($_POST['student']))
				{
					$studentArray = $this->input->post('student',TRUE);
				}
				if(!empty($studentArray))
				{
					foreach($studentArray as $svalue)
					{
						$checkStudentLinked = $this->db->select('*')->from('competition_selected_student')->where('user_id',$svalue)->where('competition_id',$this->input->post('competition',TRUE))->get()->row_array();
						if(empty($checkStudentLinked)){
							$insertData=array('competition_id'=>$this->input->post('competition',TRUE),'user_id'=>$svalue,'status'=>1,'created'=>date('Y-m-d H:i:s'));
							$insertId = $this->competition_model->_insert('competition_selected_student',$insertData);			
						}else{
							$insertId = 0;
						}
						if($insertId > 0){
							$compId = $this->input->post('competition',TRUE);
							$compPageName =  $this->modelbasic->getValueArray("competitions","pageName",array('id'=>$compId));
							$compName = $this->modelbasic->getValueArray("competitions","name",array('id'=>$compId));
							$compLink = "competition/".$compPageName;
							$notificationId =$this->db->select('id')->from('header_notification_master')->where('redirectId',$compId)->like('link',$compLink)->get()->row_array();
							$notificationMasterId = $notificationId['id'];
							if($notificationMasterId !=''){
								$notificationToCreUser=array('notification_id'=>$notificationMasterId,'user_id'=>$svalue);
								$this->modelbasic->_insert('header_notification_user_relation',$notificationToCreUser);
								
								
							}
						}
						
					}
				}
				if($insertId > 0){

					$data = array('status' =>'success','for' =>'add','message'=>'Students linked to competition successfully.');
								
				}
				else
				{
					$data = array('status' =>'fail','message'=>'Error occurred while linking student please try again....');
				}
				echo json_encode($data);
			}
			else
			{
				if($this->input->is_ajax_request()){
					echo $this->form_validation->get_json();
				}
				else
				{
					$this->load->view('admin/competition/addedit_student');
				}
			}
			
		}
		
		
	}

	function get_studentDataObjects()
	{
		$this->competition_model->markCompletedCompetions();

		$_POST['columns']='A.id,A.profile_image,A.name,A.created,A.status,A.banner,A.end_date,A.start_date,A.evaluation_end_date,A.evaluation_start_date,A.award,A.jury,A.eligibility,A.rule,A.instituteId,A.addedBy'; //userStatus,B.id,B.email,admin_name,

		$requestData= $_REQUEST;

		$columns=explode(',',$_POST['columns']);

		$selectColumns="A.id,A.profile_image,A.name,A.created,A.status,A.banner,A.end_date,A.start_date,A.evaluation_end_date,A.evaluation_start_date,A.award,A.jury,A.eligibility,A.rule,A.instituteId,A.addedBy";

		$condition=array('competition_type'=>3);
		
		$totalData=$this->modelbasic->count_all_only('competitions',$condition);

		$totalFiltered=$totalData;
		$concatColumns=''; //B.firstName,B.lastName
		$result=$this->competition_model->run_query_student('competitions',$requestData,$columns,$selectColumns,$concatColumns,''); //admin_name
		if( !empty($requestData['search']['value']) )
		{
			$totalFiltered=count($result);
		}
		$data = array();

		if(!empty($result))
		{
			$i=1;
			foreach ($result as $row)
			{
				$nestedData=array();
				$det = $this->db->select('A.id,A.firstName,A.lastName,B.studentId')->from('users as A')->join('competition_selected_student as C','C.user_id = A.id')->join('institute_csv_users as B','B.email = A.email')->where('C.competition_id',$row['id'])->get()->result_array();
				$html='';
				//$det = $competition_projects->result_array();
				if(!empty($det))
				{
					$j=1;
					foreach($det as $dt)
					{
						
				  			

				  			$html.='<tr>
										<td>'.$j.'</td>'.
				                        '<td>'.$dt['lastName'].'</td>'.
				                        '<td>'.$dt['firstName'].'</td>'.
				                        '<td>'.$dt['studentId'].'</td>
				                    </tr>';
							$j++;
				  		}
				  	}
				  	$nestedData['competition_students']=$html;
					if($row['status'] == 1)
					{
						$userStatusHtml='<span class="label label-success" style="cursor: auto;">Active</span>';
					}
					else
					{
						$userStatusHtml='<span class="label label-danger" style="cursor: auto;">Deactive</span>';
					}
					
					$competitionCoverImage=$row["banner"];
					if($competitionCoverImage <> '')
					{
						if(file_exists(file_upload_absolute_path().'competition/banner/thumbs/'.$competitionCoverImage))
						{
							$competitionCoverImage = '<img width="135" src="'.file_upload_base_url().'competition/banner/thumbs/'.$competitionCoverImage.'">';
						}
						else
						{
							$competitionCoverImage = '<img width="135" src="'.base_url().'backend_assets/img/noimage1.png">';
						}
					}
					else
					{
						$competitionCoverImage = '<img width="135" src="'.base_url().'backend_assets/img/noimage1.png">';
					}
					$competitionLogo=$row["profile_image"];
					if($competitionLogo <> '')
					{
						if(file_exists(file_upload_absolute_path().'competition/profile_image/thumbs/'.$competitionLogo))
						{
							$competitionLogo = '<img width="100" height="100" src="'.file_upload_base_url().'competition/profile_image/thumbs/'.$competitionLogo.'">';
						}
						else
						{
							$competitionLogo = '<img width="100" height="100" src="'.base_url().'backend_assets/img/noimage1.png">';
						}
					}
					else
					{
						$competitionLogo = '<img width="100" height="100" src="'.base_url().'backend_assets/img/noimage1.png">';
					}
					$nestedData['chk'] = '<input type="checkbox" class="case" id="check" name="checkall['.$row["id"].']" data-index="'.$row["id"].'">';

					$nestedData['id'] =$i+$requestData['start'];

					$nestedData['competitionName'] =$competitionLogo.'<br/>'.' <a target="_blank" href="'.front_base_url().'competition/get_competition/'.$row["id"].'">'.$row["name"].'</a>';

					$nestedData['competitionDetails'] = '<b>Competition Id: </b>'.$row["id"].'<br/><b>Cover Image: </b>'.$competitionCoverImage;
					$nestedData['start_date'] = date("d-M-Y", strtotime($row["start_date"]));
					$nestedData['end_date'] = date("d-M-Y", strtotime($row["end_date"]));
					$evaluationStartDate=date("Y-m-d", strtotime($row["evaluation_start_date"]));
					$evaluationEndDate=date("Y-m-d", strtotime($row["evaluation_end_date"]));
					$todayDate=date('Y-m-d');
					if($row["status"]==2)
					{
						$button='<span class="btn label-success" style="font-size:10px;padding:3px 7px;" onclick="emailToJury('.$row['id'].')">Send Reminder</span>';
					}
					else
					{
						$button='';
					}
					$checkWinnerEntry=$this->modelbasic->getValue('competition_winning_projects','projectId','competitionId',$row["id"]);
					
					$nestedData['award'] = $row["award"];
					$nestedData['jury'] = $row["jury"];
					$nestedData['eligibility'] = $row["eligibility"];
					$nestedData['rule'] = $row["rule"];
					if($row["status"]==1)
					{
						$nestedData['status'] = '<span class="label label-success">Inprogress</span>';
					}
					elseif($row["status"]==0)
					{
						$nestedData['status'] = '<span class="label label-danger" >Pending</span>';
					}
					elseif ($row["status"]==2)
					{
						$nestedData['status'] = '<span class="label label-primary" >Evaluating</span>';
					}
					elseif ($row["status"]==3)
					{
						$nestedData['status'] = '<span class="label label-info" >Evaluated</span>';
					}
					elseif ($row["status"]==4)
					{
						$nestedData['status'] = '<span class="label label-danger" >Completed</span>';
					}
					elseif ($row["status"]==5)
					{
						$nestedData['status'] = '<span class="label label-danger" >Expired</span>';
					}
					
					if($this->session->userdata('admin_level')==2 && $row["addedBy"]==4)
					{
						$nestedData['action'] = '<a onclick="showDetails(this)" data-original-title="view" data-toggle="tooltip" data-placement="top" class="btn menu-icon vd_bd-green vd_green"> <i class="fa fa-eye"></i> </a>'.$button;
					}else{
						$nestedData['action'] = '<a onclick="showDetails(this)" data-original-title="view" data-toggle="tooltip" data-placement="top" class="btn menu-icon vd_bd-green vd_green"> <i class="fa fa-eye"></i> </a>'.$button;
					}
					$data[] = $nestedData;
					$i++;
				}
			}
			$json_data = array(

					"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.

					"recordsTotal"    => intval( $totalData ),  // total number of records

					"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData

					"data"            => $data   // total data array

					);

			echo json_encode($json_data);

	}

	function getZoneRegionList()
	{		
		$zoneId = $_POST['zoneId'];
		$instituteId = $_POST['instituteId'];
		if($instituteId != 0 )
		{
			$getSelectedRegion = $this->modelbasic->getSelectedData('institute_master','region',array('id'=>$instituteId));
		}
		$data = $this->modelbasic->getSelectedData('region_list','*',array('zone_id'=>$zoneId));
		if(!empty($data))
		{
			foreach($data as $value)
			{
				?>
				<option value="<?php echo $value['id'];?>" <?php if(isset($getSelectedRegion) && $getSelectedRegion[0]['region'] ==$value['id']){ echo "selected"; }?>><?php echo $value['region_name'];?> </option>
				<?php
			}
		}
		else
		{
			echo '';
		}		
	}
	function getRegionInstituteList(){
		if(!empty($_POST['regionId']))
		{
			?>
			<option value="">Select Institute</option>
			<?php
			

				$regionId = $_POST['regionId'];			
				$data = $this->modelbasic->getSelectedData('institute_master','id,instituteName',array('region'=>$regionId));
				?>
				
				<?php
				if(!empty($data))
				{
					foreach($data as $value)
					{
						?>		

						<option value="<?php echo $value['id'];?>"><?php echo $value['instituteName'];?> </option>
						<?php
					}
				}
				else
				{
					echo '';
				}	
				
			
		}
	}
	function getInstituteStudentList(){
			if(!empty($_POST['instId']))
			{
				?>
				<option value="">Select Student</option>
				<?php
					$instId = $_POST['instId'];				
					$data = $this->db->select('A.id,A.firstName,A.lastName,B.studentId')->from('users as A')->join('institute_csv_users as B','B.email = A.email')->where('A.instituteId',$instId)->where('A.status',1)->where('A.admin_level',0)->where('B.studentId !=', '')->where('B.email !=', '')->where('B.centerId ', 1)->order_by('A.firstName','asc')->get()->result_array();

				?>
				<?php
					if(!empty($data))
					{
						foreach($data as $value)
						{
				?>		
							<option value="<?php echo $value['id'];?>"><?php echo $value['firstName'];?>&nbsp;&nbsp;<?php echo $value['lastName'];?>&nbsp;(<?php echo $value['studentId'];?>)</option>
							<?php
						}
					}
					else
					{
						echo '';
					}	
		
			}
		}



}

