// Main JavaScript for GeoPlan Engineering Website

(function() {
    'use strict';

    // Initialize AOS (Animate On Scroll)
    document.addEventListener('DOMContentLoaded', function() {
        AOS.init({
            duration: 800,
            easing: 'ease-out-cubic',
            once: true,
            offset: 100
        });
    });

    // Navbar scroll effect
    window.addEventListener('scroll', function() {
        const navbar = document.querySelector('.navbar');
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    // Back to top button
    const backToTopButton = document.getElementById('backToTop');

    if (backToTopButton) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 300) {
                backToTopButton.style.display = 'flex';
            } else {
                backToTopButton.style.display = 'none';
            }
        });

        backToTopButton.addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                const offsetTop = target.offsetTop - 80; // Account for fixed navbar
                window.scrollTo({
                    top: offsetTop,
                    behavior: 'smooth'
                });
            }
        });
    });

    // Enhanced carousel auto-play with pause on hover
    const carousel = document.querySelector('#heroCarousel');
    if (carousel) {
        const carouselInstance = new bootstrap.Carousel(carousel, {
            interval: 5000,
            ride: 'carousel',
            pause: 'hover'
        });

        // Pause carousel when user interacts with indicators or controls
        carousel.addEventListener('slide.bs.carousel', function() {
            carouselInstance.pause();
            setTimeout(() => {
                carouselInstance.cycle();
            }, 3000);
        });
    }

    // Service card hover effects
    document.querySelectorAll('.service-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px)';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Project card hover effects
    document.querySelectorAll('.project-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Blog card hover effects
    document.querySelectorAll('.blog-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Contact form handling (for contact page)
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // Get form data
            const formData = new FormData(this);
            const data = Object.fromEntries(formData);

            // Basic validation
            if (!data.name || !data.email || !data.subject || !data.message) {
                showAlert('Lütfen tüm alanları doldurun.', 'danger');
                return;
            }

            if (!isValidEmail(data.email)) {
                showAlert('Lütfen geçerli bir e-posta adresi girin.', 'danger');
                return;
            }

            // Simulate form submission
            showAlert('Mesajınız başarıyla gönderildi. En kısa sürede size dönüş yapacağız.', 'success');
            this.reset();
        });
    }

    // Quote form handling (for services page)
    const quoteForm = document.getElementById('quoteForm');
    if (quoteForm) {
        quoteForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const data = Object.fromEntries(formData);

            if (!data.name || !data.email || !data.phone || !data.service || !data.description) {
                showAlert('Lütfen tüm alanları doldurun.', 'danger');
                return;
            }

            if (!isValidEmail(data.email)) {
                showAlert('Lütfen geçerli bir e-posta adresi girin.', 'danger');
                return;
            }

            showAlert('Teklif talebiniz alındı. 24 saat içinde size detaylı teklif sunacağız.', 'success');
            this.reset();
        });
    }

    // Newsletter subscription (if exists)
    const newsletterForm = document.getElementById('newsletterForm');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const email = this.querySelector('input[type="email"]').value;

            if (!isValidEmail(email)) {
                showAlert('Lütfen geçerli bir e-posta adresi girin.', 'danger');
                return;
            }

            showAlert('Bültenimize başarıyla abone oldunuz!', 'success');
            this.reset();
        });
    }

    // Blog search functionality (for blog page)
    const blogSearch = document.getElementById('blogSearch');
    if (blogSearch) {
        blogSearch.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const blogCards = document.querySelectorAll('.blog-card');

            blogCards.forEach(card => {
                const title = card.querySelector('h5').textContent.toLowerCase();
                const content = card.querySelector('p').textContent.toLowerCase();

                if (title.includes(searchTerm) || content.includes(searchTerm)) {
                    card.closest('.col-lg-4, .col-md-6').style.display = 'block';
                } else {
                    card.closest('.col-lg-4, .col-md-6').style.display = 'none';
                }
            });
        });
    }

    // Project filter functionality (for projects page)
    const projectFilters = document.querySelectorAll('[data-filter]');
    if (projectFilters.length > 0) {
        projectFilters.forEach(filter => {
            filter.addEventListener('click', function(e) {
                e.preventDefault();

                // Remove active class from all filters
                projectFilters.forEach(f => f.classList.remove('active'));
                // Add active class to clicked filter
                this.classList.add('active');

                const filterValue = this.getAttribute('data-filter');
                const projectCards = document.querySelectorAll('.project-card');

                projectCards.forEach(card => {
                    const cardStatus = card.querySelector('.project-status');
                    const cardCategory = cardStatus ? cardStatus.id : '';
                    if (filterValue === 'all' || cardCategory.includes(filterValue)) {
                        card.closest('.col-lg-4, .col-md-6').style.display = 'block';
                    } else {
                        card.closest('.col-lg-4, .col-md-6').style.display = 'none';
                    }
                });
            });
        });
    }

    // 3D Model viewer toggle (for project detail page)
    const modelViewerBtn = document.getElementById('modelViewerBtn');
    const modelViewer = document.getElementById('modelViewer');

    if (modelViewerBtn && modelViewer) {
        modelViewerBtn.addEventListener('click', function() {
            if (modelViewer.style.display === 'none' || !modelViewer.style.display) {
                modelViewer.style.display = 'block';
                this.textContent = 'Modeli Gizle';
                this.classList.remove('btn-primary');
                this.classList.add('btn-secondary');
            } else {
                modelViewer.style.display = 'none';
                this.textContent = 'Modeli Görüntüle';
                this.classList.remove('btn-secondary');
                this.classList.add('btn-primary');
            }
        });
    }

    // Lazy loading for images
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    imageObserver.unobserve(img);
                }
            });
        });

        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
    }

    // Utility Functions
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    function showAlert(message, type = 'info') {
        // Remove existing alerts
        const existingAlerts = document.querySelectorAll('.custom-alert');
        existingAlerts.forEach(alert => alert.remove());

        // Create new alert
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show custom-alert`;
        alertDiv.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;

        document.body.appendChild(alertDiv);

        // Auto-remove after 5 seconds
        setTimeout(() => {
            if (alertDiv && alertDiv.parentNode) {
                alertDiv.remove();
            }
        }, 5000);
    }

    // Loading animation for page elements
    function initLoadingAnimations() {
        const elements = document.querySelectorAll('.loading');

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('loaded');
                }
            });
        }, {
            threshold: 0.1
        });

        elements.forEach(element => {
            observer.observe(element);
        });
    }

    // Initialize loading animations
    initLoadingAnimations();

    // Mobile menu enhancements
    const navbarToggler = document.querySelector('.navbar-toggler');
    const navbarCollapse = document.querySelector('.navbar-collapse');

    if (navbarToggler && navbarCollapse) {
        // Close mobile menu when clicking on a link
        navbarCollapse.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', () => {
                if (navbarCollapse.classList.contains('show')) {
                    navbarToggler.click();
                }
            });
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', (e) => {
            if (!navbarToggler.contains(e.target) && !navbarCollapse.contains(e.target)) {
                if (navbarCollapse.classList.contains('show')) {
                    navbarToggler.click();
                }
            }
        });
    }

    // Performance optimization: Debounce scroll events
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

    // Apply debounce to scroll events
    const debouncedScrollHandler = debounce(() => {
        const navbar = document.querySelector('.navbar');
        const backToTopButton = document.getElementById('backToTop');

        if (window.scrollY > 50) {
            navbar?.classList.add('scrolled');
        } else {
            navbar?.classList.remove('scrolled');
        }

        if (backToTopButton) {
            if (window.scrollY > 300) {
                backToTopButton.style.display = 'flex';
            } else {
                backToTopButton.style.display = 'none';
            }
        }
    }, 10);

    window.addEventListener('scroll', debouncedScrollHandler);

})();
