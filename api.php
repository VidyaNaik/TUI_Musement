<?php
$curl = curl_init(); // initiating cURL
curl_setopt($curl, CURLOPT_URL, "https://api.musement.com/api/v3/cities"); // setting request URL for Cities
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // settings for cURL
$output = curl_exec($curl); // executing cURL 
$output = json_decode($output); // decoding the JSON response
curl_close($curl); // closing cURL
if(is_array($output) || is_object($output)){ // checking is the response is array or object ----- this is optional
    foreach ($output as $city) { // looping cities api response
        $curltwo = curl_init(); // initiating 2nd cURL for another api call for weather
        curl_setopt($curltwo, CURLOPT_URL, "https://api.weatherapi.com/v1/forecast.json?key=a7bb5a447ea84efc986162443210111&q={$city->latitude},{$city->longitude}&days=2"); // calling weather api in loop by passing lat and log from the cities api response by concatinating
        curl_setopt($curltwo, CURLOPT_RETURNTRANSFER, 1); // settings for cURL
        $outputtwo = curl_exec($curltwo); // executing cURL 
        $outputtwo = json_decode($outputtwo); // decoding the JSON response
        print_r("Processed city {$city->code} | {$outputtwo->current->condition->text} - {$outputtwo->forecast->forecastday[0]->day->condition->text}\n"); // printing the values
        // $city->code is city name from cities API response
        // $outputtwo->current->condition->text =======> is day one weather
        // $outputtwo->forecast->forecastday[0]->day->condition->text =======> is day two weather from forecastday array
    }
}
curl_close($curltwo); // closing 2nd cURL