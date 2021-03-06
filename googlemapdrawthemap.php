<?php
// RM this file is called into the Admin pages where the map is going
// to appear, and includes the links for help, external Google maps
// that can be searched if the small built in map doesn't work.
// notable exception is UK locations which due to licensing issues can't be
// searched from within pages using the map API but can be searched from
// Google's own pages.
echo "<input type='button' onclick=\"return divbox('mapcontainer');\" value=\"" . _('Show/hide clickable map') . "\" class=\"align-middle\"> <span class='normal'>" . _('(to determine latitude, longitude and zoom)') . "</span>\n";

echo "<div id='mapcontainer' style=\"display:none; width:{$map['admw']};\" class='p-1 rounded-lg'>\n";
$searchstring = $row['place'] ? $row['place'] : _('Search for a Place');
echo "<span class='normal'>" . _('Geocode Location') . ": ";

echo "<input type='text' size=\"60\" name=\"address\" id=\"location\" onkeypress=\"return keyHandlerEnter(this,event);\" value=\"$searchstring\"";
if (!$row['place']) {
    echo " onfocus=\"if(this.value=='$searchstring'){this.value='';}\"";
}
echo ">\n";
echo "<input type='button' value=\"" . _('Search') . "\" onclick=\"showAddress(document.form1.address.value); return false\"><br><br></span>\n";
echo "<div id=\"map\" style=\"width: {$map['admw']}; height: {$map['admh']};\" class='rounded-lg'></div>\n";
$maphelplang = findhelp("places_googlemap_help.php");
echo "<span class='normal'><br><a href=\"javascript:newwindow=window.open('{$http}://maps.google.com/maps?f=q" . _('&amp;hl=en') . "$mcharsetstr&q=" . $row['place'] . "', 'googlehelp'); newwindow.focus();\"> " . _('Full Google Map Search') . "</a> | <a href=\"javascript:newwindow=window.open('$maphelplang/places_googlemap_help.php', 'newwindow', 'height=500,width=600,resizable=yes,scrollbars=yes'); newwindow.focus();\">" . _('Map Search Help') . "</a></span>\n";
echo "</div>\n";

