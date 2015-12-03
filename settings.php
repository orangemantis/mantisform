<?php
require_once 'includes/config.php';
require_once 'includes/header.php';
require_once 'includes/identity.class.php';

$settings = new settings($config, TRUE);
$settings = $settings->getSettings();
$forms = new forms($config, TRUE);
$states = $forms->createStateOptions();
$currentYear = $config['year'];

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="css/bootstrap.min.css" rel="stylesheet">
        <style>
			body {
				padding-top: 60px;
				padding-bottom: 40px;
			}
		</style>
		<link rel="stylesheet" href="css/styles.css">
		<script>
			var mantisScribe = {};
			mantisScribe.config = {
				script: 'js/settings.js'
			};
		</script>
    </head>
    <body>
    <?php include 'includes/nav.php'; ?>
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
                <h1>Settings</h1>
                <p>Connfigure the app settings below.</p>
            </div> 
		</div>
		<hr>
		<?php if(identity::checkAuth()): ?>
		<form class="form-horizontal" id="settingsForm" role="form">
			<div class="form-group">
				<label class="col-sm-2 control-label" for="campaignBrand">Brand</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="campaignBrand" name="campaign_brand" placeholder="Brand" value="<?php echo $settings['campaign_brand']; ?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="campaignName">Campaign Name</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="campaignName" name="campaign_name" placeholder="Campain Name" value="<?php echo $settings['campaign_name']; ?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="campaignDate">Campaign Date</label>
				<div class="col-sm-10">
					<input type="date" class="form-control" id="campaignDate" name="campaign_date" placeholder="Campaign Date" value="<?php echo $settings['campaign_date']; ?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="campaignLocation">Location</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="campaignLocation" name="campaign_location" placeholder="Location" value="<?php echo $settings['campaign_location']; ?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="contact">Team Leader</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="campaignContact" name="campaign_contact" placeholder="Team Leader" value="<?php echo $settings['campaign_contact']; ?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="campaignEmail">Email</label>
				<div class="col-sm-10">
					<input type="email" class="form-control" id="campaignEmail" name="campaign_email" placeholder="Email" value="<?php echo $settings['campaign_email']; ?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="phone">Phone</label>
				<div class="col-sm-10">
					<input type="tel" class="form-control" id="campaignPhone" name="campaign_phone" placeholder="Phone" value="<?php echo $settings['campaign_phone']; ?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="campaignMessage">Marketing Message</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="campaignMessage" name="campaign_message" placeholder="Marketing Message" value="<?php echo $settings['campaign_message']; ?>">
				</div>
			</div>
			<div class="form-group">
			<label class="col-sm-2 control-label" for="camapignTerms">Terms and Conditions</label>
			<div class="col-sm-10">
				<textarea class="form-control" id="campaignTerms" name="campaign_terms" rows="3"><?php echo $settings['campaign_terms']; ?></textarea>
			</div>
			</div>
			<div class="form-group">
			<label class="col-sm-2 control-label" for="campaignNote">Note</label>
			<div class="col-sm-10">
				<textarea class="form-control" id="campaignNote" name="campaign_note" rows="3"><?php echo $settings['campaign_note']; ?></textarea>
			</div>
			</div>
			<div class="form-group">
			<label class="col-sm-2 control-label" for="layoutSignup">Signup Layout</label>
			<div class="col-sm-10">
				<select class="form-control" id="layoutSignup" name="layout_signup" rows="3">
					<option value="1">Full</option>
					<option value="2">Mini</option>
				</select>
			</div>
			</div>
			<input type="hidden" id="operation" name="operation" value="">
			
		    <div class="form-group">
    			<div class="col-sm-offset-2 col-sm-10">
      				<button type="submit" value="1" id="applyBtn" class="btn btn-success">Apply</button>
    			</div>
  			</div>
		</form>
		<?php else: ?>
		<p>You must be logged in to view.</p>
		<?php endif; ?>
		<hr>

		<?php include 'includes/footer.php'; ?>

	</div>
	<!-- /container -->
	<!--  Modal here -->
	<div class="modal fade" id="scribeModal" tabindex="-1" role="dialog" aria-labelledby="scribeModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header" id="scribeModalHeader">
					<button class="close" type="button" data-dismiss="modal" aria-hidden="true">&times</button>
					<h4 class="modal-title" id="scribeModalheader">Mantis Scribe Says</h4>
				</div>
				<div class="modal-body" id="scribeModalBody">
					<img src="images/spinner.gif"> Please wait while information is saved.
				</div>
				<div class="modal-footer" id="scribeModalFooter">
					<button id="scribeModalCloseBtn" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<!-- /modal -->
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/main.js"></script>
    </body>
</html>