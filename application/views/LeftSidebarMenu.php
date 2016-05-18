<?php 
$SUID = $_SESSION['MM_SUserID'];
$SID=$_SESSION['MM_StudentID'];
$CID=$_SESSION['MM_ClientID'];
$CCID=$_SESSION['MM_ClientCode'];
$Role=$_SESSION['MM_Userrole'];
$LOC=$_SESSION['MM_Location'];
?>

<!-- start: sidebar -->
<aside id="sidebar-left" class="sidebar-left">
	<div class="sidebar-header">
		<div class="sidebar-title">
			Information
		</div>
		<div class="sidebar-toggle hidden-xs" 
		     data-toggle-class="sidebar-left-collapsed" 
		     data-target="html" data-fire-event="sidebar-left-toggle">
			<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
		</div>
	</div>

	<div class="nano">
		<div class="nano-content">
			<?php include('./display/Nav-Menu.php') ?>
         <hr class="separator" />   													

  			<!-- display student -->    
			<?php 
			if ($SUID!='')
			{ 
				$studentxyz = GetStudentInfo($SUID, $db); 
				foreach($studentxyz as $stu){
					$studentname=$stu['FirstName'] ." ". $stu['LastName'];
					$new_age = birthday($stu['Birthdate']);
					$cell= $stu['CellPhone'];
					$email=$stu['Email'];
					$insur= $stu['Insurance'];
					$status= $stu['UserStatus'];
				} ?>                							
				<div class="sidebar-widget">
					<div class="widget-header">
						<h6>Student Info</h6>
						<div class="widget-toggle">+</div>
					</div>

					<div class="widget-content">
						<ul class="list-unstyled m-none">
							<?PHP 
							if ($SID!='') { ?>
								<li>ID: <span><?php echo $_SESSION['MM_StudentID']; ?></span>
								</li> 
							<?php } ?>
							<li>Name: <span><?php echo $studentname; ?></span></li>
							<li>Age: <span><?php echo $new_age; ?></span></li>
							<li>Phone: <span><?php echo $cell; ?> </span></li>
							<li>Email: <span><?php echo $email; ?></span></li>
							<?php 
							if ($Userrole!='Student') { ?>
								<li>Insurance: <span><?php echo $insur; ?></span></li>
								<li>Status: <span><?php echo $status; ?></span></li>
							<?php } ?>
						</ul>
					</div>
				</div> 
			<?php 
			} ?>

