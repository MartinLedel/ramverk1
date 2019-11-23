<?php
/**
 * Load the stylechooser as a controller class.
 */
return [
    "routes" => [
        [
            "info" => "Hämta väder data med JSON svar.",
            "mount" => "weather2-api",
            "handler" => "\Anax\WeatherAPI\WeatherJSONController",
        ],
    ]
];
