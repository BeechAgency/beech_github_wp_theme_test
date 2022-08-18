/**
* Side Scroller - based on work by Alvaro Trigo 
* @https://codepen.io/alvarotrigo/pen/VwWMjVp
*/
(function(){
    init();

    var g_containerInViewport;

    function init(){
        setStickyContainersSize();
        bindEvents();
    }

    function bindEvents(){
        window.addEventListener("wheel", wheelHandler);        
    }

    function setStickyContainersSize(){
        document.querySelectorAll('.side-scroller').forEach(function(container){

            const stikyContainerHeight = container.querySelector('.scroller-track').scrollWidth;

            container.setAttribute('style', 'height: ' + stikyContainerHeight + 'px');
        });
    }

    function isElementInViewport (el) {
        // Bugging
        const rect = el.getBoundingClientRect();
        //console.log('Rect: ', rect.bottom, document.documentElement.clientHeight);

        if(rect.top <= 0 && rect.bottom > document.documentElement.clientHeight) {
            //console.log(rect);
        }

        return rect.top <= 0 && rect.bottom > document.documentElement.clientHeight;
    }

    function wheelHandler(evt){
        
        const containerInViewPort = Array.from(document.querySelectorAll('.side-scroller')).filter(function(container){
            return isElementInViewport(container);
        })[0];

        
        if(!containerInViewPort){
            //console.warn('No longer in viewport');
            return;
        }
        

        var isPlaceHolderBelowTop = containerInViewPort.offsetTop < document.documentElement.scrollTop;
        var isPlaceHolderBelowBottom = containerInViewPort.offsetTop + containerInViewPort.offsetHeight > document.documentElement.scrollTop;
        let g_canScrollHorizontally = isPlaceHolderBelowTop && isPlaceHolderBelowBottom;

        //console.log(g_canScrollHorizontally, isPlaceHolderBelowTop, isPlaceHolderBelowBottom);

        if(g_canScrollHorizontally){
            containerInViewPort.querySelector('.scroller-track').scrollLeft += evt.deltaY;
        }
    }
})();
/*
class XYSlideScroller {
    constructor(container = '[data-side-scroller]', track = ' > :first-child' ) {
        // Selectors
        this.container = container
        this.track = track

        this.init();
    }

    // Set all the good stuff
    setStickyContainersSize() {
        const containers = this.container;
        const track = this.track;

        document.querySelectorAll( containers ).forEach( (container) => {
            const stikyContainerHeight = (container.querySelector( track ).offsetWidth + window.innerHeight);
            container.setAttribute('style', 'height: ' + stikyContainerHeight + 'px');
        });
    }

    bindEvents() {
        window.addEventListener("wheel", this.wheelHandler);        
    }


    isElementInViewport(el) {
        const rect = el.getBoundingClientRect();
        return rect.top <= 0 && rect.bottom > document.documentElement.clientHeight;
    }

    wheelHandler(evt){
        const containers = this.container;

        const containerInViewPort = Array.from(document.querySelectorAll(containers)).filter(function(container){
            return this.isElementInViewport(container);
        })[0];

        if(!containerInViewPort){
            return;
        }

        var isPlaceHolderBelowTop = containerInViewPort.offsetTop < document.documentElement.scrollTop;
        var isPlaceHolderBelowBottom = containerInViewPort.offsetTop + containerInViewPort.offsetHeight > document.documentElement.scrollTop;
        let g_canScrollHorizontally = isPlaceHolderBelowTop && isPlaceHolderBelowBottom;

        if(g_canScrollHorizontally){
            containerInViewPort.querySelector('main').scrollLeft += evt.deltaY;
        }
    }

    init() {
        this.setStickyContainersSize();
        this.bindEvents();
    }
}

const scrollin = new XYSlideScroller('.side-scroller', '.scroller-track');
*/