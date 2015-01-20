<?php

/*

Config options -

inbound / outbound
Custom Javascript Filename
Custom CSS Filename


*/

?>
<div id="option-group">
<p>
<label for="dialer">Dialer</label>
<select name="dialer" id="dialer">
	<option>Hosted</option>
	<option>Hosted Predictive</option>
	<option>Hosted Manual</option>
	<option>local</option>
</select>
</p>
<p>
<label for="inoutsel">Disposition</label>
Inbound: <input type="checkbox" name="inbound" id="inbound" value="Yes">
Outbound: <input type="checkbox" name="outbound" id="outbound" value="Yes">
</p>
<p>
<label for="customjs">Custom Javascript</label>
<input type="text" name="customjs" id="customjs" placeholder="/path/to/js.js">
</p>
<p>
<label for="customcss">Custom Javascript</label>
<input type="text" name="customcss" id="customcss" placeholder="/path/to/css.css">
</p>

<p>
<label for="lead-database">Lead Database</label>
<select name="lead-database" id="lead-database">
	<option value="scripts">Scripts</option>
	<option value="mssql">Main SQL B</option>
	<option value="cluster1">Cluster 1</option>
	<option value="cluster2">Cluster 2</option>
	<option value="cluster3">Cluster 3</option>
</select>	
</p>
<p>
<label for="lead-dbname">Lead DBName</label>
<input type="text" name="lead-dbname" id="lead-dbname">
</p>

<p>
<label for="lead-table">Lead Table</label>
<input type="text" name="lead-table" id="lead-table">
</p>

</div>

<button id="save_config">Save Configuration</button>