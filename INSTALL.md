# Installation and Usage Guide

## Table of Contents

1. [Installation Methods](#installation-methods)
2. [Verifying Installation](#verifying-installation)
3. [Using the Module](#using-the-module)
4. [Testing the Module](#testing-the-module)
5. [Troubleshooting](#troubleshooting)

## Installation Methods

### Method 1: Manual Installation (Development)

1. Clone the repository into your Drupal installation:
   ```bash
   cd /path/to/drupal/web/modules/custom
   git clone https://github.com/pwardsalford/uos-drupal-form-select-filter.git
   ```

2. Enable the module using Drush:
   ```bash
   drush en uos_form_select_filter -y
   drush cr
   ```

3. Or enable via the Drupal UI:
   - Navigate to `/admin/modules`
   - Search for "UoS Form Select Filter"
   - Check the box and click "Install"

### Method 2: Composer (Recommended for Production)

1. Add the repository to your `composer.json`:
   ```json
   {
     "repositories": [
       {
         "type": "vcs",
         "url": "https://github.com/pwardsalford/uos-drupal-form-select-filter.git"
       }
     ]
   }
   ```

2. Require the module:
   ```bash
   composer require uos/form-select-filter:dev-main
   ```

3. Enable the module:
   ```bash
   drush en uos_form_select_filter -y
   drush cr
   ```

## Verifying Installation

After installation, verify the module is working:

1. Check module status:
   ```bash
   drush pm:list --filter="uos_form_select_filter"
   ```

2. Visit the example form:
   - Navigate to `/admin/config/user-interface/select-filter-example`
   - You should see a form with a filterable select element

3. Test the filter:
   - Type in the search box above the select element
   - Options should filter as you type

## Using the Module

### In Custom Forms

To add the select filter to your custom form:

```php
<?php

namespace Drupal\my_module\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class MyForm extends FormBase {

  public function getFormId() {
    return 'my_custom_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    // Create a select element with many options
    $options = [];
    for ($i = 1; $i <= 100; $i++) {
      $options["item_$i"] = "Item $i";
    }

    $form['my_select'] = [
      '#type' => 'select',
      '#title' => $this->t('Choose an item'),
      '#options' => $options,
      '#uos_select_filter' => TRUE,  // This enables the filter
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Handle form submission
  }

}
```

### In Configuration Forms

The filter works in configuration forms too:

```php
<?php

namespace Drupal\my_module\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class MyConfigForm extends ConfigFormBase {

  protected function getEditableConfigNames() {
    return ['my_module.settings'];
  }

  public function getFormId() {
    return 'my_module_config_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('my_module.settings');

    // Get all content types
    $content_types = \Drupal::entityTypeManager()
      ->getStorage('node_type')
      ->loadMultiple();

    $options = [];
    foreach ($content_types as $type) {
      $options[$type->id()] = $type->label();
    }

    $form['content_type'] = [
      '#type' => 'select',
      '#title' => $this->t('Select Content Type'),
      '#options' => $options,
      '#default_value' => $config->get('content_type'),
      '#uos_select_filter' => TRUE,  // Enable filter
    ];

    return parent::buildForm($form, $form_state);
  }

}
```

### Using with Form Alter

You can also add the filter to existing forms using `hook_form_alter()`:

```php
<?php

/**
 * Implements hook_form_alter().
 */
function my_module_form_alter(&$form, \Drupal\Core\Form\FormStateInterface $form_state, $form_id) {
  // Add filter to a specific form's select element
  if ($form_id === 'some_existing_form') {
    if (isset($form['existing_select'])) {
      $form['existing_select']['#uos_select_filter'] = TRUE;
    }
  }

  // Add filter to all select elements with many options
  foreach (\Drupal\Core\Render\Element::children($form) as $key) {
    if (isset($form[$key]['#type']) && $form[$key]['#type'] === 'select') {
      if (isset($form[$key]['#options']) && count($form[$key]['#options']) > 20) {
        $form[$key]['#uos_select_filter'] = TRUE;
      }
    }
  }
}
```

## Testing the Module

See [TESTING.md](TESTING.md) for comprehensive testing instructions.

Quick test to verify functionality:

1. Create a test form at `/admin/config/development/test-select-filter`:
   ```bash
   drush php-eval "
   \$form = \Drupal::formBuilder()->getForm('Drupal\uos_form_select_filter\Form\ExampleForm');
   print_r(\$form);
   "
   ```

2. Run unit tests:
   ```bash
   cd /path/to/drupal
   ./vendor/bin/phpunit -c core web/modules/custom/uos-drupal-form-select-filter/tests/src/Unit
   ```

3. Run functional tests:
   ```bash
   ./vendor/bin/phpunit -c core web/modules/custom/uos-drupal-form-select-filter/tests/src/Functional
   ```

## Troubleshooting

### Filter Not Appearing

**Problem**: The search input doesn't appear above the select element.

**Solutions**:
1. Clear Drupal cache: `drush cr`
2. Verify `#uos_select_filter` is set to `TRUE` (not `1` or `'true'`)
3. Check browser console for JavaScript errors
4. Verify the library is attached by viewing page source

### JavaScript Not Working

**Problem**: The filter input appears but doesn't filter options.

**Solutions**:
1. Check that jQuery is loaded on the page
2. Clear browser cache (Ctrl+Shift+R)
3. Verify no JavaScript conflicts with other modules
4. Check browser console for errors

### Options Not Filtering Correctly

**Problem**: Some options don't filter as expected.

**Solutions**:
1. The filter performs a case-insensitive substring match
2. Check that option text contains the expected values
3. Look for special characters or HTML in option labels

### Module Won't Enable

**Problem**: Module cannot be enabled.

**Solutions**:
1. Check PHP version is 8.1 or higher: `php -v`
2. Verify Drupal core version is 9, 10, or 11
3. Check for syntax errors: `drush core:requirements`
4. Review Drupal logs: `drush watchdog:show`

### Tests Failing

**Problem**: PHPUnit tests fail.

**Solutions**:
1. Ensure you're running tests from Drupal root directory
2. Configure `phpunit.xml` with correct database settings
3. Install dev dependencies: `composer install --dev`
4. Check PHPUnit version compatibility

## Additional Resources

- [Drupal Form API Documentation](https://www.drupal.org/docs/drupal-apis/form-api)
- [PHPUnit Testing in Drupal](https://www.drupal.org/docs/automated-testing/phpunit-in-drupal)
- [Module Development](https://www.drupal.org/docs/creating-custom-modules)

## Support

For issues and feature requests, please use the GitHub issue tracker:
https://github.com/pwardsalford/uos-drupal-form-select-filter/issues
