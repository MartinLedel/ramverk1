<?php

namespace Anax\IPValidate;

/**
 * Showing off a standard class with methods and properties.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class kmom02Model
{
    protected $api_key;

    public function __construct()
    {
        $api_keys = require ANAX_INSTALL_PATH . "/config/api_keys.php";
        $this->api_key = $api_keys["ipstacks"];
    }

    public function cURLCall($ip)
    {
        $json = [];

        // Initialize CURL:
        $ch = curl_init('http://api.ipstack.com/'. $ip . '?access_key=' . $this->api_key . '');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Store the data:
        $json = curl_exec($ch);
        curl_close($ch);

        // Decode JSON response:
        $api_result = json_decode($json, true);
        $api_result["show_map"] = "https://www.openstreetmap.org/#map=13/{$api_result['latitude']}/{$api_result['longitude']}";

        return $api_result;
    }

    public function getDataKmom02($ip)
    {
        $json = null;

        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            $hostname = gethostbyaddr($ip);
            $json = $this->cURLCall($ip);
            $json["hostname"] = $hostname;
        } elseif (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            $hostname = gethostbyaddr($ip);
            $json = $this->cURLCall($ip);
            $json["hostname"] = $hostname;
        }

        return $json;
    }
}
