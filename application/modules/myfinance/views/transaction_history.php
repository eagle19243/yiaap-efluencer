<?php echo $breadcrumb;?>
<script src="<?=JS?>mycustom.js"></script>

<section id="mainpage">  
<div class="container-fluid">
<div class="row">
<div class="col-md-2 col-sm-3 col-xs-12">
<?php $this->load->view('dashboard/dashboard-left'); ?>
</div> 
<div class="col-md-10 col-sm-9 col-xs-12">
<div class="spacer-20"></div>
        <ul class="tab">
          <li><a  href="<?php echo VPATH;?>myfinance/" ><?php echo __('myfinance_add_fund','Add Fund'); ?></a></li>
          <li class="hidden"><a  href="<?php echo VPATH;?>myfinance/milestone" ><?php echo __('myfinance_milestone','Milestone'); ?></a></li>
          <li><a href="<?php echo VPATH;?>myfinance/withdraw" ><?php echo __('myfinance_withdraw_fund','Withdraw Fund'); ?></a></li>
          <li><a class="selected" href="<?php echo VPATH;?>myfinance/transaction" ><?php echo __('myfinance_transaction_history','Transaction History'); ?></a></li>
          <li class="hide"><a href="<?php echo VPATH;?>membership/" ><?php echo __('myfinance_membership','Membership'); ?></a></li>
        </ul>
        <div class="balance">
        	<span><img src="<?php echo ASSETS;?>images/balance2_icon.png"> <?php echo __('myfinance_balance','Balance'); ?>: </span><?php echo CURRENCY;?> <?php echo $balance;?>
        </div>
        <!--EditProfile Start-->
        <div class="editprofile">
          <div class="row">
          <aside class="col-md-9 col-xs-12">
            <h4><?php echo __('myfinance_select_date_for_which_transaction_history_want','Select date for which you want your transaction history'); ?></h4>
          </aside>
          <aside class="col-md-3 col-xs-12">
            <a href="<?php echo VPATH;?>myfinance/generateCSV_new/" class="btn btn-sm btn-site pull-right" style="margin-bottom:10px"><?php echo __('myfinance_download_statement','Download Statement'); ?></a>
		  </aside>
          </div>
          <div class="transbox">
            <form class="form-horizontal">
              <div class="form-group" style="margin-top:15px">              
                <div class="col-sm-5 col-xs-12">
                  <label><?php echo __('myfinance_from','From'); ?>:</label>  
                  <div class='input-group datepicker'>
                    <input type='text' class="form-control" id="datepicker_from" name="from" size="15" value="<?php echo !empty($srch['from']) ? $srch['from'] : '';?>" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                  </div>                           
                </div>
				<div class="col-sm-5 col-xs-12">
                   <label><?php echo __('myfinance_to','To'); ?>:</label>  
                   <div class='input-group datepicker'>
                    <input type='text' class="form-control" id="datepicker_to" name="to" size="15"  value="<?php echo !empty($srch['to']) ? $srch['to'] : '';?>" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                  </div>              
                </div>
                <div class="col-sm-2 col-xs-12">
                	<label>&nbsp;</label>
                	<input type="submit" name="submit" class="btn btn-site btn-sm btn-block" value="<?php echo __('myfinance_go','Go'); ?>">
              	</div>
              </div>
            </form>
          </div>
          <div class="transbox">
            <h5><?php echo __('myfinance_statement_period','Statement Period'); ?>:</h5>
            <p><span><?php echo __('myfinance_all_transaction','All transactions'); ?></span></p>
          </div>
          <div class="transbox">
            <h5><?php echo __('myfinance_beginning_balance','Beginning Balance');; ?>:</h5>
            <p><span><?php echo CURRENCY;?> 0.00 </span></p>
          </div>
          <div class="transbox">
            <h5><?php echo __('myfinance_total_debits','Total Debits'); ?>:</h5>
            <p>
			<span class="hidden"><?php echo CURRENCY;?>
              <?php if($tot_debit[0]->amount!='') {echo $tot_debit[0]->amount;} else {echo '0.00';}?>
              </span>
			  
			  <span>
				<?php echo !empty($debit_total) ? CURRENCY.' '.$debit_total : CURRENCY. ' 0.00'; ?>
              </span>
			  
			  </p>
          </div>
          <div class="transbox">
            <h5><?php echo __('myfinance_total_cradits','Total Credits'); ?>:</h5>
            <p>
			<span class="hidden"><?php echo CURRENCY;?>
              <?php if($tot_credit[0]->amount!='') {echo $tot_credit[0]->amount;} else {echo '0.00';}?>
              </span>
			  
			  <span>
              <?php echo !empty($credit_total) ? CURRENCY.' '.$credit_total : CURRENCY. ' 0.00'; ?>
              </span>
			  
			  </p>
          </div>
          <div class="transbox">
            <h5><?php echo __('myfinance_ending_balance','Ending Balance'); ?>:</h5>
            <p><span><?php echo CURRENCY;?> <?php echo $credit_total - $debit_total;?></span></p>
          </div>
        </div>
        <!--EditProfile End-->
        
        <div class="spacer-20"></div>
		<div class="clearfix"></div>
	<!-- new transaction history (Bishu) -->
	<h4><?php echo __('myfinance_transaction_details','Transaction Details'); ?></h4>
        <div class="table-responsive">
			<table class="table">
					<thead>
					  <tr>
						<th style="width:115px"><?php echo strtoupper(__('myfinance_date','DATE')); ?></strong></th>
						<th style="min-width: 65px"><?php echo strtoupper(__('myfinance_txn_id','TXN ID')); ?></strong></th>
						<th><?php echo __('myfinance_info','Info'); ?></strong></th>
						<th><?php echo __('myfinance_cradit_cr','Credit (Cr)'); ?></strong></th>
						<th><?php echo __('myfinance_debit_dr','Debit (Dr)'); ?></strong></th>
						<th><?php echo __('myfinance_status','Status'); ?></strong></th>
						<th><?php echo __('myfinance_invoice','Invoice'); ?></strong></th>
					  </tr>
					</thead>
					<tbody>
						<?php if(count($all_data) > 0){foreach($all_data as $k => $v){ ?>
						<tr>
							<td><?php echo !empty($v['datetime']) ? date('d M, Y h:i A', strtotime($v['datetime'])) : '' ;?></td>
							<td><?php echo !empty($v['txn_id']) ? $v['txn_id'] : '' ;?></td>
							<td> <?php echo !empty($v['info']) ? $this->auto_model->parseTransaction($v['info']) : '' ;?></td>
							<td> <?php echo !empty($v['credit']) ? CURRENCY.' '.$v['credit'] : CURRENCY. ' 0.00' ;?></td>
							<td><?php echo !empty($v['debit']) ? CURRENCY. ' '.$v['debit'] : CURRENCY. ' 0.00' ;?></td>
							<td>
							<?php
								$status = '';
								switch($v['status']){
									case 'Y' : 
										$status = '<font color="green">'.__('myfinance_success','Success').'</font>';
									break;
									case 'P' : 
										$status = '<font color="blue">'.__('myfinance_pending','Pending').'</font>';
									break;
									case 'N' : 
										$status = '<font color="red">'.__('myfinance_rejected','Rejected').'</font>';
									break;
								}
								echo $status;
								?>
							</td>
							<td>
								<?php if($v['invoice_id'] > 0){ ?>
								<a href="<?php echo base_url('invoice/detail/'.$v['invoice_id']); ?>" target="_blank">Invoice</a>
								<?php	} ?>
							</td>
						</tr>
						<?php } }else{  ?>
						<tr>
							<td colspan="10" align="center"><?php echo __('myfinance_no_transaction_found','No transacion found'); ?> </td>
						</tr>
						<?php } ?>
					</tbody>
			  
			
			
			</table>
  
		</div>
		<?php  echo $links2; ?>
 
        <?php 

