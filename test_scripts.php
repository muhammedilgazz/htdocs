<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Scripts Loading</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; }
        .test-result { margin: 10px 0; padding: 10px; border-radius: 5px; }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .info { background: #d1ecf1; color: #0c5460; border: 1px solid #bee5eb; }
    </style>
</head>
<body>
    <h1>Test Scripts Loading</h1>
    
    <div class="test-result info">
        <h3>1. Testing script.php include:</h3>
        <?php
        echo "<p>Before including script.php...</p>";
        flush();
        
        if (file_exists('partials/script.php')) {
            echo "<p>✅ script.php file exists</p>";
            include 'partials/script.php';
            echo "<p>✅ script.php included successfully</p>";
        } else {
            echo "<p>❌ script.php file not found</p>";
        }
        ?>
    </div>
    
    <div class="test-result info">
        <h3>2. Testing direct script tags:</h3>
    </div>
    
    <!-- Direct jQuery test -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        console.log('=== DIRECT SCRIPT TEST ===');
        
        // Test if jQuery loaded
        if (typeof $ !== 'undefined') {
            console.log('✅ jQuery loaded successfully');
            document.write('<div class="test-result success">✅ jQuery loaded successfully</div>');
        } else {
            console.log('❌ jQuery failed to load');
            document.write('<div class="test-result error">❌ jQuery failed to load</div>');
        }
        
        // Test module files existence
        const moduleFiles = [
            'assets/js/modules/core.js',
            'assets/js/modules/ui.js',
            'assets/js/modules/forms.js',
            'assets/js/modules/navigation.js',
            'assets/js/scripts.js'
        ];
        
        console.log('=== TESTING MODULE FILES ===');
        
        moduleFiles.forEach(function(file) {
            fetch(file)
                .then(response => {
                    if (response.ok) {
                        console.log('✅ ' + file + ' exists');
                        document.getElementById('module-results').innerHTML += '<p>✅ ' + file + ' exists</p>';
                    } else {
                        console.log('❌ ' + file + ' not found');
                        document.getElementById('module-results').innerHTML += '<p>❌ ' + file + ' not found</p>';
                    }
                })
                .catch(error => {
                    console.log('❌ ' + file + ' error: ' + error);
                    document.getElementById('module-results').innerHTML += '<p>❌ ' + file + ' error</p>';
                });
        });
    </script>
    
    <div class="test-result info">
        <h3>3. Module Files Test:</h3>
        <div id="module-results">Testing module files...</div>
    </div>
    
    <div class="test-result info">
        <h3>4. Testing Bootstrap:</h3>
    </div>
    
    <!-- Bootstrap test -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        setTimeout(function() {
            if (typeof bootstrap !== 'undefined') {
                console.log('✅ Bootstrap loaded successfully');
                document.write('<div class="test-result success">✅ Bootstrap loaded successfully</div>');
            } else {
                console.log('❌ Bootstrap failed to load');
                document.write('<div class="test-result error">❌ Bootstrap failed to load</div>');
            }
        }, 1000);
    </script>
    
    <div class="test-result info">
        <h3>5. Console Log Check:</h3>
        <p>Open Developer Tools (F12) and check the Console tab for detailed messages.</p>
        <p>You should see messages starting with "=== DIRECT SCRIPT TEST ==="</p>
    </div>
    
    <br>
    <div class="test-result info">
        <h3>Next Steps:</h3>
        <ul>
            <li>If jQuery ✅ but modules ❌: JavaScript module files are missing</li>
            <li>If everything ❌: Check file permissions and paths</li>
            <li>If scripts.php include ❌: Path or permission issue</li>
            <li><a href="index.php">Go back to main page</a> after fixing issues</li>
        </ul>
    </div>
    
</body>
</html>