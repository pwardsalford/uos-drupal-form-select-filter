<?php

namespace Drupal\Tests\uos_form_select_filter\Unit;

use PHPUnit\Framework\TestCase;

/**
 * Tests the UoS Form Select Filter module hooks.
 *
 * @group uos_form_select_filter
 */
class ModuleHooksTest extends TestCase {

  /**
   * Tests that the module file can be loaded.
   */
  public function testModuleFileExists() {
    $module_file = __DIR__ . '/../../../uos_form_select_filter.module';
    $this->assertFileExists($module_file, 'Module file exists.');
  }

  /**
   * Tests that the info file is valid YAML.
   */
  public function testInfoFileValid() {
    $info_file = __DIR__ . '/../../../uos_form_select_filter.info.yml';
    $this->assertFileExists($info_file, 'Info file exists.');

    $info = \yaml_parse_file($info_file);
    $this->assertIsArray($info, 'Info file contains valid YAML.');
    $this->assertArrayHasKey('name', $info, 'Info file has a name.');
    $this->assertArrayHasKey('type', $info, 'Info file has a type.');
    $this->assertEquals('module', $info['type'], 'Info file type is module.');
  }

  /**
   * Tests that the libraries file is valid YAML.
   */
  public function testLibrariesFileValid() {
    $libraries_file = __DIR__ . '/../../../uos_form_select_filter.libraries.yml';
    $this->assertFileExists($libraries_file, 'Libraries file exists.');

    $libraries = \yaml_parse_file($libraries_file);
    $this->assertIsArray($libraries, 'Libraries file contains valid YAML.');
    $this->assertArrayHasKey('select_filter', $libraries, 'select_filter library is defined.');
  }

  /**
   * Tests that required JavaScript and CSS files exist.
   */
  public function testAssetFilesExist() {
    $js_file = __DIR__ . '/../../../js/select-filter.js';
    $this->assertFileExists($js_file, 'JavaScript file exists.');

    $css_file = __DIR__ . '/../../../css/select-filter.css';
    $this->assertFileExists($css_file, 'CSS file exists.');
  }

}
