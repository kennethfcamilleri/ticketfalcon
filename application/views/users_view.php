<!DOCTYPE html>
<html>
<head>
	<title>User View Testing</title>
</head>
<body>

	<h1>This is the Users View</h1>

	<h2>
	<?php
		foreach ($result as $obj) {
			echo $obj->first_name . "<br>";
		}
	?>
	</h2>
</body>
</html>