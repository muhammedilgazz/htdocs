/**
 * Ekash Forms Module - Enhanced Modern Version
 * @version 3.0.0
 * @description Enhanced form handling, validation, and AJAX submissions
 */

(function() {
    'use strict';

    // Wait for core to be ready
    if (!window.EkashCore) {
        console.error('EkashForms requires EkashCore to be loaded first');
        return;
    }

    // Forms configuration
    const config = {
        debug: true,
        validation: {
            showErrorsOnInput: true,
            showErrorsOnSubmit: true,
            clearErrorsOnFocus: true
        },
        ajax: {
            timeout: 30000,
            retries: 3,
            retryDelay: 1000
        },
        autosave: {
            enabled: true,
            interval: 30000,
            storagePrefix: 'ekash_autosave_'
        }
    };

    // Form state
    const state = {
        forms: new Map(),
        validators: new Map(),
        autosaveTimers: new Map(),
        submitInProgress: new Set()
    };

    // Enhanced validation rules
    const validationRules = {
        required: {
            test: (value) => value !== null && value !== undefined && value.toString().trim() !== '',
            message: 'Bu alan zorunludur'
        },
        email: {
            test: (value) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value),
            message: 'Geçerli bir e-posta adresi giriniz'
        },
        phone: {
            test: (value) => /^(\+90|0)?[0-9]{10}$/.test(value.replace(/\s/g, '')),
            message: 'Geçerli bir telefon numarası giriniz'
        },
        url: {
            test: (value) => /^https?:\/\/.+/.test(value),
            message: 'Geçerli bir URL giriniz'
        },
        number: {
            test: (value) => !isNaN(value) && isFinite(value),
            message: 'Geçerli bir sayı giriniz'
        },
        min: {
            test: (value, min) => parseFloat(value) >= parseFloat(min),
            message: (min) => `Minimum değer: ${min}`
        },
        max: {
            test: (value, max) => parseFloat(value) <= parseFloat(max),
            message: (max) => `Maksimum değer: ${max}`
        },
        minLength: {
            test: (value, length) => value.toString().length >= parseInt(length),
            message: (length) => `Minimum ${length} karakter olmalıdır`
        },
        maxLength: {
            test: (value, length) => value.toString().length <= parseInt(length),
            message: (length) => `Maksimum ${length} karakter olmalıdır`
        },
        pattern: {
            test: (value, pattern) => new RegExp(pattern).test(value),
            message: 'Geçerli format giriniz'
        },
        currency: {
            test: (value) => /^\d+(\.\d{2})?$/.test(value),
            message: 'Geçerli bir tutar giriniz (örn: 100.50)'
        },
        iban: {
            test: (value) => /^TR\d{2}\s?\d{4}\s?\d{4}\s?\d{4}\s?\d{4}\s?\d{4}\s?\d{2}$/.test(value),
            message: 'Geçerli bir IBAN giriniz'
        },
        tc: {
            test: (value) => {
                if (!/^\d{11}$/.test(value)) return false;
                const digits = value.split('').map(Number);
                const sum1 = digits[0] + digits[2] + digits[4] + digits[6] + digits[8];
                const sum2 = digits[1] + digits[3] + digits[5] + digits[7];
                return (sum1 * 7 - sum2) % 10 === digits[9] && 
                       (sum1 + sum2 + digits[9]) % 10 === digits[10];
            },
            message: 'Geçerli bir TC kimlik numarası giriniz'
        }
    };

    // Enhanced validator class
    class FormValidator {
        constructor(form, options = {}) {
            this.form = form;
            this.options = { ...config.validation, ...options };
            this.errors = new Map();
            this.rules = new Map();
            
            this.init();
        }

        init() {
            // Parse validation rules from HTML attributes
            this.parseRules();
            
            // Setup event listeners
            this.setupEventListeners();
        }

        parseRules() {
            const inputs = this.form.querySelectorAll('input, select, textarea');
            
            inputs.forEach(input => {
                const rules = [];
                
                // Required
                if (input.hasAttribute('required')) {
                    rules.push({ type: 'required' });
                }
                
                // Type-based validation
                if (input.type === 'email') {
                    rules.push({ type: 'email' });
                } else if (input.type === 'url') {
                    rules.push({ type: 'url' });
                } else if (input.type === 'number') {
                    rules.push({ type: 'number' });
                }
                
                // Min/Max for numbers
                if (input.hasAttribute('min')) {
                    rules.push({ type: 'min', value: input.getAttribute('min') });
                }
                if (input.hasAttribute('max')) {
                    rules.push({ type: 'max', value: input.getAttribute('max') });
                }
                
                // Length validation
                if (input.hasAttribute('minlength')) {
                    rules.push({ type: 'minLength', value: input.getAttribute('minlength') });
                }
                if (input.hasAttribute('maxlength')) {
                    rules.push({ type: 'maxLength', value: input.getAttribute('maxlength') });
                }
                
                // Pattern validation
                if (input.hasAttribute('pattern')) {
                    rules.push({ type: 'pattern', value: input.getAttribute('pattern') });
                }
                
                // Custom validation attributes
                if (input.hasAttribute('data-validate')) {
                    const customRules = input.getAttribute('data-validate').split(',');
                    customRules.forEach(rule => {
                        const [type, value] = rule.split(':');
                        rules.push({ type: type.trim(), value: value ? value.trim() : null });
                    });
                }
                
                if (rules.length > 0) {
                    this.rules.set(input, rules);
                }
            });
        }

        setupEventListeners() {
            // Validate on input
            if (this.options.showErrorsOnInput) {
                this.form.addEventListener('input', (event) => {
                    if (this.rules.has(event.target)) {
                        this.validateField(event.target);
                    }
                });
            }
            
            // Clear errors on focus
            if (this.options.clearErrorsOnFocus) {
                this.form.addEventListener('focus', (event) => {
                    if (this.rules.has(event.target)) {
                        this.clearFieldError(event.target);
                    }
                }, true);
            }
            
            // Validate on submit
            this.form.addEventListener('submit', (event) => {
                if (!this.validate()) {
                    event.preventDefault();
                }
            });
        }

        validateField(field) {
            const rules = this.rules.get(field);
            if (!rules) return true;
            
            const value = field.value;
            
            for (const rule of rules) {
                const validator = validationRules[rule.type];
                if (!validator) continue;
                
                if (!validator.test(value, rule.value)) {
                    const message = typeof validator.message === 'function' ? 
                        validator.message(rule.value) : validator.message;
                    
                    this.setFieldError(field, message);
                    return false;
                }
            }
            
            this.clearFieldError(field);
            return true;
        }

        validate() {
            let isValid = true;
            
            this.rules.forEach((rules, field) => {
                if (!this.validateField(field)) {
                    isValid = false;
                }
            });
            
            return isValid;
        }

        setFieldError(field, message) {
            this.errors.set(field, message);
            
            // Add error class
            field.classList.add('is-invalid');
            
            // Show error message
            let errorElement = field.parentNode.querySelector('.invalid-feedback');
            if (!errorElement) {
                errorElement = document.createElement('div');
                errorElement.className = 'invalid-feedback';
                field.parentNode.appendChild(errorElement);
            }
            
            errorElement.textContent = message;
            errorElement.style.display = 'block';
            
            // Animate error
            if (window.EkashCore) {
                EkashCore.animate.slideIn(errorElement, 'up', { duration: 200 });
            }
        }

        clearFieldError(field) {
            this.errors.delete(field);
            
            // Remove error class
            field.classList.remove('is-invalid');
            
            // Hide error message
            const errorElement = field.parentNode.querySelector('.invalid-feedback');
            if (errorElement) {
                errorElement.style.display = 'none';
            }
        }

        getErrors() {
            return Array.from(this.errors.entries());
        }

        hasErrors() {
            return this.errors.size > 0;
        }
    }

    // Enhanced AJAX system
    const ajax = {
        // Submit form via AJAX
        submitForm: function(form, options = {}) {
            return new Promise((resolve, reject) => {
                const formData = new FormData(form);
                const url = form.action || window.location.href;
                
                this.submitAjaxRequest(url, formData, options)
                    .then(resolve)
                    .catch(reject);
            });
        },

        // Submit AJAX request
        submitAjaxRequest: function(url, data, options = {}) {
            return new Promise((resolve, reject) => {
                const requestOptions = {
                    method: 'POST',
                    timeout: config.ajax.timeout,
                    retries: config.ajax.retries,
                    ...options
                };

                // Convert data to FormData if needed
                let requestData = data;
                if (!(data instanceof FormData) && typeof data === 'object') {
                    requestData = new FormData();
                    Object.entries(data).forEach(([key, value]) => {
                        requestData.append(key, value);
                    });
                }

                // Add CSRF token if available
                if (window.csrfToken) {
                    requestData.append('csrf_token', window.csrfToken);
                }

                this.makeRequest(url, requestData, requestOptions)
                    .then(resolve)
                    .catch(reject);
            });
        },

        // Make HTTP request with retry logic
        makeRequest: function(url, data, options, attempt = 1) {
            return new Promise((resolve, reject) => {
                const xhr = new XMLHttpRequest();
                
                // Setup timeout
                xhr.timeout = options.timeout;
                
                // Setup response handlers
                xhr.onload = function() {
                    if (xhr.status >= 200 && xhr.status < 300) {
                        try {
                            const response = JSON.parse(xhr.responseText);
                            resolve(response);
                        } catch (e) {
                            resolve({ success: true, data: xhr.responseText });
                        }
                    } else {
                        reject(new Error(`HTTP ${xhr.status}: ${xhr.statusText}`));
                    }
                };
                
                xhr.onerror = function() {
                    if (attempt < options.retries) {
                        setTimeout(() => {
                            this.makeRequest(url, data, options, attempt + 1)
                                .then(resolve)
                                .catch(reject);
                        }, config.ajax.retryDelay * attempt);
                    } else {
                        reject(new Error('Network error'));
                    }
                };
                
                xhr.ontimeout = function() {
                    if (attempt < options.retries) {
                        setTimeout(() => {
                            this.makeRequest(url, data, options, attempt + 1)
                                .then(resolve)
                                .catch(reject);
                        }, config.ajax.retryDelay * attempt);
                    } else {
                        reject(new Error('Request timeout'));
                    }
                };
                
                // Send request
                xhr.open(options.method, url);
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                
                if (window.csrfToken) {
                    xhr.setRequestHeader('X-CSRF-Token', window.csrfToken);
                }
                
                xhr.send(data);
            });
        }
    };

    // Enhanced autosave system
    const autosave = {
        // Enable autosave for form
        enable: function(form) {
            if (!config.autosave.enabled) return;
            
            const formId = form.id || `form_${Date.now()}`;
            const storageKey = config.autosave.storagePrefix + formId;
            
            // Load saved data
            this.loadSavedData(form, storageKey);
            
            // Setup autosave timer
            const timer = setInterval(() => {
                this.saveFormData(form, storageKey);
            }, config.autosave.interval);
            
            state.autosaveTimers.set(form, timer);
            
            // Save on input with debounce
            const debouncedSave = EkashCore.utils.debounce(() => {
                this.saveFormData(form, storageKey);
            }, 1000);
            
            form.addEventListener('input', debouncedSave);
            
            // Clear on submit
            form.addEventListener('submit', () => {
                this.clearSavedData(storageKey);
                this.disable(form);
            });
        },

        // Disable autosave for form
        disable: function(form) {
            const timer = state.autosaveTimers.get(form);
            if (timer) {
                clearInterval(timer);
                state.autosaveTimers.delete(form);
            }
        },

        // Save form data
        saveFormData: function(form, storageKey) {
            const formData = new FormData(form);
            const data = {};
            
            for (const [key, value] of formData.entries()) {
                data[key] = value;
            }
            
            try {
                EkashCore.utils.storage.set(storageKey, {
                    data: data,
                    timestamp: Date.now()
                });
                
                // Show subtle notification
                if (window.EkashUI) {
                    EkashUI.showNotification('Form otomatik kaydedildi', 'info', { 
                        duration: 2000,
                        position: 'bottom-right'
                    });
                }
            } catch (e) {
                console.warn('Autosave failed:', e);
            }
        },

        // Load saved data
        loadSavedData: function(form, storageKey) {
            const savedData = EkashCore.utils.storage.get(storageKey);
            if (!savedData) return;
            
            const { data, timestamp } = savedData;
            
            // Check if data is not too old (24 hours)
            if (Date.now() - timestamp > 24 * 60 * 60 * 1000) {
                this.clearSavedData(storageKey);
                return;
            }
            
            // Populate form
            Object.entries(data).forEach(([key, value]) => {
                const field = form.querySelector(`[name="${key}"]`);
                if (field) {
                    field.value = value;
                }
            });
            
            // Show notification
            if (window.EkashUI) {
                EkashUI.showNotification('Kaydedilmiş form verileri yüklendi', 'success', { 
                    duration: 3000 
                });
            }
        },

        // Clear saved data
        clearSavedData: function(storageKey) {
            EkashCore.utils.storage.remove(storageKey);
        }
    };

    // Enhanced form utilities
    const utils = {
        // Get form data as object
        getFormData: function(form) {
            const formData = new FormData(form);
            const data = {};
            
            for (const [key, value] of formData.entries()) {
                if (data[key]) {
                    // Handle multiple values (checkboxes, multi-select)
                    if (Array.isArray(data[key])) {
                        data[key].push(value);
                    } else {
                        data[key] = [data[key], value];
                    }
                } else {
                    data[key] = value;
                }
            }
            
            return data;
        },

        // Populate form with data
        populateForm: function(form, data) {
            Object.entries(data).forEach(([key, value]) => {
                const field = form.querySelector(`[name="${key}"]`);
                if (field) {
                    if (field.type === 'checkbox' || field.type === 'radio') {
                        field.checked = value;
                    } else {
                        field.value = value;
                    }
                }
            });
        },

        // Reset form with animation
        resetForm: function(form) {
            const fields = form.querySelectorAll('input, select, textarea');
            
            fields.forEach(field => {
                if (window.EkashCore) {
                    EkashCore.animate.fadeOut(field, { duration: 200 }).then(() => {
                        field.value = '';
                        field.checked = false;
                        field.classList.remove('is-invalid');
                        EkashCore.animate.fadeIn(field, { duration: 200 });
                    });
                } else {
                    field.value = '';
                    field.checked = false;
                    field.classList.remove('is-invalid');
                }
            });
        },

        // Validate single field
        validateField: function(field) {
            const form = field.closest('form');
            if (!form) return true;
            
            const validator = state.validators.get(form);
            if (!validator) return true;
            
            return validator.validateField(field);
        }
    };

    // Form initialization
    function initializeForms() {
        const forms = document.querySelectorAll('form');
        
        forms.forEach(form => {
            // Skip if already initialized
            if (state.forms.has(form)) return;
            
            // Create validator
            const validator = new FormValidator(form);
            state.validators.set(form, validator);
            
            // Enable autosave if attribute is present
            if (form.hasAttribute('data-autosave')) {
                autosave.enable(form);
            }
            
            // Setup AJAX submission if attribute is present
            if (form.hasAttribute('data-ajax')) {
                form.addEventListener('submit', (event) => {
                    event.preventDefault();
                    
                    // Check if already submitting
                    if (state.submitInProgress.has(form)) return;
                    
                    const submitButton = form.querySelector('button[type="submit"]');
                    
                    // Set loading state
                    if (submitButton && window.EkashUI) {
                        EkashUI.setButtonLoading(submitButton);
                    }
                    
                    state.submitInProgress.add(form);
                    
                    ajax.submitForm(form)
                        .then(response => {
                            if (response.success) {
                                if (window.EkashUI) {
                                    EkashUI.showNotification(response.message || 'İşlem başarılı', 'success');
                                }
                                
                                // Reset form if specified
                                if (form.hasAttribute('data-reset-on-success')) {
                                    utils.resetForm(form);
                                }
                                
                                // Redirect if specified
                                if (response.redirect) {
                                    setTimeout(() => {
                                        window.location.href = response.redirect;
                                    }, 1000);
                                }
                            } else {
                                if (window.EkashUI) {
                                    EkashUI.showNotification(response.message || 'İşlem başarısız', 'error');
                                }
                            }
                        })
                        .catch(error => {
                            if (window.EkashUI) {
                                EkashUI.showNotification('Bağlantı hatası: ' + error.message, 'error');
                            }
                        })
                        .finally(() => {
                            // Reset loading state
                            if (submitButton && window.EkashUI) {
                                EkashUI.resetButton(submitButton);
                            }
                            
                            state.submitInProgress.delete(form);
                        });
                });
            }
            
            // Mark as initialized
            state.forms.set(form, {
                validator: validator,
                initialized: Date.now()
            });
        });
    }

    // Initialize forms system
    function init() {
        EkashCore.performance.mark('forms-init-start');
        
        // Initialize existing forms
        initializeForms();
        
        // Watch for new forms
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                mutation.addedNodes.forEach((node) => {
                    if (node.nodeType === 1) { // Element node
                        if (node.tagName === 'FORM') {
                            initializeForms();
                        } else if (node.querySelector) {
                            const forms = node.querySelectorAll('form');
                            if (forms.length > 0) {
                                initializeForms();
                            }
                        }
                    }
                });
            });
        });
        
        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
        
        // Debug info
        if (config.debug) {
            console.log('📝 Ekash Forms initialized');
        }
        
        EkashCore.performance.mark('forms-init-end');
        EkashCore.performance.measure('forms-init', 'forms-init-start', 'forms-init-end');
        
        // Trigger ready event
        EkashCore.trigger('formsReady');
    }

    // Public API
    window.EkashForms = {
        // Configuration
        config: config,
        
        // Classes
        FormValidator: FormValidator,
        
        // Systems
        ajax: ajax,
        autosave: autosave,
        utils: utils,
        
        // Validation rules
        validationRules: validationRules,
        
        // Convenience methods
        submitAjaxRequest: ajax.submitAjaxRequest.bind(ajax),
        submitForm: ajax.submitForm.bind(ajax),
        validateField: utils.validateField.bind(utils),
        getFormData: utils.getFormData.bind(utils),
        populateForm: utils.populateForm.bind(utils),
        resetForm: utils.resetForm.bind(utils),
        
        // Initialize
        init: init
    };

    // Auto-initialize when core is ready
    EkashCore.on('coreReady', init);

})();