<?php

require_once "./public/people.php";
require_once "./classes/SingleMediaCard.php";
require_once "./classes/RecentPeopleCard.php";

$getperson_url = getURL("getperson", 1);
$showmedia_url = getURL("showmedia", 1);
$familygroup_url = getURL("familygroup", 1);
$showsource_url = getURL("showsource", 1);
$showrepo_url = getURL("showrepo", 1);
$whatsnew_url = getURL("whatsnew", 1);
$pedigree_url = getURL("pedigree", 1);
$placesearch_url = getURL("placesearch", 1);
$showtree_url = getURL("showtree", 1);
$showmap_url = getURL("showmap", 1);

$_SESSION['tng_mediatree'] = $tree;
$_SESSION['tng_mediasearch'] = "";

$flags['imgprev'] = true;

echo "<div style=\"display:table;width:100%\">\n";
echo "<div style=\"display:table-row\">";

$singleMediaCard = new SingleMediaCard();
echo $singleMediaCard->buildHtmlContent($tree, 'photos', 5);

$recentPeopleCard = new RecentPeopleCard();
$recentPeopleCard->setPath($cms['tngpath']);
$tables = ['people' => $people_table, 'trees' => $trees_table];
echo $recentPeopleCard->buildHtmlContent($text['individuals'], $tables, $tree, 10);
echo "</div>";
echo "</div>";
