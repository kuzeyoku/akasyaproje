// Main JavaScript for GeoPlan Engineering Website

(function () {
    "use strict";

    // Initialize AOS (Animate On Scroll)
    document.addEventListener("DOMContentLoaded", function () {
        AOS.init({
            duration: 800,
            easing: "ease-out-cubic",
            once: true,
            offset: 100,
        });
    });

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
        anchor.addEventListener("click", function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute("href"));
            if (target) {
                const offsetTop = target.offsetTop - 80; // Account for fixed navbar
                window.scrollTo({
                    top: offsetTop,
                    behavior: "smooth",
                });
            }
        });
    });

    // Enhanced carousel auto-play with pause on hover
    const carousel = document.querySelector("#heroCarousel");
    if (carousel) {
        const carouselInstance = new bootstrap.Carousel(carousel, {
            interval: 5000,
            ride: "carousel",
            pause: "hover",
        });

        // Pause carousel when user interacts with indicators or controls
        carousel.addEventListener("slide.bs.carousel", function () {
            carouselInstance.pause();
            setTimeout(() => {
                carouselInstance.cycle();
            }, 3000);
        });
    }

    // Service card hover effects
    document.querySelectorAll(".service-card").forEach((card) => {
        card.addEventListener("mouseenter", function () {
            this.style.transform = "translateY(-10px)";
        });

        card.addEventListener("mouseleave", function () {
            this.style.transform = "translateY(0)";
        });
    });

    // Project card hover effects
    document.querySelectorAll(".project-card").forEach((card) => {
        card.addEventListener("mouseenter", function () {
            this.style.transform = "translateY(-5px)";
        });

        card.addEventListener("mouseleave", function () {
            this.style.transform = "translateY(0)";
        });
    });

    // Blog card hover effects
    document.querySelectorAll(".blog-card").forEach((card) => {
        card.addEventListener("mouseenter", function () {
            this.style.transform = "translateY(-5px)";
        });

        card.addEventListener("mouseleave", function () {
            this.style.transform = "translateY(0)";
        });
    });

    // Project filter functionality (for projects page)
    const projectFilters = document.querySelectorAll("[data-filter]");
    if (projectFilters.length > 0) {
        projectFilters.forEach((filter) => {
            filter.addEventListener("click", function (e) {
                e.preventDefault();

                // Remove active class from all filters
                projectFilters.forEach((f) => f.classList.remove("active"));
                // Add active class to clicked filter
                this.classList.add("active");

                const filterValue = this.getAttribute("data-filter");
                const projectCards = document.querySelectorAll(".project-card");

                projectCards.forEach((card) => {
                    const cardStatus = card.querySelector(".project-status");
                    const cardCategory = cardStatus ? cardStatus.id : "";
                    if (
                        filterValue === "all" ||
                        cardCategory.includes(filterValue)
                    ) {
                        card.closest(".col-lg-4, .col-md-6").style.display =
                            "block";
                    } else {
                        card.closest(".col-lg-4, .col-md-6").style.display =
                            "none";
                    }
                });
            });
        });
    }

    // 3D Model viewer toggle (for project detail page)
    const modelViewerBtn = document.getElementById("modelViewerBtn");
    const modelViewer = document.getElementById("modelViewer");

    if (modelViewerBtn && modelViewer) {
        modelViewerBtn.addEventListener("click", function () {
            if (
                modelViewer.style.display === "none" ||
                !modelViewer.style.display
            ) {
                modelViewer.style.display = "block";
                this.textContent = "Modeli Gizle";
                this.classList.remove("btn-primary");
                this.classList.add("btn-secondary");
            } else {
                modelViewer.style.display = "none";
                this.textContent = "Modeli Görüntüle";
                this.classList.remove("btn-secondary");
                this.classList.add("btn-primary");
            }
        });
    }

    // Lazy loading for images
    if ("IntersectionObserver" in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove("lazy");
                    imageObserver.unobserve(img);
                }
            });
        });

        document.querySelectorAll("img[data-src]").forEach((img) => {
            imageObserver.observe(img);
        });
    }

    // Loading animation for page elements
    function initLoadingAnimations() {
        const elements = document.querySelectorAll(".loading");

        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add("loaded");
                    }
                });
            },
            {
                threshold: 0.1,
            }
        );

        elements.forEach((element) => {
            observer.observe(element);
        });
    }

    // Initialize loading animations
    initLoadingAnimations();

    // Mobile menu enhancements
    const navbarToggler = document.querySelector(".navbar-toggler");
    const navbarCollapse = document.querySelector(".navbar-collapse");

    if (navbarToggler && navbarCollapse) {
        // Close mobile menu when clicking on a link
        navbarCollapse.querySelectorAll(".nav-link").forEach((link) => {
            link.addEventListener("click", () => {
                if (navbarCollapse.classList.contains("show")) {
                    navbarToggler.click();
                }
            });
        });

        // Close mobile menu when clicking outside
        document.addEventListener("click", (e) => {
            if (
                !navbarToggler.contains(e.target) &&
                !navbarCollapse.contains(e.target)
            ) {
                if (navbarCollapse.classList.contains("show")) {
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
        const navbar = document.querySelector(".navbar");
        const backToTopButton = document.getElementById("backToTop");

        // Navbar
        if (window.scrollY > 50) {
            navbar?.classList.add("scrolled");
        } else {
            navbar?.classList.remove("scrolled");
        }

        // Back to top button
        if (backToTopButton) {
            if (window.scrollY > 300) {
                backToTopButton.style.opacity = "1";
                backToTopButton.style.visibility = "visible";
                backToTopButton.style.pointerEvents = "auto";
            } else {
                backToTopButton.style.opacity = "0";
                backToTopButton.style.visibility = "hidden";
                backToTopButton.style.pointerEvents = "none";
            }
        }
    }, 10);

    window.addEventListener("scroll", debouncedScrollHandler);
})();

function showCookieBanner() {
    const banner = document.getElementById("cookieBanner");
    banner.classList.add("show");
}

function hideCookieBanner() {
    const banner = document.getElementById("cookieBanner");
    banner.classList.remove("show");
}

function acceptCookies() {
    // Tüm çerezleri kabul et
    setCookie("cookieConsent", "accepted", 365);
    setCookie("analyticsEnabled", "true", 365);
    setCookie("marketingEnabled", "true", 365);
    setCookie("functionalEnabled", "true", 365);

    hideCookieBanner();
    showNotification(
        "Çerezler kabul edildi! Tüm site özellikleri aktif.",
        "success"
    );
}

function declineCookies() {
    // Sadece zorunlu çerezler
    setCookie("cookieConsent", "declined", 365);
    setCookie("analyticsEnabled", "false", 365);
    setCookie("marketingEnabled", "false", 365);
    setCookie("functionalEnabled", "false", 365);

    hideCookieBanner();
    showNotification(
        "Çerezler reddedildi. Sadece zorunlu çerezler aktif.",
        "info"
    );
}

// Helper functions
function setCookie(name, value, days) {
    const expires = new Date();
    expires.setTime(expires.getTime() + days * 24 * 60 * 60 * 1000);
    document.cookie =
        name + "=" + value + ";expires=" + expires.toUTCString() + ";path=/";
}

function getCookie(name) {
    const nameEQ = name + "=";
    const ca = document.cookie.split(";");
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == " ") c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}

function showNotification(message, type) {
    const notification = document.createElement("div");
    notification.className = `notification bg-${type}`;

    notification.innerHTML = `
    <i class="fas fa-info-circle me-2"></i>
    ${message}
`;

    document.body.appendChild(notification);

    // Animasyonla göster
    setTimeout(() => {
        notification.classList.add("show");
    }, 100);

    // 4 saniye sonra kaldır
    setTimeout(() => {
        notification.classList.remove("show");
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 4000);
}

// Sayfa yüklendiğinde kontrol et
document.addEventListener("DOMContentLoaded", function () {
    const consent = getCookie("cookieConsent");
    if (!consent) {
        // 2 saniye sonra göster
        setTimeout(showCookieBanner, 2000);
    } else {
        console.log("Cookie consent durumu:", consent);
        console.log("Analytics:", getCookie("analyticsEnabled"));
        console.log("Marketing:", getCookie("marketingEnabled"));
        console.log("Functional:", getCookie("functionalEnabled"));
    }
});
