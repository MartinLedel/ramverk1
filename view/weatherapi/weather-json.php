<?php

namespace Anax\View;

/**
 * Render content within an article.
 */
?>
<form action="weather2-api/fetch">
    <fieldset>
    <legend>Väder API</legend>
    <p>
        <label><?= $message ?><br>
        <input type="text" name="searchReq" value=""/>
        </label>
    </p>
    <p>
        <input type="radio" name="date" value="0" checked="checked"/> Dagens väder<br>
        <input type="radio" name="date" value="30"/> Föregående 30 dagar
    </p>
    <p>
        <button type="submit" name="fetch" value="fetch">Hämta väder data</button>
    </p>
    </fieldset>
</form>
