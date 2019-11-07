<?php
/**
 * Load the stylechooser as a controller class.
 */
return [
    "routes" => [
        [
            "info" => "Validera IP adresser med vanligt svar.",
            "mount" => "regular",
            "handler" => "\Anax\IPValidate\RegularController",
        ],
    ]
];
