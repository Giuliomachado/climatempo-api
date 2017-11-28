<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'resources/header.html';

/*-----------------------------*/

require '../src/Climatempo.php';
require '../src/Wrapper.php';
require '../src/Forecast.php';
require '../src/FifteenDays.php';
require '../src/Search.php';
require '../src/City.php';

use AdinanCenci\Climatempo\Search;

/*-----------------------------*/

$search = new Search('belo horizonte');
$bh     = $search->find()[0];
$token  = 'insert-your-token-here';

/*-----------------------------*/

echo "
<p>
    Here is the forecast for the citiy of $bh->name - $bh->state
</p>";

$forecast = $bh->fifteenDays($token);

?>

<table>
    <tr>
        <th>Date</th>
        <th title="Lower temperature">Low</th>
        <th title="Higher temperature">Hight</th>
        <th title="Probability of precipitation">Pop</th>
        <th title="Precipitation">MM</th>
        <th>Icon</th>
        <th>Phrase</th>
    </tr>
    <?php

    foreach ($forecast->days as $day) {
        echo "
        <tr>
            <td> $day->dateBr </td>                
            <td> $day->minTemp °C </td>
            <td> $day->maxTemp °C </td>
            <td> $day->pop % </td>
            <td> $day->mm mm </td>
            <td> 
                <img width=\"50\" src=\"resources/images/$day->dawnIcon.png\" />
                <img width=\"50\" src=\"resources/images/$day->morningIcon.png\" />
                <img width=\"50\" src=\"resources/images/$day->dayIcon.png\" />
                <img width=\"50\" src=\"resources/images/$day->afternoonIcon.png\" />
                <img width=\"50\" src=\"resources/images/$day->nightIcon.png\" /> 
            </td>
            <td> $day->textPt </td>
        </tr>"; 
    }?>
</table>

