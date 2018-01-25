$yacth = "nemo2";
$itinerary = "A";
$part = "all";
$howMany = 15;
$url = "http://45.79.111.123/api.php?yacht=$yacth&itinerary=$itinerary&part=$part&howMany=$howMany";
$client = curl_init($url);
curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($client);
$result = json_decode($response, true);
