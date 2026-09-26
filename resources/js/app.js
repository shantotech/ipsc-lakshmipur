import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';

// Self-hosted fonts: Hind Siliguri (Bangla + Latin body text) and Fraunces (display headings).
import '@fontsource/hind-siliguri/400.css';
import '@fontsource/hind-siliguri/500.css';
import '@fontsource/hind-siliguri/600.css';
import '@fontsource/hind-siliguri/700.css';
import '@fontsource-variable/fraunces/opsz.css';

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

window.Alpine = Alpine;
Alpine.start();
