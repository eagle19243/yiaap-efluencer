<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class projectdashboard_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }
    
    public function getMessage($user_id,$project_id,$limit = '', $start = ''){ 
        $this->db->select();
		$this->db->where('recipient_id',$user_id);
		$this->db->where('project_id',$project_id);
        $this->db->order_by('id','desc');
		$this->db->limit($limit, $start);
        $res=$this->db->get("message");
        $data=array();
        
        foreach($res->result() as $val){ 
            $data[]=array(
                "id" => $val->id,
				"sender_id" => $val->sender_id,
                "message" => $val->message,
                "add_date" => $val->add_date,
				'attachment'=>$val->attachment
            );
        }
        return $data;
    }
	public function getoutgoingMessage($user_id,$project_id,$limit = '', $start = ''){ 
        $this->db->select();
		$this->db->where('sender_id',$user_id);
		$this->db->where('project_id',$project_id);
        $this->db->order_by('id','desc');
		$this->db->limit($limit, $start);
        $res=$this->db->get("message");
        $data=array();
        
        foreach($res->result() as $val){ 
            $data[]=array(
                "id" => $val->id,
				"recipient_id" => $val->recipient_id,
                "message" => $val->message,
                "add_date" => $val->add_date,
				'attachment'=>$val->attachment
            );
        }
        return $data;
    }
	public function getfiles($project_id,$limit = '', $start = ''){ 
        $this->db->select();
		$this->db->where('attachment <>',"");
		$this->db->where('project_id',$project_id);
        $this->db->order_by('id','desc');
		$this->db->limit($limit, $start);
        $res=$this->db->get("message");
        $data=array();
        
        foreach($res->result() as $val){ 
            $data[]=array(
                "id" => $val->id,
				"sender_id" => $val->sender_id,
                "message" => $val->message,
                "add_date" => $val->add_date,
				'attachment'=>$val->attachment
            );
        }
        return $data;
    }
	public function getAllMessage($project_id,$sender_id,$recipient_id,$limit = '', $start = '')
	{
		$recipients=array($sender_id,$recipient_id);
		$sender=array($sender_id,$recipient_id);
		$this->db->select();
		$this->db->where('project_id',$project_id);
		$this->db->where_in('sender_id',$sender);
		$this->db->where_in('recipient_id',$recipients);
		$this->db->order_by('add_date','desc');
		$this->db->limit($limit, $start);
		$rs=$this->db->get('message');
		$data=array();
        
        foreach($rs->result() as $val){ 
            $data[]=array(
                "id" => $val->id,
                "project_id" => $val->project_id,
				"sender_id" => $val->sender_id,
				"recipient_id" => $val->recipient_id,
                "message" => $val->message,
				"attachment" => $val->attachment,
                "add_date" => $val->add_date
            );
        }
        return $data;
	}
	public function countAllMessage($project_id,$sender_id,$recipient_id)
	{
		$recipients=array($sender_id,$recipient_id);
		$sender=array($sender_id,$recipient_id);
		$this->db->select();
		$this->db->where('project_id',$project_id);
		$this->db->where_in('sender_id',$sender);
		$this->db->where_in('recipient_id',$recipients);
		$this->db->order_by('add_date','desc');
		$this->db->from('message');
		return $this->db->count_all_results();
		
	}
	public function insertMessage($data)
	{
		return $this->db->insert('message',$data);	
	}
	public function delete_message($mid)
	{
		$this->db->where('id',$mid);
		return $this->db->delete('message');	
	}
	
	
	// ---------------------------Not Use Any More -------------------------------------//
	
	public function getOutgoingMilestone($uid,$pid){
        $this->db->select("*");
		 $data= array();
        $data=$this->db->get_where("milestone_payment",array("employer_id"=>$uid,'project_id'=>$pid))->result_array();
       
        return $data;
        
    }
	
	public function getIncomingMilestone($uid,$pid){
		 $data=array();
		 $this->db->select("*");
		
         $data=$this->db->get_where("milestone_payment",array("worker_id"=>$uid,"project_id"=>$pid))->result_array();
       
	   
      
        return $data;
        
    }
	
	// ---------------------------------------- End Of Not Use Any More ---------------------//
	
	 public function getprojectdetails($id){ 
	  $data=array();
        $this->db->select('*');
         $data=$this->db->get_where("projects",array("project_id"=> $id))->row_array();
       
        
        return $data;
        
        
    }
	
	public function listing_search_pagination($pid,$pagination_string = '', $offset = 6) {
        if ($pagination_string != "") {
            $config['base_url'] = base_url() . "projectdashboard/employer/".$pid."?" . $pagination_string;
        } else {
            $config['base_url'] = base_url() . "projectdashboard/employer/".$pid."?page_id=0";
        }

        $config['total_rows'] = $this->search_count();
        $config['per_page'] = $offset;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'limit';

        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';

        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';

        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';

        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="active"><a href="javascript:void(0);">';
        $config['cur_tag_close'] = '</a></li>';
        $this->pagination->initialize($config);
        return $this->pagination->create_links();
    }
	
	private function search_count() {
        $nor = $this->db->query($this->last_query)->num_rows();
        return $nor;
    }
	
	public function getprojecttracker_manual($pid){
		$this->db->select("*");
		$this->db->where(array("project_id"=> $pid));		
		$this->db->where('stop_time <>','0000-00-00 00:00:00');
		$this->db->from("project_tracker_manual");
		$this->db->order_by('start_time','DESC');
		/* $this_query = $this->db->_compile_select();
        $this->last_query = $this_query; */
        $data=$this->db->get()->result_array();
		
        return $data;
	}
	
	
	public function getProjectUsers($project_id='', $utpye='E'){
		$user = $this->session->userdata('user');
		
		$result = array();
		
		if($utpye == 'F'){
			$p_row = get_row(array('select' => '*', 'from' => 'projects', 'where' => array('project_id' => $project_id)));
			$user_row = get_row(array('select' => 'fname,lname', 'from' => 'user', 'where' => array('user_id' => $p_row['user_id'])));
			if($p_row){
				$result[0]['user_id'] = $p_row['user_id'];
				$result[0]['name'] = $user_row['fname'].' '.$user_row['lname'];
				$result[0]['type'] = 'Employer';
				$result[0]['unread_msg'] =$this->db->where(array('recipient_id' => $user[0]->user_id, 'sender_id' => $p_row['user_id'],  'read_status' => 'N'))->count_all_results('message');
			}
		}else{
			
			$p_row = get_row(array('select' => '*', 'from' => 'projects', 'where' => array('project_id' => $project_id)));
			$p_users = $p_row['bidder_id'];
			//get_print($p_users , FALSE);
			if(!empty($p_users)){
				$all_users = explode(',',$p_users);
				if(count($all_users) > 0){
					foreach($all_users as $k => $v){
						if($v != 0){
							
							$user_row = get_row(array('select' => 'fname,lname', 'from' => 'user', 'where' => array('user_id' => $v['user_id'])));
							
							$result[] = array(
								'user_id' => $v,
								'name' => $user_row['fname'].' '.$user_row['lname'],
								'type' => 'Freelancer',
								'unread_msg' => $this->db->where(array('sender_id' => $v, 'recipient_id' => $user[0]->user_id, 'read_status' => 'N'))->count_all_results('message')
							);
						}
					}
				}
			}
		}
		
		return $result;
	}
	
	public function getsetMilestone($pid){
		$data=array();
		
		$user=$this->session->userdata('user');
		$data['account_type']=$user[0]->account_type;
		$data['user_id']=$user[0]->user_id;
		
        $this->db->select('pm.*')->from('project_milestone pm');
		$this->db->join('bids b','b.id=pm.bid_id','LEFT');
		$this->db->where('pm.project_id',$pid);
		$this->db->where('pm.status','A');
		if($data['account_type'] == 'F'){
		$this->db->where('b.bidder_id',$data['user_id']);
		}
        $data=$this->db->get()->result_array();
       
        
        return $data;
    }
	
	public function getProjectUserSingle($user_id=''){
		
		$user_row = get_row(array('select' => '*', 'from' => 'user', 'where' => array('user_id' => $user_id)));
		
		return $user_row;
	}	
	
	public function getCountryCityDetails_user($counrty='',$city_code=''){
		
		$this->db->select('Name,Code2');
		$this->db->from('country');
		$this->db->where('Code',$counrty);
		$result = $this->db->get()->row_array();
		$result['city_name'] = getField('Name','city','ID',$city_code);
		//get_print($result);
		return $result;
	}	
	

	/* New function */
	
	public function getProjectActivity($pid=''){
		 $this->db->select('*')
				->from('project_activity')
				->where('project_id', $pid);
		$res = $this->db->get()->result_array();
		if(count($res) > 0){
			foreach($res as $k => $v){
				$res[$k]['assigned_user'] = $this->_getActivityAssignedUser($v['id']);
			}
		}
		return $res;
	}
	
	public function _getActivityAssignedUser($act_id=''){
		$this->db->select('u.user_id,u.fname,u.lname,au.approved')
					->from('project_activity_user au')
					->join('user u', 'u.user_id=au.assigned_to', 'LEFT');
		$this->db->where('au.activity_id', $act_id);
		$result = $this->db->get()->result_array();
		return $result;
	}
	
	public function getDisputeMessages($srch=array(), $limit=0, $offset=40, $for_list=TRUE){
		$this->db->where('milestone_id', $srch['milestone_id']);
		$this->db->where('project_id', $srch['project_id']);
		
		if($for_list){
			$result = $this->db->limit($offset, $limit)->order_by('message_id', 'ASC')->get('dispute_messages')->result_array();

			if(count($result) > 0){
				foreach($result as $k => $v){
					
					$sender_info = $this->db->where('user_id', $v['sender_id'])->get('user')->row_array();
					
					$profile_pic = '';
			
					if(!empty($sender_info['logo'])){
						
						$profile_pic = base_url('assets/uploaded/'.$sender_info['logo']);
						
						if(file_exists('assets/uploaded/cropped_'.$sender_info['logo'])){
							$profile_pic = base_url('assets/uploaded/cropped_'.$sender_info['logo']);
						}
					}else{
						$profile_pic = base_url('assets/images/user.png');
					}
			
					
					$result[$k]['message'] = $v['message'];
					$result[$k]['date'] = date('d M, Y h:i A', strtotime($v['date']));
					$result[$k]['message_id'] = $v['message_id'];
					$result[$k]['attachment'] = $v['attachment'];
					$result[$k]['sender'] = array(
						'sender_id' => $v['sender_id'],
						'name' => $sender_info['fname'],
						'image' => $profile_pic,
					);
				}
			}
		}else{
			$result = $this->db->get('dispute_messages')->num_rows();
		}
		
		return $result;
	}
	
	public function getDisputeHistory($srch=array(), $limit=0, $offset=40, $for_list=TRUE){
		$this->db->where('milestone_id', $srch['milestone_id']);
		$this->db->where('project_id', $srch['project_id']);
		
		if($for_list){
			$result = $this->db->limit($offset, $limit)->order_by('id', 'DESC')->get('dispute_history')->result_array();

			if(count($result) > 0){
				foreach($result as $k => $v){
					
					$employer_info = $this->db->where('user_id', $v['employer_id'])->get('user')->row_array();
					$freelancer_info = $this->db->where('user_id', $v['worker_id'])->get('user')->row_array();
					
					$result[$k]['employer_info'] = $employer_info;
					$result[$k]['freelancer_info'] = $freelancer_info;
					
				}
			}
		}else{
			$result = $this->db->get('dispute_messages')->num_rows();
		}
		
		return $result;
	}
	
	public function getPendingDispute($project_id='', $bidder_id=''){
		$m_rows= $this->db->select('sum(amount) as amount')->from('escrow_new')->where(array('project_id' => $project_id, 'status' => 'D'))->get()->row_array();
		
		if(!empty($m_rows)){
			return $m_rows['amount'];
		}
		
		return 0;
	}
	
	public function getApproveDispute($project_id=''){
		$m_rows= $this->db->select('milestone_id')->from('escrow_new')->where(array('project_id' => $project_id))->get()->result_array();
		$dispute_milestones = array();
		
		if($m_rows){
			foreach($m_rows as $k => $v){
				$dispute_milestones[] = $v['milestone_id'];
			}
			
			
			
			$this->db->select("(sum(employer_amount)) as diff",FALSE)
				->from('dispute_history')
				->where_in('milestone_id', $dispute_milestones)
				->where('status', 'A');
				
			$result = $this->db->get()->row_array();
			
			if(!empty($result['diff'])){
				return $result['diff'];
			}
			
			return 0;
		}
	}
	
	public function getCommission($project_id=''){
		$c_rows= $this->db->select('sum(commission) as commission')->from('milestone_payment')->where(array('project_id' => $project_id, 'release_type' => 'P'))->get()->row_array();
		
		if(!empty($c_rows)){
			return $c_rows['commission'];
		}
		
		return 0;
		
	}
	
	
	public function getProjectScheduleFreelancer($project_id='', $freelancer_id=''){
		
		return $this->db->where(array('project_id' => $project_id, 'freelancer_id' => $freelancer_id))->get('project_schedule')->row_array();
		
	}
	
	public function getProjectRequestFreelancer($project_id='', $freelancer_id=''){
		return $this->db->where(array('project_id' => $project_id, 'freelancer_id' => $freelancer_id))->get('project_start_request')->row_array();
	}
	
	public function getProjectSchedule($project_id=''){
		
		return $this->db->where(array('project_id' => $project_id))->get('project_schedule')->result_array();
		
	}
	
	public function getProjectRequest($project_id=''){
		return $this->db->where(array('project_id' => $project_id, 'status' => 'P'))->get('project_start_request')->result_array();
	}
	
	public function startScheduledProject(){
		$curr_date = date('Y-m-d');
		$this->db->where("project_start_date <= '$curr_date'")->update('project_schedule', array('is_project_start' => '1'));
		
	}
	
	public function insertTrackerManual($data=array()){ 
        $ins = $this->db->insert("project_tracker_manual",$data);
		return $this->db->insert_id();
    }
	
	public function checkProjectDeposit($min_deposit=0 , $project_id=''){
		$total_deposit = get_project_deposit($project_id);
		$total_release = get_project_release_fund($project_id);
		$total_pending = get_project_pending_fund($project_id);
		$remaining_bal = $total_deposit - $total_release - $total_pending;
	
		if($remaining_bal < $min_deposit){
			$this->db->where(array('project_id' => $project_id, 'status' => 'P'))->update('projects', array('status' => 'S'));
			
			$employer_id =  getField('user_id', 'projects', 'project_id', $project_id);
			$to_mail = array();
			$to_mail[] = getField('email', 'user', 'user_id', $employer_id);
			$all_flncer = $this->db->where(array('project_id' => $project_id, 'is_contract_end <>' => '1'))->get('project_schedule')->result_array();
			if($all_flncer){
				foreach($all_flncer as $k => $v){
					$to_mail[] = getField('email', 'user', 'user_id', $v['freelancer_id']);
				}
			}
			
			$template='project_stopped';
			$project_title = getField('title', 'projects', 'project_id', $project_id);
			$data_parse=array( 'PROJECT'=>$project_title);
			send_layout_mail($template, $data_parse, $to_mail);
					
		}else{
			$this->db->where(array('project_id' => $project_id, 'status' => 'S'))->update('projects', array('status' => 'P'));
		}
	}
	
	
	public function getProjectFeedback($project_id='', $feedback_from=''){
		
		$result = array();
		
		$feedback = $this->db->where('project_id', $project_id)->get('feedback')->result_array();
		
		$ratings = $this->db->where(array('project_id' => $project_id))->get('review_new')->result_array();
		
		foreach($feedback as $k => $v){
			$result['private'][$v['feedback_by_user'].'|'.$v['feedback_to_user']]  = $v;
		}
		foreach($ratings as $k => $v){
			$result['public'][$v['review_by_user'].'|'.$v['review_to_user']]  = $v;
		} 
		
		return $result;
		
	}
	
	public function getprojecttracker($pid ,$uid=''){
		$this->db->select("*");
		$this->db->where(array("project_id"=> $pid));	
		if($uid){
			$this->db->where(array("worker_id"=> $uid));	
		}
		$this->db->where('stop_time <>','0000-00-00 00:00:00');
		$this->db->from("project_tracker");
		$this->db->order_by('start_time','DESC');
		/* $this_query = $this->db->_compile_select();
        $this->last_query = $this_query; */
        $data=$this->db->get()->result_array();
		
        return $data;
	}
	
	
	public function getscreenshot($tracker_id, $limit = '', $start = '', $for_list=TRUE){
		$this->db->select("*");
		$this->db->from("project_tracker_snap");
		$this->db->where("project_tracker_id", $tracker_id);
		$this->db->order_by('project_work_snap_time','DESC');
		
		if($for_list){
			$this->db->limit($limit, $start);
			$res=$this->db->get()->result_array();
		}else{
			$res=$this->db->get()->num_rows();
		}
		
        return $res;
	}
	
	public function getTrackerDetail($srch=array()){
		$this->db->select("t_s.*");
		$this->db->from("project_tracker t");
		$this->db->join("project_tracker_snap t_s", "t.id=t_s.project_tracker_id");
		
		if(!empty($srch['project_id'])){
			$this->db->where("t.project_id", $srch['project_id']);
		}
		
		if(!empty($srch['worker_id'])){
			$this->db->where("t.worker_id", $srch['worker_id']);
		}
		
		if(!empty($srch['show_date'])){
			$d = date('Y-m-d', $srch['show_date']);
			$this->db->where("DATE(t_s.project_work_snap_time) = '$d'");
		}
	
		$this->db->order_by('t_s.project_work_snap_time','ASC');
		
		$res=$this->db->get()->result_array();
		
		
        return $res;
	}
	
	
 
}