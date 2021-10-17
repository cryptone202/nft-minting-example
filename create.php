<?php
require 'vendor/autoload.php';

use Gregwar\Image\Image;

$typeArr = array(
	"Alien Gull" => [0, 3],
	"Ape Gull" => [3, 7],
	"Blue Gull" => [7, 17],
	"Golden Gull" => [17, 18],
	"Green Gull" => [18, 28],
	"Gull" => [28, 83],
	"Pink Gull" => [83, 93],
	"Steel Gull" => [93, 95],
	"Zombie Gull" => [95, 100]
);

$accessoryArr = array(
	"007" => [0, 1.85],
	"Banana" => [1.85, 3.35],
	"Black Bandana" => [3.35, 6.8],
	"Ciggarette" => [6.8, 9.7],
	"Covid" => [9.7, 12.4],
	"Fries Lover" => [12.4, 14.6],
	"Gangsta" => [14.6, 19.35],
	"Gentleman" => [19.35, 22.65],
	"Guiltless" => [22.65, 24.35],
	"Hawaiian Mood" => [24.35, 27.35],
	"Lifebuoy" => [27.35, 30.5],
	"Pink Pendant" => [30.5, 35.1],
	"Red Bandana" => [35.1, 38.55],
	"Reporter" => [38.55, 43.05],
	"Rich Gentleman" => [43.05, 46.3],
	"Riddle Solver" => [46.3, 48.7],
	"Scarf" => [48.7, 53.25],
	"True Elegant" => [53.25, 55.85],
	"Wizard Gem" => [55.85, 58.35],
	"None" => [58.35, 100]
);

$eyesArr = array(
	"3D Glasses" => [0, 4.1],
	"CSI Glasses" => [4.1, 9.45],
	"Climber Glasses" => [9.45, 14.55],
	"CyberPunk" => [14.55, 17.95],
	"Extermination" => [17.95, 20.35],
	"Fashionista" => [20.35, 24.6],
	"Gimmie Your Wallet" => [24.6, 27.4],
	"Joker" => [27.4, 30], "Nerd" => [30, 35.2],
	"Night Vision" => [35.2, 40.2],
	"Over 9000" => [40.2, 42],
	"Romantic" => [42, 45],
	"Sad Boi" => [45, 47.9],
	"Scar" => [47.9, 51.1],
	"Snorkeling Mask" => [51.1, 56.5],
	"Special Agent Glasses" => [56.5, 61.75],
	"Strength Mark" => [61.75, 65.25],
	"Swimming Goggles" => [65.25, 70.65],
	"True Fashionista" => [70.65, 74.9],
	"Wisdom Mark" => [74.9, 78.9],
	"None" => [78.9, 100]
);

$hatArr = array(
	"Angel" => [0, 2],
	"Bad Trip" => [2, 3.4],
	"Beret" => [3.4, 6.9],
	"Black Baseball Cap" => [6.9, 10.15],
	"Blue Baseball Cap" => [10.15, 13.4],
	"Blue Beanie" => [13.4, 16.75],
	"Buccaneer" => [16.75, 19.45],
	"Burger King" => [19.45, 21.6],
	"Candlestick" => [21.6, 24.05],
	"Catch Em All" => [24.05, 25.8],
	"Cowboy" => [25.8, 29.4],
	"Deckhand" => [29.4, 32.2],
	"Devil" => [32.3, 34.15],
	"Franchise King" => [34.15, 35.25],
	"General" => [35.25, 36.9],
	"Good Trip" => [36.9, 38.4],
	"Green Headphones" => [38.4, 41.85],
	"Imperator" => [41.85, 43.55],
	"Jester" => [43.55, 46.25],
	"King Bong" => [46.25, 48.6],
	"McDonalds Employee" => [48.6, 51.55],
	"Pharaoh" => [51.55, 52.55],
	"Police Officer" => [52.55, 55.65],
	"Purple Baseball Cap" => [55.65, 58.9],
	"Red Beanie" => [58.9, 62.25],
	"Red Headphones" => [62.25, 65.65],
	"Rice Collector" => [65.65, 68.3],
	"Ross Afro" => [68.3, 71.3],
	"Sad Past" => [71.3, 73.1],
	"Sanchez" => [73.1, 74.95],
	"Thief Cap" => [74.95, 78.45],
	"To The Moon" => [78.45, 79.25],
	"Viking" => [79.25, 82.75],
	"Zombie" => [82.75, 83.65],
	"None" => [83.65, 100]
);
$eyesPerc = rand(1, 999) / 10;
$typePerc = rand(1, 999) / 10;
$accessoryPerc = rand(1, 999) / 10;
$hatPerc = rand(1, 999) / 10;
$type = "";
$eyes = "";
$accessory = "";
$hat = "";
$hash = ""; // tmp

