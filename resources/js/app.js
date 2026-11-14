import { animate, inView, scroll, stagger } from 'motion';
import {
    Activity,
    ArrowUpRight,
    BarChart3,
    Building,
    Building2,
    CheckCircle2,
    ChevronDown,
    ChevronLeft,
    ChevronRight,
    ClipboardCheck,
    Clock,
    FileText,
    Globe,
    House,
    KeyRound,
    Landmark,
    Lock,
    LogIn,
    Mail,
    MapPin,
    Menu,
    Phone,
    Search,
    Server,
    Shield,
    ShieldCheck,
    SlidersHorizontal,
    Users,
    Wrench,
    X,
    createIcons,
} from 'lucide';

const LUCIDE_ICONS = {
    Activity,
    ArrowUpRight,
    BarChart3,
    Building,
    Building2,
    CheckCircle2,
    ChevronDown,
    ChevronLeft,
    ChevronRight,
    ClipboardCheck,
    Clock,
    FileText,
    Globe,
    House,
    KeyRound,
    Landmark,
    Lock,
    LogIn,
    Mail,
    MapPin,
    Menu,
    Phone,
    Search,
    Server,
    Shield,
    ShieldCheck,
    SlidersHorizontal,
    Users,
    Wrench,
    X,
};

const FILTER_ACTIVE = ['text-white'];
const FILTER_INACTIVE = ['text-[#3f5249]', 'hover:text-[#10231b]'];
const PORTAL_ROLE_ACTIVE = ['text-[#10231b]'];
const PORTAL_ROLE_INACTIVE = ['text-[#3f5249]', 'hover:bg-[#f6f5f0]/70', 'hover:text-[#10231b]'];
const SERVICE_FILTER_ACTIVE = ['font-bold', 'text-[#10231b]'];
const SERVICE_FILTER_INACTIVE = ['font-medium', 'text-[#3f5249]', 'hover:bg-[#f6f5f0]/70', 'hover:text-[#10231b]'];
const SERVICE_COUNT_ACTIVE = ['bg-[#1b4332]', 'text-white', 'font-bold'];
const SERVICE_COUNT_INACTIVE = ['bg-[#edf2ed]', 'text-[#3f5249]', 'font-semibold'];
const TAB_BADGE_ACTIVE = ['bg-white/20', 'text-white'];
const TAB_BADGE_INACTIVE = ['bg-white/90', 'text-[#10231b]'];

const setVariantClasses = (node, isSelected, activeClasses, inactiveClasses) => {
    activeClasses.forEach((cls) => node.classList.toggle(cls, isSelected));
    inactiveClasses.forEach((cls) => node.classList.toggle(cls, !isSelected));
};

function createGlideIndicator(container, { pillClass = '' } = {}) {
    if (!container) {
        return { sync: () => {}, hide: () => {} };
    }

    const pill = createNode(
        'span',
        `pointer-events-none absolute top-0 left-0 z-0 ${pillClass}`.trim(),
    );
    pill.setAttribute('data-glide-pill', '');
    pill.setAttribute('aria-hidden', 'true');
    pill.style.opacity = '0';
    container.prepend(pill);
    container.setAttribute('data-glide-ready', 'true');

    let activeTarget = null;
    let hasMeasured = false;
    let pendingResizeSync = false;
    let lastRect = null;

    const sameRect = (a, b) => Boolean(
        a
        && b
        && Math.abs(a.x - b.x) < 0.05
        && Math.abs(a.y - b.y) < 0.05
        && Math.abs(a.w - b.w) < 0.05
        && Math.abs(a.h - b.h) < 0.05,
    );

    const measureAndApply = (targetEl, animateMove = true) => {
        const previousTarget = activeTarget;
        activeTarget = targetEl || null;
        if (!activeTarget) {
            pill.style.opacity = '0';
            lastRect = null;
            return;
        }

        const cRect = container.getBoundingClientRect();
        const tRect = activeTarget.getBoundingClientRect();
        if (cRect.width <= 0 || tRect.width <= 0 || tRect.height <= 0) {
            hasMeasured = false;
            lastRect = null;
            return;
        }

        const scaleX = container.offsetWidth > 0 ? cRect.width / container.offsetWidth : 1;
        const scaleY = container.offsetHeight > 0 && cRect.height > 0 ? cRect.height / container.offsetHeight : 1;
        const nextRect = {
            x: Math.round(((tRect.left - cRect.left) / scaleX - container.clientLeft) * 100) / 100,
            y: Math.round(((tRect.top - cRect.top) / scaleY - container.clientTop) * 100) / 100,
            w: Math.round((tRect.width / scaleX) * 100) / 100,
            h: Math.round((tRect.height / scaleY) * 100) / 100,
        };

        if (previousTarget === activeTarget && hasMeasured && sameRect(lastRect, nextRect)) {
            pill.style.opacity = '1';
            return;
        }

        const instant = !animateMove || !hasMeasured || prefersReducedMotion();
        if (instant) {
            pill.style.transition = 'none';
            pendingResizeSync = false;
        }

        pill.style.width = `${nextRect.w}px`;
        pill.style.height = `${nextRect.h}px`;
        pill.style.transform = `translate3d(${nextRect.x}px, ${nextRect.y}px, 0)`;
        pill.style.opacity = '1';

        if (instant) {
            void pill.offsetWidth;
            pill.style.transition = '';
        }
        hasMeasured = true;
        lastRect = nextRect;
    };

    const hasRunningAnimation = () => typeof pill.getAnimations === 'function'
        && pill.getAnimations().some((animation) => animation.playState === 'running');

    const onResize = () => {
        if (!activeTarget) {
            return;
        }
        if (hasRunningAnimation()) {
            // Container changed during glide (e.g. modal scrollbar toggle); retarget smoothly and snap-verify at rest.
            pendingResizeSync = true;
            measureAndApply(activeTarget, true);
            return;
        }
        pendingResizeSync = false;
        measureAndApply(activeTarget, false);
    };

    pill.addEventListener('transitionend', (event) => {
        if (event.target !== pill || !pendingResizeSync || !activeTarget || hasRunningAnimation()) {
            return;
        }
        pendingResizeSync = false;
        measureAndApply(activeTarget, false);
    });

    window.addEventListener('resize', onResize, { passive: true });
    document.fonts?.ready?.then(onResize);
    if (typeof ResizeObserver !== 'undefined') {
        const ro = new ResizeObserver(() => onResize());
        ro.observe(container);
    }

    return {
        sync(targetEl, animateMove = true) {
            measureAndApply(targetEl, animateMove);
        },
        hide() {
            activeTarget = null;
            hasMeasured = false;
            pendingResizeSync = false;
            lastRect = null;
            pill.style.opacity = '0';
        },
    };
}

const hydrateIcons = () => {
    createIcons({ icons: LUCIDE_ICONS });
};

const prefersReducedMotion = () =>
    window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

const createNode = (tag, className, text) => {
    const node = document.createElement(tag);
    if (className) {
        node.className = className;
    }
    if (text !== undefined && text !== null) {
        node.textContent = String(text);
    }
    return node;
};

const safeExternalLink = (href, text, className, fallbackHref = '#direktori') => {
    const link = createNode('a', className, text);
    const trimmed = String(href || '').trim();
    if (/^https?:\/\//i.test(trimmed)) {
        link.href = trimmed;
        link.target = '_blank';
        link.rel = 'noopener noreferrer';
    } else {
        link.href = fallbackHref;
    }
    return link;
};

const getComputedTranslate = (element, axis = 'x') => {
    const transform = getComputedStyle(element).transform;
    if (!transform || transform === 'none') {
        return 0;
    }
    try {
        const matrix = new DOMMatrix(transform);
        return axis === 'y' ? matrix.m42 : matrix.m41;
    } catch {
        return 0;
    }
};

