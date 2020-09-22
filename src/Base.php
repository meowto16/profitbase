<?php

namespace Meowto16\ProfitBase;

use Exception;

/**
 * Class Base - содержим методы хелперы, для работы пакета.
 * @package Meowto16\ProfitBase
 */

class Base
{
    private $API_KEY;
    private $API_URL;
    private $AUTH_JSON_PATH;

    public $lastResponse;
    public $lastCode;

    protected function __construct($options)
    {
        try {
            if (!empty($options["API_KEY"]) && isset($options["API_KEY"]) && is_string($options["API_KEY"])) {
                $this->API_KEY = $options["API_KEY"];
            } else {
                throw new Exception('ProfitBase connection error. API key is not defined');
            }
            if (!empty($options["API_URL"]) && isset($options["API_URL"]) && is_string($options["API_URL"])) {
                $this->API_URL = $options["API_URL"];
            } else {
                throw new Exception('ProfitBase connection error. API url is not defined');
            }
            if (!empty($options["AUTH_JSON_PATH"]) && isset($options["AUTH_JSON_PATH"])) {
                $this->AUTH_JSON_PATH = $options["AUTH_JSON_PATH"];
            } else {
                throw new Exception('ProfitBase connection error. API authorize data path is not defined');
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    protected function getToken()
    {
        $authorizeDataFile = $this->AUTH_JSON_PATH;

        // Check local file
        $tokenData = file_get_contents($authorizeDataFile);
        $tokenDataDecoded = json_decode($tokenData, true);
        if (date('U') - $tokenDataDecoded["time_of_receive"] < $tokenDataDecoded["remaining_time"]) {
            return $tokenDataDecoded['access_token'];
        } // If access token time is up
        else {
            $response = $this->postQueryTo('/authentication', [
                'type' => 'api-app',
                'credentials' => [
                    'pb_api_key' => $this->API_KEY
                ]
            ], false);

            $tokenDataDecoded = $response;
            $tokenDataDecoded["time_of_receive"] = date("U");
            $tokenDataEncoded = json_encode($tokenDataDecoded);
            $tokenDataResource = fopen($authorizeDataFile, "w");
            fwrite($tokenDataResource, $tokenDataEncoded);
            fclose($tokenDataResource);

            return $tokenDataDecoded['access_token'];
        }
    }

    protected function getQueryTo($href, array $params = [], $requiresToken = true)
    {
        try {
            if (!isset($href) || empty($href)) {
                throw new Exception('ProfitBase query error. Href is not defined');
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        $query = [];
        if ($requiresToken) {
            $query["access_token"] = $this->getToken();
        }

        $query = array_merge($query, $params);

        $additionalQuery = "";
        if (!empty($query)) {
            $additionalQuery = "?";
            $additionalQuery .= http_build_query($query);
        }

        $link = $this->API_URL . $href . $additionalQuery;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $link);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $out = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        $Response = json_decode($out, true);
        $this->lastResponse = $out;

        $this->checkResponseCode($code);

        return $Response;
    }

    protected function postQueryTo($href, array $params = [], $requiresToken = true)
    {
        try {
            if (!isset($href) || empty($href)) {
                throw new Exception('ProfitBase query error. Href is not defined');
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        $additionalQuery = "";

        if ($requiresToken) {
            $query["access_token"] = $this->getToken();
            $additionalQuery = "?";
            $additionalQuery .= http_build_query($query);
        }

        $link = $this->API_URL . $href . $additionalQuery;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $link);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));

        $out = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        $Response = json_decode($out, true);
        $this->lastResponse = $Response;
        $this->lastCode = $code;

        $this->checkResponseCode($code);

        return $Response;
    }

    private function checkResponseCode($code)
    {
        $errors = array(
            301 => 'Moved permanently',
            400 => 'Bad request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not found',
            500 => 'Internal server error',
            502 => 'Bad gateway',
            503 => 'Service unavailable',
        );

        try {
            if ($code != 200 && $code != 204) {
                $error = $errors[$code] ? $errors[$code] : 'Unknown error';
                throw new Exception("ProfitBase connection error ($error)", $code);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            echo "<br>";
            echo "Error code: " . $e->getCode();
        }
    }
}
