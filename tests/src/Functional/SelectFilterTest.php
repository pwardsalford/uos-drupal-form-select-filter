<?php

namespace Drupal\Tests\uos_form_select_filter\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Tests the UoS Form Select Filter functionality.
 *
 * @group uos_form_select_filter
 */
class SelectFilterTest extends BrowserTestBase {

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * Modules to enable.
   *
   * @var array
   */
  protected static $modules = ['uos_form_select_filter'];

  /**
   * Tests that the module is installed properly.
   */
  public function testModuleInstalled() {
    $module_handler = \Drupal::moduleHandler();
    $this->assertTrue($module_handler->moduleExists('uos_form_select_filter'), 'Module is enabled.');
  }

  /**
   * Tests that the library is properly defined.
   */
  public function testLibraryExists() {
    $library_discovery = \Drupal::service('library.discovery');
    $library = $library_discovery->getLibraryByName('uos_form_select_filter', 'select_filter');
    
    $this->assertNotNull($library, 'select_filter library exists.');
    $this->assertArrayHasKey('js', $library, 'Library has JavaScript.');
    $this->assertArrayHasKey('css', $library, 'Library has CSS.');
  }

  /**
   * Tests that the select filter can be applied to a form element.
   */
  public function testSelectFilterElement() {
    // Create a simple form with a select element.
    $form = [];
    $form_state = new \Drupal\Core\Form\FormState();
    
    $form['test_select'] = [
      '#type' => 'select',
      '#title' => $this->t('Test Select'),
      '#options' => [
        'option1' => 'Option 1',
        'option2' => 'Option 2',
        'option3' => 'Option 3',
      ],
      '#uos_select_filter' => TRUE,
    ];

    // Process the form element.
    $element = $form['test_select'];
    $processed = uos_form_select_filter_process_select($element, $form_state, $form);

    // Verify the class was added.
    $this->assertContains('uos-select-filter', $processed['#attributes']['class'], 'uos-select-filter class was added.');
    
    // Verify the library was attached.
    $this->assertContains('uos_form_select_filter/select_filter', $processed['#attached']['library'], 'select_filter library was attached.');
  }

}
