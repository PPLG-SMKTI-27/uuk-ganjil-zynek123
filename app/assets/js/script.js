// ===== GLOBAL FUNCTIONS =====

/**
 * Initialize all JavaScript functionality when DOM is loaded
 */
document.addEventListener('DOMContentLoaded', function() {
    initializeComponents();
    setupEventListeners();
    setupFormValidations();
});

/**
 * Initialize all UI components
 */
function initializeComponents() {
    // Auto-hide alerts after 5 seconds
    autoHideAlerts();
    
    // Initialize tooltips
    initTooltips();
    
    // Initialize sidebar functionality
    initSidebar();
    
    // Initialize table functionalities
    initTableEnhancements();
    
    // Initialize form enhancements
    initFormEnhancements();
}

/**
 * Setup global event listeners
 */
function setupEventListeners() {
    // Global click handler for dynamic elements
    document.addEventListener('click', function(e) {
        handleGlobalClicks(e);
    });
    
    // Form submission handling
    document.addEventListener('submit', function(e) {
        handleFormSubmissions(e);
    });
    
    // Window resize handling
    window.addEventListener('resize', debounce(handleResize, 250));
}

// ===== ALERT MANAGEMENT =====

/**
 * Auto hide alerts after specified time
 */
function autoHideAlerts() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            if (alert.parentNode) {
                alert.style.opacity = '0';
                alert.style.transition = 'opacity 0.5s ease';
                setTimeout(() => {
                    if (alert.parentNode) {
                        alert.remove();
                    }
                }, 500);
            }
        }, 5000);
    });
}

/**
 * Show custom alert message
 * @param {string} message - Alert message
 * @param {string} type - Alert type (success, danger, warning, info)
 * @param {number} duration - Duration in milliseconds
 */
function showAlert(message, type = 'info', duration = 5000) {
    const alertHtml = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            <i class="fas fa-${getAlertIcon(type)} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    // Create temporary container to parse HTML
    const temp = document.createElement('div');
    temp.innerHTML = alertHtml;
    const alertElement = temp.firstElementChild;
    
    // Find where to insert the alert
    const container = document.querySelector('.container-fluid') || document.body;
    container.insertBefore(alertElement, container.firstChild);
    
    // Auto remove after duration
    if (duration > 0) {
        setTimeout(() => {
            if (alertElement.parentNode) {
                alertElement.remove();
            }
        }, duration);
    }
    
    return alertElement;
}

/**
 * Get appropriate icon for alert type
 */
function getAlertIcon(type) {
    const icons = {
        'success': 'check-circle',
        'danger': 'exclamation-triangle',
        'warning': 'exclamation-circle',
        'info': 'info-circle'
    };
    return icons[type] || 'info-circle';
}

// ===== SIDEBAR FUNCTIONALITY =====

/**
 * Initialize sidebar functionality
 */
function initSidebar() {
    const sidebar = document.getElementById('sidebarMenu');
    if (!sidebar) return;
    
    // Auto-hide sidebar on mobile when clicking a link
    const navLinks = sidebar.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth < 768) {
                const bsCollapse = new bootstrap.Collapse(sidebar);
                bsCollapse.hide();
            }
        });
    });
    
    // Add active class based on current page
    highlightActiveNavItem();
}

/**
 * Highlight active navigation item based on current URL
 */
function highlightActiveNavItem() {
    const currentPath = window.location.href;
    const navItems = document.querySelectorAll('.sidebar .nav-link');
    
    navItems.forEach(item => {
        if (item.href === currentPath) {
            item.classList.add('active', 'bg-primary');
        } else {
            item.classList.remove('active', 'bg-primary');
        }
    });
}

// ===== TABLE ENHANCEMENTS =====

/**
 * Initialize table enhancements
 */
function initTableEnhancements() {
    // Add search functionality to tables
    initTableSearch();
    
    // Add sort functionality to tables
    initTableSort();
    
    // Add row selection
    initTableRowSelection();
}

/**
 * Initialize table search functionality
 */
