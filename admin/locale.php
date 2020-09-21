<?php

/**
 * Verifies if the given $locale is supported in the project
 * @param string $locale
 * @return bool
 */
function valid(string $locale) {
    return in_array($locale, ['en_US', 'en', 'de_DE', 'de', 'es_ES', 'es']);
}

$gtLang = '';
if (isset($_GET['lang']) && valid($_GET['lang'])) { // the locale can be changed through the query-string
    $gtLang = $_GET['lang'];    //you should sanitize this!
    setcookie('lang', $gtLang); //it's stored in a cookie so it can be reused
} elseif (isset($_COOKIE['lang']) && valid($_COOKIE['lang'])) { // if the cookie is present instead, let's just keep it
    $gtLang = $_COOKIE['lang']; //you should sanitize this!
} elseif (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) { // default: look for the languages the browser says the user accepts
    $langs = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
    array_walk($langs, function (&$lang) { $lang = strtr(strtok($lang, ';'), ['-' => '_']); });
    foreach ($langs as $browser_lang) {
        if (valid($browser_lang)) {
            $gtLang = $browser_lang;
            break;
        }
    }
}

$gtLang = 'de_DE';

// here we define the global system locale given the found language
putenv("LANG=$gtLang");

// this might be useful for date functions (LC_TIME) or money formatting (LC_MONETARY), for instance
setlocale(LC_ALL, $gtLang);

// this will make Gettext look for ../locale/<gtLang>/LC_MESSAGES/main.mo
$pathname = bindtextdomain('main', './locale');

// indicates in what encoding the file should be read
bind_textdomain_codeset('main', 'UTF-8');

// here we indicate the default domain the gettext() calls will respond to
textdomain('main');

// TODO add secondary domains binds and codesets here
// bindtextdomain('secondary', './locales');
// bind_textdomain_codeset('secondary', 'UTF-8');
// this would look for the string in secondary.mo instead of main.mo
// echo dgettext('secondary', 'Welcome back!');

echo gettext("Existing Branch");