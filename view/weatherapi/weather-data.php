<?php

namespace Anax\View;

/**
 * Render content within an article.
 */
?>
<form action="fetch">
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
<link rel="stylesheet" href="<?= url("css/leaflet.css") ?>">
<?php if (isset($address["404"])) : ?>
        <p><?= $address["404"] ?></p>
<?php elseif ($jsonData && $address) : ?>
<p>
    <table>
        <tr class="first">
            <th>Stad</th>
            <th>Län</th>
            <th>Land</th>
        </tr>
        <tr>
            <td><?= $address["city"] ?></td>
            <td><?= $address["region"] ?></td>
            <td><?= $address["country"] ?></td>
        </tr>
    </table>
</p>
<p>
    Dagens väder och 1 vecka framåt:<br>
    <table>
        <tr class="first">
            <th>Datum</th>
            <th>Prognos</th>
            <th>Högsta temp</th>
            <th>Lägsta temp</th>
            <th>Latitude</th>
            <th>Longitude</th>
        </tr>
        <?php foreach ($jsonData["current"][0]["daily"]["data"] as $row) : ?>
        <tr>
            <td><?= date('d M', $row["time"]) ?></td>
            <td><?= $row["summary"] ?></td>
            <td><?= round($row["temperatureHigh"]) ?>&deg;</td>
            <td><?= round($row["temperatureLow"]) ?>&deg;</td>
            <td id="lat"><?= $jsonData["current"][0]["latitude"] ?></td>
            <td id="lng"><?= $jsonData["current"][0]["longitude"] ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</p>
    <?php if (isset($jsonData["previous"])) : ?>
    <p>
        Vädret 30 dagar bakåt:<br>
        <table>
            <tr class="first">
                <th>Datum</th>
                <th>Prognos</th>
                <th>Högsta temp</th>
                <th>Lägsta temp</th>
            </tr>
            <?php foreach ($jsonData["previous"][0] as $row) : ?>
            <tr>
                <td><?= date('d M', $row[0]["time"]) ?></td>
                <td><?= $row[0]["summary"] ?></td>
                <td><?= round($row[0]["temperatureHigh"]) ?>&deg;</td>
                <td><?= round($row[0]["temperatureLow"]) ?>&deg;</td>
            </tr>
            <?php endforeach; ?>
        </table>
    </p>
    <?php endif ; ?>
<div id="map" style="width: 800px; height: 450px;"></div>
<script src="<?= url("js/leaflet.js") ?>"></script>
<script type="text/javascript">
    var latPos = document.getElementById('lat').innerText;
    var lngPos = document.getElementById('lng').innerText;
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
            ).addTo(map).bindPopup("Vädret");
            map.setView(new L.LatLng(latPos, lngPos), 13).addLayer(osm);
    }
  }, 500);
</script>
<?php endif ; ?>
