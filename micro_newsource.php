<tr>
    <td><?php echo _('Short Title'); ?>:</td>
    <td>
        <input type="text" name="shorttitle" size="50">
    </td>
</tr>
<tr>
    <td><?php echo _('Long Title'); ?>:</td>
    <td>
        <input type="text" name="title" size="50">
    </td>
</tr>
<tr>
    <td><?php echo _('Author'); ?>:</td>
    <td>
        <input type="text" name="author" size="40">
    </td>
</tr>
<tr>
    <td><?php echo _('Call Number'); ?>:</td>
    <td>
        <input type="text" name="callnum" size="40">
    </td>
</tr>
<tr>
    <td><?php echo _('Publisher'); ?>:</td>
    <td>
        <input type="text" name="publisher" size="40">
    </td>
</tr>
<tr>
    <td><?php echo _('Repository'); ?>:</td>
    <td>
        <select name="repoID">
            <option value=""></option>
            <?php
            $query = "SELECT repoID, reponame, gedcom FROM $repositories_table $wherestr ORDER BY reponame";
            $reporesult = tng_query($query);
            while ($reporow = tng_fetch_assoc($reporesult)) {
                if (!$assignedtree && $numtrees > 1) {
                    echo "		<option value=\"{$reporow['repoID']}\">{$reporow['reponame']} (" . _('Tree') . ": {$reporow['gedcom']})</option>\n";
                } else {
                    echo "		<option value=\"{$reporow['repoID']}\">{$reporow['reponame']}</option>\n";
                }
            }
            tng_free_result($reporesult);
            ?>
        </select>
    </td>
</tr>
<tr>
    <td class='align-top'><?php echo _('Actual Text'); ?>:</td>
    <td><textarea cols="50" rows="5" name="actualtext"></textarea></td>
</tr>
