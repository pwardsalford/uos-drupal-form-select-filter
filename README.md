# UoS Drupal Form Select Filter

A Drupal module that provides an enhanced select filter for forms with search functionality.

## Features

- Adds a search input to select elements
- Filters options in real-time as users type
- Easy to integrate with existing Drupal forms
- Compatible with Drupal 9, 10, and 11

## Installation

1. Download or clone this module into your Drupal installation's `modules/custom` directory:
   ```bash
   cd /path/to/drupal/modules/custom
   git clone https://github.com/pwardsalford/uos-drupal-form-select-filter.git
   ```

2. Enable the module:
   ```bash
   drush en uos_form_select_filter
   ```
   Or via the Drupal UI at `/admin/modules`

## Usage

To add the select filter functionality to a form element, add the `#uos_select_filter` property:

```php
$form['my_select'] = [
  '#type' => 'select',
  '#title' => $this->t('My Select Field'),
  '#options' => [
    'option1' => 'Option 1',
    'option2' => 'Option 2',
    'option3' => 'Option 3',
  ],
  '#uos_select_filter' => TRUE,
];
```

## Testing

This module includes comprehensive testing support for Drupal environments. See [TESTING.md](TESTING.md) for detailed instructions.

Quick start:
```bash
# Unit tests
./vendor/bin/phpunit -c core modules/custom/uos-drupal-form-select-filter/tests/src/Unit

# Functional tests
./vendor/bin/phpunit -c core modules/custom/uos-drupal-form-select-filter/tests/src/Functional
```

## Requirements

- PHP 8.1 or higher
- Drupal 9, 10, or 11

## License

GPL-2.0-or-later