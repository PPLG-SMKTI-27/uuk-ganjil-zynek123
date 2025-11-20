<?php
echo "<h1>DEBUG STRUCTURE - CHECK APP FOLDER</h1>";

// Tampilkan current directory
echo "<h2>Current Directory:</h2>";
echo "<pre>" . __DIR__ . "</pre>";

// Cek isi folder app
echo "<h2>Checking app folder:</h2>";
$app_path = __DIR__ . '/app';
echo "Path: " . $app_path . "<br>";
echo "Exists: " . (is_dir($app_path) ? 'YES' : 'NO') . "<br>";

if (is_dir($app_path)) {
    echo "<h3>All Files and Folders in app:</h3>";
    $app_files = scandir($app_path);
    echo "<pre>";
    print_r($app_files);
    echo "</pre>";
    
    // Cek subfolders dalam app
    $subfolders = ['controllers', 'controller', 'config', 'models', 'views'];
    foreach ($subfolders as $folder) {
        $folder_path = $app_path . '/' . $folder;
        echo "Checking: $folder - " . (is_dir($folder_path) ? 'EXISTS' : 'NOT FOUND') . "<br>";
        
        if (is_dir($folder_path)) {
            $files = scandir($folder_path);
            echo "Files in $folder: <pre>";
            print_r($files);
            echo "</pre>";
        }
    }
}

// Cari file controller di mana saja
echo "<h2>Searching for Controller Files:</h2>";
function findControllers($dir) {
    $results = [];
    $files = scandir($dir);
    
    foreach ($files as $file) {
        if ($file == '.' || $file == '..') continue;
        
        $path = $dir . '/' . $file;
        
        if (is_dir($path)) {
            $results = array_merge($results, findControllers($path));
        } elseif (strpos($file, 'Controller.php') !== false) {
            $results[] = $path;
        }
    }
    
    return $results;
}

$all_controllers = findControllers(__DIR__);
echo "<h3>Found Controller Files:</h3>";
echo "<pre>";
print_r($all_controllers);
echo "</pre>";
?>