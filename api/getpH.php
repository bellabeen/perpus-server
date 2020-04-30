<?php
include_once(__DIR__."/../../lib/tanah.php");
include_once(__DIR__."/../../lib/DataFormat.php");
header('Access-Control-Allow-Origin:*');
$format=new DataFormat();
$sensor = new Sensor();
$data=$sensor->getpH();
echo $format->asJSONpH($data);