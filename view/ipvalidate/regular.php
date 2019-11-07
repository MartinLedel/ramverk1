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
        <input type="text" name="ipValidate" value=""/>
        </label>
    </p>
    <p>
        <button type="submit" name="ipV4" value="ipV4">Validera IPv4</button>
        <button type="submit" name="ipV6" value="ipV6">Validera IPv6</button>
    </p>
    </fieldset>
</form>
<p>IPv4 exempel:
    <a href="regular/validate?ipValidate=1.160.10.240&ipV4=ipV4">TEST1</a>
    <a href="regular/validate?ipValidate=172.217.7.14&ipV4=ipV4">TEST2</a>
    <a href="regular/validate?ipValidate=194.47.150.9&ipV4=ipV4">TEST3</a>
    <a href="regular/validate?ipValidate=194.47.1&ipV4=ipV4">FAIL1</a>
</p>
<p>IPv6 exempel:
    <a href="regular/validate?ipValidate=2001:0db8:85a3:0000:0000:8a2e:0370:7334&ipV6=ipV6">TEST1</a>
    <a href="regular/validate?ipValidate=2001:0db8:85a3:0000:0000:&ipV6=ipV6">FAIL1</a>
</p>
<?php if (isset($isValid)) : ?>
    <p>
        <b><?= $isValid ?> validated.</b><br>
        <?php if (isset($hostName)) : ?>
            <b>Domain name: <?= $hostName ?></b>
        <?php else : ?>
            <b>Domain name: Not found.</b>
        <?php endif; ?>
    </p>
<?php elseif (isset($notValid)) : ?>
    <p><b><?= $notValid ?> did not validate</b><br></p>
<?php endif; ?>
