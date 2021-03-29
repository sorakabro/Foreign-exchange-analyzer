<?php

include "classes/api-request-class.php";

$date = $_GET['date-input'];


if(empty($date)){
    date_default_timezone_set("Europe/Stockholm");
    $date = date('Y-m-d');
}

$api = new Api();
$data = $api->getDataCurrency($date);

// Go 30 days back

$date2 = date('Y-m-d', strtotime($date.'-30 days'));

// Go 30 days back api request
$dataOneMonthEarlier = $api->getDataCurrencyOneMonthEarlier($date2);

$dateCurrencyOneMonthEarlier = $dataOneMonthEarlier['date'];

$ratesOneMonthEarlier = $dataOneMonthEarlier['rates'];

$dateCurrency = $data['date'];

$rates = $data['rates'];

echo '<h2>Foreign exchange analyzer</h2>

<form action="">
  <label for="date">DATE</label><br>
  <input type="text" id="date-input" name="date-input" placeholder="yyyy-mm-dd"><br>
  <input type="submit" name="Submit">
</form> ';


// Find the values with the keys and combine it into an array
$rates = array_intersect_key($rates, $ratesOneMonthEarlier);

$ratesOneMonthEarlier = array_intersect_key($ratesOneMonthEarlier, $rates);

$rateCompare=array_merge_recursive($rates,$ratesOneMonthEarlier);

?>

<head>
    <link rel="stylesheet" href="includes/style.css">
</head>
        <?php

// Currency table input date
echo '<div class="row">
  <div class="column">';
echo ' <h4>Date: '.$dateCurrencyOneMonthEarlier.' </h4>';
echo ' <table>
         <tr>
            <th>Country</th>
            <th>Currency</th>
         </tr>';
foreach($rates as $country=>$currency){
    echo '<pre>';
    echo '</pre>';
    echo '<tr>';
    echo '<td>'.$country.'</td>';
    echo '<td>'.$currency.'</td>';
    echo '</tr>';
}
echo ' 
      </table> </div>';

echo '<div class="column">';
echo ' <h4>Date: '.$dateCurrency.' </h4>';
echo ' <table>
         <tr>
            <th>Country</th>
            <th>Currency</th>
         </tr>';
foreach($ratesOneMonthEarlier as $country=>$currency){
    echo '<pre>';
    echo '</pre>';
    echo '<tr>';
    echo '<td>'.$country.'</td>';
    echo '<td>'.$currency.'</td>';
    echo '</tr>';
}
echo ' 
      </table> 
      </div>';

echo '<div class="column">';
echo ' <h4>Currency Difference</h4>';
echo ' <table>
         <tr>
            <th>Procent difference currency</th>
            <th></th>
         </tr>';

foreach($rateCompare as $country=>$currency) {

    // Get the currency for the two dates
    $date1 = $currency[0];
    $date2 = $currency[1];

    // Calculate the percentage between the two dates
    $percentage = (($date2 - $date1) / $date1) * 100;
    $percentageDecimals[] = round($percentage, 3);
    $countryArray[] = $country;
    $countryPercentageData = array_combine($countryArray, $percentageDecimals);
}

// Sort Descending
arsort($countryPercentageData);

foreach($countryPercentageData as $country=>$currency) {
    echo '<pre>';
    echo '</pre>';
    echo '<tr>';
    echo '<td>' . $country . '</td>';
    echo '<td>' . $currency . '%</td>';
    echo '</tr>';
}
echo ' 
      </table> 
      </div>
      </div>';
