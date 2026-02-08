# Testing Strategy with GitHub Tools and Copilot

## Current State
The repository currently has:
- `uos_form_select_filter.module` - main module file
- `uos_form_select_filter.info.yml` - module metadata
- `src/` directory - source code
- No existing test infrastructure or GitHub Actions workflows

## Testing Strategy Using GitHub Tools & Copilot

### 1. Set Up PHPUnit Tests
For Drupal modules, you should implement:

**Unit Tests** - Test individual functions and classes in isolation
```php
<?php

namespace Drupal\Tests\uos_form_select_filter\Unit;

use Drupal\Tests\UnitTestCase;

/**
 * Tests for form select filter functionality.
 *
 * @group uos_form_select_filter
 */
class FormSelectFilterTest extends UnitTestCase {

  /**
   * Test basic functionality.
   */
  public function testBasicFunctionality() {
    // Add your unit tests here
    $this->assertTrue(TRUE);
  }
}
```

**Kernel Tests** - Test with minimal Drupal bootstrap
```php
<?php

namespace Drupal\Tests\uos_form_select_filter\Kernel;

use Drupal\KernelTests\KernelTestBase;

/**
 * Kernel tests for form select filter.
 *
 * @group uos_form_select_filter
 */
class FormSelectFilterKernelTest extends KernelTestBase {

  protected static $modules = ['uos_form_select_filter'];

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();
    $this->installConfig(['uos_form_select_filter']);
  }

  /**
   * Test module functionality with kernel.
   */
  public function testKernelFunctionality() {
    // Add kernel tests here
    $this->assertTrue(TRUE);
  }
}
```

### 2. GitHub Actions Workflow for CI/CD

Create a workflow to automatically run tests on every push and pull request:

**.github/workflows/test.yml**
```yaml
name: Drupal Module Tests

on:
  push:
    branches: [ main, develop ]
  pull_request:
    branches: [ main, develop ]

jobs:
  test:
    runs-on: ubuntu-latest
    
    strategy:
      matrix:
        php-version: ['8.1', '8.2', '8.3']
        drupal-version: ['10.1', '10.2']
    
    steps:
      - uses: actions/checkout@v4
      
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: ${{ matrix.php-version }}
          extensions: mbstring, xml, ctype, iconv, intl, pdo_sqlite, gd
          coverage: xdebug
      
      - name: Install Composer dependencies
        run: |
          composer create-project drupal/recommended-project:^${{ matrix.drupal-version }} /tmp/drupal --no-interaction
          cd /tmp/drupal
          composer config repositories.local path $GITHUB_WORKSPACE
          composer require "drupal/uos_form_select_filter:*"
      
      - name: Run PHPUnit tests
        run: |
          cd /tmp/drupal
          ./vendor/bin/phpunit -c web/core web/modules/contrib/uos_form_select_filter
      
      - name: Run PHP CodeSniffer
        run: |
          cd /tmp/drupal
          ./vendor/bin/phpcs --standard=Drupal,DrupalPractice web/modules/contrib/uos_form_select_filter

  code-quality:
    runs-on: ubuntu-latest
    
    steps:
      - uses: actions/checkout@v4
      
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.2'
      
      - name: Install dependencies
        run: |
          composer require --dev drupal/coder
          composer require --dev phpstan/phpstan
      
      - name: Run PHPStan
        run: ./vendor/bin/phpstan analyse src
```

### 3. GitHub Copilot for Test Generation

Use Copilot to:
- **Generate test cases**: Ask Copilot to create tests for specific functions
- **Write test assertions**: Use inline suggestions while writing tests
- **Create mock objects**: Let Copilot suggest appropriate mocks for dependencies

Example prompts for Copilot Chat:
- "Generate PHPUnit tests for this form alter hook"
- "Create a kernel test for testing this service"
- "Write test cases for edge cases in this function"

### 4. Code Quality Checks

Add additional workflows for code quality:

**.github/workflows/code-quality.yml**
```yaml
name: Code Quality

on: [push, pull_request]

jobs:
  phpstan:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4
      
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.2'
      
      - name: Install PHPStan
        run: composer require --dev phpstan/phpstan
      
      - name: Run PHPStan
        run: ./vendor/bin/phpstan analyse src
  
  security:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4
      
      - name: Run security checker
        uses: symfonycorp/security-checker-action@v5
```

### 5. Dependabot for Dependency Management

**.github/dependabot.yml**
```yaml
version: 2
updates:
  - package-ecosystem: "composer"
    directory: "/"
    schedule:
      interval: "weekly"
    open-pull-requests-limit: 10
```

### 6. Pull Request Templates

**.github/pull_request_template.md**
```markdown
## Description
<!-- Describe your changes -->

## Testing
- [ ] Unit tests added/updated
- [ ] Kernel tests added/updated
- [ ] Manual testing completed
- [ ] Code follows Drupal coding standards

## Checklist
- [ ] Tests pass locally
- [ ] PHPStan checks pass
- [ ] PHPCS checks pass
- [ ] Documentation updated
```

### 7. Using GitHub Copilot Workspace (if available)

For comprehensive module development:
1. **Plan features** using Copilot to break down tasks
2. **Generate implementation** with test coverage
3. **Review and iterate** with AI-assisted code reviews

## Implementation Steps

1. **Create test structure**: Set up the `tests/` directory with Unit, Kernel, and potentially Functional test subdirectories
2. **Add composer.json**: Include testing dependencies (PHPUnit, Coder, PHPStan)
3. **Set up GitHub Actions**: Create the workflow files above
4. **Write initial tests**: Use Copilot to help generate tests for existing functionality
5. **Enable branch protection**: Require tests to pass before merging PRs

## Directory Structure

```
uos-drupal-form-select-filter/
├── .github/
│   ├── workflows/
│   │   ├── test.yml
│   │   └── code-quality.yml
│   ├── dependabot.yml
│   └── pull_request_template.md
├── src/
├── tests/
│   ├── src/
│   │   ├── Unit/
│   │   ├── Kernel/
│   │   └── Functional/
├── composer.json
├── phpunit.xml.dist
├── phpstan.neon
└── uos_form_select_filter.module
```

## Testing Best Practices

1. **Test coverage**: Aim for at least 80% code coverage
2. **Test isolation**: Each test should be independent
3. **Meaningful assertions**: Use specific assertions rather than generic ones
4. **Mock external dependencies**: Don't rely on external services in tests
5. **Test edge cases**: Include tests for error conditions and boundary cases
6. **Keep tests maintainable**: Follow the same coding standards as production code

## Resources

- [Drupal PHPUnit documentation](https://www.drupal.org/docs/testing/phpunit-in-drupal)
- [GitHub Actions for PHP](https://docs.github.com/en/actions/automating-builds-and-tests/building-and-testing-php)
- [GitHub Copilot best practices](https://docs.github.com/en/copilot)
- [Drupal Coding Standards](https://www.drupal.org/docs/develop/standards)