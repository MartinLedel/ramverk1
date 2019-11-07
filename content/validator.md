###Guide till IP Valideringen för JSON API

APIet tar emot två argument:

```
ipValidate
```

och

```
ipV4
```

eller

```
ipV6
```

För att testa en adress skriver du in:

```
json2/validate?ipValidate=194.47.150.9&ipV4
```

Tillbaka ska du få ett objekt:

```
{
    "hostName": "dbwebb.se",
    "ipValidate": "194.47.150.9",
    "message": "Validated."
}
```

Objektet innehåller

```
hostName
```

som kommer innehålla domän namnet om adressen validerade.

```
ipValidate
```

som har visar ip adressen du testade och

```
message
```

som visar ifall adressen validerade.
