<?php
	$pageTitle = 'Management';
	$headingText = "Welcome Manager Screen";
	include('includes/header.php') 
?>
  <div class="row">
    <div class="col">
      <div class="d-flex flex-column ">

				<a href ="#" role="button" class="btn btn-secondary mb-4">Manage System</a>
				<a href ="#" role="button" class="btn btn-secondary mb-4">System Status</a>
				<a href ="#" role="button" class="btn btn-secondary mb-4">Generate Report</a>
				<a href ="#" role="button" class="btn btn-danger btn-outline mb-4">Log Out</a>

			</div>
    </div>
    <div class="col">
      <img width="480px"src="images/loading_chart.png" alt="Sample loading">
    </div>
  </div>

<?php 
	include('includes/footer.php')
?>