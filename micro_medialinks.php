<?php
$linkrows = "";
$usetree = $row['gedcom'];
if ($result2) {
    $oldlinks = 0;
    while ($plink = tng_fetch_assoc($result2)) {
        $oldlinks++;
        if (!$usetree) $usetree = $plink['gedcom'];

        $rights = determineLivingPrivateRights($plink);
        $plink['allow_living'] = $rights['living'];
        $plink['allow_private'] = $rights['private'];
        if ($plink['personID2'] != NULL) {
            $type = "person";
            $entityID = $plink['personID'];
            $id = " ($entityID)";
            $name = getName($plink);
            $linktype = "I";
        } elseif ($plink['familyID'] != NULL) {
            $type = "family";
            $husb['firstname'] = $plink['hfirstname'];
            $husb['lnprefix'] = $plink['hlnprefix'];
            $husb['lastname'] = $plink['hlastname'];
            $husb['prefix'] = $plink['hprefix'];
            $husb['suffix'] = $plink['hsuffix'];
            $husb['nameorder'] = $plink['hnameorder'];
            $husb['allow_living'] = $husb['allow_private'] = 1;
            $name = getName($husb);

            $wife['firstname'] = $plink['wfirstname'];
            $wife['lnprefix'] = $plink['wlnprefix'];
            $wife['lastname'] = $plink['wlastname'];
            $wife['prefix'] = $plink['wprefix'];
            $wife['suffix'] = $plink['wsuffix'];
            $wife['nameorder'] = $plink['wnameorder'];
            $wife['allow_living'] = $wife['allow_private'] = 1;
            $wifename = getName($wife);

            if ($wifename) {
                if ($name) $name .= ", ";

                $name .= $wifename;
            }
            $entityID = $plink['familyID'];
            $id = " ($entityID)";
            $linktype = "F";
        } elseif ($plink['sourceID'] != NULL) {
            $type = "source";
            $entityID = $plink['sourceID'];
            $id = " ($entityID)";
            $name = truncateIt($plink['title'], 100);
            $linktype = "S";
        } elseif ($plink['citationID'] != NULL) {
            $type = "citation";
            $entityID = $plink['citationID'];
            $id = " ($entityID)";

            //look up title from source table
            $query = "SELECT title FROM $sources_table AS s, $citations_table AS c WHERE citationID = \"$entityID\" AND c.gedcom = s.gedcom AND c.sourceID = s.sourceID";
            $resultc = tng_query($query);
            $rowc = tng_fetch_assoc($resultc);
            tng_free_result($resultc);

            $name = truncateIt($rowc['title'], 100);
            $linktype = "C";
        } elseif ($plink['repoID'] != NULL) {
            $type = "repository";
            $entityID = $plink['repoID'];
            $id = " ($entityID)";
            $name = truncateIt($plink['reponame'], 100);
            $linktype = "R";
        } else { //place
            $type = "place";
            $entityID = $name = $plink['personID'];
            $id = "";
            $linktype = "L";
        }

        $dchecked = $plink['defphoto'] ? " checked" : "";
        $schecked = $plink['dontshow'] ? "" : " checked";
        $alttext = $plink['altdescription'] || $plink['altnotes'] ? _('Yes') : "&nbsp;";

        include "eventmicro.php";

        $linkrows .= "<tr id=\"alink_{$plink['mlinkID']}\"><td class='lightback text-center'>";
        $linkrows .= "<a href='#' title=\"" . _('Edit') . "\" onclick=\"return editMedia2EntityLink({$plink['mlinkID']});\" title=\"" . _('Edit') . "\" class='smallicon admin-edit-icon'></a>";
        $linkrows .= "<a href='#' title=\"" . _('Remove Link') . "\" onclick=\"return deleteMedia2EntityLink({$plink['mlinkID']});\" title=\"" . _('Remove Link') . "\" class='smallicon admin-delete-icon'></a>";
        $linkrows .= "</td>\n";
        $linkrows .= "<td class='lightback normal'>" . $admtext[$type] . "</td>";
        $linkrows .= "<td class='lightback normal'>$name$id";
        if ($linktype != "C") {
            $linkrows .= " (<a href=\"admin_ordermedia.php?tree1={$plink['gedcom']}&linktype1=$linktype&mediatypeID=$mediatypeID&newlink1=$entityID&event1=$eventID\">" . _('Sort') . "</a>)";
        }
        $linkrows .= "&nbsp;</td>\n";
        $linkrows .= "<td class='lightback normal'>{$plink['treename']}</td>\n";
        $linkrows .= "<td class='lightback normal' id=\"event_{$plink['mlinkID']}\">$eventstr&nbsp;</td>\n";
        $linkrows .= "<td class='lightback normal text-center' id=\"alt_{$plink['mlinkID']}\">$alttext</td>\n";
        $linkrows .= "<td class='lightback normal text-center' id=\"def_{$plink['mlinkID']}\">";
        if ($linktype != "C") {
            $linkrows .= "<input type='checkbox' name=\"defc{$plink['mlinkID']}\" id=\"defc{$plink['mlinkID']}\" onclick=\"toggleDefault(this,'{$plink['gedcom']}','$entityID');\" value='1'$dchecked\">";
        }
        $linkrows .= "</td>\n";
        $linkrows .= "<td class='lightback normal text-center' id=\"show_{$plink['mlinkID']}\"><input type='checkbox' name=\"show{$plink['mlinkID']}\" id=\"show{$plink['mlinkID']}\" onclick=\"toggleShow(this);\" value='1'$schecked\"></td></tr>\n";
    }
    tng_free_result($result2);
}
?>
<div id="links" style="margin:0;padding-top:12px;">
    <table cellspacing="2">
        <tr>
            <td class="normal"><?php echo _('Tree'); ?></td>
            <td class="normal"><?php echo _('Type'); ?></td>
            <td class="normal" colspan="2"><?php echo _('ID'); ?></td>
        </tr>
        <tr>
            <td>
                <select name="tree1" id="microtree">
                    <?php echo $orderedTreesList->getSelectOptionsHtml($usetree); ?>
                </select>
            </td>
            <td>
                <select name="linktype1">
                    <option value="I"><?php echo _('Person'); ?></option>
                    <option value="F"><?php echo _('Family'); ?></option>
                    <option value="S"><?php echo _('Source'); ?></option>
                    <option value="R"><?php echo _('Repository'); ?></option>
                    <option value="C"><?php echo _('Citation'); ?></option>
                    <option value="L"><?php echo _('Place'); ?></option>
                </select>
            </td>
            <td>
                <input type="text" name="newlink1" id="newlink" value="" onkeypress="return newlinkEnter(findform,this,event);">
            </td>
            <!--<td class="normal"><input type="submit" value="<?php echo _('Add'); ?>"> &nbsp;<?php echo _('OR'); ?>&nbsp;
			<input type="button" value="<?php echo _('Find...'); ?>" name="find1" onClick="findopen=true;openFind(document.find.linktype1.options[document.find.linktype1.selectedIndex].value);$('newlines').innerHTML=resheremsg;"></td>-->
            <td class="normal">
                <input type="button" value="<?php echo _('Add'); ?>" onclick="return addMedia2EntityLink(findform);"> &nbsp;<?php echo _('OR'); ?>&nbsp;
            </td>
            <td><a href="#"
                    onclick="return findItem(findform.linktype1.options[findform.linktype1.selectedIndex].value,'newlink',null,findform.tree1.options[findform.tree1.selectedIndex].value,'<?php echo $assignedbranch; ?>','m_<?php echo $mediaID; ?>');"
                    title="<?php echo _('Find...'); ?>" class="smallicon admin-find-icon"></a></td>
        </tr>
    </table>
    <div id="alink_error" style="display:none;" class="normal red"></div>

    <p class="normal">&nbsp;<strong><?php echo _('Existing Links'); ?>:</strong> <?php echo _('Browse or Delete'); ?></p>
    <table cellpadding="3" cellspacing="1" id="linktable" class="normal">
        <tbody>
        <tr>
            <td class="fieldnameback fieldname whitespace-no-wrap">&nbsp;<b><?php echo _('Action'); ?></b>&nbsp;</td>
            <td class="fieldnameback fieldname whitespace-no-wrap">&nbsp;<b><?php echo _('Type'); ?></b>&nbsp;</td>
            <td class="fieldnameback fieldname whitespace-no-wrap">&nbsp;<b><?php echo _('Name') . ", " . _('ID'); ?></b>&nbsp;</td>
            <td class="fieldnameback fieldname whitespace-no-wrap">&nbsp;<b><?php echo _('Tree'); ?></b>&nbsp;</td>
            <td class="fieldnameback fieldname whitespace-no-wrap">&nbsp;<b><?php echo _('Event(s)'); ?></b>&nbsp;</td>
            <td class="fieldnameback fieldname whitespace-no-wrap">&nbsp;<b><?php echo _('Alt Title/Desc'); ?></b>&nbsp;</td>
            <td class="fieldnameback fieldname whitespace-no-wrap">&nbsp;<b><?php echo _('Default Photo'); ?></b>&nbsp;</td>
            <td class="fieldnameback fieldname whitespace-no-wrap">&nbsp;<b><?php echo _('Show'); ?></b>&nbsp;</td>
        </tr>
        <?php echo $linkrows; ?>
        </tbody>
    </table>
    <div id="nolinks" class="normal" style="margin-left:3px;">
        <?php if (!$oldlinks) echo _('No links exist yet'); ?>
    </div>
</div>