if(isset($ad_page)){ 
$type=$this->auto_model->getFeild("type","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"M"));
if($type=='A') 
{
$code=$this->auto_model->getFeild("advertise_code","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"M")); 
}
else
{
$image=$this->auto_model->getFeild("banner_image","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"M"));
$url=$this->auto_model->getFeild("banner_url","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"M")); 
}

if($type=='A'&& $code!=""){ 
?>
        <div class="addbox">
          <?php 
echo $code;
?>
        </div>
        <?php                      
}
elseif($type=='B'&& $image!="")
{
?>
        <div class="addbox"> <a href="<?php echo $url;?>" target="_blank"><img src="<?=ASSETS?>ad_image/<?php echo $image;?>" alt="" title="" /></a> </div>
        <?php  
}
}

?>
      </div>
      <!-- Left Section End --> 
</div>
</div>
</section>

<script src="<?=JS?>jquery.min.js"></script>

  <script type="text/javascript">
   /* $(function () {
        $('#datepicker_to').datetimepicker();
        $('#datepicker_from').datetimepicker({
            useCurrent: false //Important! See issue #1075
			format: LT
        });
        $("#datepicker_to").on("dp.change", function (e) {
            $('#datepicker_from').data("DateTimePicker").minDate(e.date);
        });
        $("#datepicker_from").on("dp.change", function (e) {
            $('#datepicker_to').data("DateTimePicker").maxDate(e.date);
        });
    });*/
</script>