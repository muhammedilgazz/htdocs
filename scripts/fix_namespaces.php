<?php

echo "Namespace fixer script started.\n";

function fix_namespaces_in_dir(string $directory, string $namespace) {
    $files = glob($directory . '/*.php');
    echo "Found " . count($files) . " files in $directory\n";

    foreach ($files as $file_path) {
        $content = file_get_contents($file_path);

        // Check if namespace already exists
        if (strpos($content, "namespace {$namespace};") !== false) {
            echo "Skipping $file_path (namespace already exists).\n";
            continue;
        }

        // Prepend the namespace after the opening php tag
        $new_content = preg_replace(
            '/<\?php/',
            "<?php\n\nnamespace {$namespace};",
            $content,
            1 // Only replace the first occurrence
        );

        if ($new_content !== $content) {
            file_put_contents($file_path, $new_content);
            echo "Fixed namespace for: $file_path\n";
        } else {
            echo "Could not fix namespace for: $file_path (no '<?php' tag found?).\n";
        }
    }
}

$controllers_dir = __DIR__ . '/../app/Controllers';
$models_dir = __DIR__ . '/../app/Models';

fix_namespaces_in_dir($controllers_dir, 'App\\Controllers');
fix_namespaces_in_dir($models_dir, 'App\\Models');

echo "Namespace fixer script finished.\n";

?>