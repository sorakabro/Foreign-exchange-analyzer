<?php

class Api {

    private $pswd = 'access_key=e742b9de0828824620d2e2fc923f49e0';

    public function getDataCurrency($date)
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://data.fixer.io/api/'.$date.'?'.$this->pswd.'',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);



        curl_close($curl);

       $responseRate = json_decode($response, true);

       return $responseRate;
    }

    public function getDataCurrencyOneMonthEarlier($date2)
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://data.fixer.io/api/'.$date2.'?'.$this->pswd.'',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);



        curl_close($curl);

        $responseRate = json_decode($response, true);

        return $responseRate;
    }
}