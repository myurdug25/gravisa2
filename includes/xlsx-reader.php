<?php
/**
 * Minimal XLSX reader (no dependencies).
 * Returns: [ [rowIndex => [colName => value, ...]], ... ] as list of row arrays (0-based),
 * where row arrays are 0-based numeric arrays in the original sheet column order.
 *
 * Intended for Makpark.xlsx style simple sheets.
 */

function gravisa_xlsx_read_all_rows(string $xlsxPath): array
{
    if (!is_file($xlsxPath)) {
        return [];
    }
    if (!class_exists('ZipArchive')) {
        return [];
    }
    $zip = new ZipArchive();
    if ($zip->open($xlsxPath) !== true) {
        return [];
    }

    // shared strings
    $sharedStrings = [];
    $ssXml = $zip->getFromName('xl/sharedStrings.xml');
    if ($ssXml !== false) {
        $sx = @simplexml_load_string($ssXml);
        if ($sx) {
            foreach ($sx->si as $si) {
                // concatenated text runs
                if (isset($si->t)) {
                    $sharedStrings[] = (string)$si->t;
                } else {
                    $txt = '';
                    if (isset($si->r)) {
                        foreach ($si->r as $r) {
                            $txt .= (string)($r->t ?? '');
                        }
                    }
                    $sharedStrings[] = $txt;
                }
            }
        }
    }

    // find sheet xml files
    $sheetNames = [];
    for ($i = 0; $i < $zip->numFiles; $i++) {
        $st = $zip->statIndex($i);
        if (!$st || empty($st['name'])) continue;
        $name = $st['name'];
        if (preg_match('#^xl/worksheets/sheet(\d+)\.xml$#', $name, $m)) {
            $sheetNames[(int)$m[1]] = $name;
        }
    }
    ksort($sheetNames);

    $all = [];
    foreach ($sheetNames as $sheetPath) {
        $xml = $zip->getFromName($sheetPath);
        if ($xml === false) continue;
        $sx = @simplexml_load_string($xml);
        if (!$sx) continue;
        $sx->registerXPathNamespace('a', 'http://schemas.openxmlformats.org/spreadsheetml/2006/main');
        $rows = [];
        $rowNodes = $sx->xpath('//a:sheetData/a:row');
        if (!$rowNodes) {
            $all[] = [];
            continue;
        }
        foreach ($rowNodes as $row) {
            $cells = [];
            $maxCol = 0;
            foreach ($row->c as $c) {
                $r = (string)($c['r'] ?? ''); // e.g. A1
                if ($r === '' || !preg_match('/^([A-Z]+)\d+$/', $r, $mm)) continue;
                $colLetters = $mm[1];
                $colIndex = 0;
                for ($k = 0; $k < strlen($colLetters); $k++) {
                    $colIndex = $colIndex * 26 + (ord($colLetters[$k]) - 64);
                }
                $colIndex -= 1; // 0-based
                if ($colIndex > $maxCol) $maxCol = $colIndex;
                $t = (string)($c['t'] ?? '');
                $v = isset($c->v) ? (string)$c->v : '';
                $val = '';
                if ($t === 's') {
                    $ix = (int)$v;
                    $val = $sharedStrings[$ix] ?? '';
                } else {
                    $val = $v;
                }
                $cells[$colIndex] = $val;
            }
            if (!$cells) {
                $rows[] = [];
                continue;
            }
            $outRow = array_fill(0, $maxCol + 1, '');
            foreach ($cells as $ci => $cv) {
                $outRow[$ci] = $cv;
            }
            $rows[] = $outRow;
        }
        $all[] = $rows;
    }
    $zip->close();
    return $all;
}

