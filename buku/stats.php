<?php
include_once(__DIR__."/../lib/tanah.php");
include_once(__DIR__."/../lib/DataFormat.php");
header('Access-Control-Allow-Origin:*');
$sensor = new Sensor();
$format=new DataFormat();
?>
<html>
	<head>
		<title>Monitoring Suhu GGP</title>
		<link rel="stylesheet" href="./include/css/style.css">
		<link rel="stylesheet" href="./include/css/bootstrap.css">
		<link rel="stylesheet" href="./include/js/bootstrap.js">
		<link rel="stylesheet" href="./include/js/highchart.css">
		<link rel="stylesheet" href="./include/js/Chart.css">
	</head>
	<body>
	<?php include "master/header.php" ?>
	<br>
			<div class="row">
				<div class="col-md-2 col-md-offset-2">
					<div class="panel panel-primary">
  						<div class="panel-heading">
    					<h3 class="panel-title tengah">Log</h3>
  						</div>
  						<div class="panel-body" style="padding:0px;">
						  <?php include "master/side-menu.php" ?>
  					</div>
				</div>
			</div>

			<!-- <form method="get">
			<label>PILIH TANGGAL</label>
			<input type="date" name="tanggal">
			<input type="submit" value="FILTER">
		</form> -->
		<form method="get">
			<label>PILIH TANGGAL AWAL</label>
			<input type="date" name="tanggalawal">
			<label>PILIH TANGGAL AKHIR</label>
			<input type="date" name="tanggalakhir">
			<input type="submit" value="SUBMIT" >
		</form>

			<div class="col-md-6">
				<div id="container1"></div>
				<div id="container2"></div>
				<div id="container3"></div>
				<div id="container4"></div>
			</div>
		</div>
	</body>
</html>

		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<script type="text/javascript" src="./include/js/modules/data.js"></script>
		<script type="text/javascript" src="./include/js/modules/exporting.js"></script>
		<script type="text/javascript" src="./include/js/highcharts.js"></script>
		<script type="text/javascript" src="./include/js/bootstrap.js"></script>
		<script type="text/javascript" src="./include/js/Chart.js"></script>
		<script type="text/javascript" src="./include/js/Chart.bundle.js"></script>
		<script src="https://code.highcharts.com/stock/highstock.js"></script>
		<script src="https://code.highcharts.com/stock/modules/data.js"></script>
		<script src="https://code.highcharts.com/stock/modules/exporting.js"></script>
		<script src="https://code.highcharts.com/stock/modules/export-data.js"></script>

		<?php
		if(isset($_GET['tanggalawal']) AND isset($_GET['tanggalakhir'])){
			$tglawal = $_GET['tanggalawal'];
			$tglakhir = $_GET['tanggalakhir'];
			$getAllWaktu=$sensor->getAllWaktu($tglawal,$tglakhir);
			$resultAll = isset($getAllWaktu['data']) ? $getAllWaktu['data'] : [];
			// echo var_dump($resultAll);
		} else{
			$getAll=$sensor->getAll();
			$resultAll= isset($getAll['data']) ? $getAll['data'] : [];
			// echo var_dump($resultAll);	
		}
		

		$data_suhu = array();
		$data_kelembapanudara = array();
		$data_kelembapantanah = array();
		$data_ph = array();
		foreach($resultAll as $result){

			array_push($data_suhu, array(strtotime($result['waktu']) * 1000,(float) $result['suhu']));
			array_push($data_kelembapanudara, array(strtotime($result['waktu']) * 1000, (float) $result['kelembapan_udara']));
			array_push($data_kelembapantanah, array(strtotime($result['waktu']) * 1000, (float) $result['kelembapan_tanah']));
			array_push($data_ph, array(strtotime($result['waktu']) * 1000, (float) $result['ph']));

		}
		// die (json_encode($data_suhu));
		?>

				<script>
					var chart = new Highcharts.Chart({
						chart: {
							renderTo: 'container1'
						},
						title: {
								text: 'Grafik Data Suhu'
							},
		
						xAxis: {
							title: {
							enabled: true,
							// text: 'Hours of the Day'
							},
							type: 'datetime',
							showFirstLabel:true,
							showLastLabel:true,
							// min:Date.UTC(2020,1,25),
							// pointInterval: 900 * 1000,
							pointStart:Date.UTC(2020,1,25,),
							dateTimeLabelFormats : {
								hour: '%I %p',
								minute: '%I:%M %p'
								}
						},
						series: [{
							
							
						 	// pointStart:Date.UTC(2020,1,25,), 
							data: 
								<?php echo json_encode($data_suhu);?>
						}]
				});
				</script>


				<script>
					var chart = new Highcharts.Chart({
						chart: {
							renderTo: 'container2'
						},
						title: {
								text: 'Grafik Data Kelembapan Udara'
							},
		
						xAxis: {
							title: {
							enabled: true,
							// text: 'Hours of the Day'
							},
							type: 'datetime',
							showFirstLabel:true,
							showLastLabel:true,
							// min:Date.UTC(2020,1,25),
							// pointInterval: 900 * 1000,
							pointStart:Date.UTC(2020,1,25,),
							dateTimeLabelFormats : {
								hour: '%I %p',
								minute: '%I:%M %p'
								}
						},
						series: [{
							
							
						 	// pointStart:Date.UTC(2020,1,25,), 
							data: 
								<?php echo json_encode($data_kelembapanudara);?>
						}]
				});
				</script>

				<script>
					var chart = new Highcharts.Chart({
						chart: {
							renderTo: 'container3'
						},
						title: {
								text: 'Grafik Data Kelembapan Tanah'
							},
		
						xAxis: {
							title: {
							enabled: true,
							// text: 'Hours of the Day'
							},
							type: 'datetime',
							showFirstLabel:true,
							showLastLabel:true,
							// min:Date.UTC(2020,1,25),
							// pointInterval: 900 * 1000,
							pointStart:Date.UTC(2020,1,25,),
							dateTimeLabelFormats : {
								hour: '%I %p',
								minute: '%I:%M %p'
								}
						},
						series: [{
							
							
						 	// pointStart:Date.UTC(2020,1,25,), 
							data: 
								<?php echo json_encode($data_kelembapantanah);?>
						}]
				});
				</script>

					<script>
					var chart = new Highcharts.Chart({
						chart: {
							renderTo: 'container4'
						},
						title: {
								text: 'Grafik Data pH'
							},
		
						xAxis: {
							title: {
							enabled: true,
							// text: 'Hours of the Day'
							},
							type: 'datetime',
							showFirstLabel:true,
							showLastLabel:true,
							// min:Date.UTC(2020,1,25),
							// pointInterval: 900 * 1000,
							pointStart:Date.UTC(2020,1,25,),
							dateTimeLabelFormats : {
								hour: '%I %p',
								minute: '%I:%M %p'
								}
						},
						series: [{
						
						 	// pointStart:Date.UTC(2020,1,25,), 
							data: 
								<?php echo json_encode($data_ph);?>
						}]
				});
				</script>