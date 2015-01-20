<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>TMC Script Builder</title>
	<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
	<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
	<link rel="stylesheet" href="assets/css/styles.css" />
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Lato:400,300,700,900' rel='stylesheet' type='text/css'>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
	<script src="assets/js/tinymce/tinymce.min.js"></script>
	<script src="assets/js/main.js"></script>

</head>

<body>
<div id="top-nav">
<h1>Script Builder <small><em>beta</em></small></h1>
<div id="search-form"><input type="text" name="search" placeholder="Search For..."></div>

</div>
<div id="main">

<div id="side-nav">
	<ul id="tab-nav">
		<li><span class="nav-icon"><i class="fa fa-home"></i></span>Dashboard</li>
		<li><span class="nav-icon"><i class="fa fa-book"></i></span>Campaign Configuration</li>
		<li><span class="nav-icon"><i class="fa fa-align-justify"></i></span>Content</li>
		<li><span class="nav-icon"><i class="fa fa-pencil"></i></span>Forms</li>
		<li><span class="nav-icon"><i class="fa fa-table"></i></span>Tabs</li>
		<li><span class="nav-icon"><i class="fa fa-cog"></i></span>Vici Function Builder</li>
		<li><span class="nav-icon"><i class="fa fa-book"></i></span>Data Management</li>
	</ul>
</div>

<div id="script-main">

	<div id="breadcrumbs">
		<ul id="dash-area">
			<li class="tab show">Dashboard <i class="fa fa-angle-double-right"></i> <span class="campaign"></span></li>
			<li class="tab hidden">Campaign Configuration <i class="fa fa-angle-double-right"></i> <span class="campaign"></span></li>
			<li class="tab hidden">Content <i class="fa fa-angle-double-right"></i> <span class="campaign"></span></li>
			<li class="tab hidden">Forms <i class="fa fa-angle-double-right"></i> <span class="campaign"></span></li>
			<li class="tab hidden">Tabs <i class="fa fa-angle-double-right"></i> <span class="campaign"></span></li>
			<li class="tab hidden">Vici Function Builder <i class="fa fa-angle-double-right"></i> <span class="campaign"></span></li>
			<li class="tab hidden">Data Management <i class="fa fa-angle-double-right"></i> <span class="campaign"></span></li>
		</ul>
	</div>

 <div id="dash-con">
 	<div class="edit-warning">You Must Select or Create a Campaign First.</div>
		
	<div id="tabs">

		<div class="tab show">
			<?php include('parts/campaign-manager.php'); ?>
		</div>

		<div class="tab hidden">
			<?php include('parts/campaign-configuration.php'); ?>
		</div>


		<div class="tab hidden">
			<?php include('parts/content-editor.php'); ?>
		</div>
		
		<div class="tab hidden">
			<?php include('parts/form-editor.php'); ?>
		</div>
		
		<div class="tab hidden">
			<?php include('parts/tab-editor.php'); ?>
		</div>
		
		<div class="tab hidden">

	
		</div>

		<div class="tab hidden">

		
		</div>	

	</div>

</div>
</div>

</div>

</body>
</html>
