###Guide till ett JSON API i för väder hämtning

APIet tar emot två argument: `searchReq` och `date`.

För att hämta väder data måste något av dessa skickas med:

* Ort, Stad, Land
* IP adress, IPv4

```
weather2-api/fetch?searchReq=Karlskrona&date=0&fetch=fetch
```

Tillbaka ska du få ett objekt med dagens väder och vädret 7 dagar framåt:

```
{
    "address": {
        "lat": "56.1621073",
        "long": "15.5866422",
        "city": "Karlskrona",
        "region": "Blekinge l\u00e4n",
        "country": "Sverige"
    },
    "weather_data": {
        "current": [
            {
                "latitude": 56.1621073,
                "longitude": 15.5866422,
                "timezone": "Europe/Stockholm",
                "daily": {
                    "summary": "Regnskurar p\u00e5 tisdag fram till fredag.",
                    "icon": "rain",
                    "data": [
                        {
                            "time": 1574463600,
                            "summary": "Mulet under dagen.",
                            "icon": "cloudy",
                            "sunriseTime": 1574491920,
                            "sunsetTime": 1574519940,
                            "moonPhase": 0.9,
                            "precipIntensity": 0.0157,
                            "precipIntensityMax": 0.035,
                            "precipIntensityMaxTime": 1574526000,
                            "precipProbability": 0.28,
                            "precipType": "rain",
                            "temperatureHigh": 5.86,
                            "temperatureHighTime": 1574504340,
                            "temperatureLow": 4.16,
                            "temperatureLowTime": 1574568120,
                            "apparentTemperatureHigh": 1.46,
                            "apparentTemperatureHighTime": 1574504700,
                            "apparentTemperatureLow": -0.18,
                            "apparentTemperatureLowTime": 1574567700,
                            "dewPoint": 4.58,
                            "humidity": 0.94,
                            "pressure": 1017.8,
                            "windSpeed": 6.59,
                            "windGust": 11.3,
                            "windGustTime": 1574523840,
                            "windBearing": 102,
                            "cloudCover": 0.91,
                            "uvIndex": 0,
                            "uvIndexTime": 1574505960,
                            "visibility": 11.059,
                            "ozone": 268,
                            "temperatureMin": 4.66,
                            "temperatureMinTime": 1574550000,
                            "temperatureMax": 6.97,
                            "temperatureMaxTime": 1574484360,
                            "apparentTemperatureMin": 0.59,
                            "apparentTemperatureMinTime": 1574550000,
                            "apparentTemperatureMax": 2.73,
                            "apparentTemperatureMaxTime": 1574482260
                        },
                        {
                            "time": 1574550000,
                            "summary": "Mulet under dagen.",
                            "icon": "cloudy",
                            "sunriseTime": 1574578440,
                            "sunsetTime": 1574606280,
                            "moonPhase": 0.93,
                            "precipIntensity": 0.0202,
                            "precipIntensityMax": 0.0328,
                            "precipIntensityMaxTime": 1574593500,
                            "precipProbability": 0.17,
                            "precipType": "rain",
                            "temperatureHigh": 5.95,
                            "temperatureHighTime": 1574595780,
                            "temperatureLow": 4.39,
                            "temperatureLowTime": 1574640000,
                            "apparentTemperatureHigh": 1.5,
                            "apparentTemperatureHighTime": 1574595120,
                            "apparentTemperatureLow": 0.6,
                            "apparentTemperatureLowTime": 1574640000,
                            "dewPoint": 3.24,
                            "humidity": 0.88,
                            "pressure": 1018.5,
                            "windSpeed": 6.6,
                            "windGust": 10.77,
                            "windGustTime": 1574617440,
                            "windBearing": 89,
                            "cloudCover": 0.96,
                            "uvIndex": 0,
                            "uvIndexTime": 1574592300,
                            "visibility": 16.093,
                            "ozone": 265.5,
                            "temperatureMin": 4.16,
                            "temperatureMinTime": 1574568120,
                            "temperatureMax": 5.95,
                            "temperatureMaxTime": 1574595780,
                            "apparentTemperatureMin": -0.18,
                            "apparentTemperatureMinTime": 1574567700,
                            "apparentTemperatureMax": 1.5,
                            "apparentTemperatureMaxTime": 1574595120
                        },
                        {
                            osvosvosvosv
                        },
                    ]
                },
                "offset": 1
            }
        ]
    }
}
```

