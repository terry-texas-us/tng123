<?php
global $flags;

if (strpos($_SERVER['SCRIPT_NAME'], 'index.php') === false) echo "</div>"; ?>
<footer class="cb-footer clearfix">
    <div class="cb-content-layout layout-item-0">
        <div class="cb-content-layout-row">
            <div class="cb-layout-cell w-full">
                <br>
                <div class="hg-footertext">
                    <?php
                    $flags['basicfooter'] = true;
                    tng_footer($flags);
                    ?>
                </div>
            </div>
        </div>
    </div>
</footer>
</div>
</div>
