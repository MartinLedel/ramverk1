<?php

namespace Anax\View;

/**
 * Render content within an article.
 */
?>
<form action="json2/validate">
    <fieldset>
    <legend>Validera IP adress</legend>
    <p>
        <label>IP adress:<br>
        <input type="text" name="ipValidate" value=""/>
        </label>
    </p>
    <p>
        <button type="submit" name="ipVersion" value="ipV4">Validera IPv4</button>
        <button type="submit" name="ipVersion" value="ipV6">Validera IPv6</button>
    </p>
    </fieldset>
</form>
<p>IPv4 exempel:
    <a href="json2/validate?ipValidate=1.160.10.240&ipVersion=ipV4">TEST1</a>
    <a href="json2/validate?ipValidate=172.217.7.14&ipVersion=ipV4">TEST2</a>
    <a href="json2/validate?ipValidate=194.47.150.9&ipVersion=ipV4">TEST3</a>
    <a href="json2/validate?ipValidate=194.47.1&ipVersion=ipV4">FAIL1</a>
</p>
<p>IPv6 exempel:
    <a href="json2/validate?ipValidate=2001:0db8:85a3:0000:0000:8a2e:0370:7334&ipVersion=ipV6">TEST1</a>
    <a href="json2/validate?ipValidate=2001:0db8:85a3:0000:0000:&ipVersion=ipV6">FAIL1</a>
</p>
