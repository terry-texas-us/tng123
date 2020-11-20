<?php
include "begin.php";
include "adminlib.php";

include "checklogin.php";
header("Content-type:text/html; charset=" . $session_charset);

$query = "SELECT cemeteryID, cemname, city, county, state, country FROM $cemeteries_table WHERE place = \"\" ORDER BY country, state, county, city, cemname";
$result = tng_query($query);
?>

<div class="databack ajaxwindow" id="cemdiv">
    <?php
    if (tng_num_rows($result)) {
        ?>
        <h3 class="subhead"><?php echo _('Choose a Cemetery'); ?></h3>
        <p><?php echo _('List only includes cemeteries that are not already linked to a place'); ?></p>
        <form action="" name="findcemetery" id="findcemetery" onsubmit="return addCemLink(this.cemeteryID.options[this.cemeteryID.selectedIndex].value);">
            <table cellspacing="0" cellpadding="2">
                <tr>
                    <td>
                        <select name="cemeteryID" id="cemeteryID">
                            <option value=""></option>
                            <?php
                            while ($cemrow = tng_fetch_assoc($result)) {
                                $location = $cemrow['country'];
                                if ($cemrow['state']) {
                                    if ($location) $location .= ", ";

                                    $location .= $cemrow['state'];
                                }
                                if ($cemrow['county']) {
                                    if ($location) $location .= ", ";

                                    $location .= $cemrow['county'];
                                }
                                if ($cemrow['city']) {
                                    if ($location) $location .= ", ";

                                    $location .= $cemrow['city'];
                                }
                                if ($cemrow['cemname']) {
                                    if ($location) $location .= ", ";

                                    $location .= $cemrow['cemname'];
                                }
                                echo "<option value=\"{$cemrow['cemeteryID']}\">$location</option>\n";
                            }
                            ?>
                        </select>
                    </td>
                    <td>
                        <input type="submit" value="<?php echo _('Go'); ?>">
                    </td>
                </tr>
            </table>
        </form>
    <?php } else { ?>
        <p><?php echo _('No cemeteries exist, or each cemetery has already been linked to a place.'); ?></p>
        <?php
    }
    tng_free_result($result);
    ?>
</div>