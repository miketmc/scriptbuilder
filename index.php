<?php 
/* initialize */
$campid = $_GET['campaign'];
$agentname = $_GET['agentName'];
if (!isset($_GET['campaign'])) { echo "<strong>No Campaign ID Specified</strong>"; die();}
include('includes/init.php');
include('includes/functions.php');

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Untitled Document</title>
	<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
    <link rel="stylesheet" href="assets/css/styles.css" />
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
    <script src="assets/js/main.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Lato:400,100,300,700,900' rel='stylesheet' type='text/css'>
</head>
<body>
	<div id="anim-container">
		<div id="loading"></div>
	</div>

	<div id="script-container">
		<div id="tabcon">
			<ul>
				<?php generate_tabs($tab_titles); ?>
			</ul>
		</div>

		<div id="tabs">
			<?php generate_tabcontent($tab_content, $content); ?>

		</div>

	</div>

</body>
</html>