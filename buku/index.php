<?php
include_once(__DIR__."/../lib/tanah.php");
include_once(__DIR__."/../lib/DataFormat.php");
header('Access-Control-Allow-Origin:*');
$sensor = new Sensor();
$format=new DataFormat();

$getAll=$sensor->getAll();
$resultAll= isset($getAll['data']) ? $getAll['data'] : [];


$getFilter=$sensor->getAllFilter();
$resultFilter = isset($getFilter['data']) ? $getFilter['data'] : [];

$getWaktu=$sensor->getnData();
$resultWaktu = isset($getWaktu['data']) ? $getWaktu['data']: [];
?>
<html>
	<head>
		<title>Sistem Monitoring</title>
		<link rel="stylesheet" href="./include/css/style.css">
		<link rel="stylesheet" href="./include/css/bootstrap.css">
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
			<?php
				foreach($resultFilter as $result){
					$result['suhu'];
					$result['kelembapan_udara'];
					$result['kelembapan_tanah'];
					$result['ph'];
					$result['waktu'];
				}
			?>
			<div class="col-md-3">
				<table class="table table-bordered">
					<thead>
						<td><center><p class="tebel" style="margin-top:0px; margin-bottom:0px; font-size:18px">Suhu (&degC)</p></center></td>
					</thead>
					<tr class="success">
					<td><center><p class="tebel gede" style="margin-top:5px"><?php echo "$result[suhu]";?></p></center></td>
					</tr>
				</table>
			</div>
			<div class="col-md-3">
				<table class="table table-bordered">
					<thead>
						<td><center><p class="tebel" style="margin-top:0px; margin-bottom:0px; font-size:18px">Kelembapan Udara</p></center></td>
					</thead>
					<tr class="danger">
					<td><center><p class="tebel gede" style="margin-top:5px"><?php echo "$result[kelembapan_udara]";?></p></center></td>
					</tr>
				</table>
			</div>
			<div class="col-md-3">
				<table class="table table-bordered">
					<thead>
						<td><center><p class="tebel" style="margin-top:0px; margin-bottom:0px; font-size:18px">Kelembapan Tanah</p></center></td>
					</thead>
					<tr class="info">
					<td><center><p class="tebel gede" style="margin-top:5px"><?php echo "$result[kelembapan_tanah]";?></p></center></td>
					</tr>
				</table>
			</div>
			<div class="col-md-3">
				<table class="table table-bordered">
					<thead>
						<td><center><p class="tebel" style="margin-top:0px; margin-bottom:0px; font-size:18px">pH</p></center></td>
					</thead>
					<tr class="warning">
					<td><center><p class="tebel gede" style="margin-top:5px"><?php echo "$result[ph]";?></p></center></td>
					</tr>
				</table>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6 col-md-offset-4">
				<p class="tebel">Ringkasan Data:</p>
					<table class="table table-striped table-hover">
						<tr>
							<td>Last Update</td>
							<td>:</td>
							<td><?php echo "$result[waktu]";?></td>
						</tr>
						<tr>
							<td>Interval Update</td>
							<td>:</td>
							<td>2 Menit</td>
						</tr>
						<tr>
							<td>Jumlah Data</td>
							<td>:</td>
							<td>
							<?php echo $resultWaktu[0]['jumlah'];?>
							</td>
							
						</tr>
					</table>
			</div>
			
		</div>
    </div>
	</body>
	<!-- <?php include "master/footer.php" ?> -->
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<script type="text/javascript" src="./js/modules/data.js"></script>
	<script type="text/javascript" src="./js/modules/exporting.js"></script>
	<script type="text/javascript" src="./js/highcharts.js"></script>
	<script type="text/javascript" src="./js/bootstrap.js"></script>
	
</html>