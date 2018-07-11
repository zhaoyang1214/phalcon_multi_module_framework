<!DOCTYPE html>
<html lang="zh-CN">
<head>
</head>
<body>

<h2>登录</h2>
<form action="{{ url('security/login') }}" method="post">
用户名：<input type="text" name="username" ><br>
密&nbsp;&nbsp;&nbsp;码：<input type="password" name="password"><br>
<input type="hidden" name="{{security.getTokenKey()}}"  value="{{security.getToken()}}">
<input type="submit" value="登录">
</form>
</body>
{{ partial('public/alert', ["alert_left_size" : 100, "alert_top_size" : 100]) }}
{# {{ partial('public/alert', ["alert_left_size" : 100, "alert_top_size" : 100, "alert_time":2]) }} #}
</html>

