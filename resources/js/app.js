import './bootstrap';
import { initBulkTables } from './bulk-table';

// --- Premium Motion Design System (Apple/Linear inspired) ---

// Scroll Reveal Observer
const initScrollReveal = () => {
    const reveals = document.querySelectorAll('.reveal-fade, .reveal-scale');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('revealed');
                observer.unobserve(entry.target);
            }
        });
    }, { 
        threshold: 0.05, 
        rootMargin: '0px 0px -8% 0px' 
    });

    reveals.forEach(el => observer.observe(el));

    // Stagger containers
    document.querySelectorAll('.reveal-stagger').forEach(staggerContainer => {
        const children = staggerContainer.querySelectorAll('.reveal-fade, .reveal-scale');
        children.forEach((child, index) => {
            child.style.transitionDelay = `${index * 70}ms`;
        });
    });
};

// Nav link hover indicators (sliding capsule)
const initNavHoverIndicator = () => {
    const navTrack = document.querySelector('.nav-track');
    if (!navTrack) return;

    let indicator = navTrack.querySelector('.nav-indicator');
    if (!indicator) {
        indicator = document.createElement('div');
        indicator.className = 'nav-indicator';
        navTrack.appendChild(indicator);
    }

    const links = navTrack.querySelectorAll('.nav-link');
    const activeLink = navTrack.querySelector('.nav-link-active');

    const updateIndicatorPosition = (targetEl) => {
        if (!targetEl) {
            indicator.style.opacity = '0';
            return;
        }
        const rect = targetEl.getBoundingClientRect();
        const trackRect = navTrack.getBoundingClientRect();
        indicator.style.width = `${rect.width}px`;
        indicator.style.left = `${rect.left - trackRect.left}px`;
        indicator.style.top = `${rect.top - trackRect.top}px`;
        indicator.style.opacity = '1';
    };

    if (activeLink) {
        setTimeout(() => updateIndicatorPosition(activeLink), 150);
    } else {
        indicator.style.opacity = '0';
    }

    links.forEach(link => {
        link.addEventListener('mouseenter', () => {
            updateIndicatorPosition(link);
        });
    });

    navTrack.addEventListener('mouseleave', () => {
        const currentActive = navTrack.querySelector('.nav-link-active');
        if (currentActive) {
            updateIndicatorPosition(currentActive);
        } else {
            indicator.style.opacity = '0';
        }
    });

    window.addEventListener('resize', () => {
        const currentActive = navTrack.querySelector('.nav-link-active');
        if (currentActive) {
            updateIndicatorPosition(currentActive);
        }
    });

    window.updateNavIndicator = updateIndicatorPosition;
};

// Magnetic CTA items
const initMagneticCTAs = () => {
    const magnetics = document.querySelectorAll('.btn-magnetic');
    magnetics.forEach(btn => {
        btn.addEventListener('mousemove', (e) => {
            const rect = btn.getBoundingClientRect();
            const x = e.clientX - rect.left - rect.width / 2;
            const y = e.clientY - rect.top - rect.height / 2;
            btn.style.transform = `translate(${x * 0.32}px, ${y * 0.32}px) scale(1.02)`;
        });
        btn.addEventListener('mouseleave', () => {
            btn.style.transform = 'translate(0, 0) scale(1)';
        });
    });
};

// Hero headline text reveal
const initHeadlineReveal = () => {
    const titles = document.querySelectorAll('.animate-headline-reveal');
    titles.forEach(title => {
        const text = title.textContent.trim();
        const words = text.split(/\s+/);
        title.innerHTML = '';
        
        words.forEach((word, index) => {
            const wordSpan = document.createElement('span');
            wordSpan.className = 'headline-word-wrap';
            
            const innerSpan = document.createElement('span');
            innerSpan.className = 'headline-word';
            innerSpan.textContent = word + ' ';
            innerSpan.style.transitionDelay = `${index * 80}ms`;
            
            wordSpan.appendChild(innerSpan);
            title.appendChild(wordSpan);
        });
    });
};

