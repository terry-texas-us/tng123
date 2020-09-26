<?php

global $text, $currentuser, $allow_admin, $tmp, $homepage;

$dadlabel = getTemplateMessage('t15_dadside');
$momlabel = getTemplateMessage('t15_momside');
$pagetitle = getTemplateMessage('t15_maintitle');
?>
<body id="bodytop" class="<?php echo defaultTemplateClass(); ?> home-page content-sidebar tng-nav tng-home">
<div class="scroll-to-top"><a href="#"><img src="img/backtotop.png" alt=""></a></div>
<div class="site-container">
    <nav class="nav-primary">
        <div class="wrap">
            <div class="responsive-menu-icon"></div>
            <ul class="menu nav-menu menu-primary responsive-menu">
                <li class="first menu-item current-menu-item"><a href="<?php echo $homepage; ?>">Home</a></li>
                <?php
                if ($dadlabel) {
                    ?>
                    <li class="menu-item"><a
                            href="pedigree.php?personID=<?php echo $tmp['t15_dadperson']; ?>&amp;tree=<?php echo $tmp['t15_dadtree']; ?>"><?php echo $dadlabel; ?></a>
                    </li>
                    <?php
                }
                if ($momlabel) {
                    ?>
                    <li class="menu-item"><a
                            href="pedigree.php?personID=<?php echo $tmp['t15_momperson']; ?>&amp;tree=<?php echo $tmp['t15_momtree']; ?>"><?php echo $momlabel; ?></a>
                    </li>
                    <?php
                }
                if ($tmp['t15_featurelinks']) {
                    echo showLinks($tmp['t15_featurelinks'], false, "menu-item");
                }
                ?>
                <li class="search-menu-item">
                    <form id="topsearchform" name="topsearchform" action="search.php" method="get">
                        <?php echo getFORM("search", "get", "", ""); ?>
                        <input type="hidden" value="AND" name="mybool">
                        <?php echo $text['firstname']; ?>:&nbsp;<input size="12" name="myfirstname" type="search" id="myfirstname"> &nbsp;
                        <?php echo $text['lastname']; ?>:&nbsp;<input size="12" name="mylastname" type="search" id="mylastname"> &nbsp;
                        <input type="submit" value="<?php echo $text['search']; ?>">
                    </form>
                </li>
            </ul>
        </div>
    </nav>
    <header class="site-header">
        <div class="wrap">
            <div class="title-area">
                <h1 class="site-title"><a href="<?php echo $homepage; ?>"><?php echo $pagetitle; ?></a></h1>
            </div>
            <aside class="widget-area">
                <section class="widget">
                    <div class="widget-wrap">
                        <aside class="widget-area">
                            <section class="widget">
                                <div class="widget-wrap">
                                    <a href="<?php echo $homepage; ?>"><img
                                            src="<?php echo $templatepath . $tmp['t15_titleimg']; ?>" title="" alt=""></a>
                                </div>
                            </section>
                        </aside>
                    </div>
                </section>
            </aside>
        </div>
    </header>
    <div class="site-inner">
