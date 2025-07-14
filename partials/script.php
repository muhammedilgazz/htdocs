<!-- jQuery -->
<script src="assets/vendor/jquery/jquery.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Chart.js (CDN version for compatibility) -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>

<!-- Perfect Scrollbar -->
<script src="assets/vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>

<!-- Toastr -->
<script src="assets/vendor/toastr/toastr.min.js"></script>

<!-- Ekash Modular Scripts - New Architecture -->
<script src="assets/js/modules/core.js"></script>
<script src="assets/js/modules/ui.js"></script>
<script src="assets/js/modules/forms.js"></script>
<script src="assets/js/modules/navigation.js"></script>

<!-- Main Application Script -->
<script src="assets/js/scripts.js"></script>

<script>
    // Debug information
    console.log('🚀 Ekash Modular Scripts loaded');
    
    // CSRF token configuration
    const CSRF_TOKEN = '<?= generate_csrf_token() ?>';
    
    // Make CSRF token globally available
    window.csrfToken = CSRF_TOKEN;
    
    // Check if all libraries are loaded
    document.addEventListener('DOMContentLoaded', function() {
        console.log('🎯 DOM Content Loaded - Starting module checks');
        
        // Check jQuery
        if (typeof $ !== 'undefined') {
            console.log('✅ jQuery loaded successfully');
        } else {
            console.error('❌ jQuery failed to load');
        }
        
        // Check Bootstrap
        if (typeof bootstrap !== 'undefined') {
            console.log('✅ Bootstrap loaded successfully');
        } else {
            console.error('❌ Bootstrap failed to load');
        }
        
        // Check Chart.js
        if (typeof Chart !== 'undefined') {
            console.log('✅ Chart.js loaded successfully');
        } else {
            console.error('❌ Chart.js failed to load');
        }
        
        // Check Toastr
        if (typeof toastr !== 'undefined') {
            console.log('✅ Toastr loaded successfully');
            
            // Configure Toastr
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
        } else {
            console.error('❌ Toastr failed to load');
        }
        
        // Check Ekash modules
        const ekashModules = ['EkashCore', 'EkashUI', 'EkashForms', 'EkashNavigation'];
        ekashModules.forEach(module => {
            if (window[module]) {
                console.log(`✅ ${module} loaded successfully`);
            } else {
                console.error(`❌ ${module} failed to load`);
            }
        });
    });

    // CSRF token setup for AJAX requests
    if (typeof $ !== 'undefined') {
        $.ajaxSetup({
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                xhr.setRequestHeader('X-CSRF-Token', CSRF_TOKEN);
            }
        });
    }
    
    // Auto-add CSRF tokens to forms
    document.addEventListener('DOMContentLoaded', function() {
        const forms = document.querySelectorAll('form:not([data-no-csrf])');
        forms.forEach(function(form) {
            // Check if CSRF token already exists
            if (!form.querySelector('input[name="csrf_token"]')) {
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = 'csrf_token';
                csrfInput.value = CSRF_TOKEN;
                form.appendChild(csrfInput);
            }
        });
    });
    
    // Legacy compatibility functions for existing code
    window.showSuccess = function(message) {
        if (window.EkashUI) {
            EkashUI.showSnackbar(message, 'success');
        } else if (typeof toastr !== 'undefined') {
            toastr.success(message);
        } else {
            alert('Success: ' + message);
        }
    };
    
    window.showError = function(message) {
        if (window.EkashUI) {
            EkashUI.showSnackbar(message, 'error');
        } else if (typeof toastr !== 'undefined') {
            toastr.error(message);
        } else {
            alert('Error: ' + message);
        }
    };
    
    window.showWarning = function(message) {
        if (window.EkashUI) {
            EkashUI.showSnackbar(message, 'warning');
        } else if (typeof toastr !== 'undefined') {
            toastr.warning(message);
        } else {
            alert('Warning: ' + message);
        }
    };
    
    window.showInfo = function(message) {
        if (window.EkashUI) {
            EkashUI.showSnackbar(message, 'info');
        } else if (typeof toastr !== 'undefined') {
            toastr.info(message);
        } else {
            alert('Info: ' + message);
        }
    };
    
    // Legacy compatibility - keep old function names working
    window.showSnackbar = window.showSuccess;
    
    // Utility functions that weren't moved to modules (for compatibility)
    window.formatCurrency = function(amount) {
        if (window.EkashCore && EkashCore.formatCurrency) {
            return EkashCore.formatCurrency(amount);
        }
        return new Intl.NumberFormat('tr-TR', {
            style: 'currency',
            currency: 'TRY'
        }).format(amount);
    };
    
    window.formatDate = function(date) {
        if (window.EkashCore && EkashCore.formatDate) {
            return EkashCore.formatDate(date);
        }
        return new Intl.DateTimeFormat('tr-TR', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        }).format(new Date(date));
    };
    
    // Legacy button loading function
    window.setLoading = function(element, loading = true) {
        if (window.EkashUI) {
            if (loading) {
                EkashUI.setButtonLoading(element);
            } else {
                EkashUI.resetButton(element);
            }
        } else {
            // Fallback
            if (loading) {
                element.disabled = true;
                element.innerHTML = '<span class="loading"></span> Yükleniyor...';
            } else {
                element.disabled = false;
                element.innerHTML = element.getAttribute('data-original-text') || 'Kaydet';
            }
        }
    };
    
    // Legacy deletion function
    window.deleteItem = function(id, table, user_id_column = 'user_id') {
        if (!confirm('Bu kaydı silmek istediğinizden emin misiniz?')) {
            return;
        }
        
        const data = {
            id: id,
            table: table,
            user_id_column: user_id_column,
            csrf_token: CSRF_TOKEN
        };
        
        if (window.EkashForms) {
            EkashForms.submitAjaxRequest('ajax/delete_item.php', data)
                .then(response => {
                    if (response.success) {
                        showSuccess(response.message);
                        setTimeout(() => window.location.reload(), 1000);
                    } else {
                        showError(response.message);
                    }
                })
                .catch(error => {
                    showError('Bağlantı hatası oluştu');
                    console.error('Error:', error);
                });
        } else {
            // Fallback to legacy method
            legacyAjaxRequest('ajax/delete_item.php', data);
        }
    };
    
    // Legacy AJAX request function
    function legacyAjaxRequest(url, data) {
        const formData = new FormData();
        Object.entries(data).forEach(([key, value]) => {
            formData.append(key, value);
        });
        
        fetch(url, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showSuccess(data.message);
                setTimeout(() => window.location.reload(), 1000);
            } else {
                showError(data.message);
            }
        })
        .catch(error => {
            showError('Bağlantı hatası oluştu');
            console.error('Error:', error);
        });
    }
    
    // Initialize tooltips and popovers when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof bootstrap !== 'undefined') {
            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
            
            // Initialize popovers
            const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
            popoverTriggerList.map(function (popoverTriggerEl) {
                return new bootstrap.Popover(popoverTriggerEl);
            });
        }
        
        // Initialize charts for index.php
        initDashboardChart();
    });
    
    // Dashboard chart initialization
    function initDashboardChart() {
        const expenseChartElement = document.getElementById('expenseChart');
        if (expenseChartElement && typeof Chart !== 'undefined') {
            try {
                const ctx = expenseChartElement.getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                        datasets: [{
                            label: 'Balance',
                            data: [12000, 19000, 15000, 25000, 22000, 30000],
                            borderColor: '#6366F1',
                            backgroundColor: 'rgba(99, 102, 241, 0.1)',
                            tension: 0.4,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.05)'
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
                console.log('✅ Dashboard chart initialized successfully');
            } catch (error) {
                console.error('❌ Chart initialization error:', error);
            }
        }
    }
    
    // Exchange rate update function (kept for compatibility)
    function updateExchangeRate() {
        fetch('ajax/get_exchange_rate.php')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const rateElement = document.getElementById('usd-rate');
                    const changeElement = document.getElementById('rate-change');
                    
                    if (rateElement) {
                        const currentRate = parseFloat(rateElement.textContent);
                        const newRate = parseFloat(data.rate);
                        
                        // Calculate rate change
                        const change = newRate - currentRate;
                        
                        // Update rate
                        rateElement.textContent = newRate.toFixed(2);
                        
                        // Update change indicator
                        if (changeElement) {
                            if (change > 0) {
                                changeElement.innerHTML = `<span style="color: #28a745;">▲ +${change.toFixed(2)}</span>`;
                            } else if (change < 0) {
                                changeElement.innerHTML = `<span style="color: #dc3545;">▼ ${change.toFixed(2)}</span>`;
                            } else {
                                changeElement.innerHTML = `<span style="color: #6c757d;">─</span>`;
                            }
                        }
                        
                        // Add tooltip
                        rateElement.title = `Son güncelleme: ${data.last_update}`;
                    }
                }
            })
            .catch(error => {
                console.error('Döviz kuru güncellenirken hata:', error);
            });
    }
    
    // Initialize exchange rate updates
    document.addEventListener('DOMContentLoaded', function() {
        // Initial update
        updateExchangeRate();
        
        // Update every 5 minutes
        setInterval(updateExchangeRate, 5 * 60 * 1000);
        
        // Manual update on click
        const exchangeWidget = document.querySelector('.exchange-rate-widget');
        if (exchangeWidget) {
            exchangeWidget.addEventListener('click', function() {
                updateExchangeRate();
                showInfo('Döviz kuru güncelleniyor...');
            });
        }
    });
    
    console.log('🎉 Ekash modular scripts initialization complete');
</script>