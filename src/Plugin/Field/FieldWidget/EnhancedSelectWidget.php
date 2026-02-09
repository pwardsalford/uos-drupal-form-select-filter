<?php

namespace Drupal\uos_form_select_filter\Plugin\Field\FieldWidget;

use Drupal\Core\Form\FormStateInterface;
use Drupal\options\Plugin\Field\FieldWidget\OptionsSelectWidget;

/**
 * Plugin implementation of the 'enhanced_select' widget for list fields.
 *
 * Uses the enhanced_select form element, providing the same functionality
 * as the core "Select list" widget with a placeholder for future enhancements.
 *
 * @FieldWidget(
 *   id = "enhanced_select",
 *   label = @Translation("Enhanced select list"),
 *   field_types = {
 *     "list_string",
 *     "list_integer",
 *     "list_float"
 *   },
 *   multiple_values = TRUE
 * )
 */
class EnhancedSelectWidget extends OptionsSelectWidget {

  /**
   * {@inheritdoc}
   */
  public function formElement($items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element = parent::formElement($items, $delta, $element, $form, $form_state);
    if (isset($element['#type']) && $element['#type'] === 'select') {
      $element['#type'] = 'enhanced_select';
    }
    if (isset($element['value']['#type']) && $element['value']['#type'] === 'select') {
      $element['value']['#type'] = 'enhanced_select';
    }
    return $element;
  }

}
