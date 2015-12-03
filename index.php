<?php
require_once 'includes/header.php';

$settings = new settings($config, TRUE);
$settings = $settings->getSettings();
$showQuickLinks = TRUE;
$forms = new forms($config, TRUE);
$states = $forms->createStateOptions();
$canadianStates = $forms->createStateOptions(2);
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
		<script src="js/mantis.js"></script>
		<script>
		//set various JS vars in config global object by page
			var mantisScribe = {};
			mantisScribe.config = {
				script: 'js/entryformvalidation.js'
			};
		</script>
    </head>
    <body>
	<?php include 'includes/nav.php'; ?>
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
                <?php echo $settings['campaign_message']; ?>
            </div> 
		</div>
		<hr>
		<form class="form-horizontal" id="scribeForm" role="form">
		<?php if($settings['layout_signup'] == 1): ?>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="firstName">First Name</label>
				<div class="col-sm-10">
					<input type="text" class="form-control required" id="firstName" name="first_name" placeholder="First Name">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="middleInitial">Middle Initial</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="middleInitial" name="middle_initial" placeholder="Middle Initial">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="lastName">Last Name</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="lastName" name="last_name" placeholder="Last Name">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="email">Email</label>
				<div class="col-sm-10">
					<input type="email" class="form-control required" id="email" name="email" placeholder="Email">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="mobilePhone">Mobile Phone</label>
				<div class="col-sm-10">
					<input type="tel" class="form-control" id="mobilePhone" name="mobile_phone" placeholder="Mobile Phone">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="homePhone">Home Phone</label>
				<div class="col-sm-10">
					<input type="tel" class="form-control" id="homePhone" name="home_phone" placeholder="Home Phone">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="address1">Address 1</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="address1" name="address1" placeholder="Address 1">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="address2">Address 2</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="address2" name="address2" placeholder="Address 2">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="city">City</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="city" name="city" placeholder="City">
				</div>
			</div>
			
			<div class="form-group">
			<label class="col-sm-2 control-label" for="state">State</label>
				<div class="col-sm-10">
					<select id="state" name="state" class="form-control">
						<option value="OTHER">Unknown</option>
						<optgroup label="USA">
						<?php echo $states; ?>
						</optgroup>
						<optgroup label="CAN">
						<?php echo $canadianStates; ?>
						</optgroup>
						<optgroup label="Other">
						<option value="OTHER">Other</option>
						</optgroup>
					</select>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-2 control-label" for="zip">Zip/Postal Code</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="zip" name="zip_pc" placeholder="Zip/Postal Code">
				</div>
			</div>
			
			<div class="form-group">
			<label class="col-sm-2 control-label" for="country">Country</label>
				<div class="col-sm-10">
					<select name="country" id="country" class="form-control ">
						<option value="USA">United States</option>
						<option value="CAN">Canada</option>
						<option value="OTHER">Other</option>
					</select>
				</div>
			</div>
			
			<div class="form-group">
			<label class="col-sm-2 control-label" for="notes">Note</label>
			<div class="col-sm-10">
				<textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
			</div>
			</div>
			<?php endif; ?>
			<?php if($settings['layout_signup'] == 2): ?>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="firstName">First Name</label>
					<div class="col-sm-10">
						<input type="text" class="form-control required" id="firstName"
							name="first_name" placeholder="First Name">
					</div>
				</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="lastName">Last Name</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="lastName"
								name="last_name" placeholder="Last Name">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="email">Email</label>
						<div class="col-sm-10">
							<input type="email" class="form-control required" id="email"
								name="email" placeholder="Email">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="mobilePhone">Mobile
							Phone</label>
						<div class="col-sm-10">
							<input type="tel" class="form-control" id="mobilePhone"
								name="mobile_phone" placeholder="Mobile Phone">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="zip">Zip/Postal Code</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="zip" name="zip_pc" placeholder="Zip/Postal Code">
						</div>
					</div>
				<?php endif; ?>
					<input type="hidden" id="subscribed" name="subscribed" value="0">
					<!-- submit -->
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button type="submit" value="1" id="subscribeBtn"
								class="btn btn-success">Agree</button>
							<button type="submit" value="0" id="noSubscribeBtn"
								class="btn btn-danger">Don't email</button>
						</div>
					</div></form>
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
					<img src="images/spinner.gif"> Please wait.
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