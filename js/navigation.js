/**
 * File navigation.js.
 *
 * Handles the big slidy boy of the nav. Use inconjunction with some tasty CSS.
 */
console.log('nav v4');

 ( function() {
	const siteNavigation = document.getElementById( 'nav' );
	const button = document.querySelector( 'nav button' );
	const page = document.getElementById('page');
	const body = document.querySelector('body');

	// Return early if the navigation don't exist.
	if ( ! siteNavigation ) { return; }

	// Return early if the buttons don't exist.
	if ( 'undefined' === typeof button || button === null ) { return; }

	const toggleMenu = ( direction = null ) => {
		const span = button.querySelector('span');

		if(direction === 'close') {
			siteNavigation.classList.add('closed');
			page.setAttribute( 'aria-expanded', 'false' );
			span.innerText = 'menu';

			return;
		}

		if(direction === 'open') {
			siteNavigation.classList.remove('closed');
			page.setAttribute( 'aria-expanded', 'true' ); 
			body.setAttribute( 'aria-expanded', 'true' );
			span.innerText = 'chevron_left';

			return;
		}

		// Else just toggle it.
		siteNavigation.classList.toggle('closed');
		
		span.innerText === 'menu' ? page.setAttribute( 'aria-expanded', 'true' ) : page.setAttribute( 'aria-expanded', 'false' );
		span.innerText === 'menu' ? body.setAttribute( 'aria-expanded', 'true' ) : body.setAttribute( 'aria-expanded', 'false' );
		span.innerText = span.innerText === 'menu' ? 'chevron_left' : 'menu';

		return;
	}

	// Toggle the .toggled class and the aria-expanded value each time the button is clicked.
	button.addEventListener( 'click', function() {
		toggleMenu();

		return true;
	} );

	const menu_items = document.querySelectorAll('nav a');
	
	menu_items.forEach( item => {
		item.addEventListener('click', () => {

			body.setAttribute( 'aria-expanded', 'false' );
			toggleMenu('close');
			/*
			setTimeout( () => {
				
			}, 150)*/
		});
	});

}() );

/**
 * Handle the scrolly boiz
 */
( function() {
	document.addEventListener('DOMContentLoaded', function () {
		setTimeout(() => {
			// Get all the Ids for scrolly bits from the menu
			const menu_items = document.querySelectorAll('nav li');
			const scroll_ids = [];

			menu_items.forEach( item => {
				if(!item.dataset.menuFor) return;
				
				scroll_ids.push(item.dataset.menuFor);
			})

			console.log('scroll_ids: ', scroll_ids);

			// Get all the elements from the page
			const page_els = [];
			let page_el_offset = 0;
			let previous_el_top = 0;

			scroll_ids.forEach( item => {
				const el = document.querySelector(item);
				const id = item;
				const top =	el.offsetTop;
				const bot = top + el.offsetHeight;
				const tag = el.tagName;


				//console.log(el, id, top, bot, tag, document.querySelector('#images').offsetTop);


				if(!el) return;

				let previous = {};
				if( page_el_offset > 0 ) {
					previous = { 
						tag : page_els[page_el_offset - 1].tag, 
						top : page_els[page_el_offset - 1].top, 
						bot : page_els[page_el_offset - 1].bot,
						el : page_els[page_el_offset - 1].el, };
				}

				page_els.push( { el, id, top, bot, tag, previous } );

				page_el_offset++;
			});

			const page_els_length = page_els.length;
			let page_els_iterator = 0;

			page_els.forEach( obj => {
				page_els[page_els_iterator].next = {};

				if( (page_els_iterator + 1) < page_els_length ) {
					page_els[page_els_iterator].next = {
						tag : page_els[page_els_iterator + 1].tag, 
						top : page_els[page_els_iterator + 1].top, 
						bot : page_els[page_els_iterator + 1].bot,
						el : page_els[page_els_iterator + 1].el,
					}
				}

				page_els_iterator++;

			});

			console.log('page_els: ', page_els);

			//console.log(page_els);

			let pre = 0; // Store position of previous element offset;

			const handleSectionPercentage = (position, element_id, top, bottom) => {
				const height = bottom - top;
				const adjusted_position = position - top;

				const percent = Math.floor(adjusted_position / height * 100);
				const menu_item = document.querySelector('nav li[data-menu-for="'+element_id+'"]');

				//console.log(element_id, menu_item);

				menu_item.dataset.sectionScrollPercentage = percent;
			}

			const scrollPercentElement = document.querySelector('#scrollPercentage');


			const debugScrolling = (position, id, top, bottom) => {
				const scrollPosition = document.querySelector('#scrollPosition');
				const sectionActive = document.querySelector('#sectionActive');
				const sectionTop = document.querySelector('#sectionTop');
				const sectionEnd = document.querySelector('#sectionEnd');

				scrollPosition.innerText = position;
				sectionActive.innerText = id;
				sectionTop.innerText = top;
				sectionEnd.innerText = bottom;

				const scrollDebugEnd = document.querySelector('#scrollDebugEnd');
				const scrollDebugStart = document.querySelector('#scrollDebugStart');

				scrollDebugStart.setAttribute('style', 'top: '+top+'px');
				scrollDebugEnd.setAttribute('style', 'top: '+bottom+'px');
				

				return;
			}

			// Check offset on scroll
			document.addEventListener('scroll', function ( event ) {
				const actualPosition = window.scrollY;
				const position = actualPosition + (63); // 3.5rem is the padding the section has from the top.

				// Loop through page_els to check offest against position
				page_els.forEach( obj => {

					const el = obj.el;
					const el_offset = obj.top;
					//const previous_el = obj.previous;
					const next_el = obj.next;
					let el_offset_bottom = obj.bot;

					// Check if the menu item is an inner guy.
					if(obj?.tag === 'DIV' ) {
						// Check if there is a next element.
						if( next_el.top !== undefined ) { 
							// If there is a next element set the top of that as the bottom of the el.
							el_offset_bottom = next_el.top; 
						}
					}
					
					const target = document.querySelector('nav li[data-menu-for="#'+el.id+'"]');
					const section = document.querySelector('#'+el.id);

					


					if( (position > el_offset) && (position < el_offset_bottom) ) {
						target.classList.add('active');
						section.classList.add('active');

						//debugScrolling(position, el.id, el_offset, el_offset_bottom);

						if(obj?.tag === 'SECTION' ) {
							//handleSectionPercentage(position, obj.id, el_offset, el_offset_bottom);
						}

						//if( obj.id === '#karen' ) { console.warn(target, position, el_offset, el_offset_bottom ); }
					} else {
						target.classList.remove('active');
						section.classList.remove('active');

						//if( obj.id === '#karen' ) { console.log(target, position, el_offset, el_offset_bottom ); }
					}
					return;
				});


				let scrollTop = window.scrollY;
				let docHeight = document.body.offsetHeight;
				let winHeight = window.innerHeight;
				let scrollPercent = scrollTop / (docHeight - winHeight);
				let scrollPercentRounded = scrollPercent * 100;

				//console.log(scrollPercentRounded);

				if(!scrollPercentElement) return;

				scrollPercentElement.style = '--scroll-percent: '+scrollPercentRounded+'%;';

			}, {
				passive: true
			});

		}, 200);
	});

}() );



