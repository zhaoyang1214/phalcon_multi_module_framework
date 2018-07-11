<!DOCTYPE html>
<html>
    <head>
     <title>test</title>
     <link href="{{ static_url('css/bootstrap.min.css') }}" rel="stylesheet" />
    </head>
    <body>
	<a href="{{url1}}">跳转到url/test1</a><br/>
	<a href="{{url('url/test2')}}">跳转到url/test2</a><br/>
    </body>
</html>