<?php

declare(strict_types=1);

$input = $argv[1] ?? __DIR__ . '/../docs/LearnCore_database_schema.dbml';
$output = $argv[2] ?? __DIR__ . '/../docs/LearnCore_database_schema.pdf';

if (! is_file($input)) {
    fwrite(STDERR, "Input file not found: {$input}\n");
    exit(1);
}

$lines = file($input, FILE_IGNORE_NEW_LINES);
if ($lines === false) {
    fwrite(STDERR, "Unable to read input file: {$input}\n");
    exit(1);
}

$pageWidth = 595.28;
$pageHeight = 841.89;
$margin = 36;
$fontSize = 7.2;
$lineHeight = 9.4;
$maxChars = 112;
$usableHeight = $pageHeight - ($margin * 2) - 18;
$linesPerPage = (int) floor($usableHeight / $lineHeight);
$wrapped = [];

foreach ($lines as $line) {
    $line = str_replace("\t", '    ', $line);

    if ($line === '') {
        $wrapped[] = '';
        continue;
    }

    while (strlen($line) > $maxChars) {
        $break = strrpos(substr($line, 0, $maxChars), ' ');
        $break = $break === false || $break < 30 ? $maxChars : $break;
        $wrapped[] = rtrim(substr($line, 0, $break));
        $line = '  ' . ltrim(substr($line, $break));
    }

    $wrapped[] = $line;
}

$pages = array_chunk($wrapped, $linesPerPage);
$objects = [];

$addObject = static function (string $body) use (&$objects): int {
    $objects[] = $body;
    return count($objects);
};

$catalogId = $addObject('<< /Type /Catalog /Pages 2 0 R >>');
$pagesId = $addObject('');
$fontId = $addObject('<< /Type /Font /Subtype /Type1 /BaseFont /Courier >>');
$pageIds = [];

foreach ($pages as $pageNumber => $pageLines) {
    $content = "BT\n/F1 {$fontSize} Tf\n1 0 0 1 {$margin} " . ($pageHeight - $margin) . " Tm\n";
    $content .= '(' . pdf_escape('LearnCore Database Schema DBML') . ") Tj\n";
    $content .= "0 -" . ($lineHeight * 1.8) . " Td\n";

    foreach ($pageLines as $line) {
        $content .= '(' . pdf_escape($line) . ") Tj\n0 -{$lineHeight} Td\n";
    }

    $content .= "ET\n";
    $contentId = $addObject("<< /Length " . strlen($content) . " >>\nstream\n{$content}endstream");
    $pageIds[] = $addObject("<< /Type /Page /Parent {$pagesId} 0 R /MediaBox [0 0 {$pageWidth} {$pageHeight}] /Resources << /Font << /F1 {$fontId} 0 R >> >> /Contents {$contentId} 0 R >>");
}

$kids = implode(' ', array_map(static fn (int $id): string => "{$id} 0 R", $pageIds));
$objects[$pagesId - 1] = "<< /Type /Pages /Kids [{$kids}] /Count " . count($pageIds) . ' >>';

$pdf = "%PDF-1.4\n";
$offsets = [0];

foreach ($objects as $index => $body) {
    $offsets[] = strlen($pdf);
    $objectNumber = $index + 1;
    $pdf .= "{$objectNumber} 0 obj\n{$body}\nendobj\n";
}

$xrefOffset = strlen($pdf);
$pdf .= "xref\n0 " . (count($objects) + 1) . "\n";
$pdf .= "0000000000 65535 f \n";

for ($i = 1, $count = count($offsets); $i < $count; $i++) {
    $pdf .= sprintf("%010d 00000 n \n", $offsets[$i]);
}

$pdf .= "trailer\n<< /Size " . (count($objects) + 1) . " /Root {$catalogId} 0 R >>\n";
$pdf .= "startxref\n{$xrefOffset}\n%%EOF\n";

if (file_put_contents($output, $pdf) === false) {
    fwrite(STDERR, "Unable to write PDF file: {$output}\n");
    exit(1);
}

echo $output . PHP_EOL;

function pdf_escape(string $text): string
{
    return str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], $text);
}
