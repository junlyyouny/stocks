<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="臻益家-库存管理系统">
	<meta name="author" content="junly">
	<link rel="icon" href="/favicon.ico">
	<title><?php echo $title; ?></title>
	<!-- Bootstrap core CSS -->
	<link href="/css/bootstrap.min.css" rel="stylesheet">
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="http://cdn.bootcss.com/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container">
			<div class="navbar-header">
				<span class="navbar-brand" style="color: #f7f3f3;">臻益家-库存管理系统</span>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav navbar-right">
					<li>
						<a href="/">首页</a>
					</li>
					<li <?php if ($this->_action == 'storage') : ?> class="active"<?php endif;?> >
						<a href="/stocks/storage">入库</a>
					</li>
					<li <?php if ($this->_action == 'delivering') : ?> class="active"<?php endif;?> >
						<a href="/stocks/delivering">出库</a>
					</li>
					<li <?php if ($this->_action == 'stock') : ?> class="active"<?php endif;?> >
						<a href="/stocks/stock">库存</a>
					</li>
				</ul>
				<form class="navbar-form navbar-right">
					<input type="text" class="form-control" placeholder="Search..." />
				</form>
			</div>
		</div>
	</nav>