<!-- display Clininican assessed risks  --> 
			<?php
			if ((($Userrole == 'Clinician') 
             || ($Userrole == 'ClinicianAdmin'))  && ($SID!=''))
			{ 
				//$SID='D001';
				$recent = GetRecentRAAPS ($SUID,$db);
				foreach ($recent as $last) {
					$lastAssmt=$last['actionID'];
				}
				$highrisks=GetHighRisks($SUID,$lastAssmt,$db);
			?>                           
            <hr class="separator" />                                                                                 				
				<div class="sidebar-widget">
					<div class="widget-header">
						<h6>Assessed High Risks</h6>
							<div class="widget-toggle">+</div>
					</div>
					<div class="widget-content">
               <?php
               if ($highrisks!='') {  ?>
						<ul class="list-unstyled m-none">
					<?php 
					  	foreach($highrisks as $risks) {?>
							<li><?PHP echo $risks['QCategory']; ?>
                     <br><span class="stats-title"><?PHP echo $risks['QRiskSum']; ?></span></p></li>
					<?php 
						}  ?>
						</ul>
					<?php 
					} else echo 'No Risks Assessed High';?>
					</div>
				</div>    
 			<?php
			}  ?>                                    
								

			<?php
			if ($SID!='') { 
				$goals = GetGoals ($SUID,$db);  ?>       
				<hr class="separator" />	    
				<!-- display goals if set -->                                      							
				<div class="sidebar-widget widget-stats">
					<div class="widget-header">
						<h6>Latest Goals <i class="fa fa-trophy" aria-hidden="true"></i>
						</h6>
						<div class="widget-toggle">+</div>
						</div>
							<div class="widget-content">
                  	   <?php  
                  	   if (isset ($goals))
                  	   { ?>
									<ul>
							  		<?php 
							   	foreach($goals as $gol) { 
							   	if (($gol['goalTargetDate'] =='1970-01-01') || 
                            	($gol['goalTargetDate'] ==NULL )){
                        		$goal_date = ' not set';
									} 
                        	else {
										$goal_date=date('m-d-Y', strtotime($gol['goalTargetDate']));
									}  
							  		if (empty ($gol['gAssignDate'])) {
										$create_date='not set';
									}
									else { 
										$create_date = date('m-d-Y', strtotime($gol['gAssignDate'])); 
									} 
									$goals = htmlspecialchars_decode($gol['goalStatus'],  ENT_QUOTES);
								   ?>
								<li>
									<span class="stats-title"><?PHP echo $gol['goal']; ?></span>
								</li>
								<li>
									<span class="stats-target">Set:  </span><span><?PHP echo $create_date; ?></span>     <span  class="stats-target">Target:  </span><span><?PHP echo $goal_date; ?></span>
								</li>
								<div class="progress">
									<?php 
									switch ($goals){
										case "Haven't started yet": { ?>
											<div class="progress-bar progress-bar-default progress-without-number" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"><br>
												<span class="sr-only">Not Started</span>
											</div><?php
											break; }
										case 'Starting to work on this': {?>
											<div class="progress-bar progress-bar-danger progress-without-number" role="progressbar" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100" style="width: 15%;">
												<span class="sr-only">great start</span>
											</div> <?php
											break; }
										case "Making progress": {?>
											<div class="progress-bar progress-bar-royal progress-without-number" role="progressbar" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100" style="width: 35%;">
												<span class="sr-only">making progress</span>
											</div> <?php
											break; }
										case 'Halfway there' : {?>
											<div class="progress-bar progress-bar-info progress-without-number" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%;">
												<span class="sr-only">halfway</span>
											</div> <?php
											break; }
										case "I'm almost done": {?>
											<div class="progress-bar progress-bar-royal progress-without-number" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%;">
												<span class="sr-only">almost</span>
											</div> <?php
											break; }
										case 'I did it!': {?>
											<div class="progress-bar progress-bar-success progress-without-number" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
												<span class="sr-only">success!</span>
											</div> <?php
											break; 
									}
								} ?>
								</div>											 
								</li>
								
							<?php }?>
									</ul>
							 <?php } else echo 'No Goals Assigned';?>
								</div>
							</div>    
			<?php 
			} ?>
<!-- Next Check -->
							<hr class="separator" />
							
	<!--modified to allow all only student admin or clinicians to schedule appts			-->		
