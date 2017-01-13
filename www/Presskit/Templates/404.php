<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>404 Not Found</title>
		<link href="//cdnjs.cloudflare.com/ajax/libs/uikit/1.2.0/css/uikit.gradient.min.css" rel="stylesheet" type="text/css">
		<link href="style.css" rel="stylesheet" type="text/css">
	</head>

	<body>
		<div class="uk-container uk-container-center">
			<div class="uk-grid">
				<div id="navigation" class="uk-width-medium-1-4">
					<h1 class="nav-header">Press Kit</h1>
				</div>
				<div id="content" class="uk-width-medium-3-4">
					<h1 class="nav-header">Not Found</h1>

					<p>The requested URL <?=$_SERVER['REQUEST_URI'];?> was not found on this server.</p>
					<p>Try to go back to <a href="./">Press Kit main page</a>.</p>
					<p>&nbsp;</p>

					<?php if (isset($errorMessages) && count($errorMessages) > 0): ?>
					<hr />
					<?php foreach($errorMessages as $msg): ?>
						<p><?=$msg?></p>
					<?php endforeach; ?>
					<?php endif; ?>
				</div>
			</div>

			<hr/>
			<p><a href="http://dopresskit.com/">presskit()</a> by Rami Ismail (<a href="http://www.vlambeer.com/">Vlambeer</a>)
					- also thanks to <a href="<?=  \Presskit\Helpers::url('/?p=', '/').\Presskit\Request::REQUEST_CREDITS_PAGE;?>">these fine folks</a>.</p>
		</div>
	</body>
</html>