foreach ($typeArr as $x => $y) {
	if ($typePerc >= $y[0] && $typePerc < $y[1]) {
		$type = $x;
		$hash = $hash . sprintf("%02d", array_search($type, array_keys($typeArr)));
		break;
	}
}
foreach ($accessoryArr as $x => $y) {
	if ($accessoryPerc >= $y[0] && $accessoryPerc < $y[1]) {
		$accessory = $x;
		$hash = $hash . sprintf("%02d", array_search($accessory, array_keys($accessoryArr)));
		break;
	}
}
foreach ($eyesArr as $x => $y) {
	if ($eyesPerc >= $y[0] && $eyesPerc < $y[1]) {
		$eyes = $x;
		$hash = $hash . sprintf("%02d", array_search($eyes, array_keys($eyesArr)));
		break;
	}
}
foreach ($hatArr as $x => $y) {
	if ($hatPerc >= $y[0] && $hatPerc < $y[1]) {
		$hat = $x;
		$hash = $hash . sprintf("%02d", array_search($hat, array_keys($hatArr)));
		break;
	}
}


$hash = addslashes($_POST["supply"]);
$roll = $typePerc . "  " . $accessoryPerc . "  " . $eyesPerc . "  " . $hatPerc;
$attributes = [
	["Unique Hash" => $hash],
	["Type" => $type],
	["Accessory" => $accessory],
	["Eyes" => $eyes],
	["Hat" => $hat],
	["Roll" => $roll]
];

$metadata = array(
	"Name" => "CryptoGull #" . $hash,
	"Description" => "CryptoGulls is an example NFT project.",
	"image" => "https://darklight.xyz/meta/" . $hash . ".png",
	"external_url" => "https://darklight.xyz/",
	"attributes" => [
		[
			"trait_type" => "Type",
			"value" => $type,
		],
		[
			"trait_type" => "Accessory",
			"value" => $accessory,
		],
		[
			"trait_type" => "Eyes",
			"value" => $eyes,
		],
		[
			"trait_type" => "Hat",
			"value" => $hat,
		],
		[
			"trait_type" => "Roll",
			"value" => $roll,
		]
	]
);

if (!file_exists("meta/" . $hash . ".png")) {
	Image::open('layers/Background/Background.png')
		->merge(Image::open('layers/Type/' . $type . '.png'))
		->merge(Image::open('layers/Accessory/' . $accessory . '.png'))
		->merge(Image::open('layers/Eyes/' . $eyes . '.png'))
		->merge(Image::open('layers/Hat/' . $hat . '.png'))
		->save("meta/" . $hash . ".png", 'png');

	// Add our metadata
	$fp = fopen("meta/" . $hash, 'wb');
	fwrite($fp, json_encode($metadata, JSON_PRETTY_PRINT));
	fclose($fp);
}

$res = new StdClass();
$res->url = "meta/" . $hash . ".png";
$res->attributes = $attributes;

die(json_encode($res, JSON_PRETTY_PRINT));