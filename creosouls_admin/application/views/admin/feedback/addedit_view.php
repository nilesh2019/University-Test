<style>
	.label-wrapper
	{
		text-align: left;
	}
	.requiredClass
	{
		color: red;
	}
</style>


<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade" style="display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header vd_bg-blue vd_white">
				<button aria-hidden="true" data-dismiss="modal" class="close" type="button">
					<i class="fa fa-times">
					</i>
				</button>
				<h4 id="myModalLabel" class="modal-title">
					Feedback Instance
				</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" id="feedbackInstanceForm" enctype="multipart/form-data" action="#" role="form" method="post">
					<div class="alert alert-danger vd_hidden">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
							<i class="icon-cross">
							</i>
						</button>
						<span class="vd_alert-icon">
							<i class="fa fa-exclamation-circle vd_red">
							</i>
						</span>
						<strong>
							Oh snap!
						</strong> Please correct following errors and try submiting it again.
					</div>
					<div class="alert alert-success vd_hidden">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
							<i class="icon-cross">
							</i>
						</button>
						<span class="vd_alert-icon">
							<i class="fa fa-check-circle vd_green">
							</i>
						</span>
						<strong>
							Well done!
						</strong>.
					</div>
					<div id="feedbackInstanceFormFields" class="form-group  mgbt-xs-20">
						<div class="col-md-12">
							<div class="label-wrapper ">
								<label class="control-label" for="sessionName">
									Name
								</label> (
								<span class="requiredClass">
									*
								</span>)
							</div>
							<div class="vd_input-wrapper light-theme" id="sessionName-input-wrapper">
								<span class="menu-icon">
									<i class="fa fa-university">
									</i>
								</span>
								<input type="text" placeholder="Session Name" id="sessionName" name="sessionName" class="required">
							</div>
							<br/>

							<br/>
							<div class="label-wrapper">
								<label class="control-label " for="sessionStartDate">
									Session Start Date
								</label> (
								<span class="requiredClass">
									*
								</span>)
							</div>
							<div class="vd_input-wrapper light-theme" id="sessionStartDate-input-wrapper" >
								<span class="menu-icon">
									<i class="fa fa-date">
									</i>
								</span>
								<input type="text" placeholder="Try typing 'Session Start Date'" autocomplete="off" id="sessionStartDate" name="sessionStartDate" class="required">
							</div>
							<br/>

							<div class="label-wrapper">
								<label class="control-label " for="sessionEndDate">
									Session End Date
								</label> (
								<span class="requiredClass">
									*
								</span>)
							</div>
							<div class="vd_input-wrapper light-theme" id="sessionEndDate-input-wrapper" >
								<span class="menu-icon">
									<i class="fa fa-date">
									</i>
								</span>
								<input type="text" placeholder="Try typing 'Session End Date'" autocomplete="off" id="sessionEndDate" name="sessionEndDate" class="required">
							</div>
							<br/>
						</div>
					</div>
					<div id="vd_login-error" class="alert alert-danger hidden">
						<i class="fa fa-exclamation-circle fa-fw">
						</i>Please fill the necessary field
					</div>
					<div class="form-group">
						<div class="col-md-12 text-center mgbt-xs-5">
							<button class="btn vd_btn vd_btn-bevel vd_bg-blue font-semibold width-100" type="submit" id="feedback-instance-submit">
								Submit
							</button>
						</div>
						<input type="hidden" name="feedbackInstanceId" id="feedbackInstanceId">
					</div>
				</form>
			</div>
			<!--      <div class="modal-footer background-login">
			<button data-dismiss="modal" class="btn vd_btn vd_bg-grey" type="button">Close</button>
			<button class="btn vd_btn vd_bg-green" type="button">Save changes</button>
			</div> -->
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
