<?php
$zipFile = '/home/u799453710/domains/universalservicehubbd.com/public_html/core.zip'; // Path to your ZIP file
$extractTo = '/home/u799453710/domains/universalservicehubbd.com/public_html/'; // Path where files will be extracted

// Make sure the extract folder exists
if (!is_dir($extractTo)) {
    mkdir($extractTo, 0777, true);
}

$zip = new ZipArchive;

if ($zip->open($zipFile) === TRUE) {
    $zip->extractTo($extractTo);

    echo "ZIP file extracted successfully!<br>";
    echo "Extracted files:<br>";

    // List extracted files
    for ($i = 0; $i < $zip->numFiles; $i++) {
        $filename = $zip->getNameIndex($i);
        echo htmlspecialchars($filename) . "<br>";
    }

    $zip->close();
} else {
    echo "Failed to open the ZIP file.";
}
?>
