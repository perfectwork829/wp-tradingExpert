(function () {
   "use strict";

   /**
    * Easy selector helper function
    */
   const select = (el, all = false) => {
      el = el.trim()
      if (all) {
         return [...document.querySelectorAll(el)]
      } else {
         return document.querySelector(el)
      }
   }

   /**
    * Easy event listener function
    */
   const on = (type, el, listener, all = false) => {
      let selectEl = select(el, all)
      if (selectEl) {
         if (all) {
            selectEl.forEach(e => e.addEventListener(type, listener))
         } else {
            selectEl.addEventListener(type, listener)
         }
      }
   }


   /**
    * Porfolio isotope and filter
    */
   window.addEventListener('load', () => {
      let portfolioContainer = select('.portfolio-container');
      if (portfolioContainer) {
         let portfolioIsotope = new Isotope(portfolioContainer, {
            itemSelector: '.portfolio-item',
            layoutMode: 'fitRows'
         });

         let portfolioFilters = select('#portfolio-flters li', true);

         on('click', '#portfolio-flters li', function (e) {
            e.preventDefault();
            portfolioFilters.forEach(function (el) {
               el.classList.remove('filter-active');
            });
            this.classList.add('filter-active');

            portfolioIsotope.arrange({
               filter: this.getAttribute('data-filter')
            });
            // portfolioIsotope.on('arrangeComplete', function () {
            //    AOS.refresh()
            // });
         }, true);
      }

   });

})()

var lightbox = GLightbox();
lightbox.on('open', (target) => {
   console.log('lightbox opened');
});
var lightboxDescription = GLightbox({
   selector: '.glightbox2'
});
var lightboxVideo = GLightbox({
   selector: '.glightbox3'
});
lightboxVideo.on('slide_changed', ({
   prev,
   current
}) => {
   console.log('Prev slide', prev);
   console.log('Current slide', current);

   const {
      slideIndex,
      slideNode,
      slideConfig,
      player
   } = current;

   if (player) {
      if (!player.ready) {
         // If player is not ready
         player.on('ready', (event) => {
            // Do something when video is ready
         });
      }

      player.on('play', (event) => {
         console.log('Started play');
      });

      player.on('volumechange', (event) => {
         console.log('Volume change');
      });

      player.on('ended', (event) => {
         console.log('Video ended');
      });
   }
});
var lightboxInlineIframe = GLightbox({
   selector: '.glightbox4'
});
