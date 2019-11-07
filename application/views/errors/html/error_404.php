<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>404 Page Not Found</title>

<style type="text/css">

	::selection {
		background-color: #e13300;
		color: white;
	}

	::-moz-selection {
		background-color: #e13300;
		color: white;
	}


	html,body {
		padding: 0;
		margin: 0;
		height: 100%;
	}

	body {
		color: #363636;
		font-family: "Fira Sans";
	}

	.wrapper {
		display: flex;
		justify-content: center;
		align-items: center;
		flex-direction: column;
	}

	h1 {
		padding: 0;
		font-weight: 600;
		margin: 0;
		display: flex;
		justify-content: center;
		align-items: center;
		height: 100%;
		width: 100%;
		color: #fec500;
		font-size: 318px;
		text-align: center;
	}

	#container {
		height: 100%;
		display: flex;
		justify-content: center;
		align-items: center;
	}

	small {
		font-size: 18px;
		color: #242424;
	}

	.error_link{
    border-bottom: 1px dashed
		text-decoration: none;
    color: inherit;
    transition: color 0.5s ease;
	}
	.error_link:hover{
		color: #23527c;
	}

</style>
</head>
<body>

	<div id="container">
		<div class="wrapper">
			<h1 style="background: url('/<?=TEMPLATE_DIR?>/img/404Bg.jpg') no-repeat center; background-size: cover; -webkit-text-fill-color: transparent; -webkit-background-clip: text;">404</h1>
			<small>Страница не найдена. Перейдите на <a class="error_link" href="/">главную</a></small>
		</div>
	</div>
</body>
</html>
