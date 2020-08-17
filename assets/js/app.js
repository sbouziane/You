var $ = import('jquery');
window.jQuery = $;
window.$ = $;
import LazyLoad from 'vanilla-lazyload';
import '../css/app.css';

var lazyLoadInstance = new LazyLoad({
    elements_selector: ".lazy"
    // ... more custom settings?
});
if (lazyLoadInstance) {
    lazyLoadInstance.update();
}