/* changing logo based on background */
/*
var header = document.querySelector('.header-row')
var row1 = document.querySelector('#row1')

var rectHeader = header.getBoundingClientRect();
var rectRow1 = row1.getBoundingClientRect();

console.log(rectHeader.top, rectRow1.top);

const darkBgs = document.querySelectorAll('.has-black-background-color');
const bodyEl = document.querySelector('body');


function isInViewport(el) {
    const bounding = el.getBoundingClientRect(),
            elHeight = el.offsetHeight,
            elWidth = el.offsetWidth;


    if (bounding.top >= -elHeight 
        && bounding.left >= -elWidth
        && bounding.right <= (window.innerWidth || document.documentElement.clientWidth) + elWidth
        && bounding.bottom <= (window.innerHeight || document.documentElement.clientHeight) + elHeight) {

        return true;
    } else {

        return false;
    }
}


document.addEventListener('scroll', function () {
    let results = [];

    darkBgs.forEach(el => {
        results.push(isInViewport(el));
    });

    if(results.includes(true)) {
        bodyEl.classList.add('invert-logo');
    } else {
        bodyEl.classList.remove('invert-logo');
    }
}, {
    passive: true
});


document.addEventListener('scroll', function () { 
    var rh = header.getBoundingClientRect();
    var rr = row1.getBoundingClientRect();

    console.log( (rh.bottom >= rr.top && rh.top <= rr.bottom),  rh.bottom >= rr.top, rh.top <= rr.bottom, "RHT:", rh.top,  "RHB:", rh.bottom,  "RRT:", rr.top, "RRB:",  rr.bottom);
});


function checkOverlap(header, element) {
    const rh = header.getBoundingClientRect();
    const re = element.getBoundingClientRect();

    return (rh.bottom >= re.top && rh.top <= re.bottom);
}


document.addEventListener('scroll', function () {
    let results = [];

    darkBgs.forEach(el => {
        results.push(checkOverlap(header, el));
    });

    if(results.includes(true)) {
        bodyEl.classList.add('invert-logo');
    } else {
        bodyEl.classList.remove('invert-logo');
    }
}, {
    passive: true
}); */