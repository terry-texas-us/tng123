<?php
// based on the code supplied by the reCAPTCHA web site
// with modifications by Roger Moffat and Bryan S. Larson to work with TNG
// Version: No Captcha reCAPTCHA v10.1.0.3 last modified 23 Feb 2015 by Bryan S. Larson
// This update adds a feature to 'remember' if a visitor has successfully completed a reCAPTCHA challenge, no further challenges will be presented to that visitor during the visit.

global $currentuser;
if ($currentuser || $_SESSION['passedcaptcha']) {
    return;
}

include_once "$mylanguage/admintext.php";
require_once "recaptchalib.php";

// Sign up for a reCAPTCHA account from https://www.google.com/recaptcha/admin/create
// Once your account is created, enter your assigned keys
// in customconfig.php or uncomment the next 2 lines and enter it below.
//$siteKey = "yoursiteKeyHere";
//$secret = "yoursecretKeyHere";

$tngSiteKey = $siteKey ? $siteKey : $tngconfig['sitekey'];
$tngSecret = $secret ? $secret : $tngconfig['secret'];

if ($tngSiteKey && $tngSecret) {

    // In the next group of 2 lines, comment out the line that you do NOT want
    //as the Theme. The last uncommented line will be in effect.

    $captchatheme = "light";

    // This "switch" statement sets the language code for the reCAPTCHA
    switch ($mylanguage) {
        case "languages/English":
        case "languages/English-UTF8":
            $captchalang = "en";
            break;
        case "languages/Dutch":
        case "languages/Dutch-UTF8":
            $captchalang = "nl";
            break;
        case "languages/French":
        case "languages/French-UTF8":
            $captchalang = "fr";
            break;
        case "languages/German":
        case "languages/German-UTF8":
            $captchalang = "de";
            break;
        case "languages/PortugeseBR":
        case "languages/PortugeseBR-UTF8":
            $captchalang = "pt";
            break;
        case "languages/Russian":
        case "languages/Russian-UTF8":
            $captchalang = "ru";
            break;
        case "languages/Spanish":
        case "languages/Spanish-UTF8":
            $captchalang = "es";
            break;
        case "languages/Turkish":
        case "languages/Turkish-UTF8":
            $captchalang = "tr";
            break;
    }

    // The response from reCAPTCHA
    $resp = null;
    // The error code from reCAPTCHA, if any
    $error = null;

    $reCaptcha = new ReCaptcha($tngSecret);

    # was there a reCAPTCHA response?
    if ($_POST["g-recaptcha-response"]) {
        $resp = $reCaptcha->verifyResponse(
            $_SERVER["REMOTE_ADDR"],
            $_POST["g-recaptcha-response"]
        );
    }

    if ($resp != null && $resp->success) {
        $_SESSION['passedcaptcha'] = 'true';
        return;
    }
    // if the response from the reCAPTCHA is valid, return to suggest.php
    ?>

    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
        <div class="g-recaptcha" data-sitekey="<?php echo $tngSiteKey; ?>" data-theme="<?php echo $captchatheme; ?>"></div>
        <script type="text/javascript"
                src="https://www.google.com/recaptcha/api.js?hl=<?php echo $lang; ?>">
        </script>
        <br>
        <input type="submit" value="<?php echo $admtext['text_continue']; ?>">
        <input type="hidden" name="enttype" value="<?php echo $enttype; ?>">
        <input type="hidden" name="ID" value="<?php echo $ID; ?>">
        <input type="hidden" name="tree" value="<?php echo $tree; ?>">
    </form>
    <input type="hidden" name="fingerprint" value="realperson">
    <?php
    tng_footer("");
    exit;
}
?>