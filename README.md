# Enhanced Select

A Drupal 10 module that provides an enhanced select form element.

## Description

This module provides the `enhanced_select` form element type that duplicates the functionality of Drupal's core select form field. The module is designed to be extended in the future with additional features.

## Installation

1. Place this module in your Drupal installation's `modules/custom` directory
2. Enable the module using Drush: `drush en uos_form_select_filter`
   Or through the Drupal admin interface at `/admin/modules`

## Usage

Use the `enhanced_select` form element type in your forms:

```php
$form['my_select'] = [
  '#type' => 'enhanced_select',
  '#title' => $this->t('Select an option'),
  '#options' => [
    'option1' => $this->t('Option 1'),
    'option2' => $this->t('Option 2'),
    'option3' => $this->t('Option 3'),
  ],
  '#default_value' => 'option1',
];
```

## Features

- Fully compatible with Drupal 10
- Replicates all functionality of the core `select` form element
- Extends `\Drupal\Core\Render\Element\Select` for maximum compatibility
- Ready for future enhancements

## Requirements

- Drupal 10.x

## Maintainers

Current maintainers:
- University of Salford