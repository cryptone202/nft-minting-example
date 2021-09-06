<?php
$data = substr($_POST['imgBase64'], strpos($_POST['imgBase64'], ",") + 1);
$decodedData = base64_decode($data);
$fp = fopen("nfts/".$_POST["hash"].".png", 'wb');
fwrite($fp, $decodedData);
fclose();
?>