<!-- ************************************************************************ -->	
<?php if (($_SESSION['MM_Userrole'] == 'Student Admin') || ($_SESSION['MM_Userrole'] == 'Clinician') 
|| ($_SESSION['MM_Userrole'] == 'ClinicianAdmin') ) {   ?>		
       <!-- Schedule Appt   -->    
       
             				<div class="sidebar-widget  widget-collapsed">
								<div class="widget-header">
									<h6>Schedule Appointment</h6>
									<div class="widget-toggle">+</div>
								</div>
								<div class="widget-content">
<!--110115 - modified to call createApptAll to all selection of all students for appt. -->
<form action="actions/createApptAll.php" method='POST'  id="add-appt-form" name="add-appt-form" >

<div class="row mb-sm">  <!-- appt for -->
    <div class="col-sm-1"></div> 
    <div class="col-sm-11 form-group">
    <label class="control-label">Appointment For <span class="required">*</span></label>
    <?php  if ($_SESSION['MM_StudentID']!= '') { 
    $youth = GetStudent($SUID, $db); 
  ?>
    
    <div>
    <input type="hidden" name="lsmstudentID" class="form-control input-sm"  value="<?php echo $SUID;?>">
    <p class="standout"><?php echo $_SESSION['MM_StudentID']?> <?php echo $youth; ?></p>
    </div>
    <?php } else { ?>
    <div>
    <select name="lsmstudentID" class="form-control populate input-sm" required>
    <?php 
    //LK - modify to GetStudentListLoc ($CID,$LOC,$db) to retrieve only students at current location
   // $stlist = GetStudentList($CID, $db);							
                                      if ($Role == 'Site Admin') 
                                      		{ $stlist = GetStudentListAll($CID, $db); }
                                      		else { $stlist = GetStudentList($CCID, $db); }
    foreach($stlist as $studlist){
        $studFirst=$studlist['FirstName'];
        $studLast=$studlist['LastName'];	
        $selID=$studlist['StudentID'];
		$stuID=$studlist['s_uuid'];
        echo "<option value='$stuID'>$selID $studFirst $studLast</option>";
    }
    ?> 
    	<option value='ALL'>Select ALL</option>
    </select>
    </div>
    <?php } ?>
    </div>
</div>
<?php  /* doesnt work 
if ($Role == 'Site Admin')  {
$CCID= GetClientCode ($_POST['lsmstudentID'],$CID,$db); } */
?>
<div class="row mb-sm">
    <div class="col-sm-1"></div> 
    <div class="col-sm-11 form-group">
    <label class="control-label">Assign Clinician<span class="required">*</span></label>
    <div>
    <select name="Aclinician" class="form-control populate input-sm" required>
    <?php 
 //   $clinicians = GetClinicians($CID, $db);							
                                      if ($Role == 'Site Admin') 
                                      		{ $Xclinicians = GetCliniciansAll($CID, $db); }
                                      		else { $Xclinicians = GetClinicians($CCID, $db); } 

    foreach($Xclinicians as $clinics) {
    $CFirst=$clinics['FirstName'];
    $CLast=$clinics['LastName'];	
    $CUID=$clinics['UserID'];	
	$CUUID=$clinics['ua_uuid'];
    echo "<option value='$CUUID'>$CFirst $CLast</option>";
    }
    ?> 
    </select>
    </div>
    </div>
</div>	

<!-- LK Change to GetAssmtsLoc ($CID,$LOC, $db) -->
<div class="row mb-sm">
    <div class="col-sm-1"></div> 
    <div class="col-sm-11 form-group">
    <label class="control-label">Assessment Assigned<span class="required">*</span></label>
    <div>
    <select id="actionType" name="actionType" class="form-control populate input-sm" required>
    <option value="">No Assessment</option>
    <?php 
if ($Role == 'Site Admin') 
      { $assessments = $assessments = GetAssmtsAll($CID, $db); }
      else { $assessments = GetAssmts($CCID, $db); } 
        							
//modified for matching ID not assmtname        
        foreach($assessments as $assmts){
            $AssmtName=$assmts['client_item'];	
            $AssmtID=$assmts['assmtID'];
            echo "<option value='$AssmtID'>$AssmtName</option>";
        }
    ?> 
    </select>
    </div>
    </div>
</div>
										<div class="row mb-sm">
											<div class="col-sm-1"></div> 
											<div class="col-sm-11 form-group">
													<label class="control-label">Date<span class="required">*</span></label>
													<div class="input-group-sm ">
														<input  name="Aapptdate" data-plugin-datepicker class="form-control" placeholder="mm/dd/yyyy" required>
													</div >
											</div>
										 </div>
										 <div class="row mb-sm">
											<div class="col-sm-1"></div> 
											<div class="col-sm-11 form-group">
												<label class="control-label">Time</label>
													<div class="input-group-sm">
															<input type="text" data-plugin-timepicker class="form-control" name="Aappttime">
													</div >
											</div>
										</div> 
<div class="row mb-sm">
	<div class="col-sm-1"></div>
	<div class="col-sm-11 form-group">
		<label class="control-label">Grade (optional)</label>
		<input type="text" name="grade" class="form-control input-sm" placeholder="enter grade">
	</div>
</div>


<div class="row mb-lg">
    <div class="col-sm-1"></div>
    <div class="col-sm-11" align="right">
    <button type="reset" class="btn btn-sm btn-default">Cancel</button>
    <button class="btn btn-sm btn-primary">Save</button>						
</div>
</div> 
<input type="hidden" name="actionItem" value="Assmt">
<input type="hidden" name="MM_insert" value="add-appt-form">

</form> 
                                </div>
                           </div>  
                             <hr class="separator" />  		 
<?php } ?>
<!-- *************************************************** -->
				 	
