<?php
$treequery = "SELECT gedcom, treename FROM $trees_table $wherestr ORDER BY treename";
$treeresult = tng_query($treequery);
$numtrees = tng_num_rows($treeresult);
if ($numtrees > 1) {
    echo "<select id='treequeryselect' name='tree'>\n";
    if (!$assignedtree) echo "<option value=''>" . _('All Trees') . "</option>\n";
    while ($treerow = tng_fetch_assoc($treeresult)) {
        echo "	<option value='{$treerow['gedcom']}'";
        if ($treerow['gedcom'] == $tree) echo " selected";

        echo ">{$treerow['treename']}</option>\n";
    }
    echo "</select>\n";
} else {
    echo "<input type='hidden' name='tree' value='$assignedtree'>\n";
}
tng_free_result($treeresult);