function initScrollSections() {
    const sections = Array.from(document.querySelectorAll('[data-scroll-section]'));
    const noopController = {
        beginJump: () => {},
        revealNow: () => {},
        endJump: () => {},
    };

    if (!sections.length || prefersReducedMotion() || typeof IntersectionObserver === 'undefined') {
        return noopController;
    }

    const REVEAL_TOP = 72;
    const REVEAL_BOTTOM = 16;
    const HIDE_TOP = 24;
    const HIDE_BOTTOM = 28;
    const ENTER_OFFSET = 14;
    const EXIT_OFFSET = 10;

    const states = new WeakMap();
    const animations = new WeakMap();
    const tokens = new WeakMap();

    let isSuspended = false;
    let protectedSection = null;

    const getMotionTargetInfo = (el) => {
        const fadeOnly = el.hasAttribute('data-scroll-fade-only');
        const glideNodes = fadeOnly ? Array.from(el.querySelectorAll('[data-scroll-glide]')) : [];
        return { fadeOnly, glideNodes };
    };

    const isRectInRevealBand = (rect) => {
        const viewportHeight = window.innerHeight || document.documentElement.clientHeight;
        const effectiveBottom = Math.max(REVEAL_TOP + 1, viewportHeight - REVEAL_BOTTOM);
        return rect.bottom > REVEAL_TOP && rect.top < effectiveBottom;
    };

    const isRectInHideBand = (rect) => {
        const viewportHeight = window.innerHeight || document.documentElement.clientHeight;
        return rect.bottom > HIDE_TOP && rect.top < viewportHeight + HIDE_BOTTOM;
    };

    const nextToken = (el) => {
        const token = (tokens.get(el) || 0) + 1;
        tokens.set(el, token);
        return token;
    };

    const stopSectionAnimations = (el) => {
        const active = animations.get(el);
        if (!active) {
            return;
        }
        active.forEach((anim) => anim.stop());
        animations.delete(el);
    };

    const clearSectionStyles = (el, fadeOnly, glideNodes) => {
        el.style.opacity = '';
        el.style.willChange = '';
        if (!fadeOnly) {
            el.style.transform = '';
            return;
        }
        glideNodes.forEach((node) => {
            node.style.transform = '';
            node.style.willChange = '';
        });
    };

    const setSectionInstantState = (el, visible, rect) => {
        const { fadeOnly, glideNodes } = getMotionTargetInfo(el);
        states.set(el, visible ? 'visible' : 'hidden');
        if (visible) {
            clearSectionStyles(el, fadeOnly, glideNodes);
            return;
        }
        const offset = rect.top < REVEAL_TOP ? -ENTER_OFFSET : ENTER_OFFSET;
        el.style.opacity = '0';
        el.style.willChange = '';
        if (!fadeOnly) {
            el.style.transform = `translateY(${offset}px)`;
            return;
        }
        glideNodes.forEach((node) => {
            node.style.transform = `translateY(${offset}px)`;
            node.style.willChange = '';
        });
    };

    const animateSection = (el, visible, rect) => {
        if (!visible && protectedSection === el) {
            return;
        }

        const targetState = visible ? 'visible' : 'hidden';
        if (states.get(el) === targetState) {
            return;
        }
        states.set(el, targetState);

        stopSectionAnimations(el);

        const { fadeOnly, glideNodes } = getMotionTargetInfo(el);
        const token = nextToken(el);
        const opacityRaw = Number.parseFloat(getComputedStyle(el).opacity);
        const currentOpacity = Number.isFinite(opacityRaw) ? opacityRaw : (visible ? 0 : 1);

        if (visible) {
            const fromDir = rect.top < REVEAL_TOP ? -ENTER_OFFSET : ENTER_OFFSET;
            const fromOpacity = currentOpacity <= 0.02 ? 0 : currentOpacity;
            const revealTiming = { duration: 0.56, ease: [0.16, 1, 0.3, 1] };
            const animList = [];

            if (fadeOnly) {
                el.style.willChange = 'opacity';
                animList.push(animate(el, { opacity: [fromOpacity, 1] }, revealTiming));
                glideNodes.forEach((node) => {
                    const fromY = currentOpacity <= 0.02 ? fromDir : getComputedTranslate(node, 'y');
                    node.style.willChange = 'transform';
                    animList.push(animate(node, { y: [fromY, 0] }, revealTiming));
                });
            } else {
                const fromY = currentOpacity <= 0.02 ? fromDir : getComputedTranslate(el, 'y');
                el.style.willChange = 'opacity, transform';
                animList.push(animate(el, { opacity: [fromOpacity, 1], y: [fromY, 0] }, revealTiming));
            }

            animations.set(el, animList);

            Promise.all(animList.map((anim) => Promise.resolve(anim))).then(() => {
                if (tokens.get(el) !== token) {
                    return;
                }
                animations.delete(el);
                // Kosongkan transform setelah settle agar sticky ancestor tetap berfungsi penuh
                clearSectionStyles(el, fadeOnly, glideNodes);
            });
            return;
        }

        const exitY = rect.top < REVEAL_TOP ? -EXIT_OFFSET : EXIT_OFFSET;
        const exitTiming = { duration: 0.32, ease: [0.32, 0.72, 0, 1] };
        const animList = [];

        if (fadeOnly) {
            el.style.willChange = 'opacity';
            animList.push(animate(el, { opacity: [currentOpacity, 0] }, exitTiming));
            glideNodes.forEach((node) => {
                node.style.willChange = 'transform';
                animList.push(animate(node, { y: [getComputedTranslate(node, 'y'), exitY] }, exitTiming));
            });
        } else {
            el.style.willChange = 'opacity, transform';
            animList.push(animate(el, { opacity: [currentOpacity, 0], y: [getComputedTranslate(el, 'y'), exitY] }, exitTiming));
        }

        animations.set(el, animList);

        Promise.all(animList.map((anim) => Promise.resolve(anim))).then(() => {
            if (tokens.get(el) !== token) {
                return;
            }
            animations.delete(el);
            el.style.willChange = '';
            glideNodes.forEach((node) => {
                node.style.willChange = '';
            });
        });
    };

    const syncSections = () => {
        sections.forEach((section) => {
            const rect = section.getBoundingClientRect();
            const currentState = states.get(section);
            if (currentState !== 'visible' && isRectInRevealBand(rect)) {
                animateSection(section, true, rect);
            } else if (currentState === 'visible' && !isRectInHideBand(rect)) {
                animateSection(section, false, rect);
            }
        });
    };

    sections.forEach((section) => {
        const rect = section.getBoundingClientRect();
        setSectionInstantState(section, isRectInRevealBand(rect), rect);
    });

    // Dua observer terpisah memberi dead-zone histeresis sehingga pantulan trackpad tidak memicu kedip
    const revealObserver = new IntersectionObserver(
        (entries) => {
            if (isSuspended) {
                return;
            }
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    animateSection(entry.target, true, entry.boundingClientRect);
                }
            });
        },
        {
            rootMargin: `-${REVEAL_TOP}px 0px -${REVEAL_BOTTOM}px 0px`,
            threshold: 0,
        },
    );

    const hideObserver = new IntersectionObserver(
        (entries) => {
            if (isSuspended) {
                return;
            }
            entries.forEach((entry) => {
                if (!entry.isIntersecting && states.get(entry.target) === 'visible') {
                    animateSection(entry.target, false, entry.boundingClientRect);
                }
            });
        },
        {
            rootMargin: `-${HIDE_TOP}px 0px ${HIDE_BOTTOM}px 0px`,
            threshold: 0,
        },
    );

    sections.forEach((section) => {
        revealObserver.observe(section);
        hideObserver.observe(section);
    });

    let resizeFrame = 0;
    window.addEventListener('resize', () => {
        if (resizeFrame) {
            return;
        }
        resizeFrame = window.requestAnimationFrame(() => {
            resizeFrame = 0;
            if (!isSuspended) {
                syncSections();
            }
        });
    }, { passive: true });

    document.addEventListener('focusin', (event) => {
        if (!(event.target instanceof Element)) {
            return;
        }
        const section = event.target.closest('[data-scroll-section]');
        if (section && states.get(section) === 'hidden') {
            animateSection(section, true, section.getBoundingClientRect());
        }
    });

    return {
        beginJump(targetSection) {
            isSuspended = true;
            protectedSection = targetSection || null;
        },
        revealNow(targetSection) {
            if (!targetSection) {
                return;
            }
            protectedSection = targetSection;
            animateSection(targetSection, true, targetSection.getBoundingClientRect());
        },
        endJump() {
            isSuspended = false;
            protectedSection = null;
            syncSections();
        },
    };
}

function initScrollProgress() {
    const progressEl = document.querySelector('[data-scroll-progress]');
    if (!progressEl || prefersReducedMotion()) {
        return;
    }

    scroll(
        animate(progressEl, { scaleX: [0, 1] }, { ease: 'linear' }),
    );
}

function initHeaderSurface() {
    const header = document.querySelector('[data-header-surface]');
    if (!header) {
        return;
    }

    let isScrolled = false;

    const sync = () => {
        const nextScrolled = window.scrollY > 8;
        if (nextScrolled === isScrolled) {
            return;
        }
        isScrolled = nextScrolled;
        header.dataset.scrolled = String(nextScrolled);
    };

    window.addEventListener('scroll', sync, { passive: true });
    sync();
}

function initHeaderScrollSpy() {
    const trackedIds = ['layanan', 'direktori', 'capaian', 'ekosistem', 'lacak-tiket'];
    const header = document.querySelector('header');
    if (!header || typeof IntersectionObserver === 'undefined') {
        return;
    }

    const desktopNav = header.querySelector('nav[aria-label="Navigasi utama portal"]');
    const mobileNav = header.querySelector('[data-mobile-nav-menu] nav');

    const desktopLinks = new Map();
    const mobileLinks = new Map();

    trackedIds.forEach((id) => {
        const dLink = desktopNav?.querySelector(`a[href="#${id}"]`);
        const mLink = mobileNav?.querySelector(`a[href="#${id}"]`);
        if (dLink) {
            desktopLinks.set(id, dLink);
        }
        if (mLink) {
            mobileLinks.set(id, mLink);
        }
    });

    const DESKTOP_ACTIVE = ['text-[#1b4332]', 'font-semibold'];
    const DESKTOP_IDLE = ['text-[#3f5249]', 'hover:bg-[#edf2ed]/60', 'hover:text-[#10231b]'];
    const MOBILE_ACTIVE = ['bg-[#edf2ed]', 'text-[#1b4332]', 'font-semibold'];
    const MOBILE_IDLE = ['text-[#10231b]', 'font-medium', 'hover:bg-[#edf2ed]'];

    const navGlide = createGlideIndicator(desktopNav, {
        pillClass: 'rounded-lg bg-[#edf2ed] shadow-[inset_0_-2px_0_#1b4332]',
    });

    let activeSectionId = null;

    const setActiveNav = (nextId) => {
        if (activeSectionId === nextId) {
            return;
        }
        const hadPriorActive = activeSectionId !== null;
        activeSectionId = nextId;

        desktopLinks.forEach((link, id) => {
            const isActive = id === nextId;
            setVariantClasses(link, isActive, DESKTOP_ACTIVE, DESKTOP_IDLE);
            if (isActive) {
                link.setAttribute('aria-current', 'location');
            } else {
                link.removeAttribute('aria-current');
            }
        });

        const activeDesktopLink = nextId ? desktopLinks.get(nextId) : null;
        if (activeDesktopLink) {
            navGlide.sync(activeDesktopLink, hadPriorActive);
        } else {
            navGlide.hide();
        }

        mobileLinks.forEach((link, id) => {
            const isActive = id === nextId;
            setVariantClasses(link, isActive, MOBILE_ACTIVE, MOBILE_IDLE);
            if (isActive) {
                link.setAttribute('aria-current', 'location');
            } else {
                link.removeAttribute('aria-current');
            }
        });
    };

    const targets = trackedIds
        .map((id) => {
            const node = id === 'capaian'
                ? (document.querySelector('[data-scrollspy-section="capaian"]') || document.getElementById('capaian'))
                : document.getElementById(id);
            return node ? { id, node } : null;
        })
        .filter(Boolean);

    const heroSection = document.querySelector('#konten-utama > section');
    const footerEl = document.getElementById('kontak');

    if (!targets.length) {
        return;
    }

    const activeBandIds = new Set();
    let heroVisible = false;
    let footerVisible = false;

    const resolveActiveId = () => {
        for (const { id } of targets) {
            if (activeBandIds.has(id)) {
                setActiveNav(id);
                return;
            }
        }

        const vh = window.innerHeight || document.documentElement.clientHeight;
        if (heroVisible && window.scrollY < vh * 0.45) {
            setActiveNav(null);
            return;
        }

        if (footerVisible && window.scrollY + vh >= document.documentElement.scrollHeight - 48) {
            setActiveNav('lacak-tiket');
            return;
        }

        const focusY = vh * 0.36;
        let fallbackId = null;
        for (const { id, node } of targets) {
            const rect = node.getBoundingClientRect();
            if (rect.top <= focusY) {
                fallbackId = id;
            }
        }
        setActiveNav(fallbackId);
    };

    const bandObserver = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                const id = entry.target.getAttribute('data-spy-id');
                if (id === '__hero') {
                    heroVisible = entry.isIntersecting;
                } else if (id === '__footer') {
                    footerVisible = entry.isIntersecting;
                } else if (id) {
                    if (entry.isIntersecting) {
                        activeBandIds.add(id);
                    } else {
                        activeBandIds.delete(id);
                    }
                }
            });
            resolveActiveId();
        },
        {
            rootMargin: '-28% 0px -56% 0px',
            threshold: 0,
        },
    );

    if (heroSection) {
        heroSection.setAttribute('data-spy-id', '__hero');
        bandObserver.observe(heroSection);
    }
    targets.forEach(({ id, node }) => {
        node.setAttribute('data-spy-id', id);
        bandObserver.observe(node);
    });
    if (footerEl) {
        footerEl.setAttribute('data-spy-id', '__footer');
        bandObserver.observe(footerEl);
    }

    resolveActiveId();
}

