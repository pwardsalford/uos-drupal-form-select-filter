<?php

namespace Drupal\Tests\uos_form_select_filter\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Tests the example form.
 *
 * @group uos_form_select_filter
 */
class ExampleFormTest extends BrowserTestBase {

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
   * Tests that the example form is accessible.
   */
  public function testExampleFormAccess() {
    // Create a user with permission to access the form.
    $admin_user = $this->drupalCreateUser(['access administration pages']);
    $this->drupalLogin($admin_user);

    // Visit the example form.
    $this->drupalGet('/admin/config/user-interface/select-filter-example');
    $this->assertSession()->statusCodeEquals(200);

    // Check that the form elements are present.
    $this->assertSession()->fieldExists('example_select');
    $this->assertSession()->fieldExists('regular_select');

    // Verify the description is present.
    $this->assertSession()->pageTextContains('This form demonstrates the UoS Form Select Filter functionality');
  }

  /**
   * Tests submitting the example form.
   */
  public function testExampleFormSubmit() {
    // Create a user with permission to access the form.
    $admin_user = $this->drupalCreateUser(['access administration pages']);
    $this->drupalLogin($admin_user);

    // Visit the example form.
    $this->drupalGet('/admin/config/user-interface/select-filter-example');

    // Submit the form.
    $edit = [
      'example_select' => 'option_5',
    ];
    $this->submitForm($edit, 'Submit');

    // Verify the success message.
    $this->assertSession()->pageTextContains('You selected: option_5');
  }

}
