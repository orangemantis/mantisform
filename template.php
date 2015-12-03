<?php
require_once 'includes/header.php';

$settings = new settings($config, TRUE);
$settings = $settings->getSettings();

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
				script: 'js/template.js'
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
		<!-- content here -->
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