function createSmoothScroller(scrollController) {
    let rafId = 0;
    let detachInterrupt = null;

    const resolveScrollSection = (targetEl) => (
        targetEl.matches('[data-scroll-section]')
            ? targetEl
            : (targetEl.closest('[data-scroll-section]') || targetEl.querySelector('[data-scroll-section]'))
    );

    const stopCurrentScroll = (resumeObservers = true) => {
        if (rafId) {
            window.cancelAnimationFrame(rafId);
            rafId = 0;
        }
        if (detachInterrupt) {
            detachInterrupt();
            detachInterrupt = null;
        }
        if (resumeObservers) {
            scrollController.endJump();
        }
    };

    const applyHashAndFocus = (targetEl, updateHash, focusOnArrive) => {
        if (updateHash) {
            try {
                window.history.replaceState(null, '', `${window.location.pathname}${window.location.search}${updateHash}`);
            } catch {
                // Abaikan jika history API dibatasi konteks
            }
        }
        if (focusOnArrive && targetEl instanceof HTMLElement) {
            const hadTabindex = targetEl.hasAttribute('tabindex');
            if (!hadTabindex) {
                targetEl.setAttribute('tabindex', '-1');
            }
            targetEl.focus({ preventScroll: true });
        }
    };

    return (targetEl, { updateHash = '', focusOnArrive = false } = {}) => {
        if (!targetEl) {
            return;
        }

        stopCurrentScroll(false);

        const headerBar = document.querySelector('header > div');
        const headerHeight = headerBar ? headerBar.getBoundingClientRect().height : 68;
        const maxScroll = Math.max(0, document.documentElement.scrollHeight - window.innerHeight);
        const rawTop = targetEl.id === 'konten-utama'
            ? 0
            : window.scrollY + targetEl.getBoundingClientRect().top - (headerHeight + 16);
        const destinationY = Math.max(0, Math.min(rawTop, maxScroll));
        const targetSection = resolveScrollSection(targetEl);

        if (prefersReducedMotion() || Math.abs(destinationY - window.scrollY) < 4) {
            window.scrollTo({ top: destinationY, behavior: 'instant' });
            scrollController.revealNow(targetSection);
            scrollController.endJump();
            applyHashAndFocus(targetEl, updateHash, focusOnArrive);
            return;
        }

        const startY = window.scrollY;
        const delta = destinationY - startY;
        const duration = Math.min(720, Math.max(400, 320 + Math.abs(delta) * 0.14));
        const startTime = performance.now();
        let revealedNearEnd = false;

        scrollController.beginJump(targetSection);

        const onUserInterrupt = () => stopCurrentScroll(true);
        const interruptEvents = ['wheel', 'touchstart'];
        interruptEvents.forEach((evt) => window.addEventListener(evt, onUserInterrupt, { passive: true, once: true }));

        const onKeyInterrupt = (event) => {
            if (['ArrowUp', 'ArrowDown', 'PageUp', 'PageDown', 'Home', 'End', ' '].includes(event.key)) {
                stopCurrentScroll(true);
            }
        };
        window.addEventListener('keydown', onKeyInterrupt, { passive: true });

        detachInterrupt = () => {
            interruptEvents.forEach((evt) => window.removeEventListener(evt, onUserInterrupt));
            window.removeEventListener('keydown', onKeyInterrupt);
        };

        const easeInOutCubic = (t) => (t < 0.5 ? 4 * t * t * t : 1 - Math.pow(-2 * t + 2, 3) / 2);

        const tick = (now) => {
            const elapsed = now - startTime;
            const progress = Math.min(1, elapsed / duration);
            const nextY = startY + delta * easeInOutCubic(progress);

            window.scrollTo({ top: nextY, behavior: 'instant' });

            if (!revealedNearEnd && progress >= 0.72) {
                revealedNearEnd = true;
                scrollController.revealNow(targetSection);
            }

            if (progress < 1) {
                rafId = window.requestAnimationFrame(tick);
                return;
            }

            stopCurrentScroll(true);
            applyHashAndFocus(targetEl, updateHash, focusOnArrive);
        };

        rafId = window.requestAnimationFrame(tick);
    };
}

function initSmoothNavigation(smoothScrollTo, closeMobileNav) {
    document.addEventListener('click', (event) => {
        if (event.defaultPrevented || event.button !== 0 || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) {
            return;
        }
        if (!(event.target instanceof Element)) {
            return;
        }
        const link = event.target.closest('a[href^="#"]');
        if (!link || link.hasAttribute('data-hero-dir-tab') || link.hasAttribute('data-sop-jump')) {
            return;
        }
        const hash = link.getAttribute('href') || '';
        if (hash.length <= 1) {
            return;
        }
        const targetEl = document.getElementById(hash.slice(1));
        if (!targetEl) {
            return;
        }
        event.preventDefault();
        closeMobileNav();
        smoothScrollTo(targetEl, {
            updateHash: hash,
            focusOnArrive: event.detail === 0,
        });
    });
}

function initMotionEntrance() {
    if (prefersReducedMotion()) {
        return;
    }

    const heroItems = Array.from(document.querySelectorAll('[data-hero-stagger]'));
    if (heroItems.length) {
        animate(
            heroItems,
            { opacity: [0.05, 1], y: [12, 0] },
            { duration: 0.48, delay: stagger(0.055), ease: [0.22, 1, 0.36, 1] },
        );
    }

    const counters = Array.from(document.querySelectorAll('[data-countup]'));
    counters.forEach((el) => {
        const target = Number.parseInt(el.getAttribute('data-countup') || '', 10);
        if (!Number.isFinite(target) || target <= 0) {
            return;
        }
        animate(0, target, {
            duration: 0.85,
            ease: [0.16, 1, 0.3, 1],
            onUpdate: (latest) => {
                el.textContent = Math.round(latest).toLocaleString('id-ID');
            },
        });
    });

    const progressBars = Array.from(document.querySelectorAll('[data-progress-bar]'));
    progressBars.forEach((bar, index) => {
        if (!bar.getAttribute('data-progress-bar')) {
            return;
        }
        bar.style.transformOrigin = 'left center';
        inView(
            bar,
            () => {
                animate(
                    bar,
                    { scaleX: [0, 1] },
                    { duration: 0.62, delay: Math.min(index * 0.04, 0.24), ease: [0.16, 1, 0.3, 1] },
                );
            },
            { amount: 0.2 },
        );
    });
}

function initMobileNav() {
    const toggle = document.querySelector('[data-mobile-nav-toggle]');
    const menu = document.querySelector('[data-mobile-nav-menu]');
    if (!toggle || !menu) {
        return () => {};
    }

    const setOpen = (isOpen) => {
        toggle.setAttribute('aria-expanded', String(isOpen));
        menu.classList.toggle('hidden', !isOpen);
        const headerSurface = toggle.closest('[data-header-surface]');
        if (headerSurface) {
            headerSurface.dataset.navOpen = String(isOpen);
        }
        if (isOpen && !prefersReducedMotion()) {
            animate(menu, { opacity: [0, 1], y: [-6, 0] }, { duration: 0.18, ease: [0.22, 1, 0.36, 1] });
        }
    };

    toggle.addEventListener('click', () => {
        const expanded = toggle.getAttribute('aria-expanded') === 'true';
        setOpen(!expanded);
    });

    menu.querySelectorAll('a[href^="#"]').forEach((link) => {
        link.addEventListener('click', () => setOpen(false));
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && toggle.getAttribute('aria-expanded') === 'true') {
            setOpen(false);
            toggle.focus();
        }
    });

    return () => setOpen(false);
}

function initHeroQuickTabs(setDirectoryTab, smoothScrollTo) {
    const quickLinks = document.querySelectorAll('[data-hero-dir-tab]');
    const rekapBar = document.querySelector('[data-rekap-bar]');
    const rekapSegments = rekapBar ? Array.from(rekapBar.querySelectorAll('[data-rekap-seg]')) : [];
    const directorySection = document.getElementById('direktori');
    if (!quickLinks.length || !directorySection) {
        return;
    }

    const setActiveSeg = (key) => {
        if (!rekapBar) {
            return;
        }
        if (key) {
            rekapBar.setAttribute('data-active-seg', key);
        } else {
            rekapBar.removeAttribute('data-active-seg');
        }
        rekapSegments.forEach((seg) => {
            seg.toggleAttribute('data-seg-active', Boolean(key) && seg.getAttribute('data-rekap-seg') === key);
        });
    };

    quickLinks.forEach((link) => {
        const targetKey = link.getAttribute('data-hero-dir-tab');

        link.addEventListener('mouseenter', () => setActiveSeg(targetKey));
        link.addEventListener('focus', () => setActiveSeg(targetKey));
        link.addEventListener('mouseleave', () => setActiveSeg(null));
        link.addEventListener('blur', () => setActiveSeg(null));

        link.addEventListener('click', (event) => {
            if (!targetKey) {
                return;
            }
            event.preventDefault();
            setDirectoryTab(targetKey);
            smoothScrollTo(directorySection, {
                updateHash: '#direktori',
                focusOnArrive: event.detail === 0,
            });
        });
    });
}