Objektet innehåller `address` där adressn finns,
`weather_data` som innehåller all väder data. Om sökningen inte hittar en address läggs ett objekt med
`address["404"]` till som har ett meddelande.

Går också att få föregående dagar.

```
weather2-api/fetch?searchReq=Karlskrona&date=30&fetch=fetch
```

Tillbaka ska du få ett objekt med vädret dem 30 föregående dagarna:

```
{
    "address": {
        "lat": "56.1621073",
        "long": "15.5866422",
        "city": "Karlskrona",
        "region": "Blekinge l\u00e4n",
        "country": "Sverige"
    },
    "weather_data": {
        "current": [
            {
                "latitude": 56.1621073,
                "longitude": 15.5866422,
                "timezone": "Europe/Stockholm",
                "daily": {
                    "summary": "Regnskurar p\u00e5 tisdag fram till fredag.",
                    "icon": "rain",
                    "data": [
                        {
                            "time": 1574463600,
                            "summary": "Mulet under dagen.",
                            "icon": "cloudy",
                            "sunriseTime": 1574491920,
                            "sunsetTime": 1574519940,
                            "moonPhase": 0.9,
                            "precipIntensity": 0.0157,
                            "precipIntensityMax": 0.035,
                            "precipIntensityMaxTime": 1574526000,
                            "precipProbability": 0.28,
                            "precipType": "rain",
                            "temperatureHigh": 5.86,
                            "temperatureHighTime": 1574504340,
                            "temperatureLow": 4.16,
                            "temperatureLowTime": 1574568120,
                            "apparentTemperatureHigh": 1.46,
                            "apparentTemperatureHighTime": 1574504700,
                            "apparentTemperatureLow": -0.18,
                            "apparentTemperatureLowTime": 1574567700,
                            "dewPoint": 4.58,
                            "humidity": 0.94,
                            "pressure": 1017.8,
                            "windSpeed": 6.59,
                            "windGust": 11.3,
                            "windGustTime": 1574523840,
                            "windBearing": 102,
                            "cloudCover": 0.91,
                            "uvIndex": 0,
                            "uvIndexTime": 1574505960,
                            "visibility": 11.059,
                            "ozone": 268,
                            "temperatureMin": 4.66,
                            "temperatureMinTime": 1574550000,
                            "temperatureMax": 6.97,
                            "temperatureMaxTime": 1574484360,
                            "apparentTemperatureMin": 0.59,
                            "apparentTemperatureMinTime": 1574550000,
                            "apparentTemperatureMax": 2.73,
                            "apparentTemperatureMaxTime": 1574482260
                        },
                        {
                            "time": 1574550000,
                            "summary": "Mulet under dagen.",
                            "icon": "cloudy",
                            "sunriseTime": 1574578440,
                            "sunsetTime": 1574606280,
                            "moonPhase": 0.93,
                            "precipIntensity": 0.0202,
                            "precipIntensityMax": 0.0328,
                            "precipIntensityMaxTime": 1574593500,
                            "precipProbability": 0.17,
                            "precipType": "rain",
                            "temperatureHigh": 5.95,
                            "temperatureHighTime": 1574595780,
                            "temperatureLow": 4.39,
                            "temperatureLowTime": 1574640000,
                            "apparentTemperatureHigh": 1.5,
                            "apparentTemperatureHighTime": 1574595120,
                            "apparentTemperatureLow": 0.6,
                            "apparentTemperatureLowTime": 1574640000,
                            "dewPoint": 3.24,
                            "humidity": 0.88,
                            "pressure": 1018.5,
                            "windSpeed": 6.6,
                            "windGust": 10.77,
                            "windGustTime": 1574617440,
                            "windBearing": 89,
                            "cloudCover": 0.96,
                            "uvIndex": 0,
                            "uvIndexTime": 1574592300,
                            "visibility": 16.093,
                            "ozone": 265.5,
                            "temperatureMin": 4.16,
                            "temperatureMinTime": 1574568120,
                            "temperatureMax": 5.95,
                            "temperatureMaxTime": 1574595780,
                            "apparentTemperatureMin": -0.18,
                            "apparentTemperatureMinTime": 1574567700,
                            "apparentTemperatureMax": 1.5,
                            "apparentTemperatureMaxTime": 1574595120
                        },
                        {
                            osvosvosvosv
                        },
                    ]
                },
                "offset": 1
            }
        ]
    }
}
```
