<?php
/**
 * Load the stylechooser as a controller class.
 */
return [
    "routes" => [
        [
            "info" => "Hämta väder data med vanligt svar.",
            "mount" => "weather-api",
            "handler" => "\Anax\WeatherAPI\WeatherController",
        ],
    ]
];
