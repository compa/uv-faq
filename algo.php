<html>
  <head>
    <script type="text/javascript" src="js/jsapi.js"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
		['Task', 'Hours per Day'],
		<?php
      $title = "";
			$data = $_GET["data"];

			$data = explode(";", $data);
			for ($i=0;$i<count($data);$i++)
			{
				$e =  explode("|", $data[$i]);
        if ($e[0] != "title"){
				  echo "['". $e[0]. "' , ".$e[1]."]";
				  if($i != count($data) -1 ){ echo ","; }
        }
        else{
          $title = $e[1];
        }
			}
		?>
        ]);

        var options = {
          title: '<?= $title; ?>',
          backgroundColor: '#f5f5f5',
          is3D: true,
          'width':700,
          'height':500};
        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
      }
    </script>
  </head>
  <body style="background-color:#f5f5f5; height:max-height:550px;">
    <div id="piechart_3d" style="margin:0 auto;width: 700px; height: 550px; background-color:#f5f5f5;"></div>
  </body>
</html>