function initTableSearch() {
    const searchInputs = document.querySelectorAll('.table-search');
    searchInputs.forEach(input => {
        input.addEventListener('input', debounce(function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const table = e.target.closest('.card').querySelector('table');
            const rows = table.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        }, 300));
    });
}

/**
 * Initialize table sort functionality
 */
function initTableSort() {
    const sortableHeaders = document.querySelectorAll('th[data-sort]');
    sortableHeaders.forEach(header => {
        header.style.cursor = 'pointer';
        header.addEventListener('click', function() {
            sortTableByColumn(this);
        });
    });
}

/**
 * Sort table by column
 */
function sortTableByColumn(header) {
    const table = header.closest('table');
    const columnIndex = Array.from(header.parentNode.children).indexOf(header);
    const isAscending = header.getAttribute('data-sort') === 'asc';
    
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    
    rows.sort((a, b) => {
        const aValue = a.children[columnIndex].textContent.trim();
        const bValue = b.children[columnIndex].textContent.trim();
        
        // Try to compare as numbers first
        const aNum = parseFloat(aValue);
        const bNum = parseFloat(bValue);
        
        if (!isNaN(aNum) && !isNaN(bNum)) {
            return isAscending ? aNum - bNum : bNum - aNum;
        }
        
        // Compare as strings
        return isAscending 
            ? aValue.localeCompare(bValue)
            : bValue.localeCompare(aValue);
    });
    
    // Remove existing rows
    while (tbody.firstChild) {
        tbody.removeChild(tbody.firstChild);
    }
    
    // Add sorted rows
    rows.forEach(row => tbody.appendChild(row));
    
    // Update sort direction
    header.setAttribute('data-sort', isAscending ? 'desc' : 'asc');
    
    // Update sort indicator
    updateSortIndicator(header, isAscending);
}

/**
 * Update sort indicator in table header
 */
function updateSortIndicator(header, isAscending) {
    // Remove existing indicators
    const existingIcons = header.querySelectorAll('.sort-icon');
    existingIcons.forEach(icon => icon.remove());
    
    // Add new indicator
    const icon = document.createElement('i');
    icon.className = `sort-icon fas fa-${isAscending ? 'sort-up' : 'sort-down'} ms-1`;
    header.appendChild(icon);
}

/**
 * Initialize table row selection
 */
function initTableRowSelection() {
    const selectableRows = document.querySelectorAll('tr[data-selectable]');
    selectableRows.forEach(row => {
        row.addEventListener('click', function(e) {
            if (e.target.tagName !== 'A' && e.target.tagName !== 'BUTTON') {
                this.classList.toggle('table-active');
            }
        });
    });
}

// ===== FORM ENHANCEMENTS =====

/**
 * Initialize form enhancements
 */
function initFormEnhancements() {
    // Auto-size textareas
    initAutoSizeTextareas();
    
    // File input enhancements
    initFileInputs();
    
    // Password visibility toggles
    initPasswordToggles();
}

/**
 * Initialize auto-size textareas
 */
function initAutoSizeTextareas() {
    const textareas = document.querySelectorAll('textarea[data-auto-size]');
    textareas.forEach(textarea => {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
        
        // Trigger initial resize
        textarea.dispatchEvent(new Event('input'));
    });
}

/**
 * Initialize file input enhancements
 */
function initFileInputs() {
    const fileInputs = document.querySelectorAll('.custom-file-input');
    fileInputs.forEach(input => {
        input.addEventListener('change', function() {
            const fileName = this.files[0]?.name || 'Pilih file';
            const label = this.nextElementSibling;
            if (label && label.classList.contains('custom-file-label')) {
                label.textContent = fileName;
            }
        });
    });
}

/**
 * Initialize password visibility toggles
 */
function initPasswordToggles() {
    const toggles = document.querySelectorAll('.password-toggle');
    toggles.forEach(toggle => {
        toggle.addEventListener('click', function() {
            const input = this.previousElementSibling;
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
            
            const icon = this.querySelector('i');
            icon.className = type === 'password' ? 'fas fa-eye' : 'fas fa-eye-slash';
        });
    });
}