// Interactive Hero Glow
const initInteractiveGlow = () => {
    const hero = document.getElementById('saas-hero-container');
    if (!hero) return;

    let glow = hero.querySelector('.hero-cursor-glow');
    if (!glow) {
        glow = document.createElement('div');
        glow.className = 'hero-cursor-glow';
        hero.appendChild(glow);
    }

    let isHovered = false;

    hero.addEventListener('mouseenter', () => {
        isHovered = true;
        glow.style.opacity = '1';
    });

    hero.addEventListener('mousemove', (e) => {
        if (!isHovered) {
            glow.style.opacity = '1';
            isHovered = true;
        }
        const rect = hero.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        requestAnimationFrame(() => {
            glow.style.left = `${x}px`;
            glow.style.top = `${y}px`;
        });
    });

    hero.addEventListener('mouseleave', () => {
        isHovered = false;
        glow.style.opacity = '0';
    });
};

// Subtle Scroll Parallax
const initParallaxEffects = () => {
    const parallaxItems = document.querySelectorAll('.parallax-effect');
    if (parallaxItems.length === 0) return;

    window.addEventListener('scroll', () => {
        const scrolled = window.scrollY;
        requestAnimationFrame(() => {
            parallaxItems.forEach(item => {
                const speed = parseFloat(item.getAttribute('data-parallax-speed') || '0.12');
                const yPos = -(scrolled * speed);
                item.style.transform = `translate3d(0, ${yPos}px, 0)`;
            });
        });
    }, { passive: true });
};

// 3D Card Tilt
const initCardTilt = () => {
    const cards = document.querySelectorAll('.tilt-card');
    cards.forEach(card => {
        // Wrap card in container for perspective boundary
        let wrapper = card.parentNode;
        if (!wrapper.classList.contains('tilt-card-wrapper')) {
            wrapper = document.createElement('div');
            wrapper.className = 'tilt-card-wrapper';
            card.parentNode.insertBefore(wrapper, card);
            wrapper.appendChild(card);
        }

        card.addEventListener('mousemove', (e) => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            const normX = (x / rect.width) - 0.5;
            const normY = (y / rect.height) - 0.5;

            // Soft tilt coordinates (max 6 deg for subtle feel)
            const tiltX = -(normY * 6).toFixed(2);
            const tiltY = (normX * 6).toFixed(2);

            requestAnimationFrame(() => {
                card.style.transform = `rotateX(${tiltX}deg) rotateY(${tiltY}deg) scale3d(1.015, 1.015, 1.015)`;
            });
        });

        card.addEventListener('mouseleave', () => {
            requestAnimationFrame(() => {
                card.style.transform = 'rotateX(0deg) rotateY(0deg) scale3d(1, 1, 1)';
            });
        });
    });
};

// Click Button Ripple Overlay
const initButtonRipple = () => {
    const buttons = document.querySelectorAll('.btn-primary, .btn-secondary, .btn-ripple, .btn-glow');
    buttons.forEach(btn => {
        btn.classList.add('btn-ripple-container');
        btn.addEventListener('click', function(e) {
            const existingRipples = btn.querySelectorAll('.ripple-span');
            existingRipples.forEach(r => r.remove());

            const rect = btn.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            const ripple = document.createElement('span');
            ripple.className = 'ripple-span';
            ripple.style.left = `${x}px`;
            ripple.style.top = `${y}px`;

            const diameter = Math.max(rect.width, rect.height);
            ripple.style.width = `${diameter}px`;
            ripple.style.height = `${diameter}px`;
            ripple.style.marginLeft = `-${diameter / 2}px`;
            ripple.style.marginTop = `-${diameter / 2}px`;

            btn.appendChild(ripple);

            ripple.addEventListener('animationend', () => {
                ripple.remove();
            });
        });
    });
};

