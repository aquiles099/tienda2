<!doctype html>
<html>
	<head>
		<title></title>
		<meta name="charset" content="utf8" />
		<style>
			body{
				font: 12px Arial, Helvetica, sans-serif;
				background: #EEE;
				color: #333;
			}
			#content{
				background: #FFF;
				padding: 20px;
				box-sizing: border-box;
			}
			h1{ font-size: 20px; font-weight: bold; }
			table{ border-collapse: collapse; }
			td{ border: 1px solid #EEE; padding: 10px; margin: 0; }
			.carro .producto .thumb img{ max-height: 90px; }
			.carro .producto .detalles{ line-height: 2em; }
			.carro .producto .detalles .cantidad,
			.carro .producto .detalles .precio{ color: #999; }
			.carro .producto .detalles .precio .numero{ color: #900; font-size: 18px; }
			.carro .total{ font-size: 18px; text-align: right; }
			.carro .total .numero{ color: #900; }
			hr{
				border: 0;
				border-top: 1px solid #EEE;
				margin: 20px 0;
			}
		</style>
	</head>
	<body>
		<div id="content">
			<?php $this->load->view($body) ?>
		</div>
	</body>
</html>