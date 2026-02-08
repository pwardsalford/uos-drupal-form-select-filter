# Testing the UoS Form Select Filter Module

This guide explains how to test the UoS Form Select Filter module in a Drupal environment.

## Prerequisites

- A working Drupal 9, 10, or 11 installation
- PHP 8.1 or higher
- Composer
- PHPUnit (included with Drupal core)

## Setting Up the Testing Environment

### 1. Install the Module

Place this module in your Drupal installation:

```bash
cd /path/to/drupal
mkdir -p modules/custom
cd modules/custom
git clone https://github.com/pwardsalford/uos-drupal-form-select-filter.git
```

### 2. Install Dependencies

If testing standalone, install dependencies:

```bash
cd uos-drupal-form-select-filter
composer install
```

If testing within a Drupal installation, Drupal's dependencies should already be available.

### 3. Configure PHPUnit

Copy the provided `phpunit.xml.dist` to `phpunit.xml` and configure it:

```bash
cp phpunit.xml.dist phpunit.xml
```

Edit `phpunit.xml` and set the following environment variables:

- `SIMPLETEST_BASE_URL`: Your Drupal site URL (e.g., `http://localhost:8080`)
- `SIMPLETEST_DB`: Your database connection string (e.g., `mysql://user:pass@localhost/drupal`)
- `BROWSERTEST_OUTPUT_DIRECTORY`: Path to store browser test output (e.g., `/tmp/browser_output`)

Example:

```xml
<env name="SIMPLETEST_BASE_URL" value="http://localhost:8080"/>
<env name="SIMPLETEST_DB" value="mysql://drupal:drupal@localhost/drupal"/>
<env name="BROWSERTEST_OUTPUT_DIRECTORY" value="/tmp/browser_output"/>
```

## Running Tests

### From Drupal Root (Recommended)

Run all tests for this module:

```bash
cd /path/to/drupal
./vendor/bin/phpunit -c core modules/custom/uos-drupal-form-select-filter
```

Run only unit tests:

```bash
./vendor/bin/phpunit -c core modules/custom/uos-drupal-form-select-filter/tests/src/Unit
```

Run only functional tests:

```bash
./vendor/bin/phpunit -c core modules/custom/uos-drupal-form-select-filter/tests/src/Functional
```

### From Module Directory

If you've configured `phpunit.xml` in the module directory:

```bash
cd modules/custom/uos-drupal-form-select-filter
../../../vendor/bin/phpunit
```

### Using Drush

You can also use Drush to run tests:

```bash
drush test-run uos_form_select_filter
```

## Test Coverage

This module includes the following test coverage:

### Unit Tests (`tests/src/Unit`)

- **ModuleHooksTest**: Tests module structure and file existence
  - Verifies module file exists
  - Validates info.yml file
  - Validates libraries.yml file
  - Checks JavaScript and CSS files exist

### Functional Tests (`tests/src/Functional`)

- **SelectFilterTest**: Tests Drupal integration
  - Verifies module installation
  - Tests library definition
  - Tests select filter element processing

## Alternative Testing Environments

### Using DDEV

If you're using DDEV for local development:

```bash
ddev ssh
cd /var/www/html
./vendor/bin/phpunit -c core modules/custom/uos-drupal-form-select-filter
```

### Using Lando

If you're using Lando:

```bash
lando ssh
cd /app
./vendor/bin/phpunit -c core modules/custom/uos-drupal-form-select-filter
```

### Using simplytest.me

For quick testing without a local environment:

1. Visit https://simplytest.me/
2. Upload the module or provide the GitHub URL
3. Select your Drupal version
4. Launch the temporary sandbox

## Continuous Integration

This module can be tested in CI environments. Example GitHub Actions workflow:

```yaml
name: Tests
on: [push, pull_request]
jobs:
  test:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.1'
      - name: Install Drupal
        run: |
          composer create-project drupal/recommended-project:^10 drupal --no-interaction
          cd drupal
          composer require --dev drupal/core-dev
      - name: Install module
        run: |
          mkdir -p drupal/web/modules/custom
          cp -r . drupal/web/modules/custom/uos-drupal-form-select-filter
      - name: Run tests
        run: |
          cd drupal
          ./vendor/bin/phpunit -c core web/modules/custom/uos-drupal-form-select-filter
```

## Troubleshooting

### Tests not found

Ensure the module is in the correct location and that Drupal's autoloader can find it.

### Database connection errors

Verify `SIMPLETEST_DB` is set correctly in your `phpunit.xml`.

### Browser tests fail

Ensure `SIMPLETEST_BASE_URL` points to a working Drupal installation and that `BROWSERTEST_OUTPUT_DIRECTORY` is writable.

### Permission errors

Ensure the web server user has permission to write to the browser output directory.

## Contributing

When contributing to this module, please ensure all tests pass:

```bash
./vendor/bin/phpunit -c core modules/custom/uos-drupal-form-select-filter
```

Add new tests for any new functionality.

## Resources

- [Drupal PHPUnit Documentation](https://www.drupal.org/docs/automated-testing/phpunit-in-drupal)
- [Writing PHPUnit Tests for Drupal](https://www.drupal.org/docs/testing/phpunit-in-drupal)
- [Functional Testing in Drupal](https://www.drupal.org/docs/testing/phpunit-in-drupal/phpunit-browser-test-tutorial)
