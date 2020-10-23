<?php

/**
 * Clears most attributes, keeping only viewbox. Inserts passed attributes. Goal is to allow theming options.
 *
 * @param $sourceFile
 * @param array $attributes attributes which are inserted with new values
 * @return string|string[]|null
 */
function buildSvgElement($sourceFile, array $attributes) {
    $element = file_get_contents($sourceFile);
    $tagStartPosition = stripos($element, "<svg ");
    $insertionStartPosition = $tagStartPosition + 5;
    $quotesDelimitedStringPattern = '("|\')((?:\\\1|(?:(?!\1).))*)\1';
    foreach (['class', 'width', 'height', 'fill', 'xmlns'] as $key) {
        $pattern = "/$key=$quotesDelimitedStringPattern/";
        $element = preg_replace($pattern, "", $element);
    }
    foreach ($attributes as $key => $attribute) {
        $pattern = "/$key=$quotesDelimitedStringPattern/";
        if (preg_match($pattern, $element)) {
            $replacement = "$key=$1{$attribute}$1";
            $element = preg_replace($pattern, $replacement, $element);
        } else {
            $element = substr_replace($element, "$key='{$attribute} '", $insertionStartPosition, 0);
        }
    }
    return preg_replace('/\s+/', ' ', $element);
}
