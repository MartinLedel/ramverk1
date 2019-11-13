<?php

namespace Anax\View;

/**
 * Render content within an article.
 */
?>
<form action="regular/validate">
    <fieldset>
    <legend>Validera IP adress</legend>
    <p>
        <label>IP adress:<br>
        <input type="text" name="ip" value="<?= $userIP ?>"/>
        </label>
    </p>
    <p>
        <button type="submit" name="kmom" value="01">Validera IP - kmom01</button>
        <button type="submit" name="kmom" value="02">Validera IP - kmom02</button>
    </p>
    </fieldset>
</form>
<p>kmom01 IPv4 exempel:
    <a href="regular/validate?ip=194.47.150.9&kmom=01">TEST1</a>
    <a href="regular/validate?ip=8.8.8.8&kmom=01">TEST2</a>
    <a href="regular/validate?ip=194.47.1&kmom=01">FAIL1</a>
</p>
<p>kmom01 IPv6 exempel:
    <a href="regular/validate?ip=2001:0db8:85a3:0000:0000:8a2e:0370:7334&kmom=01">TEST1</a>
    <a href="regular/validate?ip=2001:0db8:85a3:0000:0000:&kmom=01">FAIL1</a>
</p>
<p>kmom02 exempel:
    <a href="regular/validate?ip=194.47.150.9&kmom=02">TEST1</a>
    <a href="regular/validate?ip=8.8.8.8&kmom=02">TEST2</a>
    <a href="regular/validate?ip=194.47.1&kmom=02">FAIL1</a>
</p>
<?php if (isset($validatedText)) : ?>
<p>
    <b><?= $validatedText ?></b>
</p>
<?php elseif (isset($jsonData)) : ?>
<p>
    <table>
        <tr class="first">
            <th>IP</th>
            <th>IpV</th>
            <th>Land</th>
            <th>Stad</th>
            <th>Latitude</th>
            <th>Longitude</th>
            <th>Flagga</th>
        </tr>
        <tr>
            <td><?= $jsonData["ip"] ?></td>
            <td><?= $jsonData["type"] ?></td>
            <td><?= $jsonData["country_code"] ?></td>
            <td><?= $jsonData["city"] ?></td>
            <td><?= $jsonData["latitude"] ?></td>
            <td><?= $jsonData["longitude"] ?></td>
            <td><img src="<?= $jsonData["location"]["country_flag"] ?>"></td>
        </tr>
    </table>
</p>
<?php endif; ?>
