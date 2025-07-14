<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Script Test</title>
</head>
<body>
    <h1>Simple Script Test</h1>
    
    <div id="test-results"></div>
    
    <!-- Test 1: Direct inline script -->
    <script>
        console.log('=== INLINE SCRIPT TEST ===');
        document.getElementById('test-results').innerHTML += '<p>✅ Inline script working</p>';
    </script>
    
    <!-- Test 2: jQuery from CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        console.log('=== JQUERY CDN TEST ===');
        setTimeout(function() {
            if (typeof $ !== 'undefined') {
                console.log('✅ jQuery from CDN loaded');
                $('#test-results').append('<p>✅ jQuery from CDN loaded</p>');
            } else {
                console.log('❌ jQuery from CDN failed');
                document.getElementById('test-results').innerHTML += '<p>❌ jQuery from CDN failed</p>';
            }
        }, 500);
    </script>
    
    <!-- Test 3: Including our script.php -->
    <?php
    require_once 'config/config.php';
    echo '<script>';
    echo 'console.log("=== PHP CONFIG TEST ===");';
    echo 'console.log("CSRF Token: ' . generate_csrf_token() . '");';
    echo 'document.getElementById("test-results").innerHTML += "<p>✅ PHP config working</p>";';
    echo '</script>';
    ?>
    
    <!-- Test 4: Including script.php -->
    <script>
        console.log('=== BEFORE SCRIPT.PHP ===');
        document.getElementById('test-results').innerHTML += '<p>ℹ️ Before script.php include</p>';
    </script>
    
    <?php 
    echo "<!-- Starting script.php include -->\n";
    include 'partials/script.php'; 
    echo "<!-- Finished script.php include -->\n";
    ?>
    
    <script>
        console.log('=== AFTER SCRIPT.PHP ===');
        document.getElementById('test-results').innerHTML += '<p>ℹ️ After script.php include</p>';
        
        // Test if our scripts loaded
        setTimeout(function() {
            console.log('=== FINAL TEST RESULTS ===');
            console.log('jQuery:', typeof $ !== 'undefined');
            console.log('Bootstrap:', typeof bootstrap !== 'undefined');
            console.log('Toastr:', typeof toastr !== 'undefined');
            
            const finalResults = '<h3>Final Results:</h3>' +
                '<p>jQuery: ' + (typeof $ !== 'undefined' ? '✅' : '❌') + '</p>' +
                '<p>Bootstrap: ' + (typeof bootstrap !== 'undefined' ? '✅' : '❌') + '</p>' +
                '<p>Toastr: ' + (typeof toastr !== 'undefined' ? '✅' : '❌') + '</p>';
                
            document.getElementById('test-results').innerHTML += finalResults;
        }, 2000);
    </script>
    
</body>
</html>