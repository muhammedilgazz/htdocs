<?php
require_once 'config/config.php';
require_once 'classes/Database.php';
require_once 'classes/SecurityManager.php';
require_once 'includes/auth_check.php';

include 'partials/head.php';
?>

<body>
    <div class="app-container">
        <?php include 'partials/sidebar.php'; ?>
        
        <div class="app-main">
            <?php include 'partials/header.php'; ?>
            
            <div class="app-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">JavaScript Modül Test Sayfası</h5>
                                </div>
                                <div class="card-body">
                                    <div id="testResults">
                                        <h6>Modül Yükleme Durumu:</h6>
                                        <ul id="moduleStatus"></ul>
                                    </div>
                                    
                                    <hr>
                                    
                                    <div class="mt-4">
                                        <h6>Test Butonları:</h6>
                                        <button class="btn btn-primary ripple" onclick="testSnackbar()">
                                            Snackbar Test
                                        </button>
                                        <button class="btn btn-success ripple" onclick="testFAB()">
                                            FAB Test
                                        </button>
                                        <button class="btn btn-warning ripple" onclick="testTheme()">
                                            Tema Değiştir
                                        </button>
                                        <button class="btn btn-info ripple" onclick="testAjax()">
                                            AJAX Test
                                        </button>
                                    </div>
                                    
                                    <div class="mt-4">
                                        <h6>Console Log:</h6>
                                        <div id="consoleLog" style="background: #f8f9fa; padding: 10px; border-radius: 5px; font-family: monospace; font-size: 12px; max-height: 200px; overflow-y: auto;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'layouts/layoutBottom.php'; ?>
    
    <script>
        // Test functions
        function testSnackbar() {
            if (typeof EkashUI !== 'undefined') {
                EkashUI.showSnackbar('Snackbar test başarılı!', 'success');
                logToConsole('✅ Snackbar test başarılı');
            } else {
                logToConsole('❌ EkashUI modülü bulunamadı');
            }
        }
        
        function testFAB() {
            if (typeof EkashUI !== 'undefined') {
                // Simulate FAB action
                EkashCore.triggerEvent('fabAction', { action: 'test' });
                logToConsole('✅ FAB test başarılı');
            } else {
                logToConsole('❌ EkashUI modülü bulunamadı');
            }
        }
        
        function testTheme() {
            if (typeof EkashCore !== 'undefined') {
                EkashCore.toggleTheme();
                logToConsole('✅ Tema değiştirme test başarılı');
            } else {
                logToConsole('❌ EkashCore modülü bulunamadı');
            }
        }
        
        function testAjax() {
            if (typeof EkashForms !== 'undefined') {
                EkashForms.submitAjaxRequest('ajax/get_exchange_rate.php', {})
                    .then(response => {
                        logToConsole('✅ AJAX test başarılı: ' + JSON.stringify(response));
                    })
                    .catch(error => {
                        logToConsole('❌ AJAX test hatası: ' + error.message);
                    });
            } else {
                logToConsole('❌ EkashForms modülü bulunamadı');
            }
        }
        
        function logToConsole(message) {
            const consoleDiv = document.getElementById('consoleLog');
            const timestamp = new Date().toLocaleTimeString();
            consoleDiv.innerHTML += `[${timestamp}] ${message}\n`;
            consoleDiv.scrollTop = consoleDiv.scrollHeight;
        }
        
        function updateModuleStatus() {
            const moduleStatus = document.getElementById('moduleStatus');
            const modules = [
                { name: 'EkashCore', module: window.EkashCore },
                { name: 'EkashUI', module: window.EkashUI },
                { name: 'EkashForms', module: window.EkashForms },
                { name: 'EkashNavigation', module: window.EkashNavigation },
                { name: 'jQuery', module: window.$ },
                { name: 'Bootstrap', module: window.bootstrap },
                { name: 'Chart.js', module: window.Chart },
                { name: 'Toastr', module: window.toastr }
            ];
            
            moduleStatus.innerHTML = '';
            modules.forEach(({ name, module }) => {
                const li = document.createElement('li');
                li.innerHTML = `${module ? '✅' : '❌'} ${name}`;
                li.className = module ? 'text-success' : 'text-danger';
                moduleStatus.appendChild(li);
            });
        }
        
        // Initialize test page
        document.addEventListener('DOMContentLoaded', function() {
            logToConsole('🚀 Test sayfası yüklendi');
            
            // Wait a bit for modules to load
            setTimeout(() => {
                updateModuleStatus();
                logToConsole('📊 Modül durumu güncellendi');
            }, 1000);
            
            // Listen for module events
            if (typeof EkashCore !== 'undefined') {
                EkashCore.on('fabAction', (e) => {
                    logToConsole(`🎯 FAB Action: ${e.detail.action}`);
                });
                
                EkashCore.on('themeChanged', (e) => {
                    logToConsole(`🎨 Tema değişti: ${e.detail.theme}`);
                });
            }
        });
    </script>
</body>
</html> 