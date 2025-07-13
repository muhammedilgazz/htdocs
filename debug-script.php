<?php
require_once 'config/config.php';
require_once 'classes/Database.php';
require_once 'classes/SecurityManager.php';
require_once 'includes/auth_check.php';
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JavaScript Debug Test</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .debug-section { margin: 20px 0; padding: 15px; border: 1px solid #ddd; border-radius: 5px; }
        .success { background-color: #d4edda; border-color: #c3e6cb; }
        .error { background-color: #f8d7da; border-color: #f5c6cb; }
        .warning { background-color: #fff3cd; border-color: #ffeaa7; }
        .info { background-color: #d1ecf1; border-color: #bee5eb; }
        pre { background: #f8f9fa; padding: 10px; border-radius: 3px; overflow-x: auto; }
    </style>
</head>
<body>
    <h1>🔍 JavaScript Debug Test</h1>
    
    <div class="debug-section info">
        <h3>📋 Test Information</h3>
        <p><strong>Page:</strong> <?= $_SERVER['REQUEST_URI'] ?></p>
        <p><strong>Time:</strong> <?= date('Y-m-d H:i:s') ?></p>
        <p><strong>PHP Version:</strong> <?= PHP_VERSION ?></p>
        <p><strong>User Agent:</strong> <?= $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown' ?></p>
    </div>

    <div class="debug-section">
        <h3>🔧 Manual Console Commands</h3>
        <p>Open browser console (F12) and run these commands:</p>
        <pre>
// Test basic JavaScript
console.log('Manual test - JavaScript is working');

// Test jQuery
if (typeof $ !== 'undefined') {
    console.log('✓ jQuery is loaded');
    console.log('jQuery version:', $.fn.jquery);
} else {
    console.log('✗ jQuery is NOT loaded');
}

// Test Bootstrap
if (typeof bootstrap !== 'undefined') {
    console.log('✓ Bootstrap is loaded');
} else {
    console.log('✗ Bootstrap is NOT loaded');
}

// Test Chart.js
if (typeof Chart !== 'undefined') {
    console.log('✓ Chart.js is loaded');
} else {
    console.log('✗ Chart.js is NOT loaded');
}

// Test Toastr
if (typeof toastr !== 'undefined') {
    console.log('✓ Toastr is loaded');
} else {
    console.log('✗ Toastr is NOT loaded');
}

// Test global functions
if (typeof showSuccess !== 'undefined') {
    console.log('✓ Global functions are loaded');
} else {
    console.log('✗ Global functions are NOT loaded');
}
        </pre>
    </div>

    <div class="debug-section">
        <h3>📁 File Path Tests</h3>
        <p>Check if these files exist:</p>
        <ul>
            <li><a href="partials/script.php" target="_blank">partials/script.php</a></li>
            <li><a href="assets/vendor/jquery/jquery.min.js" target="_blank">assets/vendor/jquery/jquery.min.js</a></li>
            <li><a href="assets/js/scripts.js" target="_blank">assets/js/scripts.js</a></li>
            <li><a href="assets/vendor/toastr/toastr.min.js" target="_blank">assets/vendor/toastr/toastr.min.js</a></li>
            <li><a href="assets/vendor/perfect-scrollbar/perfect-scrollbar.min.js" target="_blank">assets/vendor/perfect-scrollbar/perfect-scrollbar.min.js</a></li>
        </ul>
    </div>

    <div class="debug-section">
        <h3>🎯 Quick Tests</h3>
        <button onclick="testAlert()">Test Alert</button>
        <button onclick="testConsole()">Test Console</button>
        <button onclick="testJQuery()">Test jQuery</button>
        <button onclick="testToastr()">Test Toastr</button>
        <button onclick="testGlobalFunctions()">Test Global Functions</button>
    </div>

    <div id="test-results" class="debug-section">
        <h3>📊 Test Results</h3>
        <div id="results-content">Click test buttons above to see results...</div>
    </div>

    <script>
        // Test functions
        function testAlert() {
            alert('Alert test - JavaScript is working!');
        }
        
        function testConsole() {
            console.log('Console test - JavaScript is working!');
            document.getElementById('results-content').innerHTML += '<p class="success">✓ Console test passed</p>';
        }
        
        function testJQuery() {
            if (typeof $ !== 'undefined') {
                $('#results-content').append('<p class="success">✓ jQuery is working</p>');
                console.log('jQuery test passed');
            } else {
                $('#results-content').append('<p class="error">✗ jQuery is NOT working</p>');
                console.log('jQuery test failed');
            }
        }
        
        function testToastr() {
            if (typeof toastr !== 'undefined') {
                toastr.success('Toastr test passed!');
                document.getElementById('results-content').innerHTML += '<p class="success">✓ Toastr is working</p>';
            } else {
                document.getElementById('results-content').innerHTML += '<p class="error">✗ Toastr is NOT working</p>';
            }
        }
        
        function testGlobalFunctions() {
            if (typeof showSuccess !== 'undefined') {
                showSuccess('Global functions test passed!');
                document.getElementById('results-content').innerHTML += '<p class="success">✓ Global functions are working</p>';
            } else {
                document.getElementById('results-content').innerHTML += '<p class="error">✗ Global functions are NOT working</p>';
            }
        }
        
        // Auto-run basic tests
        document.addEventListener('DOMContentLoaded', function() {
            console.log('=== DEBUG PAGE LOADED ===');
            console.log('DOM Content Loaded at:', new Date().toLocaleTimeString());
            
            // Auto-test basic functionality
            setTimeout(() => {
                testConsole();
                testJQuery();
                testToastr();
                testGlobalFunctions();
            }, 1000);
        });
    </script>

    <!-- Now include the actual script.php -->
    <?php include 'partials/script.php'; ?>
    
    <script>
        console.log('=== AFTER SCRIPT.PHP INCLUDE ===');
        console.log('Script.php should have been loaded by now');
        
        // Final check
        setTimeout(() => {
            console.log('=== FINAL CHECK ===');
            console.log('jQuery available:', typeof $ !== 'undefined');
            console.log('Bootstrap available:', typeof bootstrap !== 'undefined');
            console.log('Chart.js available:', typeof Chart !== 'undefined');
            console.log('Toastr available:', typeof toastr !== 'undefined');
            console.log('Global functions available:', typeof showSuccess !== 'undefined');
        }, 2000);
    </script>
</body>
</html> 