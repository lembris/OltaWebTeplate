/**
 * SEO Generator - Hybrid System
 * Provides quick PHP-based generation and AI-powered enhancement
 */

class SeoGenerator {
    constructor() {
        this.aiEnabled = false;
        this.checkAiStatus();
    }

    /**
     * Check if AI is available
     */
    checkAiStatus() {
        const url = BASE_URL.replace(/\/$/, '') + '/index.php/admin/seo/ai-status';
        fetch(url, {
            method: 'GET'
        })
        .then(response => response.json())
        .then(data => {
            this.aiEnabled = data.ai_enabled;
        })
        .catch(err => {
            console.warn('Could not check AI status:', err);
            this.aiEnabled = false;
        });
    }

    /**
     * Generate quick SEO (PHP-based)
     */
    generateQuick(type, formData) {
        return new Promise((resolve, reject) => {
            // Get CSRF token if available
            const csrfToken = document.querySelector('input[name*="csrf"]')?.value || '';
            const csrfName = document.querySelector('input[name*="csrf"]')?.name || '';
            
            const headers = {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            };
            
            if (csrfToken) {
                headers[csrfName] = csrfToken;
            }
            
            const url = BASE_URL.replace(/\/$/, '') + '/index.php/admin/seo/generate-quick';
            fetch(url, {
                method: 'POST',
                headers: headers,
                body: JSON.stringify({
                    type: type,
                    ...formData
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    resolve(data.data);
                } else {
                    reject(new Error(data.error || 'Unknown error'));
                }
            })
            .catch(err => {
                reject(err);
            });
        });
    }

    /**
     * Generate AI SEO (requires API key configured)
     */
    generateAI(type, formData) {
        return new Promise((resolve, reject) => {
            if (!this.aiEnabled) {
                reject(new Error('AI not enabled. Please configure API key in settings.'));
                return;
            }

            // Get CSRF token if available
            const csrfToken = document.querySelector('input[name*="csrf"]')?.value || '';
            const csrfName = document.querySelector('input[name*="csrf"]')?.name || '';
            
            const headers = {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            };
            
            if (csrfToken) {
                headers[csrfName] = csrfToken;
            }

            const url = BASE_URL.replace(/\/$/, '') + '/index.php/admin/seo/generate-ai';
            fetch(url, {
                method: 'POST',
                headers: headers,
                body: JSON.stringify({
                    type: type,
                    ...formData
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    resolve(data.data);
                } else {
                    reject(new Error(data.error || 'Unknown error'));
                }
            })
            .catch(err => {
                reject(err);
            });
        });
    }

    /**
     * Extract form data for SEO generation
     */
    extractFormData(formId, type) {
        const form = document.getElementById(formId);
        if (!form) {
            throw new Error('Form not found');
        }

        const data = {
            title: form.elements['title']?.value || form.elements['name']?.value || '',
            excerpt: form.elements['excerpt']?.value || form.elements['short_description']?.value || '',
            content: form.elements['content']?.value || form.elements['description']?.value || ''
        };

        // For gallery, add description
        if (type === 'gallery') {
            data.description = form.elements['description']?.value || '';
        }

        return data;
    }

    /**
     * Update SEO fields in form
     */
    updateFormFields(seo, type) {
        const form = document.querySelector('form');
        if (!form) return;

        if (type === 'blog' || type === 'pages') {
            if (seo.meta_title) {
                const field = form.elements['seo_title'];
                if (field) field.value = seo.meta_title;
            }
            if (seo.meta_description) {
                const field = form.elements['seo_description'];
                if (field) field.value = seo.meta_description;
            }
            if (seo.seo_keywords && type === 'pages') {
                const field = form.elements['seo_keywords'];
                if (field) field.value = seo.seo_keywords;
            }
        } else if (type === 'packages') {
            if (seo.meta_title) {
                const field = form.elements['meta_title'];
                if (field) field.value = seo.meta_title;
            }
            if (seo.meta_description) {
                const field = form.elements['meta_description'];
                if (field) field.value = seo.meta_description;
            }
        } else if (type === 'gallery') {
            if (seo.alt_text) {
                const field = form.elements['alt_text'];
                if (field) field.value = seo.alt_text;
            }
        }

        // Trigger change events to update character counters if present
        form.querySelectorAll('input[type="text"], textarea').forEach(field => {
            field.dispatchEvent(new Event('change', { bubbles: true }));
        });
    }

    /**
     * Show loading state
     */
    showLoading(button) {
        const originalHTML = button.innerHTML;
        button.disabled = true;
        button.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Generating...';
        return originalHTML;
    }

    /**
     * Hide loading state
     */
    hideLoading(button, originalHTML) {
        button.disabled = false;
        button.innerHTML = originalHTML;
    }

    /**
     * Show toast notification
     */
    showToast(message, type = 'info') {
        const toastHTML = `
            <div class="toast-container position-fixed top-0 end-0 p-3">
                <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-body bg-${type === 'error' ? 'danger' : type === 'success' ? 'success' : 'info'} text-white">
                        <i class="fas fa-${type === 'error' ? 'exclamation-circle' : type === 'success' ? 'check-circle' : 'info-circle'} me-2"></i>
                        ${message}
                    </div>
                </div>
            </div>
        `;
        
        document.body.insertAdjacentHTML('beforeend', toastHTML);
        
        setTimeout(() => {
            document.querySelector('.toast-container').remove();
        }, 5000);
    }
}

// Initialize global instance
const seoGen = new SeoGenerator();

/**
 * Integration functions for each form type
 */

// PACKAGES FORM
function generatePackageSEO() {
    const button = event.currentTarget;
    const originalHTML = seoGen.showLoading(button);

    try {
        const formData = seoGen.extractFormData('packageForm', 'packages');
        
        if (!formData.title && !formData.title) {
            seoGen.showToast('Please fill in package name and description first', 'error');
            seoGen.hideLoading(button, originalHTML);
            return;
        }

        seoGen.generateQuick('packages', formData)
            .then(seo => {
                seoGen.updateFormFields(seo, 'packages');
                seoGen.showToast('SEO settings generated successfully!', 'success');
                seoGen.hideLoading(button, originalHTML);
            })
            .catch(err => {
                seoGen.showToast('Error: ' + err.message, 'error');
                seoGen.hideLoading(button, originalHTML);
            });
    } catch (err) {
        seoGen.showToast('Error: ' + err.message, 'error');
        seoGen.hideLoading(button, originalHTML);
    }
}

function generatePackageSEOAI() {
    const button = event.currentTarget;
    const originalHTML = seoGen.showLoading(button);

    try {
        const formData = seoGen.extractFormData('packageForm', 'packages');
        
        if (!formData.title && !formData.title) {
            seoGen.showToast('Please fill in package name and description first', 'error');
            seoGen.hideLoading(button, originalHTML);
            return;
        }

        seoGen.generateAI('packages', formData)
            .then(seo => {
                seoGen.updateFormFields(seo, 'packages');
                seoGen.showToast('AI-powered SEO generated successfully!', 'success');
                seoGen.hideLoading(button, originalHTML);
            })
            .catch(err => {
                seoGen.showToast('AI Error: ' + err.message + '. Falling back to quick generation.', 'warning');
                seoGen.generateQuick('packages', formData)
                    .then(seo => {
                        seoGen.updateFormFields(seo, 'packages');
                        seoGen.showToast('Using quick generation instead', 'info');
                        seoGen.hideLoading(button, originalHTML);
                    });
            });
    } catch (err) {
        seoGen.showToast('Error: ' + err.message, 'error');
        seoGen.hideLoading(button, originalHTML);
    }
}

// BLOG FORM
function generateBlogSEO() {
    const button = event.currentTarget;
    const originalHTML = seoGen.showLoading(button);

    try {
        const formData = seoGen.extractFormData('blogForm', 'blog');
        
        if (!formData.title || !formData.content) {
            seoGen.showToast('Please fill in title and content first', 'error');
            seoGen.hideLoading(button, originalHTML);
            return;
        }

        seoGen.generateQuick('blog', formData)
            .then(seo => {
                seoGen.updateFormFields(seo, 'blog');
                seoGen.showToast('SEO settings generated successfully!', 'success');
                seoGen.hideLoading(button, originalHTML);
            })
            .catch(err => {
                seoGen.showToast('Error: ' + err.message, 'error');
                seoGen.hideLoading(button, originalHTML);
            });
    } catch (err) {
        seoGen.showToast('Error: ' + err.message, 'error');
        seoGen.hideLoading(button, originalHTML);
    }
}

function generateBlogSEOAI() {
    const button = event.currentTarget;
    const originalHTML = seoGen.showLoading(button);

    try {
        const formData = seoGen.extractFormData('blogForm', 'blog');
        
        if (!formData.title || !formData.content) {
            seoGen.showToast('Please fill in title and content first', 'error');
            seoGen.hideLoading(button, originalHTML);
            return;
        }

        seoGen.generateAI('blog', formData)
            .then(seo => {
                seoGen.updateFormFields(seo, 'blog');
                seoGen.showToast('AI-powered SEO generated successfully!', 'success');
                seoGen.hideLoading(button, originalHTML);
            })
            .catch(err => {
                seoGen.showToast('AI Error: ' + err.message + '. Falling back to quick generation.', 'warning');
                seoGen.generateQuick('blog', formData)
                    .then(seo => {
                        seoGen.updateFormFields(seo, 'blog');
                        seoGen.showToast('Using quick generation instead', 'info');
                        seoGen.hideLoading(button, originalHTML);
                    });
            });
    } catch (err) {
        seoGen.showToast('Error: ' + err.message, 'error');
        seoGen.hideLoading(button, originalHTML);
    }
}

// PAGES FORM
function generatePageSEO() {
    const button = event.currentTarget;
    const originalHTML = seoGen.showLoading(button);

    try {
        const formData = seoGen.extractFormData('pageForm', 'pages');
        
        if (!formData.title || !formData.content) {
            seoGen.showToast('Please fill in title and content first', 'error');
            seoGen.hideLoading(button, originalHTML);
            return;
        }

        seoGen.generateQuick('pages', formData)
            .then(seo => {
                seoGen.updateFormFields(seo, 'pages');
                seoGen.showToast('SEO settings generated successfully!', 'success');
                seoGen.hideLoading(button, originalHTML);
            })
            .catch(err => {
                seoGen.showToast('Error: ' + err.message, 'error');
                seoGen.hideLoading(button, originalHTML);
            });
    } catch (err) {
        seoGen.showToast('Error: ' + err.message, 'error');
        seoGen.hideLoading(button, originalHTML);
    }
}

function generatePageSEOAI() {
    const button = event.currentTarget;
    const originalHTML = seoGen.showLoading(button);

    try {
        const formData = seoGen.extractFormData('pageForm', 'pages');
        
        if (!formData.title || !formData.content) {
            seoGen.showToast('Please fill in title and content first', 'error');
            seoGen.hideLoading(button, originalHTML);
            return;
        }

        seoGen.generateAI('pages', formData)
            .then(seo => {
                seoGen.updateFormFields(seo, 'pages');
                seoGen.showToast('AI-powered SEO generated successfully!', 'success');
                seoGen.hideLoading(button, originalHTML);
            })
            .catch(err => {
                seoGen.showToast('AI Error: ' + err.message + '. Falling back to quick generation.', 'warning');
                seoGen.generateQuick('pages', formData)
                    .then(seo => {
                        seoGen.updateFormFields(seo, 'pages');
                        seoGen.showToast('Using quick generation instead', 'info');
                        seoGen.hideLoading(button, originalHTML);
                    });
            });
    } catch (err) {
        seoGen.showToast('Error: ' + err.message, 'error');
        seoGen.hideLoading(button, originalHTML);
    }
}

// GALLERY FORM
function generateGallerySEO() {
    const button = event.currentTarget;
    const originalHTML = seoGen.showLoading(button);

    try {
        const formData = seoGen.extractFormData('galleryForm', 'gallery');
        
        if (!formData.title) {
            seoGen.showToast('Please fill in image title first', 'error');
            seoGen.hideLoading(button, originalHTML);
            return;
        }

        seoGen.generateQuick('gallery', formData)
            .then(seo => {
                seoGen.updateFormFields(seo, 'gallery');
                seoGen.showToast('Alt text generated successfully!', 'success');
                seoGen.hideLoading(button, originalHTML);
            })
            .catch(err => {
                seoGen.showToast('Error: ' + err.message, 'error');
                seoGen.hideLoading(button, originalHTML);
            });
    } catch (err) {
        seoGen.showToast('Error: ' + err.message, 'error');
        seoGen.hideLoading(button, originalHTML);
    }
}

function generateGallerySEOAI() {
    const button = event.currentTarget;
    const originalHTML = seoGen.showLoading(button);

    try {
        const formData = seoGen.extractFormData('galleryForm', 'gallery');
        
        if (!formData.title) {
            seoGen.showToast('Please fill in image title first', 'error');
            seoGen.hideLoading(button, originalHTML);
            return;
        }

        seoGen.generateAI('gallery', formData)
            .then(seo => {
                seoGen.updateFormFields(seo, 'gallery');
                seoGen.showToast('AI-powered alt text generated successfully!', 'success');
                seoGen.hideLoading(button, originalHTML);
            })
            .catch(err => {
                seoGen.showToast('AI Error: ' + err.message + '. Falling back to quick generation.', 'warning');
                seoGen.generateQuick('gallery', formData)
                    .then(seo => {
                        seoGen.updateFormFields(seo, 'gallery');
                        seoGen.showToast('Using quick generation instead', 'info');
                        seoGen.hideLoading(button, originalHTML);
                    });
            });
    } catch (err) {
        seoGen.showToast('Error: ' + err.message, 'error');
        seoGen.hideLoading(button, originalHTML);
    }
}
