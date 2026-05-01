if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/sw.js')
        .then((reg) => console.log('Gumzo Service worker registered', reg))
        .catch((err) => console.info('sw not registered.', err));

}