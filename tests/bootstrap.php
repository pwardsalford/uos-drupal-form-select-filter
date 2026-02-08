<?php

/**
 * @file
 * Bootstrap file for PHPUnit tests.
 */

// Set the Drupal root if available.
if (getenv('DRUPAL_ROOT')) {
  $drupal_root = getenv('DRUPAL_ROOT');
}
elseif (file_exists(__DIR__ . '/../../../core/includes/bootstrap.inc')) {
  // Assume we're in a standard Drupal installation under modules/custom.
  $drupal_root = realpath(__DIR__ . '/../../..');
}
elseif (file_exists(__DIR__ . '/../vendor/autoload.php')) {
  // Standalone testing environment.
  require_once __DIR__ . '/../vendor/autoload.php';
  return;
}

if (isset($drupal_root)) {
  // Include Drupal's autoloader.
  if (file_exists($drupal_root . '/autoload.php')) {
    require_once $drupal_root . '/autoload.php';
  }
  elseif (file_exists($drupal_root . '/vendor/autoload.php')) {
    require_once $drupal_root . '/vendor/autoload.php';
  }

  // Bootstrap Drupal if testing within a Drupal installation.
  if (file_exists($drupal_root . '/core/tests/bootstrap.php')) {
    require_once $drupal_root . '/core/tests/bootstrap.php';
  }
}
