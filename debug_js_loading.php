<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JS Loading Debug</title>
</head>
<body>
    <h1>JavaScript Loading Debug</h1>
    
    <div id="test-div">Test div for jQuery</div>
    <button id="test-btn">Test Button</button>
    
    <!-- jQuery (CDN) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Chart.js (CDN version for compatibility) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>
    
    <!-- Perfect Scrollbar -->
    <script src="assets/vendor/perfect-scrollbar/perfect-scrollbar.min.js" onerror="this.onerror=null;this.src='https://cdn.jsdelivr.net/npm/perfect-scrollbar@1.5.5/dist/perfect-scrollbar.min.js'"></script>
    
    <!-- Toastr -->
    <script src="assets/vendor/toastr/toastr.min.js" onerror="this.onerror=null;this.src='https://cdn.jsdelivr.net/npm/toastr@2.1.4/toastr.min.js'"></script>
    
    <!-- Ekash Modular Scripts - New Architecture -->
    <script src="assets/js/modules/core.js"></script>
    <script src="assets/js/modules/ui.js"></script>
    <script src="assets/js/modules/forms.js"></script>
    <script src="assets/js/modules/navigation.js"></script>
    
    <!-- Main Application Script -->
    <script src="assets/js/scripts.js"></script>
    
    <script>
        console.log('=== JS LOADING DEBUG ===');
        
        // Test jQuery
        if (typeof $ !== 'undefined') {
            console.log('✅ jQuery loaded');
            $('#test-div').text('jQuery is working!');
        } else {
            console.error('❌ jQuery not loaded');
        }
        
        // Test Bootstrap
        if (typeof bootstrap !== 'undefined') {
            console.log('✅ Bootstrap loaded');
        } else {
            console.error('❌ Bootstrap not loaded');
        }
        
        // Test Chart.js
        if (typeof Chart !== 'undefined') {
            console.log('✅ Chart.js loaded');
        } else {
            console.error('❌ Chart.js not loaded');
        }
        
        // Test Toastr
        if (typeof toastr !== 'undefined') {
            console.log('✅ Toastr loaded');
        } else {
            console.error('❌ Toastr not loaded');
        }
        
        // Test Ekash modules
        const modules = ['EkashCore', 'EkashUI', 'EkashForms', 'EkashNavigation'];
        modules.forEach(module => {
            if (window[module]) {
                console.log(`✅ ${module} loaded`);
            } else {
                console.error(`❌ ${module} not loaded`);
            }
        });
        
        // Test button click
        document.getElementById('test-btn').addEventListener('click', function() {
            console.log('Button clicked!');
            if (typeof toastr !== 'undefined') {
                toastr.success('Test message!');
            } else {
                alert('Toastr not available');
            }
        });
        
        // Test DOM ready
        $(document).ready(function() {
            console.log('✅ DOM ready with jQuery');
        });
        
        document.addEventListener('DOMContentLoaded', function() {
            console.log('✅ DOM ready with vanilla JS');
        });
    </script>
</body>
</html> 