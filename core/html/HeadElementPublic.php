<?php

class HeadElementPublic
{
    private string $title;
    private string $sitePrefix;
    private array $flags;
    private array $metas;
    private array $links;
    private array $scripts;
    private array $styles;
    private string $icons;

    /**
     * HeadElementPublic constructor.
     * @param string $title
     * @param $flags 'nomobile'
     */
    function __construct(string $title, $flags) {
        global $session_charset, $sitename, $tngconfig;
        $title = @htmlspecialchars($title, ENT_QUOTES, $session_charset);
        $this->title = $title;
        $this->flags = $flags;

        $this->sitePrefix = $sitename ? @htmlspecialchars($title ? ": " . $sitename : $sitename, ENT_QUOTES, $session_charset) : "";
        $this->metas = $this->getMetaElements();
        $this->links = $this->getLinkElements();
        $this->scripts = $this->getScriptElements();
        $this->styles = $this->getStyleElements();

        $this->icons = "";
        if (isMobile()) {
            if (!isset($flags['nomobile']) || !$flags['nomobile']) {
                $this->icons = tng_mobileicons($title);
                $this->icons .= "<div id='mcontent'>\n";
            }
            $this->addStyleElement("<style>\n{$tngconfig['mmenustyle']}</style>");
        }
    }

