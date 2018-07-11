<!DOCTYPE html>
<html lang="zh-CN">
<head>
<link href="{{ static_url('css/bootstrap.min.css') }}" rel="stylesheet" />
</head>
<body>
	{{ flash.output() }}
	{{ flashSession.output() }}
</body>
</html>

