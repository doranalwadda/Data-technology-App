<?php
 
  

 $link = mysqli_connect("localhost","root", "");
  $link2= mysqli_select_db($link, "interviewdb");
$test = array();
$count = 0;
 $res = mysqli_query($link, "select * from app_usage GROUP BY Device_Name ");
//$res = mysqli_query($link,"select * from app_usage")or die(mysqli_error());

while($row = mysqli_fetch_array($res))
{
$test[$count]["label"]= $row["Device_Name"];
$test[$count]["y"] = (int)$row["Duration"];

$count=$count+1;
}

?>
<!DOCTYPE HTML>
<html>
<head>
<script>
window.onload = function() {
 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	theme: "light2",
	title:{
		text: "Table showing the Duration of App Usage against Device"
	},
	axisY: {
		title: "Duration"
	},
    axisX: {
		title: "Device Name"
	},
	data: [{
		type: "line",
		yValueFormatString: "#,##0.## hours",
		dataPoints: <?php echo json_encode($test, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
 
}
</script>
</head>
<body>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<div id="chartContainer1" style="height: 370px; width: 100%;"></div>
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
</body>
</html>  