// Stats Counting Animation
const initMetricsCounter = () => {
    const counters = document.querySelectorAll('.stat-counter');
    if (counters.length === 0) return;

    const runCounter = (el) => {
        const target = parseFloat(el.getAttribute('data-counter-target'));
        const duration = 1800; // 1.8 seconds
        const startTime = performance.now();
        const startVal = 0;
        const isDecimal = el.getAttribute('data-counter-decimal') === 'true';

        const updateVal = (currentTime) => {
            const elapsedTime = currentTime - startTime;
            if (elapsedTime >= duration) {
                el.textContent = isDecimal ? target.toFixed(1) : Math.floor(target).toLocaleString();
                return;
            }

            const progress = elapsedTime / duration;
            const easeProgress = 1 - Math.pow(1 - progress, 3); // Cubic Ease Out
            const currentVal = startVal + easeProgress * (target - startVal);

            el.textContent = isDecimal 
                ? currentVal.toFixed(1) 
                : Math.floor(currentVal).toLocaleString();

            requestAnimationFrame(updateVal);
        };

        requestAnimationFrame(updateVal);
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                runCounter(entry.target);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });

    counters.forEach(c => observer.observe(c));
};

// FAQ Slide Accordion
const initFaqAccordion = () => {
    const details = document.querySelectorAll('.faq-accordion details');
    details.forEach(el => {
        const summary = el.querySelector('summary');
        const content = el.querySelector('p') || el.querySelector('div');
        if (!content) return;

        let wrapper = el.querySelector('.faq-accordion-body');
        if (!wrapper) {
            wrapper = document.createElement('div');
            wrapper.className = 'faq-accordion-body';
            Array.from(el.childNodes).forEach(node => {
                if (node !== summary) {
                    wrapper.appendChild(node);
                }
            });
            el.appendChild(wrapper);
        }

        summary.addEventListener('click', (e) => {
            e.preventDefault();
            const isOpen = el.hasAttribute('open');

            if (!isOpen) {
                el.setAttribute('open', 'true');
                el.classList.add('faq-accordion-open');
                wrapper.style.maxHeight = '0px';
                wrapper.offsetHeight; // force reflow
                wrapper.style.maxHeight = `${wrapper.scrollHeight}px`;
                wrapper.style.opacity = '1';
                setTimeout(() => {
                    if (el.hasAttribute('open')) {
                        wrapper.style.maxHeight = 'none';
                    }
                }, 400);
            } else {
                wrapper.style.maxHeight = `${wrapper.scrollHeight}px`;
                wrapper.offsetHeight; // force reflow
                wrapper.style.maxHeight = '0px';
                wrapper.style.opacity = '0';
                el.classList.remove('faq-accordion-open');

                setTimeout(() => {
                    if (!el.classList.contains('faq-accordion-open')) {
                        el.removeAttribute('open');
                    }
                }, 400);
            }
        });
    });
};

