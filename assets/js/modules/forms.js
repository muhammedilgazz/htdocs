/**
 * Ekash Forms Module - Form handling, validation and AJAX operations
 * @version 1.0.0
 * @requires EkashCore, EkashUI
 */

const EkashForms = (function() {
    'use strict';

    // Private variables
    let isInitialized = false;
    const config = {
        csrf: {
            tokenName: 'csrf_token',
            headerName: 'X-CSRF-Token'
        },
        validation: {
            showErrors: true,
            realTimeValidation: true
        },
        ajax: {
            timeout: 30000,
            retryAttempts: 3
        }
    };

    const selectors = {
        forms: 'form[data-ajax]',
        inputs: 'input, textarea, select',
        submitButtons: 'button[type="submit"], input[type="submit"]',
        errorContainers: '.form-error',
        successContainers: '.form-success'
    };

    /**
     * Initialize forms module
     */
    function init() {
        if (isInitialized) {
            console.warn('EkashForms already initialized');
            return;
        }

        console.log('📋 Ekash Forms initializing...');

        EkashCore.ready(() => {
            initAjaxForms();
            initValidation();
            initSpecialHandlers();
        });

        isInitialized = true;
        console.log('✅ Ekash Forms initialized successfully');
    }

    /**
     * Initialize AJAX form handling
     */
    function initAjaxForms() {
        const forms = document.querySelectorAll(selectors.forms);
        
        forms.forEach(form => {
            form.addEventListener('submit', handleFormSubmit);
        });

        console.log(`✅ AJAX forms initialized for ${forms.length} forms`);
    }

    /**
     * Handle form submission
     */
    function handleFormSubmit(event) {
        event.preventDefault();
        
        const form = event.target;
        const submitButton = form.querySelector(selectors.submitButtons);
        
        // Validate form before submission
        if (!validateForm(form)) {
            return false;
        }

        // Prepare form data
        const formData = new FormData(form);
        
        // Add CSRF token if not present
        if (!formData.has(config.csrf.tokenName)) {
            const csrfToken = getCSRFToken();
            if (csrfToken) {
                formData.append(config.csrf.tokenName, csrfToken);
            }
        }

        // Get form configuration
        const url = form.getAttribute('action') || window.location.href;
        const method = form.getAttribute('method') || 'POST';
        
        // Set button loading state
        if (submitButton) {
            EkashUI.setButtonLoading(submitButton);
        }

        // Submit form via AJAX
        submitFormAjax(url, method, formData, form)
            .then(response => handleFormSuccess(response, form))
            .catch(error => handleFormError(error, form))
            .finally(() => {
                if (submitButton) {
                    EkashUI.resetButton(submitButton);
                }
            });
    }

    /**
     * Submit form via AJAX
     */
    function submitFormAjax(url, method, formData, form) {
        return new Promise((resolve, reject) => {
            const xhr = new XMLHttpRequest();
            
            xhr.timeout = config.ajax.timeout;
            
            xhr.onload = function() {
                if (xhr.status >= 200 && xhr.status < 300) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        resolve(response);
                    } catch (e) {
                        // If not JSON, treat as success with text response
                        resolve({ success: true, message: xhr.responseText });
                    }
                } else {
                    reject(new Error(`HTTP ${xhr.status}: ${xhr.statusText}`));
                }
            };
            
            xhr.onerror = function() {
                reject(new Error('Network error occurred'));
            };
            
            xhr.ontimeout = function() {
                reject(new Error('Request timed out'));
            };
            
            xhr.open(method.toUpperCase(), url);
            
            // Set CSRF header if available
            const csrfToken = getCSRFToken();
            if (csrfToken) {
                xhr.setRequestHeader(config.csrf.headerName, csrfToken);
            }
            
            xhr.send(formData);
            
            // Trigger form submit event
            EkashCore.triggerEvent('formSubmitted', { form, url, method });
        });
    }

    /**
     * Handle successful form submission
     */
    function handleFormSuccess(response, form) {
        console.log('Form submitted successfully:', response);
        
        // Show success message
        if (response.message) {
            EkashUI.showSnackbar(response.message, 'success');
        }
        
        // Reset form if specified
        if (response.resetForm !== false) {
            resetForm(form);
        }
        
        // Redirect if specified
        if (response.redirect) {
            setTimeout(() => {
                window.location.href = response.redirect;
            }, 1500);
        }
        
        // Reload page if specified
        if (response.reload) {
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        }
        
        // Trigger success event
        EkashCore.triggerEvent('formSuccess', { form, response });
    }

    /**
     * Handle form submission error
     */
    function handleFormError(error, form) {
        console.error('Form submission error:', error);
        
        let errorMessage = 'Bir hata oluştu. Lütfen tekrar deneyin.';
        
        if (error.message) {
            errorMessage = error.message;
        }
        
        // Show error message
        EkashUI.showSnackbar(errorMessage, 'error');
        
        // Trigger error event
        EkashCore.triggerEvent('formError', { form, error });
    }

    /**
     * Form validation
     */
    function validateForm(form) {
        const inputs = form.querySelectorAll(selectors.inputs);
        let isValid = true;
        
        // Clear previous errors
        clearFormErrors(form);
        
        inputs.forEach(input => {
            if (!validateInput(input)) {
                isValid = false;
            }
        });
        
        return isValid;
    }

    /**
     * Validate individual input
     */
    function validateInput(input) {
        const value = input.value.trim();
        const type = input.type;
        const required = input.hasAttribute('required');
        let isValid = true;
        let errorMessage = '';

        // Required field validation
        if (required && !value) {
            isValid = false;
            errorMessage = 'Bu alan zorunludur';
        }
        
        // Type-specific validation
        if (value && isValid) {
            switch (type) {
                case 'email':
                    if (!EkashCore.isValidEmail(value)) {
                        isValid = false;
                        errorMessage = 'Geçerli bir e-posta adresi girin';
                    }
                    break;
                    
                case 'number':
                    if (isNaN(value) || value < 0) {
                        isValid = false;
                        errorMessage = 'Geçerli bir sayı girin';
                    }
                    break;
                    
                case 'tel':
                    if (!/^\+?[\d\s\-\(\)]+$/.test(value)) {
                        isValid = false;
                        errorMessage = 'Geçerli bir telefon numarası girin';
                    }
                    break;
                    
                case 'url':
                    if (!/^https?:\/\/.+/.test(value)) {
                        isValid = false;
                        errorMessage = 'Geçerli bir URL girin (http:// veya https://)';
                    }
                    break;
            }
        }
        
        // Custom validation attributes
        if (value && isValid) {
            const minLength = input.getAttribute('minlength');
            if (minLength && value.length < parseInt(minLength)) {
                isValid = false;
                errorMessage = `En az ${minLength} karakter olmalıdır`;
            }
            
            const maxLength = input.getAttribute('maxlength');
            if (maxLength && value.length > parseInt(maxLength)) {
                isValid = false;
                errorMessage = `En fazla ${maxLength} karakter olmalıdır`;
            }
            
            const min = input.getAttribute('min');
            if (min && parseFloat(value) < parseFloat(min)) {
                isValid = false;
                errorMessage = `Minimum değer ${min} olmalıdır`;
            }
            
            const max = input.getAttribute('max');
            if (max && parseFloat(value) > parseFloat(max)) {
                isValid = false;
                errorMessage = `Maximum değer ${max} olmalıdır`;
            }
        }

        // Show/hide error
        if (!isValid) {
            showFieldError(input, errorMessage);
        } else {
            hideFieldError(input);
        }
        
        return isValid;
    }

    /**
     * Initialize real-time validation
     */
    function initValidation() {
        if (!config.validation.realTimeValidation) return;
        
        const inputs = document.querySelectorAll(selectors.inputs);
        
        inputs.forEach(input => {
            // Validate on blur
            input.addEventListener('blur', () => {
                validateInput(input);
            });
            
            // Clear error on input
            input.addEventListener('input', () => {
                if (input.classList.contains('is-invalid')) {
                    hideFieldError(input);
                }
            });
        });

        console.log(`✅ Real-time validation initialized for ${inputs.length} inputs`);
    }

    /**
     * Show field error
     */
    function showFieldError(input, message) {
        input.classList.add('is-invalid');
        input.classList.remove('is-valid');
        
        // Create or update error element
        let errorElement = input.parentNode.querySelector('.invalid-feedback');
        if (!errorElement) {
            errorElement = EkashCore.createElement('div', {
                className: 'invalid-feedback'
            });
            input.parentNode.appendChild(errorElement);
        }
        
        errorElement.textContent = message;
        errorElement.style.display = 'block';
    }

    /**
     * Hide field error
     */
    function hideFieldError(input) {
        input.classList.remove('is-invalid');
        input.classList.add('is-valid');
        
        const errorElement = input.parentNode.querySelector('.invalid-feedback');
        if (errorElement) {
            errorElement.style.display = 'none';
        }
    }

    /**
     * Clear all form errors
     */
    function clearFormErrors(form) {
        const invalidInputs = form.querySelectorAll('.is-invalid');
        invalidInputs.forEach(input => {
            input.classList.remove('is-invalid');
        });
        
        const errorElements = form.querySelectorAll('.invalid-feedback');
        errorElements.forEach(element => {
            element.style.display = 'none';
        });
    }

    /**
     * Reset form to initial state
     */
    function resetForm(form) {
        form.reset();
        clearFormErrors(form);
        
        // Reset all input states
        const inputs = form.querySelectorAll(selectors.inputs);
        inputs.forEach(input => {
            input.classList.remove('is-valid', 'is-invalid');
        });
        
        // Trigger reset event
        EkashCore.triggerEvent('formReset', { form });
    }

    /**
     * Get CSRF token from meta tag or form
     */
    function getCSRFToken() {
        // Try to get from meta tag first
        const metaToken = document.querySelector('meta[name="csrf-token"]');
        if (metaToken) {
            return metaToken.getAttribute('content');
        }
        
        // Try to get from existing form input
        const inputToken = document.querySelector(`input[name="${config.csrf.tokenName}"]`);
        if (inputToken) {
            return inputToken.value;
        }
        
        // Try to get from global variable (PHP generated)
        if (typeof window.csrfToken !== 'undefined') {
            return window.csrfToken;
        }
        
        return null;
    }

    /**
     * Initialize special form handlers (FAB forms, modals, etc.)
     */
    function initSpecialHandlers() {
        // FAB form handlers from index.php
        initFABHandlers();
        
        // Modal form handlers
        initModalHandlers();
        
        // Listen for FAB actions from UI module
        EkashCore.on('fabAction', (e) => {
            console.log('FAB action triggered:', e.detail.action);
        });
        
        console.log('✅ Special form handlers initialized');
    }

    /**
     * Initialize FAB (Floating Action Button) handlers
     */
    function initFABHandlers() {
        // Import Favorites
        const importFavoritesBtn = document.getElementById('importFavoritesBtn');
        if (importFavoritesBtn) {
            importFavoritesBtn.addEventListener('click', handleImportFavorites);
        }

        // Add from Link
        const addFromLinkBtn = document.getElementById('addFromLinkBtn');
        if (addFromLinkBtn) {
            addFromLinkBtn.addEventListener('click', handleAddFromLink);
        }

        // Bulk Add
        const bulkAddBtn = document.getElementById('bulkAddBtn');
        if (bulkAddBtn) {
            bulkAddBtn.addEventListener('click', handleBulkAdd);
        }

        // Import Notes
        const importNotesBtn = document.getElementById('importNotesBtn');
        if (importNotesBtn) {
            importNotesBtn.addEventListener('click', handleImportNotes);
        }
    }

    /**
     * Handle import favorites
     */
    function handleImportFavorites() {
        const favoritesText = document.getElementById('favoritesText')?.value.trim();
        
        if (!favoritesText) {
            EkashUI.showSnackbar('Lütfen favori ürünlerinizi girin', 'error');
            return;
        }

        const button = document.getElementById('importFavoritesBtn');
        EkashUI.setButtonLoading(button, 'İçe Aktarılıyor...');

        submitAjaxRequest('ajax/import_favorites.php', {
            favorites_text: favoritesText,
            [config.csrf.tokenName]: getCSRFToken()
        })
        .then(response => {
            if (response.success) {
                EkashUI.showSnackbar(response.message, 'success');
                const modal = document.getElementById('importFavoritesModal');
                if (modal) {
                    bootstrap.Modal.getInstance(modal)?.hide();
                }
                document.getElementById('favoritesText').value = '';
                
                setTimeout(() => location.reload(), 1500);
            } else {
                EkashUI.showSnackbar(response.message, 'error');
            }
        })
        .catch(error => {
            EkashUI.showSnackbar('Bir hata oluştu', 'error');
        })
        .finally(() => {
            EkashUI.resetButton(button);
        });
    }

    /**
     * Handle add from link
     */
    function handleAddFromLink() {
        const formData = {
            product_name: document.getElementById('productName')?.value.trim(),
            product_price: document.getElementById('productPrice')?.value.trim(),
            product_link: document.getElementById('productLink')?.value.trim(),
            product_category: document.getElementById('productCategory')?.value,
            product_image: document.getElementById('productImage')?.value.trim(),
            product_notes: document.getElementById('productNotes')?.value.trim()
        };

        if (!formData.product_name || !formData.product_price) {
            EkashUI.showSnackbar('Ürün adı ve fiyat gereklidir', 'error');
            return;
        }

        const button = document.getElementById('addFromLinkBtn');
        EkashUI.setButtonLoading(button, 'Ekleniyor...');

        formData[config.csrf.tokenName] = getCSRFToken();

        submitAjaxRequest('ajax/add_from_link.php', formData)
        .then(response => {
            if (response.success) {
                EkashUI.showSnackbar(response.message, 'success');
                const modal = document.getElementById('addFromLinkModal');
                if (modal) {
                    bootstrap.Modal.getInstance(modal)?.hide();
                }
                
                // Clear form
                ['productName', 'productPrice', 'productLink', 'productImage', 'productNotes'].forEach(id => {
                    const element = document.getElementById(id);
                    if (element) element.value = '';
                });
                
                setTimeout(() => location.reload(), 1500);
            } else {
                EkashUI.showSnackbar(response.message, 'error');
            }
        })
        .catch(error => {
            EkashUI.showSnackbar('Bir hata oluştu', 'error');
        })
        .finally(() => {
            EkashUI.resetButton(button);
        });
    }

    /**
     * Handle bulk add
     */
    function handleBulkAdd() {
        const bulkItemsText = document.getElementById('bulkItemsText')?.value.trim();
        
        if (!bulkItemsText) {
            EkashUI.showSnackbar('Lütfen ürün listesini girin', 'error');
            return;
        }

        const button = document.getElementById('bulkAddBtn');
        EkashUI.setButtonLoading(button, 'Ekleniyor...');

        submitAjaxRequest('ajax/bulk_add_products.php', {
            bulk_items_text: bulkItemsText,
            [config.csrf.tokenName]: getCSRFToken()
        })
        .then(response => {
            if (response.success) {
                EkashUI.showSnackbar(response.message, 'success');
                const modal = document.getElementById('bulkAddModal');
                if (modal) {
                    bootstrap.Modal.getInstance(modal)?.hide();
                }
                document.getElementById('bulkItemsText').value = '';
                
                setTimeout(() => location.reload(), 1500);
            } else {
                EkashUI.showSnackbar(response.message, 'error');
            }
        })
        .catch(error => {
            EkashUI.showSnackbar('Bir hata oluştu', 'error');
        })
        .finally(() => {
            EkashUI.resetButton(button);
        });
    }

    /**
     * Handle import notes
     */
    function handleImportNotes() {
        const notesText = document.getElementById('notesText')?.value.trim();
        
        if (!notesText) {
            EkashUI.showSnackbar('Lütfen notlarınızı girin', 'error');
            return;
        }

        const button = document.getElementById('importNotesBtn');
        EkashUI.setButtonLoading(button, 'İçe Aktarılıyor...');

        submitAjaxRequest('ajax/import_notes.php', {
            notes_text: notesText,
            notes_category: document.getElementById('notesCategory')?.value,
            [config.csrf.tokenName]: getCSRFToken()
        })
        .then(response => {
            if (response.success) {
                EkashUI.showSnackbar(response.message, 'success');
                const modal = document.getElementById('importNotesModal');
                if (modal) {
                    bootstrap.Modal.getInstance(modal)?.hide();
                }
                document.getElementById('notesText').value = '';
                
                setTimeout(() => location.reload(), 1500);
            } else {
                EkashUI.showSnackbar(response.message, 'error');
            }
        })
        .catch(error => {
            EkashUI.showSnackbar('Bir hata oluştu', 'error');
        })
        .finally(() => {
            EkashUI.resetButton(button);
        });
    }

    /**
     * Initialize modal form handlers
     */
    function initModalHandlers() {
        // Clean forms when modals are hidden
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
            modal.addEventListener('hidden.bs.modal', () => {
                const forms = modal.querySelectorAll('form');
                forms.forEach(resetForm);
                
                // Reset buttons
                const buttons = modal.querySelectorAll('button[type="submit"]');
                buttons.forEach(button => {
                    EkashUI.resetButton(button);
                });
            });
        });
    }

    /**
     * Generic AJAX request helper
     */
    function submitAjaxRequest(url, data) {
        return new Promise((resolve, reject) => {
            const xhr = new XMLHttpRequest();
            const formData = new FormData();
            
            // Add data to FormData
            Object.entries(data).forEach(([key, value]) => {
                formData.append(key, value);
            });
            
            xhr.timeout = config.ajax.timeout;
            
            xhr.onload = function() {
                if (xhr.status >= 200 && xhr.status < 300) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        resolve(response);
                    } catch (e) {
                        resolve({ success: true, message: xhr.responseText });
                    }
                } else {
                    reject(new Error(`HTTP ${xhr.status}: ${xhr.statusText}`));
                }
            };
            
            xhr.onerror = () => reject(new Error('Network error'));
            xhr.ontimeout = () => reject(new Error('Request timeout'));
            
            xhr.open('POST', url);
            xhr.send(formData);
        });
    }

    /**
     * Public API
     */
    return {
        // Initialization
        init,
        
        // Form handling
        validateForm,
        validateInput,
        resetForm,
        submitFormAjax,
        
        // Error handling
        showFieldError,
        hideFieldError,
        clearFormErrors,
        
        // Utilities
        getCSRFToken,
        submitAjaxRequest,
        
        // Config access
        config
    };
})();

// Auto-initialize when core is ready
EkashCore.ready(() => {
    EkashForms.init();
});

// Export for module systems
if (typeof module !== 'undefined' && module.exports) {
    module.exports = EkashForms;
}

// Global namespace
window.EkashForms = EkashForms;