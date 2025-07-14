<?php
require_once 'config/config.php';
require_once 'classes/Database.php';
require_once 'classes/SecurityManager.php';
include 'partials/head.php';
?>

<body>
    <div class="container mt-5">
        <h1>Test Index Simple</h1>
        <div id="test-status"></div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>JavaScript Test</h5>
                    </div>
                    <div class="card-body">
                        <button class="btn btn-primary" onclick="testFunction()">Test Button</button>
                        <div id="button-result" class="mt-2"></div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Menu Test</h5>
                    </div>
                    <div class="card-body">
                        <!-- Test dropdown menu -->
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                Test Menu
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li><a class="dropdown-item" href="#">Another action</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-4">
            <div class="alert alert-info">
                <h6>Test Results:</h6>
                <div id="detailed-results"></div>
            </div>
        </div>
    </div>

    <!-- Include layoutBottom to test script loading -->
    <?php include 'layouts/layoutBottom.php'; ?>
    
    <!-- Page specific test script -->
    <script>
        console.log('=== INDEX SIMPLE TEST START ===');
        
        function testFunction() {
            document.getElementById('button-result').innerHTML = '✅ Button clicked successfully!';
            
            // Test if our global functions work
            if (typeof showSuccess !== 'undefined') {
                showSuccess('Test notification working!');
                document.getElementById('button-result').innerHTML += '<br>✅ showSuccess function available';
            } else {
                document.getElementById('button-result').innerHTML += '<br>❌ showSuccess function not available';
            }
        }
        
        // Test when DOM is ready
        document.addEventListener('DOMContentLoaded', function() {
            console.log('=== DOM READY TEST ===');
            
            const results = [];
            
            // Test jQuery
            if (typeof $ !== 'undefined') {
                results.push('✅ jQuery loaded');
                console.log('✅ jQuery version:', $.fn.jquery);
            } else {
                results.push('❌ jQuery not loaded');
            }
            
            // Test Bootstrap
            if (typeof bootstrap !== 'undefined') {
                results.push('✅ Bootstrap loaded');
                console.log('✅ Bootstrap loaded');
            } else {
                results.push('❌ Bootstrap not loaded');
            }
            
            // Test our global functions
            if (typeof showSuccess !== 'undefined') {
                results.push('✅ Global functions available');
                console.log('✅ showSuccess function available');
            } else {
                results.push('❌ Global functions not available');
            }
            
            // Test menu functionality
            setTimeout(function() {
                const dropdownToggle = document.querySelector('[data-bs-toggle="dropdown"]');
                if (dropdownToggle && typeof bootstrap !== 'undefined') {
                    try {
                        new bootstrap.Dropdown(dropdownToggle);
                        results.push('✅ Bootstrap dropdown initialized');
                        console.log('✅ Bootstrap dropdown working');
                    } catch (error) {
                        results.push('❌ Bootstrap dropdown failed: ' + error.message);
                        console.error('❌ Bootstrap dropdown error:', error);
                    }
                }
                
                // Display all results
                document.getElementById('detailed-results').innerHTML = results.join('<br>');
            }, 1000);
        });
        
        console.log('=== INDEX SIMPLE TEST END ===');
    </script>

</body>
</html>