<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>404 Not Found</title>
		<link href="http://cdnjs.cloudflare.com/ajax/libs/uikit/1.2.0/css/uikit.gradient.min.css" rel="stylesheet" type="text/css">
		<link href="style.css" rel="stylesheet" type="text/css">
	</head>

	<body>
		<div class="uk-container uk-container-center">
			<div class="uk-grid">
				<div id="navigation" class="uk-width-medium-1-4">
					&nbsp;
				</div>
				<div id="content" class="uk-width-medium-3-4">
					<h1 class="nav-header">Not Found</h1>
					<p>The requested URL <?=$_SERVER['REQUEST_URI'];?> was not found on this server.</p>
				</div>
			</div>
		</div>
	</body>
</html>
