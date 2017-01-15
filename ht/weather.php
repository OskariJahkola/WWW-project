<?php
//require_once("utils.php");
$mem = new Memcached();
$mem->addServer("127.0.0.1", 11211) or die("Unable to connect");

$result = $mem->get("weathercast");

// woeid code of Lappeenranta
$city = '568782';

if(!$result){
    $url = file_get_contents('http://weather.yahooapis.com/forecastrss?w=' . $city . '&u=c');
    $xml = simplexml_load_string($url);
    $xml->registerXPathNamespace('yweather', 'http://xml.weather.yahoo.com/ns/rss/1.0');
    $location = $xml->channel->xpath('yweather:location');
    if(!empty($location)){
        foreach($xml->channel->item as $item){
            $current = $item->xpath('yweather:condition');
            $forecast = $item->xpath('yweather:forecast');
            $current = $current[0];
            $nextday = $current + 1;
            $dayaftertomorrow = $nextday + 1;
            $output = <<<END
                <h1 style="margin-bottom: 0">Weather for {$location[0]['city']}, {$location[0]['region']}</h1>
                <small>{$current['date']}</small>
                <h2>Current Conditions</h2>
                <p>
                <span style="font-size:72px; font-weight:bold;">{$current['temp']}&deg;C</span>
                <br/>
                <img src="http://l.yimg.com/a/i/us/we/52/{$current['code']}.gif" style="vertical-align: middle;"/>&nbsp;
                {$current['text']}
                </p>
                <h2>Forecast</h2>
                {$forecast[$nextday]['day']} - {$forecast[$nextday]['text']}. High: {$forecast[$nextday]['high']} Low: {$forecast[$nextday]['low']}
                <br/>
                {$forecast[$dayaftertomorrow]['day']} - {$forecast[$dayaftertomorrow]['text']}. High: {$forecast[$dayaftertomorrow]['high']} Low: {$forecast[$dayaftertomorrow]['low']}
                </p>
END;
}
}
}else{
    $output = '<h1>No results found.</h1>';
}

$mem->set("weathercast", $output, 24*60*60);
$result = $mem->get("weathercast");
print "<hr><ul>";
print($output);
print "</ul><hr />";
?>
