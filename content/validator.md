###Guide till IP Valideringen för JSON API i kmom01

APIet tar emot två argument: `ip` och `kmom`.

För att testa en adress skriver du in:

```
json2/validate?ip=194.47.150.9&kmom=01
```

Tillbaka ska du få ett objekt:

```
{
    "ip": "194.47.150.9",
    "hostname": "dbwebb.se",
    "message": "Your address validated."
}
```

Objektet innehåller `hostname` som kommer visa domän namnet om adressen validerade,

`ip` som visar ip adressen du testade och `message` som visar ifall adressen validerade.

###Guide till IP data för JSON API i kmom02

APIet tar emot två argument: `ip` och `kmom`.

För att få tillbaka data från en adress:

```
json2/validate?ip=8.8.8.8&kmom=02
```

Tillbaka ska du få ett objekt:

```
{
    "ip": "8.8.8.8",
    "type": "ipv4",
    "continent_code": "NA",
    "continent_name": "North America",
    "country_code": "US",
    "country_name": "United States",
    "region_code": "CA",
    "region_name": "California",
    "city": "Mountain View",
    "zip": "94043",
    "latitude": 37.419158935546875,
    "longitude": -122.07540893554688,
    "location": {
        "geoname_id": 5375480,
        "capital": "Washington D.C.",
        "languages": [
            {
                "code": "en",
                "name": "English",
                "native": "English"
            }
        ],
        "country_flag": "http://assets.ipstack.com/flags/us.svg",
        "country_flag_emoji": "\ud83c\uddfa\ud83c\uddf8",
        "country_flag_emoji_unicode": "U+1F1FA U+1F1F8",
        "calling_code": "1",
        "is_eu": false
    },
    "show_map": "https://www.openstreetmap.org/#map=13/37.419158935547/-122.07540893555",
    "hostname": "dns.google"
}
```
