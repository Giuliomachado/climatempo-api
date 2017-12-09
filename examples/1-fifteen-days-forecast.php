<?php
require 'resources/header.html';


error_reporting(E_ALL);
ini_set('display_errors', 1);

/*-----------------------------*/

require '../src/Climatempo.php';
require '../src/Wrapper.php';
require '../src/Forecast.php';
require '../src/FifteenDays.php';

use AdinanCenci\Climatempo\Climatempo;

/*-----------------------------*/

$token      = 'insert-your-token-here';
$climatempo = new Climatempo($token);

$id         = 3477; // São Paulo - SP

try {
    $forecast = $climatempo->fifteenDays($id);
} catch (Exception $e) {
    echo '<b>Error: </b>'.$e->getMessage();
    die();
}

echo 
"<h2>$forecast->name / $forecast->state - $forecast->country</h2>";


foreach ($forecast->data as $day) {
    echo 
    "<table class=\"forecast\">
        <caption>
            $day->date - $day->textPt - $day->dateBr (Timestamp: $day->timestamp)
        </caption>
        <thead>
            <tr>
                <th>Resume</th>
                <th>Humidity</th>
                <th>Rain</th>
                <th>Wind</th>
                <th>UV</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td rowspan=\"3\" class=\"resume\">
                    <img src=\"resources/images/$day->dayIcon.png\" /> <br>

                    <b class=\"temp-min\">$day->minTemperature °C</b> - 
                    <b class=\"temp-max\">$day->maxTemperature °C</b> <br>
                    <br>
                    Thermal Sensation <br>
                    <br>
                    <b class=\"temp-min\">$day->minThermalSensation °C</b> - 
                    <b class=\"temp-max\">$day->maxThermalSensation °C</b> <br>
                    
                    $day->resume
                </td>
                <td>
                    Min: $day->minHumidity% <br>
                    Max: $day->maxHumidity%
                </td>
                <td>
                    ".($day->probabilityOfPrecipitation ? 'Prob.: '.$day->probabilityOfPrecipitation.'% <br>' : '')."
                    ".($day->precipitation ? 'Prec.: '.$day->precipitation.'mm' : '')."
                </td>
                <td>
                    Min: $day->minWindVelocity km/h <br>
                    Max: $day->maxWindVelocity km/h <br>
                    Avg: $day->avgWindVelocity km/h <br>
                    Gust max: $day->maxGustVelocity km/h <br>
                    Direction: $day->windDirectionDegree ° ( $day->windDirection ) <br>
                </td>
                <td>
                    ".( $day->uvMax ? $day->uvMax : '' )."
                </td> 
            </tr>
            <tr>
                <th>Dawn</th>
                <th>Morning</th>
                <th>Afternoon</th>
                <th>Night</th>
            </tr>
            <tr>
                <td>
                    <img src=\"resources/images/$day->dawnIcon.png\" /> <br>
                    $day->dawnText
                </td>
                <td>
                    <img src=\"resources/images/$day->morningIcon.png\" /> <br>
                    
                    <b class=\"temp-min\">$day->minMorningTemperature °C</b> - 
                    <b class=\"temp-max\">$day->maxMorningTemperature °C</b> <br>

                    $day->morningText
                </td>
                <td>
                    <img src=\"resources/images/$day->afternoonIcon.png\" /> <br>

                    <b class=\"temp-min\">$day->minAfternoonTemperature °C</b> - 
                    <b class=\"temp-max\">$day->maxAfternoonTemperature °C</b> <br>

                    $day->afternoonText
                </td>
                <td>
                    <img src=\"resources/images/$day->nightIcon.png\" /> <br>

                    <b class=\"temp-min\">$day->minNightTemperature °C</b> - 
                    <b class=\"temp-max\">$day->maxNightTemperature °C</b> <br>

                    $day->nightText
                </td>
            </tr>
        </tbody>
    </table>";
}

require 'resources/footer.html';