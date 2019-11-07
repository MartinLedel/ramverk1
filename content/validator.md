###Guide till IP Valideringen för JSON API

APIet tar emot två argument: `ipValidate` och `ipVersion`.

För att testa en adress skriver du in:

```
json2/validate?ipValidate=194.47.150.9&ipVersion=ipV4
```

Tillbaka ska du få ett objekt:

```
{
    "hostName": "dbwebb.se",
    "ipValidate": "194.47.150.9",
    "message": "Validated."
}
```

Objektet innehåller `hostName` som kommer visa domän namnet om adressen validerade,

`ipValidate` som visar ip adressen du testade och `message` som visar ifall adressen validerade.
