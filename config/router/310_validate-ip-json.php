<?php
/**
 * Load the stylechooser as a controller class.
 */
return [
    "routes" => [
        [
            "info" => "Validera IP adress med JSON svar",
            "mount" => "json2",
            "handler" => "\Anax\IPValidate\JSONController",
        ],
    ]
];
