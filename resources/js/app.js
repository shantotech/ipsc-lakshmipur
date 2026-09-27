import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';

// Self-hosted fonts: Figtree (English text), Hind Siliguri (Bangla text) and Fraunces (English headings).
import '@fontsource/hind-siliguri/400.css';
import '@fontsource/hind-siliguri/500.css';
import '@fontsource/hind-siliguri/600.css';
import '@fontsource/hind-siliguri/700.css';
import '@fontsource-variable/fraunces/opsz.css';
import '@fontsource-variable/figtree/wght.css';

Alpine.plugin(collapse);

// Dismissible site announcement. Remembers dismissal per announcement id.
Alpine.data('announcement', (id) => ({
    open: false,
    init() {
        let dismissed = null;
        try {
            dismissed = localStorage.getItem('announcement-dismissed');
        } catch (e) {}
        this.open = dismissed !== id;
    },
    close() {
        this.open = false;
        try {
            localStorage.setItem('announcement-dismissed', id);
        } catch (e) {}
    },
}));

// Photo gallery lightbox.
Alpine.data('gallery', (photos) => ({
    photos,
    album: 'all',
    index: null,
    get current() {
        return this.index === null ? null : this.photos[this.index];
    },
    show(i) {
        this.index = i;
        document.body.classList.add('overflow-hidden');
    },
    close() {
        this.index = null;
        document.body.classList.remove('overflow-hidden');
    },
    next() {
        this.index = (this.index + 1) % this.photos.length;
    },
    prev() {
        this.index = (this.index - 1 + this.photos.length) % this.photos.length;
    },
}));

// Homepage hero slider: fades between slides, plays only the visible video,
// pauses when the tab is hidden, and has a pause button (accessibility).
Alpine.data('heroSlider', (count) => ({
    count,
    index: 0,
    playing: true,
    timer: null,
    reduced: window.matchMedia('(prefers-reduced-motion: reduce)').matches,
    init() {
        if (this.reduced) this.playing = false;
        this.$nextTick(() => {
            this.sync();
            this.schedule();
        });
        document.addEventListener('visibilitychange', () => (document.hidden ? this.stop() : this.schedule()));
    },
    slides() {
        return [...this.$root.querySelectorAll('[data-slide]')];
    },
    schedule() {
        clearTimeout(this.timer);
        if (!this.playing || this.count < 2 || document.hidden) return;
        const duration = Number(this.slides()[this.index]?.dataset.duration || 7000);
        this.timer = setTimeout(() => this.go(this.index + 1), duration);
    },
    stop() {
        clearTimeout(this.timer);
    },
    go(i) {
        this.index = (i + this.count) % this.count;
        this.sync();
        this.schedule();
    },
    next() {
        this.go(this.index + 1);
    },
    prev() {
        this.go(this.index - 1);
    },
    toggle() {
        this.playing = !this.playing;
        this.playing ? this.schedule() : this.stop();
        this.sync();
    },
    sync() {
        this.slides().forEach((slide, i) => {
            const video = slide.querySelector('video');
            if (!video) return;
            if (i === this.index && !this.reduced && this.playing) {
                video.preload = 'auto';
                video.play().catch(() => {});
            } else {
                video.pause();
            }
        });
    },
}));

// Event popup on the homepage. Opens every time the homepage loads;
// closes with the button, Esc or a click outside.
Alpine.data('sitePopup', () => ({
    open: false,
    init() {
        setTimeout(() => {
            this.open = true;
            document.body.classList.add('overflow-hidden');
            this.$nextTick(() => this.$refs.close?.focus());
        }, 1200);
    },
    close() {
        this.open = false;
        document.body.classList.remove('overflow-hidden');
    },
}));

window.Alpine = Alpine;
Alpine.start();
