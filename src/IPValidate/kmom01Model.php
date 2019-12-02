<?php

namespace Anax\IPValidate;

/**
 * Showing off a standard class with methods and properties.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class kmom01Model
{
    public function regularValidateKmom01($ip)
    {
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            $hostname = gethostbyaddr($ip);
            $text = "Your adress validated with: " . $ip . " and has domain name: " . $hostname;
        } elseif (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            $hostname = gethostbyaddr($ip);
            $text = "Your adress validated with: " . $ip . " and has domain name: " . $hostname;
        } else {
            $text = "Your adress did not validate with: " . $ip;
        }

        return $text;
    }

    public function jsonValidateKmom01($ip)
    {
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            $hostname = gethostbyaddr($ip);
            $json = [
            "ip" => $ip,
            "hostname" => $hostname,
            "message" => "Your address validated."
            ];
        } elseif (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            $hostname = gethostbyaddr($ip);
            $json = [
            "ip" => $ip,
            "hostname" => $hostname,
            "message" => "Your address validated."
            ];
        } else {
            $json = [
            "ip" => $ip,
            "message" => "Your address did not validate."
            ];
        }

        return $json;
    }
}