// ===== FORM VALIDATION =====

/**
 * Setup form validations
 */
function setupFormValidations() {
    // Real-time validation for required fields
    const requiredFields = document.querySelectorAll('[required]');
    requiredFields.forEach(field => {
        field.addEventListener('blur', validateField);
        field.addEventListener('input', clearFieldError);
    });
    
    // Email validation
    const emailFields = document.querySelectorAll('input[type="email"]');
    emailFields.forEach(field => {
        field.addEventListener('blur', validateEmail);
    });
    
    // Password strength validation
    const passwordFields = document.querySelectorAll('input[type="password"]');
    passwordFields.forEach(field => {
        field.addEventListener('input', validatePasswordStrength);
    });
}

/**
 * Validate individual form field
 */
function validateField(e) {
    const field = e.target;
    const value = field.value.trim();
    
    if (field.hasAttribute('required') && !value) {
        showFieldError(field, 'Field ini wajib diisi');
        return false;
    }
    
    if (field.type === 'email' && value) {
        return validateEmail({ target: field });
    }
    
    clearFieldError({ target: field });
    return true;
}

/**
 * Validate email field
 */
function validateEmail(e) {
    const field = e.target;
    const email = field.value.trim();
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    
    if (email && !emailRegex.test(email)) {
        showFieldError(field, 'Format email tidak valid');
        return false;
    }
    
    clearFieldError({ target: field });
    return true;
}

/**
 * Validate password strength
 */
function validatePasswordStrength(e) {
    const field = e.target;
    const password = field.value;
    
    if (!password) {
        clearFieldError(field);
        return;
    }
    
    let strength = 0;
    let feedback = '';
    
    // Length check
    if (password.length >= 6) strength += 25;
    if (password.length >= 8) strength += 25;
    
    // Complexity checks
    if (/[A-Z]/.test(password)) strength += 25;
    if (/[0-9]/.test(password)) strength += 25;
    if (/[^A-Za-z0-9]/.test(password)) strength += 25;
    
    // Cap at 100%
    strength = Math.min(strength, 100);
    
    // Update strength indicator if exists
    const strengthBar = field.parentNode.querySelector('.password-strength');
    const feedbackEl = field.parentNode.querySelector('.password-feedback');
    
    if (strengthBar) {
        strengthBar.style.width = strength + '%';
        strengthBar.className = `password-strength progress-bar ${
            strength < 50 ? 'bg-danger' : 
            strength < 75 ? 'bg-warning' : 'bg-success'
        }`;
    }
    
    if (feedbackEl) {
        feedbackEl.textContent = getPasswordFeedback(strength);
    }
}

/**
 * Get password strength feedback
 */
function getPasswordFeedback(strength) {
    if (strength < 50) return 'Password lemah';
    if (strength < 75) return 'Password cukup';
    return 'Password kuat';
}

/**
 * Show field error
 */
function showFieldError(field, message) {
    field.classList.add('is-invalid');
    
    let feedback = field.nextElementSibling;
    if (!feedback || !feedback.classList.contains('invalid-feedback')) {
        feedback = document.createElement('div');
        feedback.className = 'invalid-feedback';
        field.parentNode.appendChild(feedback);
    }
    
    feedback.textContent = message;
    feedback.style.display = 'block';
}

/**
 * Clear field error
 */
function clearFieldError(e) {
    const field = e.target;
    field.classList.remove('is-invalid');
    
    const feedback = field.nextElementSibling;
    if (feedback && feedback.classList.contains('invalid-feedback')) {
        feedback.style.display = 'none';
    }
}

// ===== UTILITY FUNCTIONS =====

/**
 * Debounce function to limit function calls
 */
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

/**
 * Format date to Indonesian format
 */
function formatDate(date, includeTime = false) {
    const options = { 
        day: '2-digit', 
        month: '2-digit', 
        year: 'numeric' 
    };
    
    if (includeTime) {
        options.hour = '2-digit';
        options.minute = '2-digit';
    }
    
    return new Date(date).toLocaleDateString('id-ID', options);
}