// Testimonials Carousel autoplay / swipe drag
const initTestimonialsCarousel = () => {
    const container = document.querySelector('.testimonial-carousel-container');
    if (!container) return;

    const track = container.querySelector('.testimonial-carousel-track');
    const slides = Array.from(container.querySelectorAll('.testimonial-carousel-slide'));
    if (slides.length === 0) return;

    let dotsContainer = container.querySelector('.carousel-dots-nav');
    if (!dotsContainer) {
        dotsContainer = document.createElement('div');
        dotsContainer.className = 'carousel-dots-nav flex justify-center gap-2 mt-8';
        container.appendChild(dotsContainer);
    }

    let isDesktop = window.innerWidth >= 768;
    let itemsPerView = isDesktop ? 3 : 1;
    let pageCount = Math.max(1, slides.length - itemsPerView + 1);
    let currentPage = 0;
    let slideWidthPercent = 100 / itemsPerView;

    const createDots = () => {
        dotsContainer.innerHTML = '';
        for (let i = 0; i < pageCount; i++) {
            const dot = document.createElement('button');
            dot.type = 'button';
            dot.className = `carousel-dot ${i === currentPage ? 'active' : ''}`;
            dot.setAttribute('aria-label', `Go to slide ${i + 1}`);
            dot.addEventListener('click', () => {
                goToPage(i);
                resetAutoplay();
            });
            dotsContainer.appendChild(dot);
        }
    };

    const updateDots = () => {
        const dots = dotsContainer.querySelectorAll('.carousel-dot');
        dots.forEach((dot, idx) => {
            if (idx === currentPage) {
                dot.classList.add('active');
            } else {
                dot.classList.remove('active');
            }
        });
    };

    const goToPage = (pageIdx) => {
        currentPage = Math.max(0, Math.min(pageIdx, pageCount - 1));
        const offset = -currentPage * slideWidthPercent;
        track.style.transform = `translateX(${offset}%)`;
        updateDots();
    };

    let autoplayInterval;
    const startAutoplay = () => {
        autoplayInterval = setInterval(() => {
            let next = currentPage + 1;
            if (next >= pageCount) {
                next = 0;
            }
            goToPage(next);
        }, 5000);
    };

    const resetAutoplay = () => {
        clearInterval(autoplayInterval);
        startAutoplay();
    };

    let startX = 0;
    let currentX = 0;
    let isDragging = false;
    let trackOffset = 0;

    const handleDragStart = (e) => {
        isDragging = true;
        clearInterval(autoplayInterval);
        track.style.transition = 'none';
        startX = e.type.includes('touch') ? e.touches[0].clientX : e.clientX;
        trackOffset = -currentPage * (track.offsetWidth / itemsPerView);
    };

    const handleDragMove = (e) => {
        if (!isDragging) return;
        currentX = e.type.includes('touch') ? e.touches[0].clientX : e.clientX;
        const deltaX = currentX - startX;
        track.style.transform = `translateX(${trackOffset + deltaX}px)`;
    };

    const handleDragEnd = (e) => {
        if (!isDragging) return;
        isDragging = false;
        track.style.transition = 'transform 0.6s cubic-bezier(0.16, 1, 0.3, 1)';
        
        const deltaX = currentX - startX;
        const threshold = track.offsetWidth / (itemsPerView * 4);
        
        if (Math.abs(deltaX) > threshold) {
            if (deltaX > 0 && currentPage > 0) {
                goToPage(currentPage - 1);
            } else if (deltaX < 0 && currentPage < pageCount - 1) {
                goToPage(currentPage + 1);
            } else {
                goToPage(currentPage);
            }
        } else {
            goToPage(currentPage);
        }
        
        startAutoplay();
    };

    track.addEventListener('mousedown', handleDragStart);
    window.addEventListener('mousemove', handleDragMove);
    window.addEventListener('mouseup', handleDragEnd);

    track.addEventListener('touchstart', handleDragStart, { passive: true });
    track.addEventListener('touchmove', handleDragMove, { passive: true });
    track.addEventListener('touchend', handleDragEnd);

    window.addEventListener('resize', () => {
        const wasDesktop = isDesktop;
        isDesktop = window.innerWidth >= 768;
        if (wasDesktop !== isDesktop) {
            itemsPerView = isDesktop ? 3 : 1;
            pageCount = Math.max(1, slides.length - itemsPerView + 1);
            slideWidthPercent = 100 / itemsPerView;
            createDots();
            goToPage(0);
        }
    });

    createDots();
    startAutoplay();
};

const initHeaderScroll = () => {
    const nav = document.querySelector('.nav-shell');
    if (nav) {
        const updateHeader = () => {
            if (window.scrollY > 40) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
        };
        window.addEventListener('scroll', updateHeader);
        updateHeader();
    }
};

const initPageTransition = () => {
    document.body.classList.add('page-loaded');
};

const initScrollProgress = () => {
    const progressBar = document.getElementById('scroll-progress');
    if (!progressBar) return;
    
    window.addEventListener('scroll', () => {
        const scrollHeight = document.documentElement.scrollHeight - window.innerHeight;
        if (scrollHeight <= 0) {
            progressBar.style.width = '0%';
            progressBar.style.opacity = '0';
            return;
        }
        const scrollPercent = (window.scrollY / scrollHeight) * 100;
        requestAnimationFrame(() => {
            progressBar.style.width = `${scrollPercent}%`;
            if (scrollPercent > 0.5) {
                progressBar.style.opacity = '1';
            } else {
                progressBar.style.opacity = '0';
            }
        });
    }, { passive: true });
};

