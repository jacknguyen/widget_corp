	<div id="footer" class="navbar navbar-default navbar-fixed-bottom" role="footer">
		<div class="container-fluid">
			<p class="navbar-text">Copyright <?php echo date('Y'); ?>, Widget Corp.</p>
		</div>
	</div>

	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>
</html>

<?php
	// 5. Close database connection
	if(isset($connection)) { mysqli_close($connection); }
?>