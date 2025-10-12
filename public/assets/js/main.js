// Main JavaScript for GeoPlan Engineering Website
(function () {
    "use strict";

    // ========== Utility Functions ==========
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func(...args), wait);
        };
    }

    function setCookie(name, value, days) {
        const expires = new Date(Date.now() + days * 864e5).toUTCString();
        document.cookie = `${name}=${value};expires=${expires};path=/`;
    }

    function getCookie(name) {
        return document.cookie.split('; ')
            .find(row => row.startsWith(name + '='))
            ?.split('=')[1];
    }

    // ========== Initialization ==========
    document.addEventListener("DOMContentLoaded", function () {
        // Initialize AOS
        if (typeof AOS !== 'undefined') {
            AOS.init({
                duration: 800,
                easing: "ease-out-cubic",
                once: true,
                offset: 100,
                disable: window.innerWidth < 768 ? true : false
            });
        }

        // Initialize all features
        initNavbar();
        initBackToTop();
        initSmoothScroll();
        initCarousel();
        initCardHoverEffects();
        initProjectFilters();
        initModelViewer();
        initLazyLoading();
        initLoadingAnimations();
        initMobileMenu();
        initCookieBanner();
    });

    // ========== Navbar ==========
    function initNavbar() {
        const navbar = document.querySelector(".navbar");
        if (!navbar) return;

        const scrollHandler = debounce(() => {
            navbar.classList.toggle('scrolled', window.scrollY > 50);
        }, 10);

        window.addEventListener("scroll", scrollHandler, { passive: true });
    }

    // ========== Back to Top ==========
    function initBackToTop() {
        const btn = document.getElementById("backToTop");
        if (!btn) return;

        const scrollHandler = debounce(() => {
            const show = window.scrollY > 300;
            btn.style.opacity = show ? "1" : "0";
            btn.style.visibility = show ? "visible" : "hidden";
            btn.style.pointerEvents = show ? "auto" : "none";
        }, 10);

        window.addEventListener("scroll", scrollHandler, { passive: true });

        btn.addEventListener("click", (e) => {
            e.preventDefault();
            window.scrollTo({ top: 0, behavior: "smooth" });
        });
    }

    // ========== Smooth Scroll ==========
    function initSmoothScroll() {
        document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
            anchor.addEventListener("click", function (e) {
                const target = document.querySelector(this.getAttribute("href"));
                if (target) {
                    e.preventDefault();
                    const offsetTop = target.offsetTop - 80;
                    window.scrollTo({ top: offsetTop, behavior: "smooth" });
                }
            });
        });
    }

    // ========== Carousel ==========
    function initCarousel() {
        const carousel = document.querySelector("#heroCarousel");
        if (!carousel || typeof bootstrap === 'undefined') return;

        const instance = new bootstrap.Carousel(carousel, {
            interval: 5000,
            ride: "carousel",
            pause: "hover",
        });

        carousel.addEventListener("slide.bs.carousel", function () {
            instance.pause();
            setTimeout(() => instance.cycle(), 3000);
        });
    }

    // ========== Card Hover Effects ==========
    function initCardHoverEffects() {
        const cardTypes = [
            { selector: ".service-card", translateY: -10 },
            { selector: ".project-card", translateY: -5 },
            { selector: ".blog-card", translateY: -5 }
        ];

        cardTypes.forEach(({ selector, translateY }) => {
            document.querySelectorAll(selector).forEach((card) => {
                card.addEventListener("mouseenter", () => {
                    card.style.transform = `translateY(${translateY}px)`;
                });
                card.addEventListener("mouseleave", () => {
                    card.style.transform = "translateY(0)";
                });
            });
        });
    }

    // ========== Project Filters ==========
    function initProjectFilters() {
        const filters = document.querySelectorAll("[data-filter]");
        if (filters.length === 0) return;

        filters.forEach((filter) => {
            filter.addEventListener("click", function (e) {
                e.preventDefault();

                filters.forEach((f) => f.classList.remove("active"));
                this.classList.add("active");

                const filterValue = this.getAttribute("data-filter");
                const projectCards = document.querySelectorAll(".project-card");

                projectCards.forEach((card) => {
                    const status = card.querySelector(".project-status");
                    const category = status ? status.id : "";
                    const shouldShow = filterValue === "all" || category.includes(filterValue);
                    const parent = card.closest(".col-lg-4, .col-md-6");
                    if (parent) parent.style.display = shouldShow ? "block" : "none";
                });
            });
        });
    }

    // ========== Model Viewer ==========
    function initModelViewer() {
        const btn = document.getElementById("modelViewerBtn");
        const viewer = document.getElementById("modelViewer");
        if (!btn || !viewer) return;

        btn.addEventListener("click", function () {
            const isHidden = viewer.style.display === "none" || !viewer.style.display;
            viewer.style.display = isHidden ? "block" : "none";
            this.textContent = isHidden ? "Modeli Gizle" : "Modeli Görüntüle";
            this.classList.toggle("btn-primary", !isHidden);
            this.classList.toggle("btn-secondary", isHidden);
        });
    }

    // ========== Lazy Loading ==========
    function initLazyLoading() {
        if (!("IntersectionObserver" in window)) return;

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove("lazy");
                    observer.unobserve(img);
                }
            });
        });

        document.querySelectorAll("img[data-src]").forEach((img) => observer.observe(img));
    }

    // ========== Loading Animations ==========
    function initLoadingAnimations() {
        const elements = document.querySelectorAll(".loading");
        if (elements.length === 0) return;

        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add("loaded");
                    }
                });
            },
            { threshold: 0.1 }
        );

        elements.forEach((el) => observer.observe(el));
    }

    // ========== Mobile Menu ==========
    function initMobileMenu() {
        const toggler = document.querySelector(".navbar-toggler");
        const collapse = document.querySelector(".navbar-collapse");
        if (!toggler || !collapse) return;

        // Close menu on link click
        collapse.querySelectorAll(".nav-link").forEach((link) => {
            link.addEventListener("click", () => {
                if (collapse.classList.contains("show")) toggler.click();
            });
        });

        // Close menu on outside click
        document.addEventListener("click", (e) => {
            if (!toggler.contains(e.target) && !collapse.contains(e.target)) {
                if (collapse.classList.contains("show")) toggler.click();
            }
        });
    }

    // ========== Cookie Banner ==========
    function initCookieBanner() {
        const consent = getCookie("cookieConsent");
        if (!consent) {
            setTimeout(showCookieBanner, 2000);
        }
    }

    window.showCookieBanner = function () {
        const banner = document.getElementById("cookieBanner");
        if (banner) banner.classList.add("show");
    };

    window.hideCookieBanner = function () {
        const banner = document.getElementById("cookieBanner");
        if (banner) banner.classList.remove("show");
    };

    window.acceptCookies = function () {
        setCookie("cookieConsent", "accepted", 365);
        setCookie("analyticsEnabled", "true", 365);
        setCookie("marketingEnabled", "true", 365);
        setCookie("functionalEnabled", "true", 365);
        hideCookieBanner();
        showNotification("Çerezler kabul edildi! Tüm site özellikleri aktif.", "success");
    };

    window.declineCookies = function () {
        setCookie("cookieConsent", "declined", 365);
        setCookie("analyticsEnabled", "false", 365);
        setCookie("marketingEnabled", "false", 365);
        setCookie("functionalEnabled", "false", 365);
        hideCookieBanner();
        showNotification("Çerezler reddedildi. Sadece zorunlu çerezler aktif.", "info");
    };

    // ========== Notifications ==========
    window.showNotification = function (message, type = "info") {
        const icons = {
            success: "check-circle",
            error: "exclamation-circle",
            warning: "exclamation-triangle",
            info: "info-circle"
        };

        const notification = document.createElement("div");
        notification.className = `notification bg-${type}`;
        notification.innerHTML = `
            <i class="fas fa-${icons[type] || 'bell'} me-2"></i>
            ${message}
        `;

        document.body.appendChild(notification);

        setTimeout(() => notification.classList.add("show"), 100);

        setTimeout(() => {
            notification.classList.remove("show");
            setTimeout(() => notification.remove(), 300);
        }, 4000);
    };

})();
