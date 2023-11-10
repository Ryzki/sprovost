<?php

namespace App\Http\Integration;

use Illuminate\Http\Request;

class YanduanIntegration
{
    protected $accessKey = 'TThrauE38AOMq4rJKghhOi1BqOpAzyPiAgJQWdvyjlliiMAcdfqJkKo8x';
    protected $secretKey = '02F0v4CFdNKGEFFxFckzKYQ9JlxSCPVPlcCoXOOwYzyBeV5ziF1U';

    function callCurl($url, $body, $header, $method){
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
        ));

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        $response = curl_exec($ch);
        curl_close($ch);

        if ($response === false) {
            dd(curl_error($ch));
        }

        return $response;
    }

    function getToken(){
        session()->forget('errGetToken');
        try {
            $url = env('API_YANDUAN').'generate-token';
            $method = 'POST';
            $header = array(
                'Access-Key: '.$this->accessKey,
                'Secret-Key: '.$this->secretKey,
            );
            $body = null;
            $token = json_decode($this->callCurl($url, $body, $header, $method));

            session()->put('tokenYanduan', $token->data);
        } catch (\Throwable $th) {
            session()->flash('errGetToken', 'Gagal Tersambung ke API WA Yanduan');
        }
    }

    function getProcessedReport($startDate, $endDate){
        $url = env('API_YANDUAN').'reports/processed-reports';
        $token = session()->get('tokenYanduan');

        $method = 'POST';
        $header = array(
            'Access-Key: '.$this->accessKey,
            'Secret-Key: '.$this->secretKey,
            'Accept: application/json',
            'Content-Type: application/json',
            'Token: '.$token,
        );
        $body = '{
            "release_date_from":"'.$startDate.'",
            "release_date_to":"'.$endDate.'"
        }';

        $report = json_decode($this->callCurl($url, $body, $header, $method));

        return $report;
    }

    function getPangkat(){
        $url = 'https://propam.admasolusi.space/api/v1/master/pangkat';
        $method = 'GET';
        $header = array(
            'Cookie: Path=/'
        );
        $pangkat = json_decode($this->callCurl($url, null, $header, $method));
        return $pangkat;
    }
}
