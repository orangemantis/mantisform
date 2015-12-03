<?php
require_once 'includes/header.php';

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
				script: 'js/login.js'
			};
		</script>
    </head>
    <body>
    <?php include 'includes/nav.php'; ?>
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
                <h1>Login</h1>
                <p>Sign in to administer this app.</p>
            </div> 
		</div>
		<hr>
		<form class="form-horizontal" id="loginForm" role="form" method="post">
			<div class="form-group">
				<label class="col-sm-2 control-label" for="user">User</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="user" name="user" placeholder="user">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="password">Password</label>
				<div class="col-sm-10">
					<input type="password" class="form-control" id="password" name="password" placeholder="password">
				</div>
			</div>
			<div class="form-group">
    			<div class="col-sm-offset-2 col-sm-10">
      				<button type="submit" value="1" id="loginBtn" class="btn btn-success">Login</button>
    			</div>
  			</div>
		</form>
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