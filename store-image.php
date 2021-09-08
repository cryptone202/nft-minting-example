<?php
	if ($_POST["imgBase64"] !== NULL && $_POST["hash"] !== NULL) {
		if (!file_exists("nfts/".$_POST["hash"].".png")) {
			$data = substr($_POST['imgBase64'], strpos($_POST['imgBase64'], ",") + 1);
			$decodedData = base64_decode($data);
			$fp = fopen("nfts/".$_POST["hash"].".png", 'wb');
			fwrite($fp, $decodedData);
			fclose($fp);
		}

		$eyes = ["Angry.png", "Cute.png", "Cyborg.png", "Dollar Sign.png", "Fire.png","Heart.png", "HODL.png", "Laser.png", "Sleeping.png"];
		$hats = ["Army Hat.png", "Btc.png", "Bucket.png", "Cap.png", "Chef Hat.png", "Eth.png", "Halo.png", "HODL.png", "Top hat.png"];
		
		$res = new \stdClass();
		$res->name = "Drippy Dolhpine " . $_POST["hash"];
		$res->description = "A lit dolphin";
		$res->image = "https://nullus.io/nfts/nfts/".$_POST["hash"].".png";
		$res->attributes = [ ["trait_type" => "eyes", "value" => $eyes[$_POST["hash"][0]]], ["trait_type" => "hat", "value" => $eyes[$_POST["hash"][1]]]];
		
		if (!file_exists("nfts/".$_POST["hash"])) {
			$fp = fopen("nfts/".$_POST["hash"], 'wb');
			fwrite($fp, json_encode($res, JSON_PRETTY_PRINT));
			fclose($fp);
		}
		
		die(json_encode($res, JSON_PRETTY_PRINT));
	}