    /**
     * @return string
     */
    public function getTitle(): string {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getHtml(): string {
        $head = "<head>\n";
        $head .= implode("\n", $this->metas) . "\n";
        $head .= "<title>$this->title$this->sitePrefix</title>\n";
        $head .= implode("\n", $this->links) . "\n";
        $head .= implode("\n", $this->scripts) . "\n";
        $head .= implode("\n", $this->styles) . "\n";
        $head .= "</head>\n";
        return $head;
    }

    /**
     * @return string
     */
    public function getIcons(): string {
        return $this->icons;
    }

    /**
     * @param string $meta
     */
    public function addMetaElement(string $meta) {
        $this->metas[] = $meta;
    }

    /**
     * @param string $link
     */
    public function addLinkElement(string $link) {
        $this->links[] = $link;
    }

    /**
     * @param string $script
     */
    public function addscriptElement(string $script) {
        $this->links[] = $script;
    }

    /**
     * @param string $style
     */
    public function addStyleElement(string $style) {
        $this->styles[] = $style;
    }

    /**
     * @return array
     */
    public function getScriptElements(): array {
        global $http, $isConnected, $responsivetables, $tngconfig, $tngprint;

        $scripts = [];
        if ($isConnected) {
            $scripts[] = "<script src='https://code.jquery.com/jquery-3.3.1.min.js' integrity='sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=' crossorigin='anonymous'></script>";
            $scripts[] = "<script src='https://code.jquery.com/ui/1.12.1/jquery-ui.min.js' integrity='sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=' crossorigin='anonymous'></script>";
        } else {
            $scripts[] = "<script>// <![CDATA[\nwindow.jQuery || document.write('<script src=\'js/jquery-3.3.1.min.js?v=910\'>\\x3C/script>')\n//]]></script>";
            $scripts[] = "<script>// <![CDATA[\nwindow.jQuery.ui || document.write('<script src=\'js/jquery-ui-1.12.1.min.js?v=910\'>\\x3C/script>')\n//]]></script>";
        }
        $scripts[] = "<script src='js/net.js'></script>";

        if (isset($this->flags['scripting'])) {
            $scripts[] = $this->flags['scripting'];
        }
        if (!empty($tngconfig['showshare']) && $isConnected && !isMobile()) {
            $w = $http == "https" ? "ws" : "w";
            $scripts[] = "<script src='{$http}://{$w}.sharethis.com/button/buttons.js'></script>";
            $scripts[] = "<script>stLight.options({publisher: 'be4e16ed-3cf4-460b-aaa4-6ac3d0e3004b', doNotHash: true, doNotCopy: true, hashAddressBar: false});</script>";
        }
        if ($tngconfig['menu'] < 2 && !$tngprint && !isMobile()) {
            $scripts[] = "<script src='js/tngmenuhover2.js'></script>";
        }
        if (isMobile() && $responsivetables) {
            $scripts[] = "<script src='js/tablesaw.js'></script>";
            $scripts[] = "<!--[if lt IE 9]>";
            $scripts[] = "<script src='js/respond.js'></script>";
            $scripts[] = "<![endif]-->";
        }
        $scripts[] = self::getLitBoxScript($this->flags['error']);

        if (!empty($tngconfig['cookieapproval']) && strpos($_SERVER['REQUEST_URI'], "/data_protection_policy.php") === FALSE) {
            $scripts[] = self::getCookieApprovalScript();
            $scripts[] = "<script src = 'js/cookiebanner.js'></script >";
        }
        return $scripts;
    }

    /**
     * @return array
     */
    public function getStyleElements(): array {
        $styles = [];
        if (isset($this->flags['style'])) {
            $styles[] = $this->flags['style'];
        }
        return $styles;
    }

    /**
     * @return array
     */
    public function getLinkElements(): array {
        global $responsivetables, $templatepath, $tngconfig, $tngdomain, $tngprint;
        $links = [];
        $links[] = "<link href='https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I' crossorigin='anonymous'>";
        if (isMobile() && $responsivetables) {
            $links[] = "<link href='css/tablesaw.bare.css' rel='stylesheet'>";
        }
        $links[] = "<link href='css/genstyle.css' rel='stylesheet'>";
        if (isset($this->flags['tabs'])) {
            $links[] = "<link href='{$templatepath}css/{$this->flags['tabs']}' rel='stylesheet'>";
        }
        $links[] = "<link href='{$templatepath}css/templatestyle.css' rel='stylesheet'>";
        if (isMobile()) {
            $links[] = "<link href='css/tngmobile.css' rel='stylesheet'>";
            $links[] = "<link href='{$templatepath}css/tngmobile.css' rel='stylesheet'>";
        }
        $links[] = "<link href='{$templatepath}css/mytngstyle.css' rel='stylesheet'>";
        if (isset($this->flags['link'])) {
            $links[] = $this->flags['link'];
        }
        if (isMobile()) {
            $links[] = "<link rel='apple-touch-icon-precomposed' sizes='144x144' href='$tngdomain/img/tng-apple-icon-144.png'>";
            $links[] = "<link rel='apple-touch-icon-precomposed' sizes='114x114' href='$tngdomain/img/tng-apple-icon-114.png'>";
            $links[] = "<link rel='apple-touch-icon-precomposed' sizes='72x72' href='$tngdomain/img/tng-apple-icon-72.png'>";
            $links[] = "<link rel='apple-touch-icon-precomposed' href='$tngdomain/img/tng-apple-icon.png'>";
            $links[] = "<link rel='shortcut icon' href='$tngdomain/img/tng-apple-icon.png'>";
        } elseif ($tngconfig['favicon']) {
            $links[] = "<link rel='shortcut icon' href='$tngdomain/{$tngconfig['favicon']}'>";
        }
        $links[] = "<link rel='alternate' type='application/rss+xml' title='RSS' href='tngrss.php'>";
        if ($tngprint) {
            $links[] = "<link href='css/tngprint.css' rel='stylesheet'>";
        }
        return $links;
    }

    /**
     * @return array
     */
    public function getMetaElements(): array {
        global $custommeta, $fbOGimage, $pageURL, $site_desc, $sitename, $tngdomain;

        $metas[] = "<meta charset='utf-8'>";
        $metas[] = "<meta name='author' content='Darrin Lythgoe'>";
        $metas[] = "<meta name='Description' content='$this->title$this->sitePrefix'>";
        $metas[] = "<meta name='Keywords' content='$site_desc'>";
        $metas[] = "<meta name='viewport' content='width=device-width, initial-scale=1'>";
        if (isset($this->flags['norobots'])) {
            $metas[] = $this->flags['norobots'];
        }
        if (isMobile()) {
            $metas[] = "<meta name='apple-mobile-web-app-capable' content='yes'>";
        }

        if ($fbOGimage) { // Facebook Open Graph protocol
            $metas[] = "<meta property='og:title' content='$sitename'>";
            $metas[] = "<meta property='og:description' content='$this->title'>";
            $metas[] = "<meta property='og:url' content='$tngdomain/$pageURL'>";
            $metas[] = $fbOGimage; // expected to be properly formed single meta tag
        }
        if (isset($this->flags['autorefresh']) && $this->flags['autorefresh'] == 1) {
            $metas[] = "<meta http-equiv='refresh' content='30'>";
        }
        // @include $custommeta; // todo include in dynamic method. static property needed
        return $metas;
    }

    /**
     * @return string
     */
    public static function getCookieApprovalScript(): string {
        global $text;
        $script = "<script>\n";
        $script .= "window.CookieHinweis_options = {\n";
        $script .= "message: '{$text['cookieuse']}<br>',\n";
        $script .= "agree: '{$text['understand']}',\n";
        $script .= "learnMore: '&bull; {$text['viewpolicy']}',\n";
        $script .= "link: 'data_protection_policy.php',\n";
        $script .= "theme: 'hell-unten-rechts'\n";
        $script .= "};\n";
        $script .= "</script >";
        $script .= "<script src = 'js/cookiebanner.js'></script >\n";
        return $script;
    }

    /**
     * @param $error
     * @return string
     */
    public static function getLitBoxScript($error): string {
        global $text;
        $script = "<script>\n";
        $script .= "var tnglitbox;\n";
        $script .= "var share = 0;\n";
        $script .= "var closeimg = 'img/tng_close.gif';\n";
        $script .= "const loadingmsg = '{$text['loading']}';\n";
        $script .= "const expand_msg = '{$text['expand']}';\n";
        $script .= "const collapse_msg = '{$text['collapse']}';\n";

        if (isset($error) && $error) {
            $script .= "jQuery(document).ready(function(){openLogin('ajx_login.php?p=" . urlencode("") . "&message={$error}');});\n";
        }
        $script .= "</script>";
        return $script;
    }

    public static function getFamilyChartScript(): string {
        $script = "<script>\n";
        $script .= "function toggle(elem) {\n";
        $script .= "if (document.getElementById(elem).style.display) {\n";
        $script .= "document.getElementById(elem).style.display = '';\n";
        $script .= "} else {";
        $script .= "document.getElementById(elem).style.display = 'block';\n";
        $script .= "}\n";
        $script .= "}\n";
        $script .= "</script>\n";
        return $script;
    }
}
