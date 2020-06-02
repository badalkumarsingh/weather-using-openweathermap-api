<!DOCTYPE html>
<html>

<head>
    <title>Weather</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./style.css">
    <style>

    </style>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script type="text/javascript">
        function geoFindMe() {
            function success(position) {
                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;
                document.getElementById("lat").value = latitude;
                document.getElementById("lon").value = longitude;
                //alert(a);
                /*AJAX*/

                /*Ennd AJAX*/
            }

            function error() {
                document.getElementById("err_msg").value = 'Unable to retrieve your location';
            }

            if (!navigator.geolocation) {
                document.getElementById("err_msg").value = 'Geolocation is not supported by your browser';
            } else {
                document.getElementById("err_msg").value = 'Locating…';
                navigator.geolocation.getCurrentPosition(success, error);
            }

        }
    </script>
</head>

<body onload="geoFindMe()">
    <?php
if(!empty($_GET['lat']) && !empty($_GET['lon'])) {
    $lat = $_GET['lat'];
    $lon = $_GET['lon'];
$api_key = 'YOUR_API_KEY';
$todays_weather = 'http://api.openweathermap.org/data/2.5/weather?lat='.$lat.'&lon='.$lon.'&appid='.$api_key;
$forecast = 'http://api.openweathermap.org/data/2.5/forecast/daily?lat='.$lat.'&lon='.$lon.'&cnt=7&appid='.$api_key;

$json_todays_weather=file_get_contents($todays_weather);
$json_forecast = file_get_contents($forecast);

$data=json_decode($json_todays_weather,true); //todays data
$data_forecast = json_decode($json_forecast, true); //forecat data

$temp = $data['main']['temp'];
$sunrise = $data['sys']['sunrise'];
$sunset = $data['sys']['sunset'];
?>

        
        <div class="card header-<?php echo $data['weather'][0]['main']; ?>">

            <h2>
                <?php echo $data['name'].', '.$data['sys']['country']?>
                <img id="img" src="http://openweathermap.org/img/w/<?php echo $data['weather'][0]['icon']?>.png" width="50px" height="50px">
            </h2>
            <h3>
                <?php echo $data['weather'][0]['main']?><span>Wind <?php echo $data['wind']['speed']?>km/h <span class="dot">•</span> Humidity
                <?php echo $data['main']['humidity']?>%</span><span><?php echo gmdate("l", $sunrise+19800); ?></span>
            </h3>
            <h1>
                <?php echo ((int)$temp-273.15) ?>°
            </h1>
            <table>
                <?php
                echo '<tr>';
                foreach($data_forecast['list'] as $item){
                    echo '<td>'.substr(gmdate("l", ((int)$item['dt']+19800)),0,3).'</td>';
                
                }
                echo '</tr><tr>';
                foreach($data_forecast['list'] as $item){
                    echo '<td>'.((int)$item['temp']['max']-273.15).'°</td>';
                    
                }
                echo '</tr><tr>';
                foreach($data_forecast['list'] as $item){
                        echo "<td><img src='http://openweathermap.org/img/w/".$item['weather'][0]['icon'].".png'></td>";
                }
                echo '</tr><tr>';
                foreach($data_forecast['list'] as $item){
                    echo '<td>'.((int)$item['temp']['min']-273.15).'°</td>';
                
                }
                echo '</tr>';
                ?>
                <!-- <tr>
                    <td colspan="6" align="center">
                        <h3>
                            <span>Sunrise <?php //echo gmdate("H:i", $sunrise+19800); ?> <span class="dot">•</span> Sunset
                            <?php //echo gmdate("H:i", $sunset+19800); ?>
                            </span>
                        </h3>
                    </td>
                </tr> -->
            </table>
        </div>

            <?php
        }
else{
   echo "<div class='card' style='background: url(bg3.jpg);background-size:cover;  color:wheat;'><div class='error'><h2>Weather Report</h2><h4>Using Openweathermap API</h4><form method='GET' action=''><input type='hidden' value='' id='lon' name='lon'><input type='hidden' value='' id='lat' name='lat'><input class='myButton' type='submit' value='Show Weather Report'><p id='err_msg'>Allow Location Access To See The Weather Report.</p></form></div></div>";
}
?>
            <script src="temp.js"></script>