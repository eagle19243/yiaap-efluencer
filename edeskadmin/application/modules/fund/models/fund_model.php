<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class  Fund_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }


   public function getTransaction($limit = '', $start = ''){ 
        $this->db->select('*');
        $this->db->order_by("id","desc");
        $this->db->limit($limit,$start);      
        $res=$this->db->get("transaction");
        $data=array();
        
        foreach($res->result() as $row){ 
            $data[]=array(
               "paypal_transaction_id" =>$row->paypal_transaction_id,
			   "project_id" =>$row->project_id,
			   "activity" =>  $row->activity,
               "amount" =>  $row->amount,
			   "user_id" => $row->user_id,
               "transction_type" => $row->transction_type,
               "transaction_for" => $row->transaction_for,
               "transction_date"  => $row->transction_date,
               "status" => $row->status
            );
        }
		//print_r($data);
		//die;
        return $data;
    }
	public function getTransaction_byproject_id($project_id, $limit = '', $start = ''){ 
        $this->db->select('*');
		$this->db->where('project_id',$project_id);
        $this->db->order_by("id","desc");
        $this->db->limit($limit,$start);      
        $res=$this->db->get("transaction");
        $data=array();
        
        foreach($res->result() as $row){ 
            $data[]=array(
               "paypal_transaction_id" =>$row->paypal_transaction_id,
			   "project_id" =>$row->project_id,
			   "activity" =>  $row->activity,
               "amount" =>  $row->amount,
			   "user_id" => $row->user_id,
               "transction_type" => $row->transction_type,
               "transaction_for" => $row->transaction_for,
               "transction_date"  => $row->transction_date,
               "status" => $row->status
            );
        }
		//print_r($data);
		//die;
        return $data;
    }
	
	public function getFilterTransaction($from='',$to='',$uname='',$trnxs='',$project='',$limit = '', $start = ''){ 
	
       $this->db->select('t.*,u.username')->from('transaction t');
		$this->db->join('user u', 't.user_id=u.user_id', 'LEFT');
		$this->db->join('projects p', 'p.project_id=t.project_id', 'LEFT');
		
			if(!empty($from)){
		   $this->db->where('date(t.transction_date) >=', $from);
		   }
		   if(!empty($to)){
			$this->db->where('date(t.transction_date) <=', $to);
		   }
		   if(!empty($uname)){
			   
			$this->db->where("(CONCAT(u.fname,' ',u.lname) LIKE '%{$uname}%') OR ( u.username LIKE '%{$uname}%') OR (u.email LIKE '%{$uname}%')");  
			
			//$this->db->like('u.username',$uname);
		   }
		   if(!empty($trnxs)){
			$this->db->where('t.transction_type',$trnxs);
			}
			if(!empty($project)){
			$this->db->like('p.title',$project);
			}
         $this->db->order_by("t.id","desc");
        $this->db->limit($limit,$start);      
        $res=$this->db->get();
		//print_r($this->db->last_query());
		//die();
        $data=array();
        
        foreach($res->result() as $row){ 
            $data[]=array(
               "paypal_transaction_id" =>$row->paypal_transaction_id,
			   "project_id" =>$row->project_id,
               "amount" =>  $row->amount,
			   "user_id" => $row->user_id,
               "transction_type" => $row->transction_type,
               "transaction_for" => $row->transaction_for,
               "transction_date"  => $row->transction_date,
               "status" => $row->status
            );
        }
		//print_r($data);
		//die;
        return $data;
    }
	
	
   public function getTransactionCount($project_id=''){ 
   		if($project_id!="")
		{
       		$this->db->where("project_id",$project_id);
	   	}
        $this->db->from('transaction');
        return $this->db->count_all_results(); 
    }
	
	public function getFundCount(){ 
       // $this->db->where("user_id",$user_id);
        $this->db->from('useraddfund');
        return $this->db->count_all_results(); 
    }
	   
	public function getFilterCount($from='',$to='',$uname='',$trnxs='',$project=''){ 
       $this->db->select('t.*,u.username')->from('transaction t');
		$this->db->join('user u', 't.user_id=u.user_id', 'LEFT');
		$this->db->join('projects p', 'p.project_id = t.project_id', 'LEFT');
		
		if(!empty($from)){
		   $this->db->where('t.transction_date >=', $from);
		   }
		   if(!empty($to)){
			$this->db->where('t.transction_date <=', $to);
		   }
		   if(!empty($uname)){
			$this->db->like('u.username',$uname);
		   }
		   if(!empty($trnxs)){
			$this->db->where('t.transction_type',$trnxs);
			}
			if(!empty($project)){
			$this->db->like('p.title',$project);
			}
        return $this->db->count_all_results(); 
    } 
    
	
  public function insertTransaction($data){          
        return $this->db->insert("transaction",$data);
    }
	
	
	 public function updateUser($amount,$user_id){ 
        $data=array(
            "acc_balance" =>$amount
        );
        $this->db->where('user_id', $user_id);
         $this->db->update('user', $data); 
    }
	
	
	
  public function getDispute($limit = '20', $start = '0'){ 
        $this->db->select('*');
        $this->db->order_by("id","desc");
        $this->db->limit($limit,$start);      
        $res=$this->db->get_where("dispute",array('status' =>'N'));
        $data=array();
        
        foreach($res->result() as $row){ 
		
            $data[]=array( 
					"id" => $row->id,
					"milestone_id" => $row->milestone_id,
					"employer_id" => $row->employer_id,
					"worker_id" => $row->worker_id,
					"disput_amt" => $row->disput_amt,
					"add_date" => $row->add_date,
					"admin_involve" => $row->admin_involve
            );
        }
		//print_r($data);
		//die;
        return $data;
    }
	
	
	public function getWithdrawlReq($limit,$start){
		$this->db->select('*');
        $this->db->order_by("withdrawl_id","desc");
        $this->db->limit($limit,$start); 
		$res=$this->db->get("withdrawl");
		$data=array();
        
        foreach($res->result() as $row){ 
            $data[]=array( 
			"withdrawl_id" => $row->withdrawl_id,
			"user_details" => $this->getGetUserDetails($row->user_id),
			"account_details"  => $this->getGetAccountDetails($row->account_id),
			"transer_through" =>$row->transer_through,
			"total_amount" =>$row->total_amount,
			"admin_pay" =>$row->admin_pay,
			"admin_id" =>$row->admin_id,
			"status" =>$row->status,
			"transction_date"=> $row->withdrawn_date,
			"corelation_id" => $this->auto_model->getFeild("paypal_transaction_id","transaction","","",array("id"=>$row->transaction_id))
			);
        }
	
		return $data;
	}
	
	public function getPaidTransaction($limit,$start,$srch=array(),$for_list=TRUE){
		$this->db->select('withdrawl.*');
		$this->db->from('withdrawl');
		$this->db->join('user', 'user.user_id=withdrawl.user_id', 'LEFT');
		$this->db->where('withdrawl.status', 'Y');
		
		if(!empty($srch['from_txt'])){
			$from_dt = date('Y-m-d', strtotime($srch['from_txt']));
			$this->db->where("DATE(serv_withdrawl.withdrawn_date) >= DATE('{$from_dt}')");
		}
		
		if(!empty($srch['to_txt'])){
			$to_dt = date('Y-m-d', strtotime($srch['to_txt']));
			$this->db->where("DATE(serv_withdrawl.withdrawn_date) <= DATE('{$to_dt}')");
		}
		
		if(!empty($srch['uname'])){
			$this->db->where("(CONCAT(serv_user.fname,' ',serv_user.lname) LIKE '%{$srch['uname']}%') OR ( serv_user.username LIKE '%{$srch['uname']}%') OR (serv_user.email LIKE '%{$srch['uname']}%')");
		}
		
		if(!empty($srch['uemail'])){
			$this->db->where('user.email', $srch['uemail']);
		}
		
       if($for_list){
		    $this->db->order_by("withdrawl.withdrawl_id","desc");
			$this->db->limit($limit,$start); 
			$res=$this->db->get();
			
			$data=array();
			
			foreach($res->result() as $row){ 
				$data[]=array( 
				"withdrawl_id" => $row->withdrawl_id,
				"user_details" => $this->getGetUserDetails($row->user_id),
				"account_details"  => $this->getGetAccountDetails($row->account_id),
				"transer_through" =>$row->transer_through,
				"total_amount" =>$row->total_amount,
				"admin_pay" =>$row->admin_pay,
				"admin_id" =>$row->admin_id,
				"status" =>$row->status,
				"transction_date"=> $row->withdrawn_date,
				"corelation_id" => $this->auto_model->getFeild("paypal_transaction_id","transaction","","",array("id"=>$row->transaction_id))
				);
			}
		
			return $data;
		}else{
			$res=$this->db->get();
			return $res->num_rows();
		}
	}
	
	
	
	public function getGetUserDetails($uid){
	
		$this->db->select('fname,lname,acc_balance,country,email');
		$res=$this->db->get_where("user",array("user_id"=>$uid));
		$data=array();
		
		foreach($res->result() as $row){ 
            $data=array( 
			"name" => $row->fname.' '.$row->lname,
			"acc_balance" => $row->acc_balance,
			"country"  => $row->country,
			"email" => $row->email
			);
		}
	
		return $data;
		
	
	}
	
	
	
	public function updateWithdrawl($wid){
		$data = array(
			'status' => 'Y'
			);
		$this->db->where('withdrawl_id', $wid);
		return $this->db->update('withdrawl' ,$data);
	
	}
	
	
	
	public function getGetAccountDetails($acc_id){
	
		$this->db->select('*');
        $res=$this->db->get_where("user_bank_account",array("account_id"=>$acc_id));
		$data=array();
		
		 foreach($res->result() as $row){ 
            $data=array( 
			"account_for" => $row->account_for,
			"paypal_account" => $row->paypal_account,
			"skrill_account" => $row->skrill_account,
			"wire_account_no" => $row->wire_account_no,
			"wire_account_name" => $row->wire_account_name,
			"wire_account_IFCI_code" => $row->wire_account_IFCI_code,
			"city" => $row->city,
			"country" => $row->country,
			"address" => $row->address
			);
		}
	
		return $data;
		
	}
	
	
	
	
	
	
	
   public function getEscrowCount(){ 
   	$a='Y';
       $this->db->where('fund_release','A');
	   $this->db->where(array("release_payment !="=>$a));
        $this->db->from('project_milestone');
		return $this->db->count_all_results(); 
		//echo $this->db->last_query();die;
    }   
	
	public function getDisputeCount(){ 
       $this->db->where("status","N");
	    //$this->db->where("admin_involve","Y");
        $this->db->from('dispute');
        return $this->db->count_all_results(); 
    } 
    
	
	  public function joinEscrow(){ 
			$this->db->select('*');  
			$this->db->from('escrowmilestone_payment');  
			$this->db->join('bids', 'bids.id = escrow.bid_id');  
			$this->db->join('projects', 'projects.project_id = bids.project_id');  
			$query = $this->db->get();
			//echo $this->db->last_query();die;			
	  }
	  
	 
	    public function searchTransaction($from='',$to=''){ 
		
		$from = $this->input->post('from_txt');
        $to = $this->input->post('to_txt');
		
		$this->db->select('*');  
		$this->db->from('transaction');
		$this->db->where('transction_date >= ',$from);
		$this->db->where('transction_date <= ',$to);
		
		
		
        $res=$this->db->get();
	        $data=array();
       foreach($res->result() as $row){ 
            $data[]=array(
               "paypal_transaction_id" =>$row->paypal_transaction_id,
               "amount" =>  $row->amount,
			   "user_id" => $row->user_id,
               "transction_type" => $row->transction_type,
               "transaction_for" => $row->transaction_for,
               "transction_date"  => $row->transction_date,
               "status" => $row->status
            );
        }
		
		
        return $data;
    }     
        
   
    	  public function getProfit(){ 
		  
		  		$data=array();
		  		for($i=0;$i<6;$i++)
				{
					$from_date=date("Y-m", strtotime("-$i months"));
					$this->db->select_sum('profit');
					$this->db->like('transction_date', $from_date);	
					$res=$this->db->get("transaction");
					foreach($res->result() as $row){ 
					$data[]=array(
					   "profit" => $row->profit,
					   "transction_date"  => $from_date
					   );
					}

				}
				//print_r($data);die();
				return $data;
   		 }
	  
    
		/*public function getProfitCount(){
			$this->db->select_sum('profit');
			$query = $this->db->get('transaction');
			return $query->result();
		}
*/
		
		
	 public function getProfitCount(){ 
      
        $this->db->from('transaction');
        return $this->db->count_all_results(); 
    }    
	
	
	
	 	  public function getProfitDetails($from_date){ 
		  			
				$from_date = date('Y-m');	
			    $this->db->select('*');
				
				$this->db->like('transction_date', $from_date);
			
				$this->db->order_by("transction_date","desc");
			    
				$res=$this->db->get("transaction");
				
				$data=array();
				
				foreach($res->result() as $row){ 
					$data[]=array( 
						"id" => $row->id,
						"paypal_transaction_id" => $row->paypal_transaction_id,
						"user_id" => $row->user_id,
						"profit" => $row->profit,
						"transaction_for" => $row->transaction_for,
						"transction_date" => $row->transction_date
									
					   
					);
				}
				//print_r($data);die();
				return $data;
   		 }
	  
                 
        public function getWithdrawReqCount(){ 
            $this->db->select("withdrawl_id");
            //$this->db->where("transer_through","P");
            //$this->db->where("status","N");
            $res =  $this->db->get("withdrawl");        
            $count = $res->num_rows();
            return $count;
            
        }

        public function getuserWithdrawDetails($wid){
            $this->db->select("user_id,account_id,admin_pay");
            $res=$this->db->get_where("withdrawl",array("withdrawl_id"=> $wid,"status"=>"N","transer_through"=>"P"));
            $data=array();
            if($res->num_rows()>0){ 
                foreach($res->result() as $row){ 
                    $data[]=array(
                       "user_id" => $row->user_id,
                        "account_id" => $row->account_id,
                       "admin_pay" =>  $row->user_id  
                    );

                }                
            }

           return $data; 
            
        }
        
        public function getuserBankDetails($uid,$accid){
            $this->db->select("paypal_account,skrill_account");
            $res=$this->db->get_where("user_bank_account",array("account_id"=> $accid,"status"=>"Y","user_id"=>$uid));
            $data=array();
            foreach($res->result() as $row){ 
                $data[]=array(
                   "paypal_account" => $row->paypal_account,
                   "skrill_account" => $row->skrill_account
                );
                
            }
           return $data; 
            
        }        
        
        
        public function paypal_settings(){ 
            $this->db->select("paypal_mail,paypal_api_uid,paypal_api_pass,paypal_api_sig,sandbox_api_uid,sandbox_api_pass,sandbox_api_sig,paypal_mode,deposite_by_creaditcard_fees,deposite_by_paypal_commission,deposite_by_paypal_fees");         
            $res=$this->db->get("setting");
            
            $data=array();
            
            foreach($res->result() as $row){ 
                $data=array(
                    "paypal_mail" => $row->paypal_mail,
                    "paypal_api_uid"=> $row->paypal_api_uid,
                    "paypal_api_pass"=> $row->paypal_api_pass,
                    "paypal_api_sig"=> $row->paypal_api_sig,
                    "sandbox_api_uid"=> $row->sandbox_api_uid,
                    "sandbox_api_pass"=> $row->sandbox_api_pass,
                    "sandbox_api_sig"=> $row->sandbox_api_sig,
                    "paypal_mode"=> $row->paypal_mode,
                    "deposite_by_creaditcard_fees"=> $row->deposite_by_creaditcard_fees,
                    "deposite_by_paypal_commission"=> $row->deposite_by_paypal_commission,
                    "deposite_by_paypal_fees"=> $row->deposite_by_paypal_fees                                        
                );
            }
            
            return $data;
            
        }
		public function skrill_settings(){ 
            $this->db->select("skrill_mail,skrill_pass,deposite_by_skrill_fees");         
            $res=$this->db->get("setting");
            
            $data=array();
            
            foreach($res->result() as $row){ 
                $data=array(
                    "skrill_mail" => $row->skrill_mail,
                    "skrill_pass"=> $row->skrill_pass,
                    "deposite_by_skrill_fees"=> $row->deposite_by_skrill_fees                                        
                );
            }
            
            return $data;
            
        }

        public function updateTransaction($data,$tid){
           $this->db->where('id', $tid);
           $this->db->update('transaction', $data);              
        }

        public function updateWithdraw($data,$wid){
           $this->db->where('withdrawl_id', $wid);
           $this->db->update('withdrawl', $data);              
        }        
        

        /*	public function getProfitDetails($date){
	
		//$date = $this->input->get('2017-07');
		$date = date('Y-m-d');
		$exp = explode('-',$date);
	 	$year = $exp['0'];
		$month = $exp['1'];
	
		$this->db->select('*');
		$t_date = $this->db->like($year,$month);
        $res=$this->db->get_where("transaction",array("transction_date"=>$t_date));
		echo $this->db->last_query();
		die;
		$data=array();
		
		 foreach($res->result() as $row){ 
            $data=array( // 	id	paypal_transaction_id	amount	profit	transction_type CR=Credit DR=Debit	transaction_for	transction_date	status
			"id" => $row->id,
			"paypal_transaction_id" => $row->paypal_transaction_id,
			"user_id" => $row->user_id,
			"profit" => $row->profit,
			"transaction_for" => $row->transaction_for,
			"transction_date" => $row->transction_date
			);
		}
	
		return $data;
		
	}*/
	
	
    


	public function getAllFund($limit = '', $start = ''){ 
        $this->db->select('*');
        $this->db->order_by("id","desc");
        $this->db->limit($limit,$start);      
        $res=$this->db->get("useraddfund");
        $data=array();
        
        foreach($res->result() as $row){ 
            $data[]=array(
               "trans_id" =>$row->trans_id,
               "id"  =>$row->id,
               "amount" =>  $row->amount,
	       "user_id" => $row->user_id,
               "payee_name" => $row->payee_name,
               "dep_bank" => $row->dep_bank,
               "dep_branch"  => $row->dep_branch,
	       "dep_date"  => $row->dep_date,
               "status" => $row->status
            );
        }
		//print_r($data);
		//die;
        return $data;
    }

    public function releaseFund($fid){ 
        
        $user_id=  $this->auto_model->getFeild("user_id","useraddfund","id",$fid);
        
        $fund_balance=$this->auto_model->getFeild("amount","useraddfund","id",$fid);
        
        $user_balance=$this->auto_model->getFeild("acc_balance","user","user_id",$user_id);
        
        $amount=$user_balance+$fund_balance;
        
        $data_userfind=array(
            "status" =>"Y"
        );
        
        $data_user=array( 
            "acc_balance"=>$amount
        );
        
        $data_transaction=array(
            "user_id"=> $user_id,
            "amount"=> $fund_balance,
            "transction_type"=>"CR",
            "transaction_for"=>"Add Cash Wire",
            "transction_date"=>date("Y-m-d"),
            "status"=>"Y"
        );
        
        $tid=$this->db->insert('transaction', $data_transaction); 
        
        if($tid>0){ 
            $this->db->where('user_id', $user_id);
            $this->db->update('user', $data_user); 
            
            $this->db->where('id', $fid);
            $this->db->update('useraddfund', $data_userfind);            
            return 1;
        }
        
    }
	public function deleteFund($fid)
	{
		$this->db->where('id',$fid);
		return $this->db->delete('useraddfund');	
	}
	
	public function disputeDetails($did){ 
        $this->db->select("*");
        $res=$this->db->get_where("dispute",array("id"=>$did));
        $data=array();
        
        foreach($res->result() as $row){ 
            $data=array(
                "id" => $row->id,
                "milestone_id" => $row->milestone_id,
                "disput_amt" => $row->disput_amt, 
                "employer_id" => $row->employer_id,
                "worker_id" => $row->worker_id,
                "add_date" => $row->add_date,
                "status" => $row->status,
				"admin_involve" => $row->admin_involve
            );
        }
        return $data;
    }
	
	 public function disputeConversation($did){ 
        $this->db->select("*");
		$this->db->order_by('id','asc');
        $res=$this->db->get_where("dispute_conversation",array("dispute_id"=>$did));
        $data=array();
        
        foreach($res->result() as $row){ 
            $data[]=array(
                "id" => $row->id,
                "user_id" => $row->user_id,
                "message" => $row->message, 
                "attachment" => $row->attachment,
                "add_date" => $row->add_date
            );
        }
        return $data;
    }
	
	public function disputeDiscuss($did){ 
        $this->db->select("*");
        $res=  $this->db->get_where("dispute_discussion",array("disput_id" => $did));        
       
        
        
        $data=array();
        if(count($res->result())>0){ 
          foreach($res->result() as $row){ 
            $data[]=array(
                "employer_id" => $row->employer_id,
                "worker_id" => $row->worker_id,
                "employer_amt" => $row->employer_amt,
                "worker_amt" => $row->worker_amt,
                "accept_opt" => $row->accept_opt,
                "status" => $row->status
            );
          }          
        }
        else{ 
            $data[]=array(
                "employer_id" => "",
                "worker_id" => "",
                "employer_amt" => "0.0",
                "worker_amt" => "0.0",
                "accept_opt" => "0.0",
                "status" => ""
            );            
        }

        return $data;
        
    }
	public function insertMessage($data){ 
        return $this->db->insert("dispute_conversation",$data);
    }
    public function updateDiscussion($data,$id)
	{
		$this->db->where('disput_id',$id);
		return $this->db->update('dispute_discussion',$data);	
	}
	public function updateDispute($data,$id)
	{
		$this->db->where('id',$id);
		return $this->db->update('dispute',$data);	
	}
	public function update_user($data,$id)
	{
		$this->db->where('user_id',$id);
		return $this->db->update('user',$data);	
	}
	/*public function insertTransaction($data)
	{
		return $this->db->insert('transaction',$data);	
	}*/
	public function updateWithdrawl_new($data,$id)
	{
		$this->db->where('withdrawl_id',$id);
		return $this->db->update('withdrawl',$data);
	}
	public function updateMilestone($data,$id)
	{
		$this->db->where('id',$id);
		return $this->db->update('milestone_payment',$data);
	}    
    public function getEscrow($limit = '20', $start = '0')
	{
		$this->db->select('*');
        $this->db->order_by("id","desc");
        $this->db->limit($limit,$start);      
        $res=$this->db->get_where("project_milestone",array('fund_release' =>'A','release_payment !=' => 'Y'));
		
		$data=array();
        
        foreach($res->result() as $row){ 
		
            $data[]=array( 
					"id" => $row->id,
					"project_id" => $row->project_id,
					"employer_id" => $row->employer_id,
					"bidder_id" => $row->bidder_id,
					"amount" => $row->amount,
					"mpdate" => $row->mpdate,
					"release_payment" => $row->release_payment
            );
		}
		return $data;
	}


	public function getWithdrawlRequestNew($srch=array(), $limit=0, $offset=30, $for_list=TRUE){
		
		$this->db->select('tr.*,SUM(tr.debit) as withdraw_amount,(SUM(tr.debit) - SUM(tr.credit)) as net_pay,tn.status')
				->from('transaction_row tr')
				->join('transaction_new tn', 'tn.txn_id=tr.txn_id', 'LEFT');
		
		$this->db->where('tn.txn_type', WITHDRAW_WALLET_FUND);
		
		if(!empty($srch['from'])){
			$from_dt = date('Y-m-d', strtotime($srch['from']));
			$this->db->where("DATE(tn.datetime) >= DATE('{$from_dt}')");
		}
		if(!empty($srch['to'])){
			$to_dt = date('Y-m-d', strtotime($srch['to']));
			$this->db->where("DATE(tn.datetime) <= DATE('{$to_dt}')");
		}
		
		
		$this->db->group_by('tr.txn_id');
		
		if($for_list){
			$result = $this->db->limit($offset, $limit)->order_by('tr.txn_row_id', 'DESC')->get()->result_array();
			
			if($result){
				foreach($result as $k => $v){
					$user_id = getField('user_id', 'wallet', 'wallet_id', $v['wallet_id']);
					
					$account_id = getField('account_id', 'user_bank_account', 'user_id', $user_id);
					
					$result[$k]['user_details'] =  $this->getGetUserDetails($user_id);
				}
			}
		}else{
			$result = $this->db->get()->num_rows();
		}
		
		return $result;
		
		
	}
	
	/* --------------------- Wallet Functions  ------------------------------*/
	
	public function getWallet($srch=array(), $limit=0, $offset=30, $for_list=TRUE){
		
		$this->db->select("w.*,CONCAT(u.fname,' ',u.lname) as full_name", FALSE)
				->from('wallet w')
				->join('user u', 'u.user_id=w.user_id', 'LEFT');
	
		
		if(!empty($srch['wallet_id'])){
			$this->db->where('w.wallet_id', $srch['wallet_id']);
		}
		
		if(!empty($srch['title'])){
			$this->db->like('w.title', $srch['title']);
		}
		
		if($for_list){
			$result = $this->db->limit($offset, $limit)->order_by('w.wallet_id', 'DESC')->get()->result_array();
			
		}else{
			$result = $this->db->get()->num_rows();
		}
		
		return $result;
		
		
	}
	
	public function getWalletTxn($srch=array(), $limit=0, $offset=30, $for_list=TRUE){
		$this->db->select('tr.*, tn.status')
				->from('transaction_row tr')
				->join('transaction_new tn', 'tn.txn_id=tr.txn_id', 'LEFT');
	
		$this->db->where('tr.wallet_id', $srch['wallet_id']);
		
		if(!empty($srch['from'])){
			$from_dt = date('Y-m-d', strtotime($srch['from']));
			$this->db->where("DATE(tr.datetime) >= DATE('{$from_dt}')");
		}
		if(!empty($srch['to'])){
			$to_dt = date('Y-m-d', strtotime($srch['to']));
			$this->db->where("DATE(tr.datetime) <= DATE('{$to_dt}')");
		}
		
		if($for_list){
			$result = $this->db->limit($offset, $limit)->order_by('tr.txn_row_id', 'DESC')->get()->result_array();
			
		}else{
			$result = $this->db->get()->num_rows();
		}
		
		return $result;
	}
	
	public function wallet_debit_balance($wallet_id=''){
		$res = $this->db->select("sum(tr.debit) as debit")
				->from('transaction_row tr')
				->join('transaction_new t', 't.txn_id=tr.txn_id', 'LEFT')
				->where('tr.wallet_id', $wallet_id)
				->where('t.status', 'Y')
				->get()
				->row_array();
		
		return $res['debit'];
	}
	
	public function wallet_credit_balance($wallet_id=''){
		$res = $this->db->select("sum(tr.credit) as credit")
				->from('transaction_row tr')
				->join('transaction_new t', 't.txn_id=tr.txn_id', 'LEFT')
				->where('tr.wallet_id', $wallet_id)
				->where('t.status', 'Y')
				->get()
				->row_array();
		
		return $res['credit'];
	}

	/* --------------------- Wallet Functions  ------------------------------*/
	
	public function getTxnHistoryNew($srch=array(), $limit=0, $offset=30, $for_list=TRUE){
		
		$this->db->select("tn.*,c.key,c.description")
				->from('transaction_new tn')
				->join('finance_constants c', 'c.value=tn.txn_type', 'LEFT');
	
		
		if(!empty($srch['txn_id'])){
			$this->db->where('tn.txn_id', $srch['txn_id']);
		}
		
		if(!empty($srch['from'])){
			$from_dt = date('Y-m-d', strtotime($srch['from']));
			$this->db->where("DATE(tn.datetime) >= DATE('{$from_dt}')");
		}
		if(!empty($srch['to'])){
			$to_dt = date('Y-m-d', strtotime($srch['to']));
			$this->db->where("DATE(tn.datetime) <= DATE('{$to_dt}')");
		}
		
		
		
		if($for_list){
			$result = $this->db->limit($offset, $limit)->order_by('tn.txn_id', 'DESC')->get()->result_array();
			if($result){
				foreach($result as $k => $v){
					$txn_row = $this->db->select("sum(debit) as total_debit , sum(credit) as total_credit")->where("txn_id", $v['txn_id'])->get('transaction_row')->row_array();
					
					$result[$k]['total_debit'] = $txn_row['total_debit'];
					$result[$k]['total_credit'] = $txn_row['total_credit'];
					$result[$k]['net_amount'] = ($txn_row['total_credit'] - $txn_row['total_debit']);
					
				}
			}
			
		}else{
			$result = $this->db->get()->num_rows();
		}
		
		return $result;
		
		
	}
	
	public function getProjectTxnHistoryNew($srch=array(), $limit=0, $offset=30, $for_list=TRUE){
		
		$this->db->select("p.title,tn.*,c.key,c.description")
				->from('project_transaction p_txn')
				->join('transaction_new tn', 'tn.txn_id=p_txn.txn_id', 'LEFT')
				->join('projects p', 'p.project_id=p_txn.project_id', 'LEFT')
				->join('finance_constants c', 'c.value=tn.txn_type', 'LEFT');
	
		
		if(!empty($srch['project'])){
			$this->db->like('p.project_id', $srch['project']);
			$this->db->or_like('p.title', $srch['project']);
		}
		
		if(!empty($srch['txn_id'])){
			$this->db->where('p_txn.txn_id', $srch['txn_id']);
		}
		
		if(!empty($srch['project_id'])){
			$this->db->where('p_txn.project_id', $srch['project_id']);
		}
		
		if(!empty($srch['key'])){
			$this->db->like('c.key', $srch['key']);
		}
		
		
		if($for_list){
			$result = $this->db->limit($offset, $limit)->order_by('tn.txn_id', 'DESC')->get()->result_array();
			//echo $this->db->last_query();
			if($result){
				foreach($result as $k => $v){
					$txn_row = $this->db->select("sum(debit) as total_debit , sum(credit) as total_credit")->where("txn_id", $v['txn_id'])->get('transaction_row')->row_array();
					
					$result[$k]['total_debit'] = $txn_row['total_debit'];
					$result[$k]['total_credit'] = $txn_row['total_credit'];
					$result[$k]['net_amount'] = ($txn_row['total_credit'] - $txn_row['total_debit']);
					
				}
			}
			
		}else{
			$result = $this->db->get()->num_rows();
		}
		
		return $result;
		
		
	}
	
	public function getProjectAllTxn($srch=array(), $limit=0, $offset=30, $for_list=TRUE){
		$this->db->select("p_txn.project_id,tr.*,tn.status")
				->from('project_transaction p_txn')
				->join('transaction_new tn', 'p_txn.txn_id=tn.txn_id', 'LEFT')
				->join('transaction_row tr', 'tn.txn_id=tr.txn_id', 'LEFT');
				
		
		$this->db->where('p_txn.project_id', $srch['project_id']);
		
		if(!empty($srch['from'])){
			$from_dt = date('Y-m-d', strtotime($srch['from']));
			$this->db->where("DATE(tr.datetime) >= DATE('{$from_dt}')");
		}
		if(!empty($srch['to'])){
			$to_dt = date('Y-m-d', strtotime($srch['to']));
			$this->db->where("DATE(tr.datetime) <= DATE('{$to_dt}')");
		}
		
		if($for_list){
			$result = $this->db->limit($offset, $limit)->order_by('tr.txn_row_id', 'DESC')->get()->result_array();
			
		}else{
			$result = $this->db->get()->num_rows();
		}
		
		return $result;
	}
	
	public function getDisputes($srch=array(), $limit=0, $offset=30, $for_list=TRUE){
		$this->db->select("e.*,p.title as project_title,pm.title,pm.description,pm.send_to_admin")
				->from('escrow_new e')
				->join('projects p', 'e.project_id=p.project_id', 'LEFT')
				->join('project_milestone pm', 'e.milestone_id=pm.id', 'LEFT')
				->where(array('e.status' => 'D'));
		
		if($for_list){
			$result = $this->db->limit($offset, $limit)->order_by('e.escrow_id', 'DESC')->get()->result_array();
			
		}else{
			$result = $this->db->get()->num_rows();
		}
		
		return $result;
	}
	
	public function getDisputeMessages($srch=array(), $limit=0, $offset=30, $for_list=TRUE){
		$this->db->select("dm.*,concat(u.fname,' ',u.lname) as sender_name", FALSE)
				->from('dispute_messages dm')
				->join('user u', 'dm.sender_id=u.user_id', 'INNER');
				
		$this->db->where('dm.project_id', $srch['project_id']);
		$this->db->where('dm.milestone_id', $srch['milestone_id']);
		if($for_list){
			$result = $this->db->limit($offset, $limit)->order_by('dm.message_id', 'DESC')->get()->result_array();
			
		}else{
			$result = $this->db->get()->num_rows();
		}
		
		return $result;
	}
	
	public function getDisputeHistory($project_id='',  $milestone_id=''){
		
		$this->db->select("dh.*,concat(u.fname,' ',u.lname) as employer_name, concat(wu.fname,' ',wu.lname) as worker_name", FALSE)
				->from('dispute_history dh')
				->join('user u', 'dh.employer_id=u.user_id', 'LEFT')
				->join('user wu', 'dh.worker_id=wu.user_id', 'LEFT');
				
		$this->db->where('dh.project_id', $project_id);
		$this->db->where('dh.milestone_id', $milestone_id);
		$result = $this->db->order_by('dh.id', 'DESC')->get()->result_array();
		
		return $result;
	}
	
	public function getEscrowList($srch=array(), $limit=0, $offset=30, $for_list=TRUE){
		$this->db->select("e.*,p.title as project_title,pm.title,pm.description")
				->from('escrow_new e')
				->join('projects p', 'e.project_id=p.project_id', 'LEFT')
				->join('project_milestone pm', 'e.milestone_id=pm.id', 'LEFT');
		
		if(!empty($srch['project_id'])){
			$this->db->where('e.project_id', $srch['project_id']);
		}
		if(!empty($srch['status'])){
			$this->db->where('e.status', $srch['status']);
		}
		if($for_list){
			$result = $this->db->limit($offset, $limit)->order_by('e.escrow_id', 'DESC')->get()->result_array();
			
		}else{
			$result = $this->db->get()->num_rows();
		}
		
		return $result;
	}
	
	public function getEscrowProject($srch=array(), $limit=0, $offset=40, $for_list=TRUE){
		$projects = $this->db->dbprefix('projects');
		$this->db->select("p_txn.project_id, p.title,p.project_type, SUM( txn_row.debit) AS total_debit, SUM( txn_row.credit) AS total_credit, (SUM( txn_row.credit) - SUM( txn_row.debit)) as pending_balance, txn_row.wallet_id", false)
			->from('project_transaction p_txn') 
			->join('transaction_new txn', 'txn.txn_id=p_txn.txn_id')
			->join('transaction_row txn_row', 'txn_row.txn_id=p_txn.txn_id')
			->join('projects p', 'p.project_id=p_txn.project_id', 'LEFT')
			->where('txn.status', 'Y');
			
			$this->db->where('txn.status', 'Y');
			if(!empty($srch['project_id'])){
				$this->db->where('p_txn.project_id', $srch['project_id']);
			}
			
			if(!empty($srch['status']) && $srch['status'] == 'pending'){
				$this->db->having('pending_balance >', '0');
			}
			
			//$this->db->where("p_txn.project_id in(select project_id from $projects where user_id=$user_id)");
			$this->db->where('txn_row.wallet_id', ESCROW_WALLET);
			$this->db->group_by('p_txn.project_id');
			$this->db->order_by('p.project_id', 'DESC');
			
		if($for_list){
			$result = $this->db->limit($offset, $limit)->order_by('p_txn.project_txn_id', 'DESC')->get()->result_array();
		}else{
			$result = $this->db->get()->num_rows();
		}
		
		return $result;
		
	}
	
	public function getEscrowPendingBalance(){
		$pending_bal = 0;
		$this->db->select("p_txn.project_id, p.title,p.project_type, SUM( txn_row.debit) AS total_debit, SUM( txn_row.credit) AS total_credit, (SUM( txn_row.credit) - SUM( txn_row.debit)) as pending_balance, txn_row.wallet_id", false)
			->from('project_transaction p_txn') 
			->join('transaction_new txn', 'txn.txn_id=p_txn.txn_id')
			->join('transaction_row txn_row', 'txn_row.txn_id=p_txn.txn_id')
			->join('projects p', 'p.project_id=p_txn.project_id', 'LEFT')
			->where('txn.status', 'Y');
			
		$this->db->where('txn.status', 'Y');
		if(!empty($srch['project_id'])){
			$this->db->where('p_txn.project_id', $srch['project_id']);
		}
		
		if(!empty($srch['status']) && $srch['status'] == 'pending'){
			$this->db->having('pending_balance >', '0');
		}
		
		
		$this->db->where('txn_row.wallet_id', ESCROW_WALLET);
			
		$result = $this->db->get()->row_array();
		
		if($result['pending_balance'] > 0){
			$pending_bal = $result['pending_balance'];
		}
		return $pending_bal; 
	}
	
	public function getProjectEscrowTxn($srch=array(), $limit=0, $offset=40, $for_list=TRUE){
		$this->db->select("p_txn.project_id,tr.*,tn.status")
				->from('project_transaction p_txn')
				->join('transaction_new tn', 'p_txn.txn_id=tn.txn_id', 'LEFT')
				->join('transaction_row tr', 'tn.txn_id=tr.txn_id', 'LEFT');
				
		
		$this->db->where('p_txn.project_id', $srch['project_id']);
		$this->db->where('tn.status', 'Y');
		
		if(!empty($srch['from'])){
			$from_dt = date('Y-m-d', strtotime($srch['from']));
			$this->db->where("DATE(tr.datetime) >= DATE('{$from_dt}')");
		}
		if(!empty($srch['to'])){
			$to_dt = date('Y-m-d', strtotime($srch['to']));
			$this->db->where("DATE(tr.datetime) <= DATE('{$to_dt}')");
		}
		$this->db->where('tr.wallet_id', ESCROW_WALLET);
		if($for_list){
			$result = $this->db->limit($offset, $limit)->order_by('tr.txn_row_id', 'DESC')->get()->result_array();
			
		}else{
			$result = $this->db->get()->num_rows();
		}
		
		return $result;
	}
	
	
}
