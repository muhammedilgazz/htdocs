<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debug Layout</title>
</head>
<body>
    <h1>Debug Layout</h1>
    
    <div id="debug-info"></div>
    
    <script>
        console.log('=== BEFORE LAYOUT INCLUDE ===');
        document.getElementById('debug-info').innerHTML += '<p>✅ Before layout include</p>';
    </script>
    
    <?php
    echo "<p>Starting layoutBottom.php include...</p>";
    
    // Check if layoutBottom.php exists
    if (file_exists('layouts/layoutBottom.php')) {
        echo "<p>✅ layoutBottom.php exists</p>";
        
        // Try to read and display the content
        $content = file_get_contents('layouts/layoutBottom.php');
        echo "<h3>layoutBottom.php content:</h3>";
        echo "<pre style='background: #f0f0f0; padding: 10px; border: 1px solid #ccc;'>";
        echo htmlspecialchars($content);
        echo "</pre>";
        
        echo "<p>Including layoutBottom.php now...</p>";
        include 'layouts/layoutBottom.php';
        echo "<p>✅ layoutBottom.php included</p>";
        
    } else {
        echo "<p>❌ layoutBottom.php not found</p>";
    }
    ?>
    
    <script>
        console.log('=== AFTER LAYOUT INCLUDE ===');
        document.getElementById('debug-info').innerHTML += '<p>✅ After layout include</p>';
        
        setTimeout(function() {
            console.log('=== CHECKING LOADED LIBRARIES ===');
            const libs = {
                'jQuery': typeof $ !== 'undefined',
                'Bootstrap': typeof bootstrap !== 'undefined',
                'Toastr': typeof toastr !== 'undefined'
            };
            
            let libStatus = '<h3>Library Status:</h3>';
            for (const [name, loaded] of Object.entries(libs)) {
                libStatus += '<p>' + name + ': ' + (loaded ? '✅' : '❌') + '</p>';
                console.log(name + ':', loaded);
            }
            
            document.getElementById('debug-info').innerHTML += libStatus;
        }, 2000);
    </script>
    
</body>
</html>