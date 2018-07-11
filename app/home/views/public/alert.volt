<link href="{{ static_url('css/bootstrap.min.css') }}" rel="stylesheet" />
<div id="alert-show" style="display:none;z-index: 9999; position: fixed ! important; 
left: {% if alert_left_size is defined%}{{ alert_left_size }}{% else %}50{% endif %}px; top: {% if alert_top_size is defined%}{{ alert_top_size }}{% else %}50{% endif %}px;">{{ flash.output() }}{{ flashSession.output() }}</div>
<script type="text/javascript">
(function(){
var alertShow = document.getElementById('alert-show');
if(alertShow.innerHTML){
	var alert = alertShow.firstChild;
	var alert_time = {% if alert_time is defined%}{{ alert_time }}{% else %}3{% endif %};
	if(alert.classList.contains('alert-success')){
		alert_time = {% if alert_time is defined%}{{ alert_time }}{% else %}1{% endif %};
	}else if(alert.classList.contains('alert-info')){
		alert_time = {% if alert_time is defined%}{{ alert_time }}{% else %}2{% endif %};
	}
	alertShow.style.display="block";
	var interval = setInterval(function(){
		if(--alert_time <= 0) {
			alertShow.style.display="none";
			clearInterval(interval);
		};
	}, 1000);
}
})();  
</script>