function initServiceFilters(smoothScrollTo) {
    const filterButtons = Array.from(document.querySelectorAll('[data-service-filter]'));
    const serviceCards = Array.from(document.querySelectorAll('[data-service-card]'));
    const statusText = document.querySelector('[data-service-status]');
    const filterContainer = document.querySelector('[data-glide-service-filter]');

    filterButtons.forEach((btn) => {
        btn.classList.remove('bg-[#edf2ed]', 'bg-white', 'shadow-[inset_3.5px_0_0_#1b4332]');
    });

    const serviceGlide = createGlideIndicator(filterContainer, {
        pillClass: 'bg-[#edf2ed] shadow-[inset_3.5px_0_0_#1b4332]',
    });

    let currentGroup = 'semua';
    const initialServiceBtn =
        filterButtons.find((btn) => btn.getAttribute('data-service-filter') === 'semua') || filterButtons[0];
    if (initialServiceBtn) {
        serviceGlide.sync(initialServiceBtn, false);
    }

    const applyServiceFilter = (selectedGroup) => {
        const prevIdx = filterButtons.findIndex((b) => b.getAttribute('data-service-filter') === currentGroup);
        const nextIdx = filterButtons.findIndex((b) => b.getAttribute('data-service-filter') === selectedGroup);
        const direction = nextIdx >= prevIdx ? 1 : -1;
        currentGroup = selectedGroup;

        const revealed = [];

        serviceCards.forEach((card) => {
            const cardGroup = card.getAttribute('data-service-group');
            const shouldShow = selectedGroup === 'semua' || cardGroup === selectedGroup;
            card.classList.remove('md:col-span-2');
            card.classList.toggle('hidden', !shouldShow);
            if (shouldShow) {
                revealed.push(card);
            }
        });

        // Jaga kartu spotlight tetap lebar penuh dan isi baris tunggal yang tersisa agar grid 2 kolom bebas celah kosong
        let openColumn = 0;
        revealed.forEach((card, index) => {
            const isSpotlight = card.getAttribute('data-service-spotlight') === 'true';
            if (isSpotlight) {
                if (openColumn === 1 && index > 0) {
                    revealed[index - 1].classList.add('md:col-span-2');
                }
                card.classList.add('md:col-span-2');
                openColumn = 0;
            } else {
                openColumn = (openColumn + 1) % 2;
            }
        });
        if (openColumn === 1 && revealed.length > 0) {
            revealed[revealed.length - 1].classList.add('md:col-span-2');
        }

        if (revealed.length && !prefersReducedMotion()) {
            animate(
                revealed,
                { opacity: [0.3, 1], x: [direction * 18, 0] },
                { duration: 0.28, delay: stagger(0.025), ease: [0.22, 1, 0.36, 1] },
            );
        }

        let activeFilterBtn = null;
        filterButtons.forEach((btn) => {
            const isSelected = btn.getAttribute('data-service-filter') === selectedGroup;
            if (isSelected) {
                activeFilterBtn = btn;
            }
            btn.setAttribute('aria-pressed', String(isSelected));
            setVariantClasses(btn, isSelected, SERVICE_FILTER_ACTIVE, SERVICE_FILTER_INACTIVE);

            const countBadge = btn.querySelector('[data-service-filter-badge]');
            if (countBadge) {
                setVariantClasses(countBadge, isSelected, SERVICE_COUNT_ACTIVE, SERVICE_COUNT_INACTIVE);
            }
        });
        if (activeFilterBtn) {
            serviceGlide.sync(activeFilterBtn, true);
        }

        if (statusText) {
            statusText.textContent = selectedGroup === 'semua'
                ? `Menampilkan ${revealed.length} layanan utama portal`
                : `Menampilkan ${revealed.length} layanan pada kategori terpilih`;
        }
    };

    filterButtons.forEach((btn) => {
        btn.addEventListener('click', () => {
            applyServiceFilter(btn.getAttribute('data-service-filter') || 'semua');
        });
    });

    const sopToggle = document.querySelector('[data-sop-toggle]');
    const sopPanel = document.querySelector('[data-sop-panel]');
    const sopLabel = document.querySelector('[data-sop-toggle-label]');
    const sopChevron = document.querySelector('[data-sop-chevron]');
    const sopCount = Number.parseInt(sopLabel?.getAttribute('data-sop-count') || '', 10) || (sopPanel ? sopPanel.querySelectorAll('li').length : 10);

    const setSopPanelOpen = (expanded, shouldAnimate = true) => {
        if (!sopToggle || !sopPanel) {
            return;
        }
        sopToggle.setAttribute('aria-expanded', String(expanded));
        sopPanel.classList.toggle('hidden', !expanded);
        if (sopChevron) {
            sopChevron.style.transform = expanded ? 'rotate(180deg)' : 'rotate(0deg)';
        }
        if (shouldAnimate && expanded && !prefersReducedMotion()) {
            animate(sopPanel, { opacity: [0, 1], y: [-6, 0] }, { duration: 0.24, ease: [0.22, 1, 0.36, 1] });
        }
        if (sopLabel) {
            sopLabel.textContent = expanded ? `Sembunyikan ${sopCount} SOP` : `Lihat ${sopCount} SOP`;
        }
    };

    if (sopToggle && sopPanel) {
        sopToggle.addEventListener('click', () => {
            const nextExpanded = sopToggle.getAttribute('aria-expanded') !== 'true';
            setSopPanelOpen(nextExpanded, true);
        });

        document.querySelectorAll('[data-sop-jump]').forEach((jumpLink) => {
            jumpLink.addEventListener('click', (event) => {
                const sopSection = document.getElementById('layanan-sop');
                if (!sopSection) {
                    return;
                }
                event.preventDefault();
                setSopPanelOpen(true, true);
                smoothScrollTo(sopSection, {
                    updateHash: '#layanan-sop',
                    focusOnArrive: event.detail === 0,
                });
            });
        });

        if (window.location.hash === '#layanan-sop' || window.location.hash === '#daftar-sop-panel') {
            setSopPanelOpen(true, false);
        }
    }
}

function renderDesktopRow(tabKey, row) {
    const tr = createNode('tr', 'transition-colors duration-150 even:bg-[#fafbf9] hover:bg-[#edf2ed]/65');
    tr.setAttribute('data-dir-row', '');

    if (tabKey === 'aplikasi') {
        const metricClass = (val) => `px-5 py-3.5 text-right font-mono text-xs tabular-nums ${Number(val) > 0 ? 'font-bold text-[#10231b]' : 'text-[#54665d]'}`;
        tr.append(
            createNode('td', 'px-5 py-3.5 font-mono text-xs font-semibold tabular-nums text-[#3f5249]', row.no),
            createNode('td', 'px-5 py-3.5 font-bold text-[#10231b]', row.instansi),
            createNode('td', 'bg-[#f4f8f5] px-5 py-3.5 text-right font-mono text-sm font-bold tabular-nums text-[#1b4332]', row.jumlah),
            createNode('td', metricClass(row.prioritas), row.prioritas),
            createNode('td', metricClass(row.tematik), row.tematik),
            createNode('td', metricClass(row.instansional), row.instansional),
            createNode('td', metricClass(row.lainnya), row.lainnya),
        );
        return tr;
    }

    if (tabKey === 'website') {
        const domainTd = createNode('td', 'px-5 py-3.5 font-mono text-xs font-semibold');
        domainTd.append(safeExternalLink(row.url || `https://${row.domain}`, row.domain, 'text-[#1b4332] hover:text-[#0b2017] hover:underline'));

        const catTd = createNode('td', 'px-5 py-3.5');
        catTd.append(createNode('span', 'inline-flex items-center rounded-md border border-[#c8d6cc] bg-[#f2f6f3] px-2.5 py-0.5 font-mono text-[11px] font-bold text-[#1b4332]', row.kategori));

        tr.append(
            createNode('td', 'px-5 py-3.5 font-mono text-xs font-semibold tabular-nums text-[#3f5249]', row.no),
            createNode('td', 'px-5 py-3.5 font-bold text-[#10231b]', row.instansi),
            domainTd,
            catTd,
        );
        return tr;
    }

    const domainTd = createNode('td', 'px-5 py-3.5 font-mono text-xs font-semibold');
    domainTd.append(safeExternalLink(row.url || `http://${row.domain}`, row.domain, 'text-[#1b4332] hover:text-[#0b2017] hover:underline'));

    const statusTd = createNode('td', 'px-5 py-3.5');
    statusTd.append(createNode('span', 'inline-flex items-center rounded-md border border-[#b9d4c2] bg-[#edf6f0] px-2.5 py-0.5 text-xs font-bold text-[#166534]', row.register || row.status || 'Sudah'));

    tr.append(
        createNode('td', 'px-5 py-3.5 font-mono text-xs font-semibold tabular-nums text-[#3f5249]', row.no),
        domainTd,
        createNode('td', 'px-5 py-3.5 font-bold text-[#10231b]', row.desa),
        createNode('td', 'px-5 py-3.5 text-[#3f5249]', row.kecamatan),
        statusTd,
        createNode('td', 'px-5 py-3.5 font-mono text-xs font-semibold text-[#3f5249]', row.platform),
    );
    return tr;
}

function renderMobileCard(tabKey, row) {
    const card = createNode('div', 'p-4');
    card.setAttribute('data-dir-row', '');

    if (tabKey === 'aplikasi') {
        const head = createNode('div', 'flex items-center justify-between gap-2');
        head.append(
            createNode('span', 'text-sm font-bold text-[#10231b]', row.instansi),
            createNode('span', 'rounded-md border border-[#c8d6cc] bg-[#f2f6f3] px-2.5 py-0.5 font-mono text-xs font-bold tabular-nums text-[#1b4332]', `${row.jumlah} aplikasi`),
        );
        const dl = createNode('dl', 'mt-2.5 grid grid-cols-2 gap-x-4 gap-y-1 text-xs text-[#3f5249]');
        const makeMetric = (label, val) => {
            const box = createNode('div');
            box.append(`${label}: `, createNode('strong', 'font-mono tabular-nums text-[#10231b]', val));
            return box;
        };
        dl.append(
            makeMetric('Prioritas', row.prioritas),
            makeMetric('Tematik', row.tematik),
            makeMetric('Instansional', row.instansional),
            makeMetric('Lainnya', row.lainnya),
        );
        card.append(head, dl);
        return card;
    }

    if (tabKey === 'website') {
        const head = createNode('div', 'flex items-start justify-between gap-2');
        head.append(
            createNode('span', 'text-sm font-bold text-[#10231b]', row.instansi),
            createNode('span', 'rounded-md border border-[#c8d6cc] bg-[#f2f6f3] px-2 py-0.5 font-mono text-[11px] font-bold text-[#1b4332]', row.kategori),
        );
        const link = safeExternalLink(
            row.url || `https://${row.domain}`,
            row.domain,
            'mt-1.5 inline-flex items-center gap-1 break-all font-mono text-xs font-semibold text-[#1b4332] hover:underline',
        );
        card.append(head, link);
        return card;
    }

    const head = createNode('div', 'flex items-start justify-between gap-2');
    head.append(
        createNode('span', 'text-sm font-bold text-[#10231b]', `Desa ${row.desa}`),
        createNode('span', 'rounded-md border border-[#b9d4c2] bg-[#edf6f0] px-2 py-0.5 text-[11px] font-bold text-[#166534]', row.register || row.status || 'Sudah'),
    );
    const link = safeExternalLink(
        row.url || `http://${row.domain}`,
        row.domain,
        'mt-1.5 inline-flex items-center gap-1 break-all font-mono text-xs font-semibold text-[#1b4332] hover:underline',
    );
    const sub = createNode('p', 'mt-1 text-xs text-[#3f5249]');
    sub.append(`Kecamatan ${row.kecamatan} · `, createNode('span', 'font-mono font-semibold', row.platform));
    card.append(head, link, sub);
    return card;
}

