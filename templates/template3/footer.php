<?php
global $currentuser, $mylanguage, $flags;
?>

<table class="tableborder rounded t3shadow w-full">
    <tr>
        <td class="p-1">
            <div class="footer">
                <?php
                $flags['basicfooter'] = true;
                tng_footer($flags);
                ?>
            </div>
        </td>
    </tr>
</table>