<?php  if (($_SESSION['MM_Userrole'] == 'Clinician') || ($_SESSION['MM_Userrole'] == 'ClinicianAdmin')) { ?>
							 <!-- Assign Goal -->
            				<div class="sidebar-widget widget-collapsed">
								<div class="widget-header">
									<h6>Add Goal</h6>
									<div class="widget-toggle">+</div>
								</div>

								<div class="widget-content">
									 <form  action="actions/createGoal.php" method="POST" name="addGoal" ?>
										<div class="row mb-sm">  <!-- referral for -->
											<div class="col-sm-1"></div> 
											<div class="col-sm-11 form-group">
												<label class="control-label">Goal For </label>
												<?php if ($_SESSION['MM_StudentID']!= '') { 
														$student = GetStudent($SUID, $db); 
													?>
												<div>
										<!--			<input type="hidden" name="gyouthID" class="form-control input-sm"  value="<?php echo $_SESSION['MM_StudentID'];?>">   -->
										<input type="hidden" name="gyouthID" class="form-control input-sm"  value="<?php echo $SUID;?>">
													<input type="hidden" name="goalActionID" class="form-control input-sm"  value="<?php echo $_SESSION['MM_ActionID'];?>">
													<p class="standout"><?php echo $_SESSION['MM_StudentID']?> <?php echo $student; ?></p>
												</div>
											<?php } else { ?>
												<div>
													<select name="gyouthID" class="form-control populate input-sm">
													<?php 
											//		$studentlist = GetStudentList($CID, $db);							
                                      if (($Role == 'Site Admin') || ($Role == 'Sys Admin')) 
                                      		{ $studentlist = GetStudentListAll($ClientID, $db); }
                                      		else { $studentlist = GetStudentList($CCID, $db); }
													foreach($studentlist as $slist){
														$sFirst=$slist['FirstName'];
														$sLast=$slist['LastName'];	
														$selectedID=$slist['StudentID'];	
														$selectstudent=$slist['s_uuid'];	
														?> 
														<option value="<?php echo $selectstudent; ?>"><?php echo $selectedID; ?> - <?php echo $sFirst; ?> <?php echo $sLast; ?></option>										   
											<?php }  ?> 
													</select>
												</div>
										<?php } ?>
											</div>
										</div>
											<div class="row mb-md">
												<div class="col-sm-1"></div>
												<div class="col-sm-11 form-group">
													<label class="control-label">Goal</label>
													<input type="text" name="goal" class="form-control input-sm" placeholder="enter goal" required>
												</div>
											</div>
										<div class="row mb-md">
												<div class="col-sm-1"></div>
												<div class="col-sm-11 form-group">
														<label class="control-label">Target Date</label>
														<div class="input-group-sm">
															<input  name="date" data-plugin-datepicker class="form-control input-sm" placeholder="mm/dd/yyyy">
														</div>
												</div>
											</div>	
											<div class="row mb-md">
												<div class="col-sm-1"></div>
												<div class="col-sm-11" align="right">
													<button type="reset" class="btn btn-sm btn-default">Cancel</button>
													<button type="submit" class="btn btn-sm btn-primary">Save</button>		
												</div>
										 </div> 
										 <input type="hidden" name="MM_insert" value="add-goal-form">
									   </form>
								  </div> 
							</div>   
                                  <hr class="separator" />

   <!-- Schedule Followup   --> 
    				<?php  if ($_SESSION['MM_StudentID']!= '')  { 
    								if (($_SESSION['MM_Userrole'] == 'Clinician') || ($_SESSION['MM_Userrole'] == 'Student Admin') || ($_SESSION['MM_Userrole'] == 'ClinicianAdmin')) { ?>
							<div class="sidebar-widget  widget-collapsed">
								<div class="widget-header">
									<h6>Schedule Follow-Up</h6>
									<div class="widget-toggle">+</div>
								</div>

								<div class="widget-content">
									<form action="actions/createFollow.php" method='POST'  id="add-follow-form" name="add-follow-form" >
										<div class="row mb-sm">  <!-- appt for -->
											<div class="col-sm-1"></div> 
											<div class="col-sm-11 form-group">
												<label class="control-label">Follow-Up For </label>
												<?php if ($_SESSION['MM_StudentID']!= '') { 
												$kid = GetStudent($SUID, $db); ?>
												<div>
													<input type="hidden" name="studentID" class="form-control input-sm"  value="<?php echo $SUID;?>">
													<p class="standout"><?php echo $_SESSION['MM_StudentID']?> <?php echo $kid; ?></p>
												</div>
											<?php } else { ?>
												<div>
													<select name="studentID" class="form-control populate input-sm">
													<?php 
													//	$stulist = GetStudentList($CID, $db);							
                                      if (($Role == ' Site Admin') || ($Role == 'Sys Admin')) 
                                      		{ $stulist = GetStudentListAll($ClientID, $db); }
                                      		else { $stulist = GetStudentList($CCID, $db); }
														foreach($stulist as $studelist){
															$stdFirst=$studelist['FirstName'];
															$stdLast=$studelist['LastName'];	
															$selectID=$studelist['StudentID'];	
															$selectStu=$studelist['s_uuid']; ?> 
														<option value="<?php echo $selectStu; ?>"><?php  echo $selectID; ?> - <?php echo $stdFirst; ?> <?php  echo $stdLast; ?></option>
											   
														<?php }  ?>
													</select>
												</div>
										<?php } ?>
											</div>
										</div>

										<div class="row mb-sm">
											<div class="col-sm-1"></div> 
											<div class="col-sm-11 form-group">
													<label class="control-label">Assign Clinician</label>
													<div>
														<select name="clinician" class="form-control populate input-sm" required>
															<?php
										//					$cliniciansC = GetClinicians($CID, $db);							
                                      if (($Role == 'Site Admin') || ($Role == 'Sys Admin') || ($Role == 'Student Admin')) 
                                      		{ $cliniciansC = GetCliniciansAll($CID, $db); }
                                      		else { $cliniciansC = GetClinicians($CCID, $db); }
														foreach($cliniciansC as $clinicsC){
															$CCFirst=$clinicsC['FirstName'];
															$CCLast=$clinicsC['LastName'];	
															$CCUID=$clinicsC['ua_uuid'];	?> 
														<option value="<?php echo $CCUID; ?>"><?php echo $CCFirst; ?> <?php  echo $CCLast; ?></option>
												<?php 	}   ?> 
														</select>
													</div>
											</div >
										</div>														
																			
										<div class="row mb-sm">
											<div class="col-sm-1"></div> 
											<div class="col-sm-11 form-group">
												<label class="control-label">Associated Assessment</label>
												<div>
														<select id="whichID" name="whichID" class="form-control populate input-sm" /required>
												<?php 
												 // test purposes $SID='D001';
														$wrecentraaps= GetRecentRAAPS($SUID, $db);	
														if (count($wrecentraaps) != '0') {
														foreach($wrecentraaps as $wraaps){
															$wrtype=$wraaps['actionType'];
															$wrID=$wraaps['actionID'];
															 ?> <option value="<?php echo $wrID; ?>"><?php echo $wrtype; ?> </option> 															
														<?php } 
														} else {$followwr='0';} 
																	
														$wrecentacttob= GetRecentActTOB($SUID, $db);	
														if (count($wrecentacttob) != '0') {
														foreach($wrecentacttob as $wacttob){
															$wtobtype=$wacttob['actionType'];
															$wtobID=$wacttob['actionID'];
															?> <option value="<?php echo $wtobID; ?>"><?php echo $wtobtype; ?> </option>								
														<?php } 
														} else {$followtob='0';}  
														
														$wrecentactsh= GetRecentActSH($SUID, $db);
														if (count($wrecentactsh) != '0') {	
														foreach($wrecentactsh as $wactsh){
															$wshtype=$wactsh['actionType'];
															$wshID=$wactsh['actionID'];
															 ?> <option value="<?php echo $wshID; ?>"><?php echo $wshtype; ?> </option>
														<?php } 
														} else {$followsh='0';} ?>  
															
														<?php if (($followwr=='0') && ($followsh=='0') && ($followtob=='0')) {  ?> <option value= "">No Previous Appt</option> <?php } 
														  ?>
												</select>
												</div>
											</div >
										</div>
							
										<div class="row mb-sm">
											<div class="col-sm-1"></div> 
											<div class="col-sm-11 form-group">
													<label class="control-label">Date</label>
													<div class="input-group-sm ">
														<input  name="apptdate" data-plugin-datepicker class="form-control" placeholder="mm/dd/yyyy"  /required>
													</div >
											</div>
										 </div>
										 <div class="row mb-sm">
											<div class="col-sm-1"></div> 
											<div class="col-sm-11 form-group">
												<label class="control-label">Time</label>
													<div class="input-group-sm">
															<input type="text" data-plugin-timepicker class="form-control" name="appttime">
													</div >
											</div>
										</div> 
										
											<div class="row mb-sm">
											<div class="col-sm-1"></div> 
											<div class="col-sm-11 form-group">
												<label class="control-label">Reason</label>
												<div>
														<input type="text" name="freason" class="form-control" value="">
												</div>
											</div >
										</div>
										
										<div class="row mb-lg">
											<div class="col-sm-1"></div>
											<div class="col-sm-11" align="right">
												<button type="reset" class="btn btn-sm btn-default">Cancel</button>
												<button class="btn btn-sm btn-primary">Save</button>						
											</div>
										</div>
										<input type="hidden" name="actionItem" value="FollowUp"> 
										<input type="hidden" name="MM_insert" value="add-follow-form">
									</form> 
                                </div>
                           </div>   
                             <hr class="separator" /> 
                      <?php }  } ?>       
 <!-- Make Referral       -->   
 	<?php if ($_SESSION['MM_StudentID']!= '')  {
if (($_SESSION['MM_Userrole'] == 'Clinician') || ($_SESSION['MM_Userrole'] == 'Student Admin') || ($_SESSION['MM_Userrole'] == 'ClinicianAdmin')) { 
 							 $referee= GetStudent($SUID, $db);   						 
 							  ?>           
      -     				<div class="sidebar-widget  widget-collapsed">
								<div class="widget-header">
									<h6>Make a Referral</h6>
									<div class="widget-toggle">+</div>
								</div>

								<div class="widget-content">
									<form action="actions/createReferral.php" method='POST'  id="make-ref-form" name="make-ref-form" >
										<div class="row mb-sm">  <!-- referral for -->
											<div class="col-sm-1"></div> 
											<div class="col-sm-11 form-group">
												<label class="control-label">Referral For </label>
												<div>
													<input type="hidden" name="refereeID" class="form-control input-sm"  value="<?php echo $SUID;?>">
													<input type="hidden" name="refActionID" class="form-control input-sm"  value="<?php echo $_SESSION['MM_ActionID'];?>">
													<p class="standout"><?php echo $_SESSION['MM_StudentID']?> <?php echo $referee; ?></p>
												</div>

											</div>
										</div> 
										
										
										
										<div class="row mb-sm">
											<div class="col-sm-1"></div> 
											<div class="col-sm-11 form-group">
													<label class="control-label">Referral Type</label>
													<div>
														<select name="reftype" class="form-control populate input-sm" required>
															<option value="">No Referral</option>
														<?php 
																$referraltype= GetReferralTypes($CID,$db);
																foreach($referraltype as $reftype){
																		$refertype=$reftype['ReferralType'];
																		?> 
															<option value="<?php echo $refertype; ?>"><?php echo $refertype; ?></option>
														 <?php } ?> 
														</select>
													</div>
											</div >
										</div>
										<div class="row mb-sm">
											<div class="col-sm-1"></div> 
											<div class="col-sm-11 form-group">
												<label class="control-label">Associated Assessment</label>
												<div>
														<select name="what" class="form-control populate input-sm" /required>
												<?php 
														$assmtcount='0';
												 // test purposes $SID='D001';
														$krecentraaps= GetRecentAssmts($SUID, $db);	
														if (count($krecentraaps) > '0') {
														foreach($krecentraaps as $kraaps) {
															$krtype=$kraaps['actionType'];
															$krID=$kraaps['actionID'];															
														?> 
														<option value="<?php echo $krID; ?>"><?php echo $krtype; ?></option>	
														<?php  } 
														} else { ?> <option value= "">No Previous Appt</option> <?php }  ?>
												</select>
												</div>
											</div >
										</div>
										<div class="row mb-sm">
											<div class="col-sm-1"></div> 
											<div class="col-sm-11 form-group">
													<label class="control-label">Referred To</label>
													<div>
														<select id="referral" name="referral" class="form-control populate input-sm" required>
															<?php 
																$refertolist= GetReferTo($CID,$CCID,$db);
                 												foreach($refertolist as $referlist) {
																$referto=$referlist['ua_uuid'];
																$rtFirst=$referlist['FirstName'];
																$rtLast=$referlist['LastName'];
																$rtSpeciality=$referlist['Speciality'];
															 ?> 
																<option value="<?php echo $referto; ?>"><?php echo $rtFirst; ?> <?php echo $rtLast; ?>   <?php echo $rtSpeciality; ?></option>
													<?php 
                												}  ?> 
														</select>
													</div>
											</div >
										</div>														
										<div class="row mb-sm">
											<div class="col-sm-1"></div> 
											<div class="col-sm-11 form-group">
													<label class="control-label">Date</label>
													<div class="input-group-sm ">
														<input  name="apptdate" data-plugin-datepicker class="form-control" placeholder="mm/dd/yyyy"  /required>
													</div >
											</div>
										 </div>
										<div class="row mb-sm">
											<div class="col-sm-1"></div> 
											<div class="col-sm-11 form-group">
												<label class="control-label">Reason</label>
												<div>
														<input type="text" name="reason" class="form-control" value="">
												</div>
											</div >
										</div>
										<div class="row mb-lg">
											<div class="col-sm-1"></div>
											<div class="col-sm-11" align="right">
												<button type="reset" class="btn btn-sm btn-default">Cancel</button>
												<button class="btn btn-sm btn-primary">Save</button>						
											</div>
										</div> 
										<input type="hidden" name="MM_insert" value="make-ref-form">
									</form> 
                                </div>
                           </div>                      
							<hr class="separator" /> 
	<?php  }  }				
	} ?>