function initDirectoryController() {
    const root = document.querySelector('[data-directory-root]');
    if (!root) {
        return () => {};
    }

    let dataset = null;
    const rawScript = document.getElementById('talas-directory-data');
    if (rawScript && rawScript.textContent) {
        try {
            dataset = JSON.parse(rawScript.textContent);
        } catch {
            dataset = null;
        }
    }

    const tabs = Array.from(root.querySelectorAll('[data-dir-tab]'));
    const panels = Array.from(root.querySelectorAll('[data-dir-panel]'));
    const webCatButtons = Array.from(root.querySelectorAll('[data-web-cat]'));
    const searchInput = root.querySelector('[data-dir-search]');
    const tabInput = root.querySelector('[data-dir-active-input]');
    const webCatInput = root.querySelector('[data-dir-webcat-input]');
    const resetBtn = root.querySelector('[data-dir-reset]');
    const perPage = Math.max(1, Number.parseInt(root.getAttribute('data-per-page') || '10', 10));

    tabs.forEach((tab) => {
        tab.classList.remove('border-[#1b4332]', 'bg-[#1b4332]');
        tab.classList.add('border-transparent', 'bg-transparent');
    });
    webCatButtons.forEach((btn) => {
        btn.classList.remove('border-[#1b4332]', 'bg-[#1b4332]');
        btn.classList.add('border-transparent', 'bg-transparent');
    });

    const tabOrder = tabs.map((tab) => tab.getAttribute('data-dir-tab')).filter(Boolean);
    const webCatOrder = webCatButtons.map((btn) => btn.getAttribute('data-web-cat')).filter(Boolean);

    const dirTabsGlide = createGlideIndicator(root.querySelector('[data-glide-dir-tabs]'), {
        pillClass: 'rounded-lg border border-[#1b4332] bg-[#1b4332] shadow-[0_2px_8px_-2px_rgba(16,35,27,0.35)]',
    });
    const webCatGlide = createGlideIndicator(root.querySelector('[data-glide-web-cat]'), {
        pillClass: 'rounded-lg border border-[#1b4332] bg-[#1b4332] shadow-[0_2px_6px_-1px_rgba(16,35,27,0.28)]',
    });

    let activeStageAnim = null;
    let activeStageEl = null;

    const stopStageSlide = () => {
        if (activeStageAnim) {
            activeStageAnim.stop();
            activeStageAnim = null;
        }
        if (activeStageEl) {
            activeStageEl.style.opacity = '';
            activeStageEl.style.transform = '';
            activeStageEl.style.willChange = '';
            activeStageEl = null;
        }
    };

    const playHorizontalSlide = (targetEl, direction, distance = 24, duration = 0.28) => {
        stopStageSlide();
        if (!targetEl || prefersReducedMotion()) {
            return;
        }
        activeStageEl = targetEl;
        targetEl.style.willChange = 'transform, opacity';
        activeStageAnim = animate(
            targetEl,
            { opacity: [0.22, 1], x: [direction * distance, 0] },
            { duration, ease: [0.22, 1, 0.36, 1] },
        );
        Promise.resolve(activeStageAnim).finally(() => {
            if (activeStageEl === targetEl) {
                targetEl.style.opacity = '';
                targetEl.style.transform = '';
                targetEl.style.willChange = '';
                activeStageEl = null;
                activeStageAnim = null;
            }
        });
    };

    const initialPages = {};
    panels.forEach((panel) => {
        const key = panel.getAttribute('data-dir-panel');
        if (key) {
            initialPages[key] = Math.max(1, Number.parseInt(panel.getAttribute('data-current-page') || '1', 10));
        }
    });

    const state = {
        tab: root.getAttribute('data-active-tab') || 'aplikasi',
        webCat: root.getAttribute('data-web-category') || 'SEMUA',
        query: (searchInput?.value || '').trim(),
        pages: initialPages,
    };

    const buildDirectoryUrl = (tabKey, { query = state.query, webCat = state.webCat, page = 1 } = {}) => {
        const url = new URL(window.location.href);
        url.search = '';
        url.searchParams.set('tab', tabKey);
        if (query !== '') {
            url.searchParams.set('q', query);
        }
        if (tabKey === 'website' && webCat !== 'SEMUA') {
            url.searchParams.set('web_cat', webCat);
        }
        if (page > 1) {
            url.searchParams.set('page', String(page));
        }
        url.hash = 'direktori';
        return url.toString();
    };

    const getSearchableText = (tabKey, item) => {
        if (tabKey === 'aplikasi') {
            return [item.instansi, item.jumlah, item.prioritas, item.tematik, item.instansional, item.lainnya]
                .filter((val) => val !== null && val !== undefined)
                .join(' ')
                .toLowerCase();
        }
        if (tabKey === 'website') {
            return [item.instansi, item.domain, item.kategori]
                .filter((val) => val !== null && val !== undefined)
                .join(' ')
                .toLowerCase();
        }
        return [item.domain, item.desa, item.kecamatan, item.register || item.status, item.platform]
            .filter((val) => val !== null && val !== undefined)
            .join(' ')
            .toLowerCase();
    };

    const syncUrlState = () => {
        if (!window.history?.replaceState) {
            return;
        }
        const url = new URL(window.location.href);
        url.searchParams.set('tab', state.tab);
        if (state.query !== '') {
            url.searchParams.set('q', state.query);
        } else {
            url.searchParams.delete('q');
        }
        if (state.tab === 'website' && state.webCat !== 'SEMUA') {
            url.searchParams.set('web_cat', state.webCat);
        } else {
            url.searchParams.delete('web_cat');
        }
        const page = state.pages[state.tab] || 1;
        if (page > 1) {
            url.searchParams.set('page', String(page));
        } else {
            url.searchParams.delete('page');
        }
        window.history.replaceState(null, '', url.toString());
    };

    const renderTabPanel = (tabKey, fadeRows = false) => {
        const panel = root.querySelector(`[data-dir-panel="${tabKey}"]`);
        if (!panel) {
            return;
        }

        const isActive = tabKey === state.tab;
        panel.classList.toggle('hidden', !isActive);

        if (!dataset || !Array.isArray(dataset[tabKey])) {
            return;
        }

        const needle = state.query.toLowerCase();
        let rows = dataset[tabKey];

        if (tabKey === 'website' && state.webCat !== 'SEMUA') {
            rows = rows.filter((item) => String(item.kategori || '').toUpperCase() === state.webCat);
        }

        if (needle !== '') {
            rows = rows.filter((item) => getSearchableText(tabKey, item).includes(needle));
        }

        const totalFiltered = rows.length;
        const totalPages = Math.max(1, Math.ceil(totalFiltered / perPage));
        const currentPage = Math.min(Math.max(1, state.pages[tabKey] || 1), totalPages);
        state.pages[tabKey] = currentPage;

        const offset = (currentPage - 1) * perPage;
        const slice = rows.slice(offset, offset + perPage);

        const desktopBody = panel.querySelector(`[data-dir-table-body="${tabKey}"]`);
        const mobileBody = panel.querySelector(`[data-dir-mobile-body="${tabKey}"]`);
        if (desktopBody) {
            desktopBody.replaceChildren(...slice.map((row) => renderDesktopRow(tabKey, row)));
            if (fadeRows && !prefersReducedMotion() && desktopBody.children.length) {
                animate(
                    Array.from(desktopBody.children),
                    { opacity: [0.5, 1] },
                    { duration: 0.16, delay: stagger(0.012) },
                );
            }
        }
        if (mobileBody) {
            mobileBody.replaceChildren(...slice.map((row) => renderMobileCard(tabKey, row)));
        }

        const emptyBox = panel.querySelector(`[data-dir-empty="${tabKey}"]`);
        if (emptyBox) {
            emptyBox.classList.toggle('hidden', totalFiltered > 0);
        }

        const summaryEl = panel.querySelector(`[data-dir-summary="${tabKey}"]`);
        if (summaryEl) {
            const labelMap = { aplikasi: 'Aplikasi', website: 'Website', desaid: 'Desa.id' };
            summaryEl.replaceChildren(
                'Menampilkan ',
                createNode('strong', 'tabular-nums text-[#10231b]', slice.length),
                ' dari ',
                createNode('strong', 'tabular-nums text-[#10231b]', totalFiltered.toLocaleString('id-ID')),
                ` baris data ${labelMap[tabKey] || ''}`,
            );
        }

        const pageInfo = panel.querySelector(`[data-dir-page-info="${tabKey}"]`);
        if (pageInfo) {
            pageInfo.textContent = `Hal. ${currentPage} / ${totalPages}`;
        }

        const prevBtn = panel.querySelector('[data-dir-page-btn="prev"]');
        const nextBtn = panel.querySelector('[data-dir-page-btn="next"]');
        if (prevBtn) {
            const disablePrev = currentPage <= 1;
            const prevPage = Math.max(1, currentPage - 1);
            prevBtn.setAttribute('href', buildDirectoryUrl(tabKey, { page: prevPage }));
            prevBtn.setAttribute('aria-disabled', String(disablePrev));
            prevBtn.classList.toggle('pointer-events-none', disablePrev);
            prevBtn.classList.toggle('opacity-45', disablePrev);
        }
        if (nextBtn) {
            const disableNext = currentPage >= totalPages;
            const nextPage = Math.min(totalPages, currentPage + 1);
            nextBtn.setAttribute('href', buildDirectoryUrl(tabKey, { page: nextPage }));
            nextBtn.setAttribute('aria-disabled', String(disableNext));
            nextBtn.classList.toggle('pointer-events-none', disableNext);
            nextBtn.classList.toggle('opacity-45', disableNext);
        }
    };

    const renderAll = (mode = false, direction = 1) => {
        const effectiveWebCat = state.tab === 'website' ? state.webCat : 'SEMUA';
        root.setAttribute('data-web-category', effectiveWebCat);

        if (resetBtn) {
            const hasFilter = state.query !== '' || effectiveWebCat !== 'SEMUA';
            resetBtn.setAttribute('href', buildDirectoryUrl(state.tab, { query: '', webCat: 'SEMUA', page: 1 }));
            resetBtn.classList.toggle('hidden', !hasFilter);
            resetBtn.classList.toggle('inline-flex', hasFilter);
        }
        if (tabInput) {
            tabInput.value = state.tab;
        }
        if (webCatInput) {
            webCatInput.value = effectiveWebCat;
        }

        let activeTabNode = null;
        tabs.forEach((tab) => {
            const tabKey = tab.getAttribute('data-dir-tab') || 'aplikasi';
            const isSelected = tabKey === state.tab;
            if (isSelected) {
                activeTabNode = tab;
            }
            const tabWebCat = isSelected && tabKey === 'website' ? effectiveWebCat : 'SEMUA';
            const tabPage = tabKey === 'website' && !isSelected ? 1 : (state.pages[tabKey] || 1);
            tab.setAttribute('href', buildDirectoryUrl(tabKey, { query: state.query, webCat: tabWebCat, page: tabPage }));
            tab.setAttribute('aria-selected', String(isSelected));
            tab.setAttribute('tabindex', isSelected ? '0' : '-1');
            setVariantClasses(tab, isSelected, FILTER_ACTIVE, FILTER_INACTIVE);

            const countBadge = tab.querySelector('[data-dir-tab-badge], .tabular-nums');
            if (countBadge) {
                setVariantClasses(countBadge, isSelected, TAB_BADGE_ACTIVE, TAB_BADGE_INACTIVE);
            }
        });
        if (activeTabNode) {
            dirTabsGlide.sync(activeTabNode, mode === 'tab');
        }

        let activeWebCatNode = null;
        webCatButtons.forEach((btn) => {
            const btnCat = btn.getAttribute('data-web-cat') || 'SEMUA';
            const isCatSelected = btnCat === effectiveWebCat;
            if (isCatSelected) {
                activeWebCatNode = btn;
            }
            btn.setAttribute('href', buildDirectoryUrl('website', { query: state.query, webCat: btnCat, page: 1 }));
            btn.setAttribute('aria-pressed', String(isCatSelected));
            setVariantClasses(btn, isCatSelected, FILTER_ACTIVE, FILTER_INACTIVE);
        });

        panels.forEach((panel) => {
            const key = panel.getAttribute('data-dir-panel');
            if (key) {
                renderTabPanel(key, mode === 'fade' && key === state.tab);
            }
        });

        if (state.tab === 'website' && activeWebCatNode) {
            webCatGlide.sync(activeWebCatNode, mode === 'cat');
        } else {
            webCatGlide.hide();
        }

        if (mode === 'tab') {
            const activePanel = root.querySelector(`[data-dir-panel="${state.tab}"]`);
            playHorizontalSlide(activePanel, direction, 28, 0.28);
        } else if (mode === 'cat' || mode === 'page') {
            const tableStage = root.querySelector(`[data-dir-table-stage="${state.tab}"]`);
            playHorizontalSlide(tableStage, direction, 24, 0.26);
        }
    };

    const activateTab = (nextKey) => {
        if (!nextKey || nextKey === state.tab) {
            return;
        }
        const prevIdx = tabOrder.indexOf(state.tab);
        const nextIdx = tabOrder.indexOf(nextKey);
        const direction = nextIdx >= prevIdx ? 1 : -1;

        state.tab = nextKey;
        if (nextKey !== 'website') {
            state.webCat = 'SEMUA';
            state.pages.website = 1;
        }
        root.setAttribute('data-active-tab', nextKey);
        renderAll('tab', direction);
        syncUrlState();
    };

    const selectWebCategory = (nextCat) => {
        if (!nextCat || nextCat === state.webCat) {
            return;
        }
        const prevIdx = webCatOrder.indexOf(state.webCat);
        const nextIdx = webCatOrder.indexOf(nextCat);
        const direction = nextIdx >= prevIdx ? 1 : -1;

        state.webCat = nextCat;
        state.pages.website = 1;
        renderAll('cat', direction);
        syncUrlState();
    };

    tabs.forEach((tab, index) => {
        tab.addEventListener('click', (event) => {
            event.preventDefault();
            const key = tab.getAttribute('data-dir-tab');
            if (key) {
                activateTab(key);
            }
        });

        tab.addEventListener('keydown', (event) => {
            let targetIndex = null;
            if (event.key === 'ArrowRight') {
                targetIndex = (index + 1) % tabs.length;
            } else if (event.key === 'ArrowLeft') {
                targetIndex = (index - 1 + tabs.length) % tabs.length;
            } else if (event.key === 'Home') {
                targetIndex = 0;
            } else if (event.key === 'End') {
                targetIndex = tabs.length - 1;
            }
            if (targetIndex === null) {
                return;
            }
            event.preventDefault();
            const target = tabs[targetIndex];
            const key = target.getAttribute('data-dir-tab');
            if (key) {
                activateTab(key);
                target.focus();
            }
        });
    });

    webCatButtons.forEach((btn, index) => {
        btn.addEventListener('click', (event) => {
            event.preventDefault();
            selectWebCategory(btn.getAttribute('data-web-cat') || 'SEMUA');
        });

        btn.addEventListener('keydown', (event) => {
            let targetIndex = null;
            if (event.key === 'ArrowRight') {
                targetIndex = (index + 1) % webCatButtons.length;
            } else if (event.key === 'ArrowLeft') {
                targetIndex = (index - 1 + webCatButtons.length) % webCatButtons.length;
            } else if (event.key === 'Home') {
                targetIndex = 0;
            } else if (event.key === 'End') {
                targetIndex = webCatButtons.length - 1;
            }
            if (targetIndex === null) {
                return;
            }
            event.preventDefault();
            const target = webCatButtons[targetIndex];
            const catKey = target.getAttribute('data-web-cat') || 'SEMUA';
            selectWebCategory(catKey);
            target.focus();
        });
    });

    panels.forEach((panel) => {
        const key = panel.getAttribute('data-dir-panel');
        if (!key) {
            return;
        }
        panel.querySelectorAll('[data-dir-page-btn]').forEach((btn) => {
            btn.addEventListener('click', (event) => {
                event.preventDefault();
                if (btn.getAttribute('aria-disabled') === 'true') {
                    return;
                }
                const dir = btn.getAttribute('data-dir-page-btn');
                const direction = dir === 'next' ? 1 : -1;
                state.pages[key] = Math.max(1, (state.pages[key] || 1) + direction);
                renderAll('page', direction);
                syncUrlState();
            });
        });
    });

    if (searchInput) {
        searchInput.addEventListener('input', () => {
            state.query = searchInput.value.trim();
            state.pages = { aplikasi: 1, website: 1, desaid: 1 };
            renderAll('fade');
            syncUrlState();
        });
    }

    if (resetBtn && searchInput) {
        resetBtn.addEventListener('click', (event) => {
            event.preventDefault();
            searchInput.value = '';
            state.query = '';
            state.webCat = 'SEMUA';
            state.pages = { aplikasi: 1, website: 1, desaid: 1 };
            renderAll('fade');
            syncUrlState();
            searchInput.focus();
        });
    }

    const searchForm = root.querySelector('form');
    if (searchForm) {
        searchForm.addEventListener('submit', (event) => {
            if (dataset) {
                event.preventDefault();
                state.query = (searchInput?.value || '').trim();
                state.pages = { aplikasi: 1, website: 1, desaid: 1 };
                renderAll('fade');
                syncUrlState();
            }
        });
    }

    renderAll(false);
    return activateTab;
}

