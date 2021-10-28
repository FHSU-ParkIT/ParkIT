<?php
	$pageTitle = 'Log In';
	$headingText = "Log In";
	include('includes/header.php') 
?>
		

			<div class="d-flex flex-column align-items-center">
				<!-- Content -->
				<!-- User Sign in Form -->
				<form class="w-50">
					<div class="form-group">
						<label for="username">Username</label>
						<input type="email" class="form-control" id="userEmail" aria-describedby="formHelp" placeholder="Enter email or Phone #">
					</div>

					<div class="form-group pt-2">
						<label for="userPassword">Password</label>
						<input type="password" class="form-control" id="userPassword" placeholder="Password">
					</div>

					<div class="d-grid gap-2 pt-4">
						<button type="submit" class="btn btn-primary btn-lg">Submit</button>
					</div>

				</form>

				<a href="index.php" class="link-secondary pt-2">Return To Home</a>
				<!-- End of Content -->
			</div>

<?php 
	include('includes/footer.php')
?>