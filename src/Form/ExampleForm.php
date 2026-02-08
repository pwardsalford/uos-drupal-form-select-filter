<?php

namespace Drupal\uos_form_select_filter\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides an example form demonstrating the select filter.
 */
class ExampleForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'uos_form_select_filter_example';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['description'] = [
      '#markup' => '<p>' . $this->t('This form demonstrates the UoS Form Select Filter functionality. The select field below includes a search filter.') . '</p>',
    ];

    // Example select with many options to demonstrate the filter.
    $options = [];
    for ($i = 1; $i <= 50; $i++) {
      $options["option_$i"] = $this->t('Option @number', ['@number' => $i]);
    }

    $form['example_select'] = [
      '#type' => 'select',
      '#title' => $this->t('Example Select (with filter)'),
      '#options' => $options,
      '#description' => $this->t('Start typing to filter the options.'),
      '#uos_select_filter' => TRUE,
    ];

    $form['regular_select'] = [
      '#type' => 'select',
      '#title' => $this->t('Regular Select (without filter)'),
      '#options' => array_slice($options, 0, 10, TRUE),
      '#description' => $this->t('This is a regular select without the filter.'),
    ];

    $form['actions'] = [
      '#type' => 'actions',
    ];

    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->messenger()->addMessage(
      $this->t('You selected: @value', [
        '@value' => $form_state->getValue('example_select'),
      ])
    );
  }

}
