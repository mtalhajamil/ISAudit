

<!DOCTYPE html>

<html>
<head>
	<title>Bar Chart</title>
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
  <script src="amcharts/serial.js" type="text/javascript"></script>
  <script src="amcharts/themes/light.js" type="text/javascript"></script>
  <script type="text/javascript">


  </script>
</head>
<body>
  <div class="panel panel-default">
    <div class="panel-heading">Report Open/Close Status
      [<a href="../logout.php">Logout</a>]
      [<a href="../profile.php">Profile</a>]
      [<a href="../reportView.php">Reports</a>]
      <img style="float:right;" src="../img/logo.png">
    </div>
    
    <a href="openCloseGraph.php" class="btn btn-success">Summary</a>
    <br />
    <br />
    <br />
    <div><img style="float:right;" src="chartOpenClosed.png"></div>
    <div id="chartdiv" style="width: 100%; height: 700px;"></div>
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
	
  var chartData1 = AmCharts.loadJSON('../chart1.php');


  var chart = AmCharts.makeChart("chartdiv", {
    "type": "serial",
    "theme": "light",
    "categoryField": "name",
    "rotate": true,
    "startDuration": 1,
    "categoryAxis": {
      "gridPosition": "start",
      "position": "left"
    },
    "trendLines": [],
    "graphs": [
    {
      "balloonText": "Open:[[value]]",
      "fillAlphas": 0.8,
      "id": "AmGraph-1",
      "lineAlpha": 0.2,
      "title": "Opened",
      "type": "column",
      "valueField": "opened"
    },
    {
      "balloonText": "Closed:[[value]]",
      "fillAlphas": 0.8,
      "id": "AmGraph-2",
      "lineAlpha": 0.2,
      "title": "Closed",
      "type": "column",
      "valueField": "closed"
    }
    ],
    "guides": [],
    "valueAxes": [
    {
      "id": "ValueAxis-1",
      "position": "top",
      "axisAlpha": 0
    }
    ],
    "allLabels": [],
    "balloon": {},
    "titles": [],
    "dataProvider": chartData1,
    "export": {
      "enabled": true
    }

  });

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
