/**
 * @file
 * Javascript for elimai theme.
 */

(function ($) {

Drupal.behaviors.elimai = {
  attach: function (context) {

    // Adding the menu divider for main menu and secondary menu.
    $('ul#main-menu li a').append('<span class="menu-divider">/</span>');
    $('ul#secondary-menu li a').append('<span class="menu-divider">/</span>');

    // Removing the pagination item-list class for twitter bootstrap.
    $('.pagination > div').removeClass('item-list');

    // Making the content div 100% for no-sidebars pages.
    if($('body').hasClass('no-sidebars')) {
      $('#main-wrapper #content').removeClass('span8');
      $('#main-wrapper #content').addClass('span12');
    }
    else{
      $('#main-wrapper #content').removeClass('span12');
      $('#main-wrapper #content').addClass('span8');
    }
  }
}

})(jQuery);
