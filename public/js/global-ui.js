/**
 * SDN 2 Dermolo - Global UI Components
 * Handles mobile menu, confirmations, scroll-to-top, and card animations.
 * This file is loaded once and available globally.
 */

(function () {
    'use strict';

    if (window.globalUIInitialized === true) {
        return;
    }

    // Initialize on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    function init() {
        setupMobileMenu();
        setupConfirmModal();
        setupScrollToTop();
        setupCardAnimations();
        
        window.globalUIInitialized = true;
        console.log('[GlobalUI] Components initialized');
    }

    /**
     * Mobile menu toggle
     */
    function setupMobileMenu() {
        const menuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        if (!menuButton || !mobileMenu) {
            return;
        }

        menuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    }

    /**
     * Confirmation modal for forms
     */
    function setupConfirmModal() {
        const modal = document.getElementById('public-confirm-modal');
        const message = document.getElementById('public-confirm-message');
        const okBtn = document.getElementById('public-confirm-ok');
        const cancelBtn = document.getElementById('public-confirm-cancel');
        let pendingForm = null;

        if (!modal || !message || !okBtn) {
            return;
        }

        const closeModal = () => {
            pendingForm = null;
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        };

        // Setup form listeners
        document.querySelectorAll('form[data-confirm]').forEach((form) => {
            form.addEventListener('submit', (event) => {
                event.preventDefault();
                pendingForm = form;
                message.textContent = form.dataset.confirm || 'Apakah Anda yakin?';
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            });
        });

        cancelBtn?.addEventListener('click', closeModal);

        modal?.addEventListener('click', (event) => {
            if (event.target?.dataset?.confirmClose) {
                closeModal();
            }
        });

        okBtn?.addEventListener('click', () => {
            if (pendingForm) {
                pendingForm.submit();
            }
            closeModal();
        });
    }

    /**
     * Scroll to top button
     */
    function setupScrollToTop() {
        const scrollToTopBtn = document.getElementById('scrollToTop');

        if (!scrollToTopBtn) {
            return;
        }

        window.addEventListener('scroll', () => {
            scrollToTopBtn.classList.toggle('hidden', window.pageYOffset <= 300);
        });

        scrollToTopBtn.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    /**
     * Card fade-in animations on scroll
     */
    function setupCardAnimations() {
        // Disconnect existing observer if any
        if (window.cardAnimationObserver) {
            window.cardAnimationObserver.disconnect();
        }

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

        // Observe all card elements
        document.querySelectorAll('.card-hover').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(card);
        });

        window.cardAnimationObserver = observer;
    }

    /**
     * Reinitialize components after SPA navigation
     * Called by spa.js after content is loaded
     */
    window.reinitializeGlobalUI = function() {
        setupConfirmModal();
        setupScrollToTop();
        setupCardAnimations();
        console.log('[GlobalUI] Components reinitialized after SPA navigation');
    };

})();
