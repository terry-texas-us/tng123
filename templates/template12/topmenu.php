<?php
global $mediatypes, $currentuser, $allow_admin, $tmp, $target, $tngconfig, $logout_url;
?>

<body id="bodytop" class="<?php echo pathinfo(basename($_SERVER['SCRIPT_NAME']), PATHINFO_FILENAME); ?> publicbody">
    <a id="top"></a>
<div id="cb-main">
    <header class="cb-header clearfix">
        <div class="cb-shapes">
            <h1 class="cb-headline" data-left="25.52%">
                <a href="index.php"><?php echo getTemplateMessage('t12_maintitle'); ?></a>
            </h1>
            <h2 class="cb-slogan" data-left="25.52%"><?php echo getTemplateMessage('t12_headsubtitle'); ?></h2>

            <div class="cb-mainimage"><img src="<?php echo $templatepath; ?><?php echo $tmp['t12_headimg']; ?>" alt=""></div>
        </div>
        <div class="cb-header-search-box">
            <table>
                <tr>
                    <td class="cb-searchtext">
                        <table>
                            <tr>
                                <td class="col1and2">
                                    <a><span class="cb-searchtext"><?php echo _("First Name"); ?></span></a>
                                </td>
                                <td class="col1and2" colspan="2">
                                    <a><span class="cb-searchtext"><?php echo _("Last Name"); ?></span></a>
                                </td>
                            </tr>
                            <tr>
                                <form id="topsearchform" class="cb-search" name="topsearchform" action="search.php" method="get">
                                    <td class="col1and2">
                                        <input type="hidden" value="AND" name="mybool">
                                        <input size="17" name="myfirstname" type="search" id="myfirstname">
                                    </td>
                                    <td class="col1and2">
                                        <input size="17" name="mylastname" type="search" id="mylastname">
                                    </td>
                                    <td>
                                        <input class="cb-search-button" type="submit" value="&nbsp;&nbsp;">
                                    </td>
                                </form>
                            </tr>
                            <script>
                                document.topsearchform.myfirstname.focus();
                            </script>
                            <tr>
                                <td id="cb-header-links">
                                    <a href="searchform.php">[<?php echo _("Advanced Search"); ?>]</a>
                                </td>
                                <td colspan="2" id="cb-header-links">
                                    <a href="surnames.php">[<?php echo _("Surnames"); ?>]</a>
                                    <br>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

        </div>
    </header>
    <div class="cb-sheet clearfix">
<?php if (strpos($_SERVER['SCRIPT_NAME'], 'index.php') === false) { ?>
    <div class='cb-tng-area'>
<?php } ?>