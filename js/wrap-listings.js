console.log('working');
jQuery( ".awpcp-listings.awpcp-clearboth" ).wrapInner( '<div id="sof_listing_wrapper" ><div id="sof_listing_columns"></div></div>' );

jQuery('#sof_listing_columns').masonry({
    // options
    itemSelector: '.pin',
    //columnWidth: 1,
    transitionDuration: '0.9s',
    percentPosition: true
    //isFitWidth: true,
    //gutter: 10
    //columnWidth: '.grid-sizer'

});