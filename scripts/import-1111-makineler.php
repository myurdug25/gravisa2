<?php
/**
 * 1111 klasöründeki görselleri parse edip makineler_admin.json oluşturur
 * Görselleri images/makineler/ klasörüne kopyalar
 */
$baseDir = dirname(__DIR__);
$sourceDir = $baseDir . '/1111/1111';
$targetDir = $baseDir . '/images/makineler';
$dataFile = $baseDir . '/data/makineler_admin.json';

if (!is_dir($sourceDir)) {
    die("1111/1111 klasörü bulunamadı.\n");
}

if (!is_dir($targetDir)) {
    mkdir($targetDir, 0755, true);
}

// Bilinen markalar (firma) - parse için
$brands = [
    'Atlas Copco', 'Hitachi', 'Caterpillar', 'Volvo', 'Sandvik', 'Hidromek', 'Manitou',
    'Liebherr', 'Wacker Neuson', 'Dynapac', 'Mercedes', 'New Holland', 'Ford', 'MAN',
    'Tünelmak', 'Tümmak', 'Kale Makine', 'Lasparsan', 'Putzmeister', 'Meyco', 'Aliva',
    'AKSA', 'CSK', 'MAKKON', 'Kümsan', 'SANDVİK-RAMMER', 'Montebert', 'Teksomak',
    'ANKA', 'KJ POWER', 'Miltek', 'Isuzu', 'Sargın', 'Doğan', 'Kardelen', 'Tiger',
    'Epiroc', 'GHH', 'Man', 'Massey Ferguson', 'Mitsubishi', 'Kawasaki', 'Sumitomo',
    'Yanmar', 'BPI', 'Böhler', 'Mine Master', 'JCB', 'Case', 'Komatsu', 'John Deere',
];

$files = scandir($sourceDir);
$machines = [];
$id = 1;

foreach ($files as $file) {
    if ($file === '.' || $file === '..' || is_dir($sourceDir . '/' . $file)) continue;
    
    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'jfif'])) continue;
    
    $nameWithoutExt = pathinfo($file, PATHINFO_FILENAME);
    $nameWithoutExt = preg_replace('/^0+/', '', $nameWithoutExt);
    
    $tip = '';
    $firma = '';
    $tipModel = '';
    
    foreach ($brands as $brand) {
        $pos = mb_stripos($nameWithoutExt, $brand);
        if ($pos !== false) {
            $tip = trim(mb_substr($nameWithoutExt, 0, $pos));
            $firma = $brand;
            $tipModel = trim(mb_substr($nameWithoutExt, $pos + mb_strlen($brand)));
            break;
        }
    }
    
    if ($tip === '') {
        $parts = preg_split('/\s+/', $nameWithoutExt, 2);
        $tip = $parts[0] ?? $nameWithoutExt;
        $rest = $parts[1] ?? '';
        $firma = '';
        $tipModel = $rest;
    }
    
    $safeName = 'makine_' . $id . '.' . $ext;
    $targetPath = $targetDir . '/' . $safeName;
    $sourcePath = $sourceDir . '/' . $file;
    
    if (copy($sourcePath, $targetPath)) {
        $machines[] = [
            'id' => $id,
            'no' => (string)$id,
            'tip' => $tip,
            'firma' => $firma,
            'tipModel' => $tipModel,
            'modelYil' => '',
            'guc' => '',
            'gucBirim' => '',
            'kapasite' => '',
            'saseSeriNo' => '',
            'motorSeriNo' => '',
            'motorMarka' => '',
            'motorTip' => '',
            'stok' => true,
            'img' => 'images/makineler/' . $safeName,
        ];
        $id++;
    }
}

file_put_contents($dataFile, json_encode($machines, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
echo "Toplam " . count($machines) . " makine import edildi.\n";
echo "Veri: $dataFile\n";
echo "Görseller: $targetDir\n";
