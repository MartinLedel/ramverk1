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
<link rel="stylesheet" href="../view/ipvalidate/leaflet.css">
<p>
    <table>
        <tr class="first">
            <th>IP</th>
            <th>Domän</th>
            <th>IpV</th>
            <th>Land</th>
            <th>Stad</th>
            <th>Latitude</th>
            <th>Longitude</th>
        </tr>
        <tr>
            <td id="ip"><?= $jsonData["ip"] ?></td>
            <td><?= $jsonData["hostname"] ?></td>
            <td><?= $jsonData["type"] ?></td>
            <td><?= $jsonData["country_name"] ?></td>
            <td><?= $jsonData["city"] ?></td>
            <td id="lat"><?= $jsonData["latitude"] ?></td>
            <td id="lng"><?= $jsonData["longitude"] ?></td>
        </tr>
    </table>
</p>
<div id="map" style="width: 800px; height: 450px;"></div>
<script src="../view/ipvalidate/leaflet.js"></script>
<script type="text/javascript">
    var latPos = document.getElementById('lat').innerText;
    var lngPos = document.getElementById('lng').innerText;
    var ipAdress = document.getElementById('ip').innerText;
    var locationMarker = L.icon({
        iconUrl: 'img/location.png',

        iconSize:     [24, 24],
        iconAnchor:   [12, 12],
        popupAnchor:  [0, 0]
    });
    setTimeout(() => {
        if (latPos && lngPos) {
            var map = new L.Map('map');
            var osmUrl = 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
                osmAttrib = 'Map data &copy; 2018 OpenStreetMap contributors',
                osm = new L.TileLayer(osmUrl, { maxZoom: 18, attribution: osmAttrib });
            L.marker(
                [latPos, lngPos],
                {icon: locationMarker}
            ).addTo(map).bindPopup("IP: " + ipAdress);
            map.setView(new L.LatLng(latPos, lngPos), 13).addLayer(osm);
    }
  }, 500);
</script>
<?php endif; ?>
