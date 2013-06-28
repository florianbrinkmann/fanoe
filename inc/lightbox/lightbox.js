// JavaScript Document

(function($) {
 // Initialize the Lightbox automatically for any links to images with extensions .jpg, .jpeg, .png or .gif
    $("a[href$='.jpg'], a[href$='.png'], a[href$='.jpeg'], a[href$='.gif']").fancybox();
 
    // Initialize the Lightbox for any links with the 'fancybox' class
    $(".fancybox").fancybox();
 
    // Initialize the Lightbox and add rel="gallery" to all gallery images when the gallery is set up using  so that a Lightbox Gallery exists
    $(".gallery a[href$='.jpg'], .gallery a[href$='.png'], .gallery a[href$='.jpeg'], .gallery a[href$='.gif']").attr('rel','gallery').fancybox();
 
 
})(jQuery);