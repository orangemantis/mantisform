<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse"
				data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span> <span
					class="icon-bar"></span> <span class="icon-bar"></span> <span
					class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="index.php"><?php echo $settings['campaign_brand']; ?>
			</a>
		</div>
		<div class="collapse navbar-collapse">
			<ul class="nav navbar-nav">
				<li><a href="index.php">Home</a>
				</li>
				<li><a href="terms.php">Terms</a>
				</li>
				<li class="dropdown"><a href="#" class="dropdown-toggle"
					data-toggle="dropdown">Admin<b class="caret"></b>
				</a>
					<ul class="dropdown-menu">
						<li>
							<a href="admin.php">Admin</a>
						</li>
						<li>
							<a href="review.php">Review Entries</a>
						</li>
						<li>
							<a href="download.php">Download</a>
						</li>
						<li>
							<a href="settings.php">Settings</a>
						</li>
						<li>
							<a href="login.php">Login</a>
						</li>
					</ul>
				</li>
			</ul>
			<?php if(isset($showQuickLinks)): ?>
			<form id="quickActions" class="navbar-form navbar-right">
				<button id="quickSubscribeBtn" class="btn btn-success" value="1">Agree</button>
				<button id="quickNoSubscribeBtn" class="btn btn-danger" value="0">Don't
					email</button>
				<button id="quickResetBtn" class="btn btn-default" value="1">Reset</button>
			</form>
			<?php endif; ?>
		</div>
		<!--/.nav-collapse -->
	</div>
</div>
