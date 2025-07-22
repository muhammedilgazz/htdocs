<!-- jQuery -->
<script src="<?= BASE_URL ?>assets/vendor/jquery/jquery.min.js?v=<?= filemtime(ROOT_PATH . '/assets/vendor/jquery/jquery.min.js') ?>"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js?v=<?= filemtime(ROOT_PATH . '/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

<!-- Chart.js (CDN version for compatibility) -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js?v=<?= filemtime(ROOT_PATH . '/assets/vendor/chartjs/chartjs.js') ?>"></script>

<!-- Perfect Scrollbar -->
<script src="<?= BASE_URL ?>assets/vendor/perfect-scrollbar/perfect-scrollbar.min.js?v=<?= filemtime(ROOT_PATH . '/assets/vendor/perfect-scrollbar/perfect-scrollbar.min.js') ?>"></script>

<!-- Toastr -->
<script src="<?= BASE_URL ?>assets/vendor/toastr/toastr.min.js?v=<?= filemtime(ROOT_PATH . '/assets/vendor/toastr/toastr.min.js') ?>"></script>

<!-- Custom Scripts -->
<script src="<?= BASE_URL ?>assets/js/scripts.js?v=<?= filemtime(ROOT_PATH . '/assets/js/scripts.js') ?>"></script>

<script>
    // Debug information
    console.log('Script.php loaded');
    
    // Check if all libraries are loaded
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM Content Loaded');
        
        // Check jQuery
        if (typeof $ !== 'undefined') {
            console.log('✓ jQuery loaded successfully');
        } else {
            console.error('✗ jQuery failed to load');
        }
        
        // Check Bootstrap
        if (typeof bootstrap !== 'undefined') {
            console.log('✓ Bootstrap loaded successfully');
        } else {
            console.error('✗ Bootstrap failed to load');
        }
        
        // Check Chart.js
        if (typeof Chart !== 'undefined') {
            console.log('✓ Chart.js loaded successfully');
        } else {
            console.error('✗ Chart.js failed to load');
        }
        
        // Check Toastr
        if (typeof toastr !== 'undefined') {
            console.log('✓ Toastr loaded successfully');
        } else {
            console.error('✗ Toastr failed to load');
        }
    });

    // CSRF token'ı tüm AJAX isteklerine ekle
    $.ajaxSetup({
        beforeSend: function(xhr) {
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        }
    });
    
    // Form'lara CSRF token ekle
    document.addEventListener('DOMContentLoaded', function() {
        const forms = document.querySelectorAll('form');
        forms.forEach(function(form) {
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = 'csrf_token';
            csrfInput.value = '<?= generate_csrf_token() ?>';
            form.appendChild(csrfInput);
        });
    });
    
    // Sidebar toggle (mobil)
    document.getElementById('sidebarToggle')?.addEventListener('click', function() {
        document.querySelector('.sidebar').classList.toggle('show');
    });
    
    // Mobilde sidebar dışına tıklandığında kapat
    document.addEventListener('click', function(e) {
        const sidebar = document.querySelector('.sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        
        if (window.innerWidth <= 768 && sidebar && sidebarToggle) {
            if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                sidebar.classList.remove('show');
            }
        }
    });
    
    // Sidebar menü kontrolü - Basitleştirilmiş versiyon
    document.addEventListener('DOMContentLoaded', function() {
        // Tüm collapse menülerini kontrol et
        const collapseMenus = document.querySelectorAll('[data-bs-toggle="collapse"]');
        
        collapseMenus.forEach(function(menu) {
            menu.addEventListener('click', function(e) {
                e.preventDefault();
                
                const targetId = this.getAttribute('data-bs-target');
                const targetElement = document.querySelector(targetId);
                const chevronIcon = this.querySelector('.bi-chevron-down');
                
                if (targetElement) {
                    // Eğer menü zaten açıksa, kapat
                    if (targetElement.classList.contains('show')) {
                        targetElement.classList.remove('show');
                        if (chevronIcon) {
                            chevronIcon.style.transform = 'rotate(0deg)';
                        }
                        this.setAttribute('aria-expanded', 'false');
                    } else {
                        // Diğer açık menüleri kapat
                        const otherMenus = document.querySelectorAll('.collapse.show');
                        otherMenus.forEach(function(otherMenu) {
                            otherMenu.classList.remove('show');
                        });
                        
                        // Diğer chevron ikonlarını sıfırla
                        const otherChevrons = document.querySelectorAll('.nav-link[data-bs-toggle="collapse"] .bi-chevron-down');
                        otherChevrons.forEach(function(chevron) {
                            chevron.style.transform = 'rotate(0deg)';
                        });
                        
                        // Diğer menü butonlarının aria-expanded'ını false yap
                        const otherMenuButtons = document.querySelectorAll('.nav-link[data-bs-toggle="collapse"]');
                        otherMenuButtons.forEach(function(button) {
                            button.setAttribute('aria-expanded', 'false');
                        });
                        
                        // Hedef menüyü aç
                        targetElement.classList.add('show');
                        if (chevronIcon) {
                            chevronIcon.style.transform = 'rotate(180deg)';
                        }
                        this.setAttribute('aria-expanded', 'true');
                    }
                }
            });
        });
        
        // Sayfa yüklendiğinde aktif menüyü aç
        const currentPage = window.location.pathname.split('/').pop();
        const activeMenuLink = document.querySelector(`a[href="${currentPage}"]`);
        
        if (activeMenuLink) {
            const parentSubmenu = activeMenuLink.closest('.collapse');
            if (parentSubmenu) {
                parentSubmenu.classList.add('show');
                const parentMenuButton = document.querySelector(`[data-bs-target="#${parentSubmenu.id}"]`);
                if (parentMenuButton) {
                    parentMenuButton.setAttribute('aria-expanded', 'true');
                    const chevronIcon = parentMenuButton.querySelector('.bi-chevron-down');
                    if (chevronIcon) {
                        chevronIcon.style.transform = 'rotate(180deg)';
                    }
                }
            }
        }
    });
    
    // Toastr ayarları
    if (typeof toastr !== 'undefined') {
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
    }
    
    // Başarı mesajı göster
    function showSuccess(message) {
        if (typeof toastr !== 'undefined') {
            toastr.success(message);
        } else {
            alert('Success: ' + message);
        }
    }
    
    // Hata mesajı göster
    function showError(message) {
        if (typeof toastr !== 'undefined') {
            toastr.error(message);
        } else {
            alert('Error: ' + message);
        }
    }
    
    // Uyarı mesajı göster
    function showWarning(message) {
        if (typeof toastr !== 'undefined') {
            toastr.warning(message);
        } else {
            alert('Warning: ' + message);
        }
    }
    
    // Bilgi mesajı göster
    function showInfo(message) {
        if (typeof toastr !== 'undefined') {
            toastr.info(message);
        } else {
            alert('Info: ' + message);
        }
    }
    
    // Para formatı
    function formatCurrency(amount) {
        return new Intl.NumberFormat('tr-TR', {
            style: 'currency',
            currency: 'TRY'
        }).format(amount);
    }
    
    // Tarih formatı
    function formatDate(date) {
        return new Intl.DateTimeFormat('tr-TR', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        }).format(new Date(date));
    }
    
    // Loading durumu
    function setLoading(element, loading = true) {
        if (loading) {
            element.disabled = true;
            element.innerHTML = '<span class="loading"></span> Yükleniyor...';
        } else {
            element.disabled = false;
            element.innerHTML = element.getAttribute('data-original-text') || 'Kaydet';
        }
    }
    
    // Form submit işlemleri
    document.addEventListener('DOMContentLoaded', function() {
        const forms = document.querySelectorAll('form'); // Tüm formları dinle
        forms.forEach(function(form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const submitBtn = form.querySelector('button[type="submit"]');
                if (!submitBtn) return;
                
                const originalText = submitBtn.innerHTML;
                submitBtn.setAttribute('data-original-text', originalText);
                
                setLoading(submitBtn, true);
                
                const formData = new FormData(form);
                
                // Formun action özniteliğini kullanarak AJAX URL'sini belirle
                const ajaxUrl = form.action || window.location.href;

                fetch(ajaxUrl, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    setLoading(submitBtn, false);
                    
                    if (data.success) {
                        showSuccess(data.message || 'İşlem başarılı');
                        
                        // Modal varsa kapat
                        const modal = form.closest('.modal');
                        if (modal) {
                            const modalInstance = bootstrap.Modal.getInstance(modal);
                            if (modalInstance) {
                                modalInstance.hide();
                            }
                        }
                        
                        // Sayfa yenileme gerekli mi?
                        if (data.reload) {
                            setTimeout(() => {
                                window.location.reload();
                            }, 1000);
                        }
                    } else {
                        showError(data.message || 'Bir hata oluştu');
                    }
                })
                .catch(error => {
                    setLoading(submitBtn, false);
                    showError('Bağlantı hatası oluştu');
                    console.error('Error:', error);
                });
            });
        });
    });
    
    // Tablo sıralama
    function initTableSorting() {
        const tables = document.querySelectorAll('table[data-sortable]');
        tables.forEach(function(table) {
            const headers = table.querySelectorAll('th[data-sort]');
            headers.forEach(function(header) {
                header.addEventListener('click', function() {
                    const column = this.getAttribute('data-sort');
                    const direction = this.getAttribute('data-direction') === 'asc' ? 'desc' : 'asc';
                    
                    // Tüm header'lardan active class'ını kaldır
                    headers.forEach(h => h.classList.remove('active'));
                    this.classList.add('active');
                    this.setAttribute('data-direction', direction);
                    
                    // Sıralama işlemi
                    sortTable(table, column, direction);
                });
            });
        });
    }
    
    function sortTable(table, column, direction) {
        const tbody = table.querySelector('tbody');
        const rows = Array.from(tbody.querySelectorAll('tr'));
        
        rows.sort(function(a, b) {
            const aValue = a.querySelector(`td[data-${column}]`).getAttribute(`data-${column}`);
            const bValue = b.querySelector(`td[data-${column}]`).getAttribute(`data-${column}`);
            
            if (direction === 'asc') {
                return aValue.localeCompare(bValue);
            } else {
                return bValue.localeCompare(aValue);
            }
        });
        
        rows.forEach(function(row) {
            tbody.appendChild(row);
        });
    }
    
    // Sayfa yüklendiğinde tablo sıralamayı başlat
    document.addEventListener('DOMContentLoaded', initTableSorting);
    
    // Responsive tablo
    function initResponsiveTables() {
        const tables = document.querySelectorAll('.table-responsive');
        tables.forEach(function(table) {
            const wrapper = table.parentElement;
            if (wrapper.scrollWidth > wrapper.clientWidth) {
                wrapper.style.overflowX = 'auto';
            }
        });
    }
    
    document.addEventListener('DOMContentLoaded', initResponsiveTables);
    
    // Tooltip'leri etkinleştir
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof bootstrap !== 'undefined') {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
            
            // Popover'ları etkinleştir
            var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
            var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
                return new bootstrap.Popover(popoverTriggerEl);
            });
        }
    });
    
    // Modal Form İşlemleri
    document.addEventListener('DOMContentLoaded', function() {
        // İhtiyaç Ekle Form
        const addIhtiyacForm = document.getElementById('addIhtiyacForm');
        if (addIhtiyacForm) {
            addIhtiyacForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                formData.append('action', 'add_ihtiyac');
                
                fetch('ajax/add_ihtiyac.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showSuccess('İhtiyaç başarıyla eklendi');
                        this.reset();
                        const modal = bootstrap.Modal.getInstance(document.getElementById('addIhtiyacModal'));
                        modal.hide();
                    } else {
                        showError(data.message || 'İhtiyaç eklenirken hata oluştu');
                    }
                })
                .catch(error => {
                    showError('Bağlantı hatası oluştu');
                    console.error('Error:', error);
                });
            });
        }
        
        // İban Ekle Form
        const addIbanForm = document.getElementById('addIbanForm');
        if (addIbanForm) {
            addIbanForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                formData.append('action', 'add_iban');
                
                fetch('ajax/add_iban.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showSuccess('IBAN başarıyla eklendi');
                        this.reset();
                        const modal = bootstrap.Modal.getInstance(document.getElementById('addIbanModal'));
                        modal.hide();
                    } else {
                        showError(data.message || 'IBAN eklenirken hata oluştu');
                    }
                })
                .catch(error => {
                    showError('Bağlantı hatası oluştu');
                    console.error('Error:', error);
                });
            });
        }
        
        // Hesap Ekle Form
        const addHesapForm = document.getElementById('addHesapForm');
        if (addHesapForm) {
            addHesapForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                formData.append('action', 'add_hesap');
                
                fetch('ajax/add_hesap.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showSuccess('Hesap başarıyla eklendi');
                        this.reset();
                        const modal = bootstrap.Modal.getInstance(document.getElementById('addHesapModal'));
                        modal.hide();
                    } else {
                        showError(data.message || 'Hesap eklenirken hata oluştu');
                    }
                })
                .catch(error => {
                    showError('Bağlantı hatası oluştu');
                    console.error('Error:', error);
                });
            });
        }
        
        // Hayal/Hedef Ekle Form
        const addHayalHedefForm = document.getElementById('addHayalHedefForm');
        if (addHayalHedefForm) {
            addHayalHedefForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                formData.append('action', 'add_hayal_hedef');
                
                fetch('ajax/add_hayal_hedef.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showSuccess('Hayal/Hedef başarıyla eklendi');
                        this.reset();
                        const modal = bootstrap.Modal.getInstance(document.getElementById('addHayalHedefModal'));
                        modal.hide();
                    } else {
                        showError(data.message || 'Hayal/Hedef eklenirken hata oluştu');
                    }
                })
                .catch(error => {
                    showError('Bağlantı hatası oluştu');
                    console.error('Error:', error);
                });
            });
        }
    });
    
    // Harcama Ekle Form
    document.addEventListener('DOMContentLoaded', function() {
        const addExpenseForm = document.getElementById('addExpenseForm');
        if (addExpenseForm) {
            addExpenseForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                formData.append('action', 'add_expense');
                
                fetch('ajax/add_expense.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showSuccess('Harcama başarıyla eklendi');
                        this.reset();
                        const modal = bootstrap.Modal.getInstance(document.getElementById('addExpenseModal'));
                        modal.hide();
                    } else {
                        showError(data.message || 'Harcama eklenirken hata oluştu');
                    }
                })
                .catch(error => {
                    showError('Bağlantı hatası oluştu');
                    console.error('Error:', error);
                });
            });
        }
    });
    
    // Hızlı İşlemler Modal Form İşlemleri
    document.addEventListener('DOMContentLoaded', function() {
        // Not Ekle Form
        const addNoteForm = document.getElementById('addNoteForm');
        if (addNoteForm) {
            addNoteForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                formData.append('action', 'add_note');
                
                fetch('ajax/add_note.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showSuccess('Not başarıyla eklendi');
                        this.reset();
                        const modal = bootstrap.Modal.getInstance(document.getElementById('addNoteModal'));
                        modal.hide();
                    } else {
                        showError(data.message || 'Not eklenirken hata oluştu');
                    }
                })
                .catch(error => {
                    showError('Bağlantı hatası oluştu');
                    console.error('Error:', error);
                });
            });
        }
        
        // To-Do Ekle Form
        const addTodoForm = document.getElementById('addTodoForm');
        if (addTodoForm) {
            addTodoForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                formData.append('action', 'add_todo');
                
                fetch('ajax/add_todo.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showSuccess('To-Do başarıyla eklendi');
                        this.reset();
                        const modal = bootstrap.Modal.getInstance(document.getElementById('addTodoModal'));
                        modal.hide();
                    } else {
                        showError(data.message || 'To-Do eklenirken hata oluştu');
                    }
                })
                .catch(error => {
                    showError('Bağlantı hatası oluştu');
                    console.error('Error:', error);
                });
            });
        }
        
        // Gelir Ekle Form
        const addIncomeForm = document.getElementById('addIncomeForm');
        if (addIncomeForm) {
            addIncomeForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                formData.append('action', 'add_income');
                
                fetch('ajax/add_income.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showSuccess('Gelir başarıyla eklendi');
                        this.reset();
                        const modal = bootstrap.Modal.getInstance(document.getElementById('addIncomeModal'));
                        modal.hide();
                    } else {
                        showError(data.message || 'Gelir eklenirken hata oluştu');
                    }
                })
                .catch(error => {
                    showError('Bağlantı hatası oluştu');
                    console.error('Error:', error);
                });
            });
        }
    });
    
    // Rapor Oluştur Fonksiyonları
    function generateMonthlyReport() {
        const month = document.getElementById('reportMonth').value;
        const year = document.getElementById('reportYear').value;
        const type = document.getElementById('reportType').value;
        
        const formData = new FormData();
        formData.append('action', 'generate_monthly_report');
        formData.append('month', month);
        formData.append('year', year);
        formData.append('type', type);
        
        fetch('ajax/generate_report.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showSuccess('Rapor başarıyla oluşturuldu');
                // Rapor sonucunu göster
                if (data.report_url) {
                    window.open(data.report_url, '_blank');
                }
                const modal = bootstrap.Modal.getInstance(document.getElementById('monthlyPaymentReportModal'));
                modal.hide();
            } else {
                showError(data.message || 'Rapor oluşturulurken hata oluştu');
            }
        })
        .catch(error => {
            showError('Bağlantı hatası oluştu');
            console.error('Error:', error);
        });
    }
    
    function generateShoppingReport() {
        const category = document.getElementById('shoppingCategory').value;
        const priority = document.getElementById('shoppingPriority').value;
        const minPrice = document.getElementById('minPrice').value;
        const maxPrice = document.getElementById('maxPrice').value;
        
        const formData = new FormData();
        formData.append('action', 'generate_shopping_report');
        formData.append('category', category);
        formData.append('priority', priority);
        formData.append('min_price', minPrice);
        formData.append('max_price', maxPrice);
        
        fetch('ajax/generate_report.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showSuccess('Alınacaklar raporu başarıyla oluşturuldu');
                if (data.report_url) {
                    window.open(data.report_url, '_blank');
                }
                const modal = bootstrap.Modal.getInstance(document.getElementById('shoppingListReportModal'));
                modal.hide();
            } else {
                showError(data.message || 'Rapor oluşturulurken hata oluştu');
            }
        })
        .catch(error => {
            showError('Bağlantı hatası oluştu');
            console.error('Error:', error);
        });
    }
    
    function generateGoalsReport() {
        const type = document.getElementById('goalType').value;
        const status = document.getElementById('goalStatus').value;
        const startDate = document.getElementById('goalStartDate').value;
        const endDate = document.getElementById('goalEndDate').value;
        
        const formData = new FormData();
        formData.append('action', 'generate_goals_report');
        formData.append('type', type);
        formData.append('status', status);
        formData.append('start_date', startDate);
        formData.append('end_date', endDate);
        
        fetch('ajax/generate_report.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showSuccess('Hedefler raporu başarıyla oluşturuldu');
                if (data.report_url) {
                    window.open(data.report_url, '_blank');
                }
                const modal = bootstrap.Modal.getInstance(document.getElementById('goalsReportModal'));
                modal.hide();
            } else {
                showError(data.message || 'Rapor oluşturulurken hata oluştu');
            }
        })
        .catch(error => {
            showError('Bağlantı hatası oluştu');
            console.error('Error:', error);
        });
    }
    
    function generateYearlyReport() {
        const year = document.getElementById('yearlyReportYear').value;
        const type = document.getElementById('yearlyReportType').value;
        const chartType = document.getElementById('yearlyChartType').value;
        
        const formData = new FormData();
        formData.append('action', 'generate_yearly_report');
        formData.append('year', year);
        formData.append('type', type);
        formData.append('chart_type', chartType);
        
        fetch('ajax/generate_report.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showSuccess('Yıllık rapor başarıyla oluşturuldu');
                if (data.report_url) {
                    window.open(data.report_url, '_blank');
                }
                const modal = bootstrap.Modal.getInstance(document.getElementById('yearlyReportModal'));
                modal.hide();
            } else {
                showError(data.message || 'Rapor oluşturulurken hata oluştu');
            }
        })
        .catch(error => {
            showError('Bağlantı hatası oluştu');
            console.error('Error:', error);
        });
    }
    
    // Döviz Kuru Güncelleme Fonksiyonu
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
                        
                        // Kur değişimini hesapla
                        const change = newRate - currentRate;
                        const changePercent = (change / currentRate) * 100;
                        
                        // Kuru güncelle
                        rateElement.textContent = newRate.toFixed(2);
                        
                        // Değişim göstergesini güncelle
                        if (changeElement) {
                            if (change > 0) {
                                changeElement.innerHTML = `<span style="color: #28a745;">▲ +${change.toFixed(2)}</span>`;
                            } else if (change < 0) {
                                changeElement.innerHTML = `<span style="color: #dc3545;">▼ ${change.toFixed(2)}</span>`;
                            } else {
                                changeElement.innerHTML = `<span style="color: #6c757d;">─</span>`;
                            }
                        }
                        
                        // Tooltip ekle
                        rateElement.title = `Son güncelleme: ${data.last_update}`;
                    }
                }
            })
            .catch(error => {
                console.error('Döviz kuru güncellenirken hata:', error);
            });
    }
    
    // Global functions for index.php
    window.showSnackbar = showSnackbar;
    window.showSuccess = showSuccess;
    window.showError = showError;
    window.showWarning = showWarning;
    window.showInfo = showInfo;
    
    // Global delete function
    function deleteItem(id, table, user_id_column = 'user_id') {
        if (!confirm('Bu kaydı silmek istediğinizden emin misiniz?')) {
            return;
        }
        
        const formData = new FormData();
        formData.append('id', id);
        formData.append('table', table);
        formData.append('user_id_column', user_id_column);
        formData.append('csrf_token', '<?= generate_csrf_token() ?>');
        
        fetch('ajax/delete_item.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showSuccess(data.message);
                // Sayfayı yenile
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                showError(data.message);
            }
        })
        .catch(error => {
            showError('Bağlantı hatası oluştu');
            console.error('Error:', error);
        });
    }
    
    // Auto import function
    function autoImport(action, url, category = '') {
        const formData = new FormData();
        formData.append('action', action);
        formData.append('url', url);
        formData.append('category', category);
        formData.append('csrf_token', '<?= generate_csrf_token() ?>');
        
        fetch('ajax/auto_import.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showSuccess(data.message);
                // Sayfayı yenile
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                showError(data.message);
            }
        })
        .catch(error => {
            showError('Bağlantı hatası oluştu');
            console.error('Error:', error);
        });
    }
    
    // Postpone expense function
    function postponeExpense(id, months) {
        const formData = new FormData();
        formData.append('id', id);
        formData.append('postpone_months', months);
        formData.append('csrf_token', '<?= generate_csrf_token() ?>');
        
        fetch('ajax/postpone_expense.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showSuccess(data.message);
                // Sayfayı yenile
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                showError(data.message);
            }
        })
        .catch(error => {
            showError('Bağlantı hatası oluştu');
            console.error('Error:', error);
        });
    }
    
    // Complete postponed expense function
    function completePostponedExpense(id) {
        const formData = new FormData();
        formData.append('id', id);
        formData.append('csrf_token', '<?= generate_csrf_token() ?>');
        
        fetch('ajax/complete_postponed_expense.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showSuccess(data.message);
                // Sayfayı yenile
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                showError(data.message);
            }
        })
        .catch(error => {
            showError('Bağlantı hatası oluştu');
            console.error('Error:', error);
        });
    }
    
    // Global functions
    window.deleteItem = deleteItem;
    window.autoImport = autoImport;
    window.postponeExpense = postponeExpense;
    window.completePostponedExpense = completePostponedExpense;
    
    // Sayfa yüklendiğinde döviz kurunu güncelle
    document.addEventListener('DOMContentLoaded', function() {
        // İlk güncelleme
        updateExchangeRate();
        
        // Her 5 dakikada bir güncelle
        setInterval(updateExchangeRate, 5 * 60 * 1000);
        
        // Döviz kuru widget'ına tıklandığında manuel güncelleme
        const exchangeWidget = document.querySelector('.exchange-rate-widget');
        if (exchangeWidget) {
            exchangeWidget.addEventListener('click', function() {
                updateExchangeRate();
                showInfo('Döviz kuru güncelleniyor...');
            });
        }

        // Chart.js configuration for index.php
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
                console.log('Chart initialized successfully');
            } catch (error) {
                console.error('Chart initialization error:', error);
            }
        } else {
            console.log('Chart element not found or Chart.js not loaded');
        }
    });
</script>