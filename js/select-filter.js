/**
 * @file
 * Select filter functionality for enhanced select elements.
 */

(function ($, Drupal) {
  'use strict';

  /**
   * Behavior to add search/filter functionality to select elements.
   */
  Drupal.behaviors.uosSelectFilter = {
    attach: function (context, settings) {
      $('.uos-select-filter', context).once('uos-select-filter').each(function () {
        var $select = $(this);
        var $wrapper = $('<div class="uos-select-filter-wrapper"></div>');
        var $input = $('<input type="text" class="uos-select-filter-input form-control" placeholder="Search...">');

        // Wrap the select element and add search input.
        $select.before($wrapper);
        $wrapper.append($input).append($select);

        // Filter options based on search input.
        $input.on('keyup', function () {
          var searchTerm = $(this).val().toLowerCase();
          $select.find('option').each(function () {
            var optionText = $(this).text().toLowerCase();
            if (optionText.indexOf(searchTerm) > -1) {
              $(this).show();
            } else {
              $(this).hide();
            }
          });
        });
      });
    }
  };

})(jQuery, Drupal);
