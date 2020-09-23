<?php
include "tng_begin.php";

$logstring = "<a href=\"histories/feature1.php\">Your Feature 1 Story</a>";
writelog($logstring);
preparebookmark($logstring);

$flags['noheader'] = false; // include the template Custom Header - normally topmenu.php
$flags['nobody'] = true; // do not add the <body> tag - tag added in topmenu.php
$flags['noicons'] = false; // generate the TNG menu bar

// for multi-language pages, you can use $text variables for your Feature Story Title

echo "<!doctype html>\n";
echo "<html lang='en'>\n";

tng_header("Your Feature 1 Story Title", $flags);
?>
<h1>Feature 1 Story</h1>
<p>
    Your Feature 1 story goes here. You can use HTML tags within the body of the story. You can also use PHP code by inserting the code within a < ?
    php ? > section (note that blanks were inserted in between the php starting and ending characters so the
    php start and end tags would display on the page.
</p>
<p>
    If you are creating a story that you want to translate and display in the language the user has selected to view your site, then you can place the
    content that starts with the heading 1 (< h1 >) line to everything in the line before the tng_footer.php
    function call in your language folder and use a PHP
</p>
<p>
    include $mylanguage/feature1.php to include the content from you language folder for each language you support on your site.
    <br>
    For additional information see the TNG Wiki article on creating User Pages or histories using the historytemplate.php file at
    http://tng.lythgoes.net/wiki/index.php?title=User_Pages_-_Getting_Started and
    http://tng.lythgoes.net/wiki/index.php?title=User_Pages_-_Multi-Language
</p>
<p>
    This feature1.php file was created from the historytemplate.php and saved in the histories folder as an example of how to create such a file.
</p>
<?php tng_footer(""); ?>
