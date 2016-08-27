<?php
// Create connection
$users = array(
  1=>"69e17db7-cb18-dd7a-38cc-57bc120f3f18",
  2=>"c6d79eca-ed8c-f81e-161b-57bc12d9f75a",
  4=>"2f2f78d6-fd9e-4177-7e78-57bc12e9d683",
  5=>"8a71f840-686c-eaf7-3361-57bc12e90d5f",
  53=>"ea6756a3-d1a8-1ccb-4278-57bc12c31e50",
  57=>"51f24c52-9742-36e3-c2cb-57bc12ab424b",
  54=>"aa2ce641-9735-3c3d-b1bc-57bc128d2d5e",
  11=>"10e2ceb4-75c9-2750-53db-57bc1241f393",
  13=>"6aa0ebf7-27b5-6e59-134a-57bc12f2e989",
  14=>"c428c1cb-8eda-e1eb-5c5b-57bc124fee0b",
  29=>"381dbc4b-5197-f7ac-4580-57bc12bf85c4",
  30=>"99220457-8134-fd67-6504-57bc1209cb1a",
  55=>"f26f24b4-7208-a735-31f3-57bc12cdc0c9",
  56=>"5e1e75f2-1c41-e1ef-1894-57bc12453497",
  60=>"b5ea75e3-5963-e2c8-1969-57bc12ab027c",
  59=>"1900ac9e-7eea-2ff2-41ba-57bc12ef372d",
  61=>"730248ab-b844-5cf1-a85b-57bc127a7436",
  62=>"d13688e3-e615-b789-9755-57bc12fd74f2",
  63=>"3ce25248-a163-f67b-e9ca-57bc1271e54e",
  64=>"9acb27a9-14a9-b99a-d254-57bc12117f55",
  65=>"7a1c0c55-4fdf-22c5-b86c-57bc12da1784",
  66=>"63c24f95-9c7f-156c-8c12-57bc126358e3",
  67=>"bdc7f8d8-8d82-37d5-1ea2-57bc1274ebdc",
  68=>"6327f577-0b40-ed27-8f85-57bc12c60761",
  69=>"c0d8783c-fccc-8000-adc2-57bc12c9e5b7",
  70=>"284974c1-78bf-ed03-562a-57bc12581625",
  71=>"8832a6ee-b068-ec24-52f9-57bc1225e3b6",
  72=>"e515c090-b13b-aac2-dfeb-57bc12391703",
  73=>"49b7fe69-55d9-7815-d7d6-57bc12fffa38",
  74=>"a4b59ed2-b7bb-38e2-55e0-57bc12742754",
  75=>"94b60886-96e6-11aa-5d85-57bc129195bd",
  76=>"691ff0d7-1f4f-8767-4d0e-57bc12868e74",
  77=>"ca06abfc-784a-1da6-147d-57bc121212de",
  78=>"38ffa1ff-ff94-e45f-2dae-57bc12080ebb",
  79=>"9844ff1f-a847-e692-ad26-57bc12444d87",
  80=>"24cf0712-8bb8-9817-3a11-57bc129fafd5",
  81=>"62cabf8b-ad4e-9d5b-e246-57bc120b731d",
  82=>"bf047f53-0bb7-327f-de88-57bc12985223",
  83=>"2430edbb-c99e-a082-8ed9-57bc12da950a",
  84=>"7ec6ef1c-7ca1-7417-381d-57bc1252bb54",
  85=>"de0cd042-40a6-8fe0-afd6-57bc125e88fa",
  86=>"4bf0cff9-bad0-6e64-8134-57bc1299f26a",
  87=>"aba6be68-8b46-c66f-d2c0-57bc127cc408",
  88=>"15020395-ffe9-b379-01ae-57bc1277acea",
  89=>"71959c94-4922-59ae-839a-57bc1200f81b",
  90=>"cbdcdb56-027f-1340-33ee-57bc124f273a",
  91=>"37a2c074-b38c-31be-96c6-57bc128dc2b2",
  93=>"94c86965-2ee4-812a-2739-57bc12f075f5",
  94=>"f1249da9-9958-1a2b-957c-57bc121dd283"
);
$conn = new mysqli("127.0.0.1", "root", "stusWeW2", "impulsa");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "ALTER TABLE `impulsa`.`usuarios` CHANGE COLUMN `created` `created` datetime DEFAULT NULL, CHANGE COLUMN `modified` `modified` datetime DEFAULT NULL;";
var_dump($sql);
$result = $conn->query($sql);
var_dump($conn->error);exit();
$sql = "ALTER TABLE usuarios ADD COLUMN sugar_uuid varchar(36) AFTER modified";
var_dump($sql);
$result = $conn->query($sql);
var_dump($conn->error);exit();
foreach ($users as $key => $uuid) {
  $sql = "UPDATE  'impulsa'.'usuarios' SET 'sugar_uuid' = ".$uuid ." where id =" . $key;
  var_dump($sql);
  $result = $conn->query($sql);
  var_dump($result);
}
$conn->close();
?>
