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

    let pendingConfirmForm = null;

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
        if (document.body.dataset.confirmModalBound === 'true') {
            return;
        }

        document.body.dataset.confirmModalBound = 'true';

        document.addEventListener('submit', (event) => {
            const form = event.target;
            if (!(form instanceof HTMLFormElement) || !form.matches('form[data-confirm]')) {
                return;
            }

            const modal = document.getElementById('public-confirm-modal');
            const message = document.getElementById('public-confirm-message');
            if (!modal || !message) {
                return;
            }

            event.preventDefault();
            pendingConfirmForm = form;
            message.textContent = form.dataset.confirm || 'Apakah Anda yakin?';
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        });

        document.addEventListener('click', (event) => {
            const target = event.target;
            if (!(target instanceof Element)) {
                return;
            }

            if (target.closest('[data-confirm-close], #public-confirm-cancel')) {
                closeConfirmModal();
                return;
            }

            if (target.closest('#public-confirm-ok')) {
                if (pendingConfirmForm) {
                    HTMLFormElement.prototype.submit.call(pendingConfirmForm);
                }

                closeConfirmModal();
            }
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

        updateScrollToTopVisibility();

        if (document.body.dataset.scrollToTopBound === 'true') {
            return;
        }

        document.body.dataset.scrollToTopBound = 'true';

        window.addEventListener('scroll', updateScrollToTopVisibility, { passive: true });
        document.addEventListener('click', (event) => {
            const target = event.target;
            if (!(target instanceof Element) || !target.closest('#scrollToTop')) {
                return;
            }

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
        setupCardAnimations();
        updateScrollToTopVisibility();
        console.log('[GlobalUI] Components reinitialized after SPA navigation');
    };

    function closeConfirmModal() {
        const modal = document.getElementById('public-confirm-modal');

        pendingConfirmForm = null;

        if (!modal) {
            return;
        }

        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    function updateScrollToTopVisibility() {
        const scrollToTopBtn = document.getElementById('scrollToTop');
        if (!scrollToTopBtn) {
            return;
        }

        scrollToTopBtn.classList.toggle('hidden', window.pageYOffset <= 300);
    }

})();
