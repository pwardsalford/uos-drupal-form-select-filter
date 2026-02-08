<?php

namespace Drupal\uos_form_select_filter\Element;

use Drupal\Core\Render\Element\Select;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides an enhanced select form element.
 *
 * @FormElement("enhanced_select")
 */
class EnhancedSelect extends Select {

  /**
   * {@inheritdoc}
   */
  public function getInfo() {
    $info = parent::getInfo();
    $info['#process'][] = [get_class($this), 'processEnhancedSelect'];
    return $info;
  }

  /**
   * Processes an enhanced select form element.
   *
   * This is a placeholder process callback that allows for future enhancements
   * to the select element. The parent Select class handles all core processing
   * through its inherited process callbacks.
   *
   * @param array $element
   *   The form element to process.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   * @param array $complete_form
   *   The complete form structure.
   *
   * @return array
   *   The processed form element.
   */
  public static function processEnhancedSelect(array &$element, FormStateInterface $form_state, array &$complete_form) {
    // Placeholder for future enhancements. Core select processing is inherited
    // from the parent Select class.
    return $element;
  }

}
