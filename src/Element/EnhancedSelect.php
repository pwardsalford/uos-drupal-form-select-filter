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
   * This method replicates the core select functionality while allowing
   * for future enhancements.
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
    // Currently just passes through to parent, but provides a hook for
    // future enhancements.
    return $element;
  }

}
