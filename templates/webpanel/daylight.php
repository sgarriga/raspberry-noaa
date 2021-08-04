<?php
  include_once('header.php');

  $today = date("Y-m-d");
  $apiUrl = "https://api.sunrise-sunset.org/json?lat=34.898180&lng=-84.064322&date=".$today;
  $curl_request = curl_init();
   
  curl_setopt($curl_request, CURLOPT_URL, $apiUrl);
  curl_setopt($curl_request, CURLOPT_RETURNTRANSFER, 1);
       
  $response = curl_exec($curl_request);
  $res = json_decode($response);
  $gmtTimezone = new DateTimeZone('GMT');

  $utc_dawn = DateTime::createFromFormat(
    'Y-m-d h:i:s A',
    $today." ".$res->results->sunrise,
    new DateTimeZone('UTC')
  );

  $local_dawn = clone $utc_dawn;
  $local_dawn->setTimeZone(new DateTimeZone('America/New_York'));

  $utc_dusk = DateTime::createFromFormat(
    'Y-m-d h:i:s A',
    $today." ".$res->results->sunset,
    new DateTimeZone('UTC')
  );

  $local_dusk = clone $utc_dusk;
  $local_dusk->setTimeZone(new DateTimeZone('America/New_York'));

  $utc_noon = DateTime::createFromFormat(
    'Y-m-d h:i:s A',
    $today." ".$res->results->solar_noon,
    new DateTimeZone('UTC')
  );

  $local_noon = clone $utc_noon; 
  $local_noon->setTimeZone(new DateTimeZone('America/New_York'));

  print("<table style=\"text-align:center\"><tr>".
        "<th>".$lang["sunrise"]."</th>".
        "<th>&nbsp;&nbsp;&nbsp;</th>".
        "<th>".$lang["noon"]."</th>".
        "<th>&nbsp;&nbsp;&nbsp;</th>".
        "<th>".$lang["sunset"]."</th>".
        "</tr>");
  print("<tr>".
        "<td></td>".
        "<td></td>".
        "<td><img src=\"sun-full.png\"></td>".
        "<td></td>".
        "<td></td>".
        "</tr>");
  print("<tr>".
        "<td><img src=\"sun-dawn.png\"></td>".
        "<td></td>".
        "<td></td>".
        "<td></td>".
        "<td><img src=\"sun-dusk.png\"></td>".
        "</tr>");
  print("<tr>".
        "<td>".$local_dawn->format("h:i:s A")."</td>".
        "<td></td>".
        "<td>".$local_noon->format("h:i:s A")."</td>".
        "<td></td>".
        "<td>".$local_dusk->format("h:i:s A")."</td>".
        "</tr></table>");

  curl_close($curl_request);   

  print("</br>");
  print("<a href=\"https://www.sunrise-sunset.org\">".
        "<img style=\"height: 36px;\" src=\"sunrise-sunset.png\"></a>");

  print("</br>");
  print("</br>");
  # Current Moon Phase HTML (c) MoonConnection.com
  print("<img style=\"width: 212; height: 135; border: 0;\" src=\"http://www.moonmodule.com/cs/dm/hn.gif\">");

  print("</br>");
  print("<a href=\"https://www.moonconnection.com/moon_phases.phtml\"><img src=\"https://www.moonconnection.com/images/moon_l.gif\"></a>");

  print("</div>");
  print("</body>");
  print("</html>");