/**
 * Format number with thousand separators
 */
function formatNumber(number) {
    return new Intl.NumberFormat('id-ID').format(number);
}

/**
 * Show loading state on element
 */
function showLoading(element) {
    element.classList.add('loading');
    element.disabled = true;
    
    const originalText = element.innerHTML;
    element.setAttribute('data-original-text', originalText);
    element.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Loading...';
    
    return () => {
        element.classList.remove('loading');
        element.disabled = false;
        element.innerHTML = originalText;
    };
}

/**
 * Confirm action with custom message
 */
function confirmAction(message = 'Apakah Anda yakin?') {
    return new Promise((resolve) => {
        // You can replace this with a custom modal
        if (confirm(message)) {
            resolve(true);
        } else {
            resolve(false);
        }
    });
}

/**
 * Copy text to clipboard
 */
async function copyToClipboard(text) {
    try {
        await navigator.clipboard.writeText(text);
        showAlert('Teks berhasil disalin', 'success');
        return true;
    } catch (err) {
        showAlert('Gagal menyalin teks', 'danger');
        return false;
    }
}

// ===== EVENT HANDLERS =====

/**
 * Handle global click events
 */
function handleGlobalClicks(e) {
    // Handle copy buttons
    if (e.target.closest('[data-copy]')) {
        const button = e.target.closest('[data-copy]');
        const text = button.getAttribute('data-copy');
        copyToClipboard(text);
    }
    
    // Handle print buttons
    if (e.target.closest('[data-print]')) {
        window.print();
    }
    
    // Handle export buttons
    if (e.target.closest('[data-export]')) {
        const format = e.target.closest('[data-export]').getAttribute('data-export');
        exportData(format);
    }
}

/**
 * Handle form submissions
 */
function handleFormSubmissions(e) {
    const form = e.target;
    
    // Add loading state to submit button
    const submitButton = form.querySelector('button[type="submit"]');
    if (submitButton) {
        const hideLoading = showLoading(submitButton);
        
        // Re-enable button after form submission (success or error)
        setTimeout(hideLoading, 3000);
    }
}

/**
 * Handle window resize
 */
function handleResize() {
    // Add any resize-specific logic here
    console.log('Window resized to:', window.innerWidth, 'x', window.innerHeight);
}

// ===== DATA EXPORT =====

/**
 * Export data in various formats
 */
function exportData(format = 'csv') {
    const table = document.querySelector('table');
    if (!table) {
        showAlert('Tidak ada data untuk diexport', 'warning');
        return;
    }
    
    let data = '';
    const rows = table.querySelectorAll('tr');
    
    rows.forEach(row => {
        const cells = row.querySelectorAll('th, td');
        const rowData = Array.from(cells).map(cell => {
            let text = cell.textContent.trim();
            // Remove icons and badges
            text = text.replace(/<[^>]*>/g, '');
            // CSV format requires quotes around text with commas
            if (text.includes(',') || text.includes('"')) {
                text = `"${text.replace(/"/g, '""')}"`;
            }
            return text;
        }).join(',');
        
        data += rowData + '\n';
    });
    
    if (format === 'csv') {
        downloadFile(data, 'data.csv', 'text/csv');
    }
}

/**
 * Download file
 */
function downloadFile(content, filename, contentType) {
    const blob = new Blob([content], { type: contentType });
    const url = URL.createObjectURL(blob);
    const link = document.createElement('a');
    link.href = url;
    link.download = filename;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    URL.revokeObjectURL(url);
}

// ===== TOOLTIP INITIALIZATION =====

/**
 * Initialize tooltips
 */
function initTooltips() {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
}

// ===== PUBLIC API =====

// Make some functions available globally
window.App = {
    showAlert,
    confirmAction,
    formatDate,
    formatNumber,
    copyToClipboard,
    showLoading
};

console.log('Lab PPLG System JS loaded successfully!');