<?php

global $tmp;

$dadlabel = getTemplateMessage('t13_dadside');
$momlabel = getTemplateMessage('t13_momside');
?>

<body id="bodytop" class="<?php echo pathinfo(basename($_SERVER['SCRIPT_NAME']), PATHINFO_FILENAME); ?>">
<div id="art-main">
    <div class="cleared reset-box"></div>
    <div class="art-nav">
        <div class="art-nav-l"></div>
        <div class="art-nav-r"></div>
        <div class="art-nav-outer">
            <div class="art-nav-wrapper">
                <div class="art-nav-inner">
                    <ul class="art-hmenu">
                        <?php if ($dadlabel) { ?>
                            <li>
                                <a href="pedigree.php?personID=<?php echo $tmp['t13_dadperson']; ?>&amp;tree=<?php echo $tmp['t13_dadtree']; ?>"><span
                                        class="l"></span><span class="r"></span><span
                                        class="t"><?php echo getTemplateMessage('t13_dadside'); ?></span></a>
                            </li>
                            <?php
                        }
                        if ($momlabel) {
                            ?>
                            <li>
                                <a href="pedigree.php?personID=<?php echo $tmp['t13_momperson']; ?>&amp;tree=<?php echo $tmp['t13_momtree']; ?>"><span
                                        class="l"></span><span class="r"></span><span
                                        class="t"><?php echo getTemplateMessage('t13_momside'); ?></span></a>
                            </li>
                            <?php
                        }
                        echo showLinks($tmp['t13_featurelinks'], false, "", "<span class=\"l\"></span><span class=\"r\"></span><span class=\"t\">xxx</span>");
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="cleared reset-box"></div>
    <div class="art-sheet">
        <div class="art-sheet-cc"></div>
        <div class="art-sheet-body">
            <div class="art-content-layout">
                <div class="art-content-layout-row">
                    <div class="art-layout-cell art-content">
                        <div class="art-post">
                            <div class="art-post-body">
                                <h2 class="site-head"><a href="index.php"><img
                                            src="<?php echo $templatepath; ?>img/globe-small.jpg" alt=""
                                            class="greentree"><?php echo getTemplateMessage('t13_maintitle'); ?></a></h2>
