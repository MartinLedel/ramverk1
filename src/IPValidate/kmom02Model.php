<?php

namespace Anax\IPValidate;

/**
 * Showing off a standard class with methods and properties.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class kmom02Model
{
    public function cURLCall($ip)
    {
        $api_key = file_get_contents(ANAX_INSTALL_PATH . "/config/apikey.txt");
        $api_key = trim($api_key);
        $json = [];

        // Initialize CURL:
        $ch = curl_init('http://api.ipstack.com/'. $ip . '?access_key=' . $api_key . '');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Store the data:
        $json = curl_exec($ch);
        curl_close($ch);

        // Decode JSON response:
        $api_result = json_decode($json, true);

        return $api_result;
    }

    public function getDataKmom02($ip)
    {
        $json = null;

        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            $json = $this->cURLCall($ip);
        } elseif (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            $json = $this->cURLCall($ip);
        }

        return $json;
    }
}