<!--
<div class="sidebar-widget  widget-collapsed">
<div class="widget-header">
<h6>Test Variable</h6>
<div class="widget-toggle">+</div>
<ul class="list-unstyled m-none">
<li>username:<?php echo $_SESSION['MM_Username'];?></li>
<li>user role:<?php echo $_SESSION['MM_Userrole'];?></li>
<li>user id:<?php echo $_SESSION['MM_UserID'];?></li>
<li>uuid:<?php echo $_SESSION['MM_UUID'];?></li>
<li>client id: <?php echo $_SESSION['MM_ClientID'];?></li>
<li>client code: <?php echo $_SESSION['MM_ClientCode'];?></li>
<li>first name: <?php echo $_SESSION['MM_FirstName'];?></li>
<li>last name: <?php echo $_SESSION['MM_LastName'];?></li>
<li>location: <?php echo $_SESSION['MM_Location'];?></li>
<li>assmt type: <?php echo $_SESSION['MM_AssmtType'];?></li>
<li>student id: <?php echo $_SESSION['MM_StudentID'];?></li>
<li>student user id: <?php echo $_SESSION['MM_SUserID'];?></li>
<li>assmt inst id: <?php echo $_SESSION['MM_AssmtInstID'];?></li>
<li>action id: <?php echo $_SESSION['MM_ActionID'];?></li>
<li>action item: <?php echo $_SESSION['MM_ActionItem'];?></li>
</ul>
</div>
</div> 
-->

					</div>
				</div>

				
				
				</aside>