const initBackToTop = () => {
    const btn = document.getElementById('back-to-top');
    if (!btn) return;
    
    window.addEventListener('scroll', () => {
        if (window.scrollY > 400) {
            btn.classList.add('visible');
        } else {
            btn.classList.remove('visible');
        }
    }, { passive: true });
    
    btn.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
};

const initMobileStickyCTA = () => {
    const cta = document.getElementById('mobile-sticky-cta');
    if (!cta) return;
    
    window.addEventListener('scroll', () => {
        if (window.scrollY > 500) {
            cta.classList.add('visible');
        } else {
            cta.classList.remove('visible');
        }
    }, { passive: true });
};

const initActiveSectionHighlighting = () => {
    const sections = [
        document.getElementById('saas-hero-container'),
        document.getElementById('services-catalog'),
        document.getElementById('how-it-works'),
        document.getElementById('why-choose-us'),
        document.getElementById('reviews')
    ].filter(Boolean);

    if (sections.length === 0) return;

    const desktopLinks = document.querySelectorAll('.nav-track a[data-section]');
    const mobileLinks = document.querySelectorAll('.nav-mobile-panel a[data-section]');

    const observerOptions = {
        root: null,
        rootMargin: '-30% 0px -50% 0px',
        threshold: 0
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const sectionId = entry.target.getAttribute('id');
                
                desktopLinks.forEach(link => {
                    if (link.getAttribute('data-section') === sectionId) {
                        link.classList.add('nav-link-active');
                        if (window.updateNavIndicator) {
                            window.updateNavIndicator(link);
                        }
                    } else {
                        link.classList.remove('nav-link-active');
                    }
                });

                mobileLinks.forEach(link => {
                    if (link.getAttribute('data-section') === sectionId) {
                        link.classList.add('nav-mobile-link-active');
                    } else {
                        link.classList.remove('nav-mobile-link-active');
                    }
                });
            }
        });
    }, observerOptions);

    sections.forEach(section => observer.observe(section));
};

const initSmoothAnchorScrolling = () => {
    const links = document.querySelectorAll('a[href^="#"]');
    links.forEach(link => {
        link.addEventListener('click', (e) => {
            const targetId = link.getAttribute('href');
            if (targetId === '#') return;
            const targetEl = document.querySelector(targetId);
            if (targetEl) {
                e.preventDefault();
                targetEl.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
                
                const mobilePanelDetails = link.closest('details');
                if (mobilePanelDetails && mobilePanelDetails.hasAttribute('open')) {
                    mobilePanelDetails.removeAttribute('open');
                }
            }
        });
    });
};

const initScrollDepthTracking = () => {
    const milestones = { 25: false, 50: false, 75: false, 100: false };
    
    window.addEventListener('scroll', () => {
        const scrollHeight = document.documentElement.scrollHeight - window.innerHeight;
        if (scrollHeight <= 0) return;
        
        const scrollPercent = Math.round((window.scrollY / scrollHeight) * 100);
        
        [25, 50, 75, 100].forEach(milestone => {
            if (scrollPercent >= milestone && !milestones[milestone]) {
                milestones[milestone] = true;
                console.log(`[Analytics] Scroll depth reached: ${milestone}%`);
                
                window.dispatchEvent(new CustomEvent('scrollDepth', {
                    detail: { percent: milestone }
                }));
            }
        });
    }, { passive: true });
};

document.addEventListener('DOMContentLoaded', () => {
    initBulkTables();
    initScrollReveal();
    initNavHoverIndicator();
    initMagneticCTAs();
    initHeadlineReveal();
    initInteractiveGlow();
    initParallaxEffects();
    initCardTilt();
    initButtonRipple();
    initMetricsCounter();
    initFaqAccordion();
    initTestimonialsCarousel();
    initHeaderScroll();
    initScrollProgress();
    initBackToTop();
    initMobileStickyCTA();
    initActiveSectionHighlighting();
    initSmoothAnchorScrolling();
    initScrollDepthTracking();
    initPageTransition();
});
