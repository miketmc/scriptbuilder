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
<label for "inoutsel">Disposition</label>
Inbound: <input type="checkbox" name="inbound" value="Yes">
Outbound: <input type="checkbox" name="outbound" value="Yes">
</p>
<p>
<label for "customjs">Custom Javascript</label>
<input type="text" name="customjs" placeholder="/path/to/js.js">
</p>
<p>
<label for "customcss">Custom Javascript</label>
<input type="text" name="customcss" placeholder="/path/to/css.css">
</p>
</div>

<button id="save_config">Save Configuration</button>