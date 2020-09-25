<?php

require_once "./public/people.php";
require_once "./classes/SingleMediaCard.php";
require_once "./classes/RecentPeopleCard.php";

$_SESSION['tng_mediatree'] = $tree;
$_SESSION['tng_mediasearch'] = "";

$flags['imgprev'] = true;

echo "<div style='display: table; width: 100%;'>\n";
echo "<div style='display: table-row;'>\n";

$singleMediaCard = new SingleMediaCard();
echo $singleMediaCard->buildHtmlContent($tree, 'photos', 5);

$recentPeopleCard = new RecentPeopleCard();
$recentPeopleCard->setPath("");
$tables = ['people' => $people_table, 'trees' => $trees_table];
echo $recentPeopleCard->buildHtmlContent($text['individuals'], $tables, $tree, 10);
echo "</div>\n";
echo "</div>\n";
