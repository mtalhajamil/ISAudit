

<!DOCTYPE html>
<html>
<head>
	<title>Pie Chart</title>
  <link rel="shortcut icon" href="../favicon.ico" />

  <link rel="stylesheet" type="text/css" href="../css/app.css">
  <link rel="stylesheet" type="text/css" href="../css/bootstrap-datetimepicker.css">
  <link rel="stylesheet" type="text/css" href="../css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="../css/sb-admin2.css">
  <link rel="stylesheet" type="text/css" href="../css/selectionPage.css">
  <link rel="stylesheet" type="text/css" href="../css/sms.css">
  <link rel="stylesheet" type="text/css" href="../css/structure.css">
  <link rel="stylesheet" type="text/css" href="../css/design.css">

  <script src="amcharts/amcharts.js" type="text/javascript"></script>
  <script src="amcharts/pie.js" type="text/javascript"></script>
  <script src="amcharts/serial.js" type="text/javascript"></script>
  <script src="amcharts/themes/light.js" type="text/javascript"></script>
</head>
<body>
  <div class="panel panel-default">
    <div class="panel-heading">Summary of Open/Close Report
      [<a href="../logout.php">Logout</a>]
      [<a href="../profile.php">Profile</a>]
      [<a href="../reportView.php">Reports</a>]
      <img style="float:right;" src="../img/logo.png">
    </div>
    <br />
    <br />
    <br />
    <br />
    <div id="chartdiv" style="width: 100%; height: 500px;"></div>
  </div>
  <script>

   AmCharts.loadJSON = function(url) {
  // create the request
  if (window.XMLHttpRequest) {
    // IE7+, Firefox, Chrome, Opera, Safari
    var request = new XMLHttpRequest();
  } else {
    // code for IE6, IE5
    var request = new ActiveXObject('Microsoft.XMLHTTP');
  }

  // load it
  // the last "false" parameter ensures that our code will wait before the
  // data is loaded
  request.open('GET', url, false);
  request.send();

  // parse and return the output
  return eval(request.responseText);
};

AmCharts.ready(function() {

  var chartData1 = AmCharts.loadJSON('../chart2.php');

  var chart = AmCharts.makeChart("chartdiv", {
    "type": "pie",
    "startDuration": 0,
    "theme": "light",
    "addClassNames": true,
    "legend":{
      "position":"right",
      "marginRight":100,
      "autoMargins":false
    },
    "innerRadius": "30%",
    "defs": {
      "filter": [{
        "id": "shadow",
        "width": "200%",
        "height": "200%",
        "feOffset": {
          "result": "offOut",
          "in": "SourceAlpha",
          "dx": 0,
          "dy": 0
        },
        "feGaussianBlur": {
          "result": "blurOut",
          "in": "offOut",
          "stdDeviation": 5
        },
        "feBlend": {
          "in": "SourceGraphic",
          "in2": "blurOut",
          "mode": "normal"
        }
      }]
    },
    "dataProvider": chartData1,
    "valueField": "total",
    "titleField": "title",
    "export": {
      "enabled": true
    }
  });

  chart.addListener("init", handleInit);

  chart.addListener("rollOverSlice", function(e) {
    handleRollOver(e);
  });

  function handleInit(){
    chart.legend.addListener("rollOverItem", handleRollOver);
  }

  function handleRollOver(e){
    var wedge = e.dataItem.wedge.node;
    wedge.parentNode.appendChild(wedge);  
  }

$('a').each(function() {
   var $this = $(this);
   $this.html($this.text().replace('JS chart by amCharts', ' '));
});

});

</script>
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/moment.js"></script>
<script type="text/javascript" src="../js/bootstrap.min.js"></script>
<script type="text/javascript" src="../js/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="../js/util.js"></script>
<script type="text/javascript" src="../js/skel.min.js"></script>
</body>
</html>

<?php
include('../session.php');
?>