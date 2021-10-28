<?php
	$pageTitle = 'Sign Up';
	$headingText = "Sign Up Today!";
	include('includes/header.php') 
?>
		
			<div class="container d-flex flex-column align-items-center">
				<!-- Content -->

				<!-- User Sign Up Form -->
				<form class="w-50 pb-5">
					<div class="form-group">
						<label for="userEmail">Email address</label>
						<input type="email" class="form-control" id="userEmail" aria-describedby="formHelp" placeholder="Enter email">
					</div>

					<div class="form-group pt-2">
						<label for="phoneNumber">Phone Number</label>
						<input type="tel" class="form-control" id="phoneNumber" placeholder="Phone Number" aria-describedby="formHelp">
					</div>

					<div class="form-group pt-2">
						<label for="userPassword">Password</label>
						<input type="password" class="form-control" id="userPassword" placeholder="Password">
					</div>

					<div class="form-group pt-2">
						<label for="userPasswordConfirm">Confirm Password</label>
						<input type="password" class="form-control" id="userPasswordConfirm" placeholder="Confirm Password">
					</div>

					<div class="d-grid gap-2 pt-4">
						<small id="formHelp" class="form-text text-muted text-center">We'll never share your information with anyone else.</small>
						<button type="submit" class="btn btn-primary btn-lg">Submit</button>
					</div>
				</form>

				<!-- End of Content -->
			</div>

<?php 
	include('includes/footer.php')
?>