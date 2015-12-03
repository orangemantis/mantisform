<?php 
require_once 'includes/identity.class.php';
?>
<footer>
	<p>&copy; orangeMantis <?php echo $currentYear; ?> &nbsp; 
	<?php if (identity::checkAuth()){
		echo  '<button id="logoutBtn" type="button" class="btn btn-default">Logout</button>';
	}; ?></p>
</footer>