function initModals(closeMobileNav) {
    const serviceModal = document.querySelector('[data-modal="service"]');
    const portalModal = document.querySelector('[data-modal="portal"]');
    let activeModal = null;
    let lastFocusedElement = null;

    const getFocusableElements = (container) => Array.from(
        container.querySelectorAll('a[href], button:not([disabled]), [tabindex]:not([tabindex="-1"])'),
    ).filter((node) => node.offsetParent !== null);

    const openModal = (modalEl, triggerEl) => {
        if (!modalEl) {
            return;
        }
        closeMobileNav();
        if (activeModal && activeModal !== modalEl) {
            closeModal(false);
        }

        lastFocusedElement = triggerEl || document.activeElement;
        activeModal = modalEl;
        modalEl.classList.remove('hidden');
        modalEl.classList.add('flex');
        modalEl.setAttribute('aria-hidden', 'false');
        document.body.classList.add('overflow-hidden');

        const modalPanel = modalEl.querySelector('[data-modal-panel]');
        if (modalPanel) {
            modalPanel.scrollTop = 0;
        }
        modalEl.querySelectorAll('[data-modal-scroll]').forEach((scrollNode) => {
            scrollNode.scrollTop = 0;
        });

        if (!prefersReducedMotion()) {
            if (modalPanel) {
                animate(
                    modalPanel,
                    { opacity: [0, 1], scale: [0.96, 1], y: [8, 0] },
                    { type: 'spring', stiffness: 420, damping: 32 },
                );
            }
        }

        const focusTarget = modalEl.querySelector('[data-close-modal]') || modalEl.querySelector('[data-modal-panel]');
        if (focusTarget) {
            focusTarget.focus();
        }
    };

    const closeModal = (restoreFocus = true) => {
        if (!activeModal) {
            return;
        }
        const closingModal = activeModal;
        closingModal.dispatchEvent(new CustomEvent('talas:modal-closed'));
        closingModal.classList.add('hidden');
        closingModal.classList.remove('flex');
        closingModal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('overflow-hidden');
        activeModal = null;

        if (restoreFocus && lastFocusedElement instanceof HTMLElement) {
            const fallbackFocus = document.querySelector('[data-mobile-nav-toggle]');
            const focusTarget = lastFocusedElement.offsetParent !== null ? lastFocusedElement : fallbackFocus;
            if (focusTarget instanceof HTMLElement && focusTarget.offsetParent !== null) {
                focusTarget.focus();
            }
        }
        lastFocusedElement = null;
    };

    const servicesDataEl = document.getElementById('talas-services-json');
    let servicesMap = {};
    let servicesParseFailed = false;
    if (servicesDataEl && servicesDataEl.textContent) {
        try {
            servicesMap = JSON.parse(servicesDataEl.textContent) || {};
        } catch (error) {
            console.error('Gagal membaca data layanan TALAS:', error);
            servicesMap = {};
            servicesParseFailed = true;
        }
    }

    const renderServiceSopLinks = (item) => {
        if (!serviceModal) {
            return;
        }
        const sopSectionEl = serviceModal.querySelector('[data-modal-sop-section]');
        const sopListEl = serviceModal.querySelector('[data-modal-service-sop-list]');
        const sopNoteEl = serviceModal.querySelector('[data-modal-sop-note]');
        if (!sopSectionEl || !sopListEl) {
            return;
        }

        const docs = Array.isArray(item.dokumen_sop) ? item.dokumen_sop : [];
        sopListEl.replaceChildren();
        sopListEl.classList.toggle('sm:grid-cols-2', docs.length > 1);
        sopListEl.classList.toggle('grid-cols-1', docs.length <= 1);

        if (sopNoteEl) {
            const hasDedicatedSop = item.has_dedicated_sop !== false;
            sopNoteEl.classList.toggle('hidden', hasDedicatedSop);
            if (!hasDedicatedSop) {
                sopNoteEl.textContent = docs.length > 1
                    ? 'Terintegrasi lintas SOP resmi'
                    : 'Tanpa PDF khusus · Rujukan SOP terkait';
            }
        }

        if (docs.length === 0) {
            const emptyDocNotice = createNode(
                'p',
                'rounded-lg border border-dashed border-[#d6ded7] bg-[#f8faf8] px-3.5 py-2.5 text-xs text-[#3f5249]',
                'Dokumen SOP terpisah belum dipublikasikan; silakan gunakan tombol Arsip SOP di bawah.',
            );
            sopListEl.append(emptyDocNotice);
            return;
        }

        const fallbackArchive = item.sop_archive_url || '#layanan-sop';
        docs.forEach((doc, idx) => {
            const spanLastOdd = docs.length > 1 && docs.length % 2 === 1 && idx === docs.length - 1;
            const docLink = safeExternalLink(
                doc.url,
                '',
                `talas-transition flex min-h-[44px] items-center justify-between gap-2.5 rounded-lg border border-[#d6ded7] bg-[#f8faf8] px-3 py-2 text-xs hover:border-[#1b4332] hover:bg-white${spanLastOdd ? ' sm:col-span-2' : ''}`,
                fallbackArchive,
            );

            const left = createNode('span', 'min-w-0 leading-snug');
            const codeBadge = createNode('span', 'font-bold tabular-nums text-[#1b4332]', doc.kode || 'SOP');
            const sep = createNode('span', 'mx-1.5 text-[#c5d1c8]', '/');
            sep.setAttribute('aria-hidden', 'true');
            const docName = createNode('span', 'font-medium text-[#10231b]', doc.nama || doc.dokumen || 'Dokumen SOP');
            left.append(codeBadge, sep, docName);

            const right = createNode('span', 'inline-flex shrink-0 items-center gap-1 font-mono text-[11px] font-semibold text-[#3f5249]');
            right.append(createNode('span', '', 'PDF'));
            const arrowIcon = createNode('i', 'h-3.5 w-3.5 shrink-0 text-[#1b4332]');
            arrowIcon.setAttribute('data-lucide', 'arrow-up-right');
            arrowIcon.setAttribute('aria-hidden', 'true');
            right.append(arrowIcon);

            docLink.append(left, right);
            sopListEl.append(docLink);
        });
    };

    const populateServiceModal = (btn) => {
        if (!serviceModal) {
            return;
        }
        const slug = btn.getAttribute('data-service-slug') || '';
        const item = Object.prototype.hasOwnProperty.call(servicesMap, slug) ? servicesMap[slug] : null;

        const setText = (selector, value) => {
            const target = serviceModal.querySelector(selector);
            if (target) {
                target.textContent = value || '';
            }
        };

        const errorBoxEl = serviceModal.querySelector('[data-modal-service-error]');
        const sopSectionEl = serviceModal.querySelector('[data-modal-sop-section]');
        const kelengkapanEl = serviceModal.querySelector('[data-modal-service-kelengkapan]');
        const alurEl = serviceModal.querySelector('[data-modal-service-alur]');
        const alurEmptyEl = serviceModal.querySelector('[data-modal-service-alur-empty]');
        const pdfLink = serviceModal.querySelector('[data-modal-service-pdf]');
        const archiveFallback = serviceModal.querySelector('[data-modal-service-archive-fallback]');

        if (servicesParseFailed || !item) {
            if (errorBoxEl) {
                errorBoxEl.classList.remove('hidden');
                errorBoxEl.textContent = 'Rincian layanan gagal dimuat dari dokumen halaman ini. Silakan buka Arsip SOP resmi atau Portal Login untuk informasi terkini.';
            }
            setText('[data-modal-service-nama]', 'Rincian Layanan Tidak Tersedia');
            setText('[data-modal-service-kategori]', 'Layanan TALAS BOGOR');
            setText('[data-modal-service-kode]', 'SOP');
            setText('[data-modal-service-ringkasan]', '');
            setText('[data-modal-service-sasaran]', '-');
            setText('[data-modal-service-pelaksana]', '-');
            setText('[data-modal-service-sop]', '-');
            setText('[data-modal-service-mutu]', '-');
            setText('[data-modal-service-syarat]', '');
            setText('[data-modal-service-dasar]', '');
            if (sopSectionEl) {
                sopSectionEl.classList.add('hidden');
            }
            kelengkapanEl?.replaceChildren();
            alurEl?.replaceChildren();
            alurEmptyEl?.classList.remove('hidden');
            if (pdfLink instanceof HTMLAnchorElement) {
                pdfLink.classList.add('hidden');
                pdfLink.classList.remove('inline-flex');
            }
            if (archiveFallback) {
                archiveFallback.classList.remove('hidden');
                archiveFallback.classList.add('inline-flex');
            }
            return;
        }

        if (errorBoxEl) {
            errorBoxEl.classList.add('hidden');
            errorBoxEl.textContent = '';
        }
        sopSectionEl?.classList.remove('hidden');

        setText('[data-modal-service-nama]', item.nama);
        setText('[data-modal-service-kategori]', item.kategori);
        setText('[data-modal-service-kode]', item.kode_sop || 'SOP');
        setText('[data-modal-service-ringkasan]', item.ringkasan);
        setText('[data-modal-service-sasaran]', item.sasaran);
        setText('[data-modal-service-pelaksana]', item.pelaksana || 'Bidang Aplikasi Informatika Diskominfo');
        setText('[data-modal-service-sop]', item.rujukan_sop);
        setText('[data-modal-service-mutu]', item.mutu_baku || 'Mengacu dokumen SOP resmi');
        setText('[data-modal-service-syarat]', item.syarat_catatan);
        setText('[data-modal-service-dasar]', item.dasar_hukum);

        const iconEl = serviceModal.querySelector('[data-modal-service-icon]');
        if (iconEl instanceof HTMLImageElement && item.icon_url) {
            iconEl.src = item.icon_url;
        }

        if (kelengkapanEl) {
            kelengkapanEl.replaceChildren();
            const reqs = Array.isArray(item.kelengkapan) && item.kelengkapan.length > 0
                ? item.kelengkapan
                : [item.syarat_catatan || 'Mengikuti berkas persyaratan pada dokumen SOP resmi terkait.'];
            reqs.forEach((reqText) => {
                const li = createNode(
                    'li',
                    'flex items-start gap-2.5 rounded-lg border border-[#e5ebe6] bg-white px-3.5 py-2.5 leading-relaxed text-[#3f5249]',
                );
                const marker = createNode('span', 'mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-[#1b4332]');
                marker.setAttribute('aria-hidden', 'true');
                li.append(marker, createNode('span', '', reqText));
                kelengkapanEl.append(li);
            });
        }

        if (alurEl) {
            alurEl.replaceChildren();
            const steps = Array.isArray(item.alur) ? item.alur : [];
            if (alurEmptyEl) {
                alurEmptyEl.classList.toggle('hidden', steps.length > 0);
            }
            steps.forEach((step, idx) => {
                const li = createNode(
                    'li',
                    'flex flex-col gap-1.5 rounded-lg border border-[#e5ebe6] bg-[#f8faf8] px-3.5 py-2.5 sm:flex-row sm:items-center sm:justify-between sm:gap-3',
                );
                const left = createNode('div', 'flex min-w-0 items-start gap-2.5');
                const num = createNode('span', 'font-display shrink-0 text-xs font-bold tabular-nums text-[#1b4332]', String(idx + 1).padStart(2, '0'));
                const desc = createNode('span', 'text-xs leading-relaxed font-medium text-[#10231b] sm:text-[13px]', step.tahap || '');
                left.append(num, desc);

                const waktu = createNode(
                    'span',
                    'shrink-0 self-start rounded border border-[#d6ded7] bg-white px-2 py-0.5 text-[11px] font-bold tabular-nums text-[#3f5249] sm:self-center',
                    step.waktu || '',
                );
                li.append(left, waktu);
                alurEl.append(li);
            });
        }

        renderServiceSopLinks(item);
        hydrateIcons();

        const docs = Array.isArray(item.dokumen_sop) ? item.dokumen_sop : [];
        const singleDedicatedPdf = item.has_dedicated_sop !== false && docs.length === 1 && Boolean(docs[0]?.url);
        if (pdfLink instanceof HTMLAnchorElement) {
            pdfLink.classList.toggle('hidden', !singleDedicatedPdf);
            pdfLink.classList.toggle('inline-flex', singleDedicatedPdf);
            if (singleDedicatedPdf) {
                pdfLink.href = docs[0].url;
                const labelSpan = pdfLink.querySelector('span');
                if (labelSpan) {
                    labelSpan.textContent = docs[0].kode ? `PDF ${docs[0].kode}` : 'Unduh PDF SOP';
                }
            }
            if (archiveFallback) {
                archiveFallback.classList.toggle('hidden', singleDedicatedPdf);
                archiveFallback.classList.toggle('inline-flex', !singleDedicatedPdf);
                if (archiveFallback instanceof HTMLAnchorElement && item.sop_archive_url) {
                    archiveFallback.href = item.sop_archive_url;
                }
            }
        }
    };

    document.querySelectorAll('[data-open-service-modal]').forEach((btn) => {
        btn.addEventListener('click', () => {
            populateServiceModal(btn);
            openModal(serviceModal, btn);
        });
    });

    document.querySelectorAll('[data-service-card][data-service-spotlight="false"]').forEach((card) => {
        card.addEventListener('click', (event) => {
            if (event.target instanceof Element && event.target.closest('button, a')) {
                return;
            }
            if (window.getSelection && window.getSelection().toString().trim().length > 0) {
                return;
            }
            const modalBtn = card.querySelector('[data-open-service-modal]');
            if (modalBtn instanceof HTMLElement) {
                modalBtn.click();
            }
        });
    });

    document.querySelectorAll('[data-open-portal-modal]').forEach((btn) => {
        btn.addEventListener('click', () => {
            const targetRole = btn.getAttribute('data-portal-role-target');
            if (targetRole) {
                portalModal.dispatchEvent(new CustomEvent('talas:select-portal-role', {
                    detail: { roleKey: targetRole },
                }));
            }
            openModal(portalModal, btn);
        });
    });

    document.querySelectorAll('[data-portal-role-card]').forEach((card) => {
        card.addEventListener('click', (event) => {
            if (event.target instanceof Element && event.target.closest('button, a')) {
                return;
            }
            if (window.getSelection && window.getSelection().toString().trim().length > 0) {
                return;
            }
            const modalBtn = card.querySelector('[data-open-portal-modal]');
            if (modalBtn instanceof HTMLElement) {
                modalBtn.click();
            }
        });
    });

    document.querySelectorAll('[data-close-modal], [data-modal-backdrop]').forEach((node) => {
        node.addEventListener('click', () => closeModal(true));
    });

    document.addEventListener('keydown', (event) => {
        if (!activeModal) {
            return;
        }
        if (event.key === 'Escape') {
            event.preventDefault();
            closeModal(true);
            return;
        }
        if (event.key === 'Tab') {
            const focusable = getFocusableElements(activeModal);
            if (!focusable.length) {
                return;
            }
            const first = focusable[0];
            const last = focusable[focusable.length - 1];
            if (event.shiftKey && document.activeElement === first) {
                event.preventDefault();
                last.focus();
            } else if (!event.shiftKey && document.activeElement === last) {
                event.preventDefault();
                first.focus();
            }
        }
    });
}

