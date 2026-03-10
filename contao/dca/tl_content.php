<?php

declare(strict_types=1);

use Contao\ContentModel;
use Contao\StringUtil;

// Show CSS ID, CSS class and additional info in backend labels for all content elements
$GLOBALS['TL_DCA']['tl_content']['list']['sorting']['child_record_callback'] = static function (array $row): string {
    $label = (new tl_content())->addCteType($row);

    $parts = [];

    $cssId = StringUtil::deserialize($row['cssID'] ?? '');
    $cssHtmlId = trim($cssId[0] ?? '');
    $cssClass  = trim($cssId[1] ?? '');

    if ($cssHtmlId !== '') {
        $parts[] = 'cssID: <code>' . htmlspecialchars($cssHtmlId) . '</code>';
    }
    if ($cssClass !== '') {
        $parts[] = 'cssClass: <code>' . htmlspecialchars($cssClass) . '</code>';
    }

    // Count child elements (element_group only)
    if (($row['type'] ?? '') === 'element_group') {
        $childCount = ContentModel::countBy(
            ['pid=? AND ptable=? AND tstamp!=0'],
            [$row['id'], 'tl_content']
        );
        if ($childCount > 0) {
            $parts[] = $childCount . ' ' . ($childCount === 1 ? 'Element' : 'Elemente');
        }
    }

    if ($parts !== []) {
        $label = preg_replace(
            '/(<div class="cte_type [^"]*">)(.*?)(<\/div>)/s',
            '$1$2 <span style="opacity:.6"> | ' . implode(' | ', $parts) . '</span>$3',
            $label,
            1
        );
    }

    return $label;
};