function initPortalRoleTabs() {
    const portalModal = document.querySelector('[data-modal="portal"]');
    if (!portalModal) {
        return;
    }

    const roleTabs = Array.from(portalModal.querySelectorAll('[data-portal-role]'));
    const rolePanels = Array.from(portalModal.querySelectorAll('[data-portal-role-panel]'));
    const roleStage = portalModal.querySelector('[data-portal-role-stage]');
    const roleTabsContainer = portalModal.querySelector('[data-glide-portal-roles]');
    if (!roleTabs.length || !rolePanels.length) {
        return;
    }

    roleTabs.forEach((tab) => {
        tab.classList.remove('bg-[#edf2ed]', 'bg-white', 'shadow-[inset_3px_0_0_#784f14]');
    });

    const roleGlide = createGlideIndicator(roleTabsContainer, {
        pillClass: 'bg-[#edf2ed] shadow-[inset_3px_0_0_#784f14]',
    });

    const tabOrder = roleTabs.map((tab) => tab.getAttribute('data-portal-role'));
    const panelByKey = new Map(
        rolePanels.map((panel) => [panel.getAttribute('data-portal-role-panel'), panel]),
    );
    const panelTransitionStyles = [
        'position',
        'top',
        'left',
        'right',
        'width',
        'zIndex',
        'pointerEvents',
        'opacity',
        'transform',
        'willChange',
    ];

    let activeKey =
        roleTabs.find((tab) => tab.getAttribute('aria-selected') === 'true')?.getAttribute('data-portal-role') ||
        tabOrder[0];
    let transitionToken = 0;
    let activeAnimations = [];

    const syncRoleGlide = (animateMove = false) => {
        const currentTab = roleTabs.find((tab) => tab.getAttribute('data-portal-role') === activeKey);
        if (currentTab) {
            roleGlide.sync(currentTab, animateMove);
        }
    };

    if (typeof MutationObserver !== 'undefined') {
        const modalObserver = new MutationObserver(() => {
            if (!portalModal.classList.contains('hidden')) {
                requestAnimationFrame(() => syncRoleGlide(false));
            }
        });
        modalObserver.observe(portalModal, { attributes: true, attributeFilter: ['class'] });
    }

    const stopActiveAnimations = () => {
        activeAnimations.forEach((ctrl) => ctrl?.stop?.());
        activeAnimations = [];
    };

    const clearPanelStyles = (panel) => {
        panelTransitionStyles.forEach((prop) => {
            panel.style[prop] = '';
        });
    };

    const finalizeStage = (targetKey) => {
        rolePanels.forEach((panel) => {
            const matches = panel.getAttribute('data-portal-role-panel') === targetKey;
            panel.toggleAttribute('hidden', !matches);
            clearPanelStyles(panel);
        });
        if (roleStage) {
            roleStage.style.removeProperty('height');
            roleStage.style.removeProperty('overflow');
        }
    };

    const selectRole = (roleKey) => {
        if (!roleKey || roleKey === activeKey || !panelByKey.has(roleKey)) {
            return;
        }

        const prevKey = activeKey;
        const fromPanel = panelByKey.get(prevKey);
        const nextPanel = panelByKey.get(roleKey);
        if (!nextPanel) {
            return;
        }

        const prevIndex = tabOrder.indexOf(prevKey);
        const nextIndex = tabOrder.indexOf(roleKey);
        const direction = nextIndex >= prevIndex ? 1 : -1;

        activeKey = roleKey;
        transitionToken += 1;
        const currentToken = transitionToken;

        roleTabs.forEach((tab) => {
            const isSelected = tab.getAttribute('data-portal-role') === roleKey;
            tab.setAttribute('aria-selected', String(isSelected));
            tab.setAttribute('tabindex', isSelected ? '0' : '-1');
            setVariantClasses(tab, isSelected, PORTAL_ROLE_ACTIVE, PORTAL_ROLE_INACTIVE);
        });
        syncRoleGlide(true);

        const modalVisible = !portalModal.classList.contains('hidden');
        const startHeight = roleStage ? roleStage.getBoundingClientRect().height : 0;

        if (!roleStage || !fromPanel || !modalVisible || startHeight <= 0 || prefersReducedMotion()) {
            stopActiveAnimations();
            finalizeStage(roleKey);
            return;
        }

        const fromOpacityRaw = Number.parseFloat(getComputedStyle(fromPanel).opacity);
        const fromOpacity = Number.isFinite(fromOpacityRaw) ? fromOpacityRaw : 1;
        const fromX = getComputedTranslate(fromPanel, 'x');

        const nextWasVisible = !nextPanel.hidden;
        const nextOpacityRaw = nextWasVisible ? Number.parseFloat(getComputedStyle(nextPanel).opacity) : 0;
        const nextOpacity = nextWasVisible && Number.isFinite(nextOpacityRaw) ? nextOpacityRaw : 0;
        const nextX = nextWasVisible ? getComputedTranslate(nextPanel, 'x') : 20 * direction;

        stopActiveAnimations();

        rolePanels.forEach((panel) => {
            if (panel !== fromPanel && panel !== nextPanel) {
                panel.toggleAttribute('hidden', true);
                clearPanelStyles(panel);
            }
        });

        clearPanelStyles(fromPanel);
        clearPanelStyles(nextPanel);

        roleStage.style.height = `${startHeight}px`;
        roleStage.style.overflow = 'hidden';

        fromPanel.removeAttribute('hidden');
        fromPanel.style.position = 'absolute';
        fromPanel.style.top = '0';
        fromPanel.style.left = '0';
        fromPanel.style.right = '0';
        fromPanel.style.width = '100%';
        fromPanel.style.zIndex = '0';
        fromPanel.style.pointerEvents = 'none';
        fromPanel.style.willChange = 'transform, opacity';

        nextPanel.removeAttribute('hidden');
        nextPanel.style.position = 'relative';
        nextPanel.style.zIndex = '1';
        nextPanel.style.opacity = String(nextOpacity);
        nextPanel.style.willChange = 'transform, opacity';

        const endHeight = nextPanel.getBoundingClientRect().height;

        const outAnim = animate(
            fromPanel,
            { opacity: [fromOpacity, 0], x: [fromX, -20 * direction] },
            { duration: 0.18, ease: [0.4, 0, 0.2, 1] },
        );

        const inAnim = animate(
            nextPanel,
            { opacity: [nextOpacity, 1], x: [nextX, 0] },
            { duration: 0.3, delay: nextWasVisible ? 0 : 0.08, ease: [0.22, 1, 0.36, 1] },
        );

        const animations = [outAnim, inAnim];

        if (Math.abs(endHeight - startHeight) > 1) {
            const heightAnim = animate(
                roleStage,
                { height: [`${startHeight}px`, `${endHeight}px`] },
                { duration: 0.32, ease: [0.22, 1, 0.36, 1] },
            );
            animations.push(heightAnim);
        } else {
            roleStage.style.height = `${endHeight}px`;
        }

        activeAnimations = animations;

        Promise.all(animations.map((anim) => Promise.resolve(anim))).then(() => {
            if (currentToken !== transitionToken) {
                return;
            }
            activeAnimations = [];
            finalizeStage(roleKey);
        });
    };

    portalModal.addEventListener('talas:select-portal-role', (event) => {
        const targetRole = event?.detail?.roleKey;
        if (typeof targetRole === 'string' && targetRole.length > 0) {
            selectRole(targetRole);
        }
    });

    portalModal.addEventListener('talas:modal-closed', () => {
        transitionToken += 1;
        stopActiveAnimations();
        finalizeStage(activeKey);
    });

    roleTabs.forEach((tab, index) => {
        tab.addEventListener('click', () => {
            const key = tab.getAttribute('data-portal-role');
            if (key) {
                selectRole(key);
            }
        });

        tab.addEventListener('keydown', (event) => {
            const previousKeys = ['ArrowLeft', 'ArrowUp'];
            const nextKeys = ['ArrowRight', 'ArrowDown'];
            let nextIndex = null;

            if (previousKeys.includes(event.key)) {
                nextIndex = (index - 1 + roleTabs.length) % roleTabs.length;
            } else if (nextKeys.includes(event.key)) {
                nextIndex = (index + 1) % roleTabs.length;
            } else if (event.key === 'Home') {
                nextIndex = 0;
            } else if (event.key === 'End') {
                nextIndex = roleTabs.length - 1;
            }

            if (nextIndex === null) {
                return;
            }

            event.preventDefault();
            const nextTab = roleTabs[nextIndex];
            const key = nextTab.getAttribute('data-portal-role');
            if (key) {
                selectRole(key);
                nextTab.focus();
            }
        });
    });
}

const init = () => {
    hydrateIcons();
    const closeMobileNav = initMobileNav();
    const scrollController = initScrollSections();
    const smoothScrollTo = createSmoothScroller(scrollController);
    const setDirectoryTab = initDirectoryController();

    initSmoothNavigation(smoothScrollTo, closeMobileNav);
    initScrollProgress();
    initHeaderSurface();
    initHeaderScrollSpy();
    initHeroQuickTabs(setDirectoryTab, smoothScrollTo);
    initServiceFilters(smoothScrollTo);
    initModals(closeMobileNav);
    initPortalRoleTabs();
    initMotionEntrance();
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
} else {
    init();
}
