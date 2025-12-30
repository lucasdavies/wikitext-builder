# WikitextBuilder

A PHP library for building MediaWiki wikitext markup programmatically.

## Requirements

- PHP 8.4 or higher

## Installation

Install via Composer:

```bash
composer require lucasdavies/wikitextbuilder
```

## Usage

### Basic Setup

```php
use LucasDavies\WikitextBuilder\Builder;

$builder = new Builder();
```

### Headings

Generate MediaWiki headings with the appropriate number of equals signs:

```php
$builder->heading('Section Title', 2); // ==Section Title==
$builder->heading('Subsection', 3);    // ===Subsection===
```

### Templates

Create MediaWiki templates with various formatting options:

```php
// Basic template
$builder->template('Citation needed');
// {{Citation needed}}

// Template with unnamed parameters
$builder->template('Convert')->params(['100', 'km', 'mi']);
// {{Convert|100|km|mi}}

// Template with named parameters
$builder->template('Infobox')
    ->params([
        'name' => 'Example',
        'type' => 'Sample'
    ]);
// {{Infobox|name=Example|type=Sample}}

// Multiline template
$builder->template('Infobox')
    ->multiline()
    ->params([
        'name' => 'Example',
        'type' => 'Sample'
    ]);
// {{Infobox
// |name=Example
// |type=Sample
// }}

// Multiline with spacing
$builder->template('Infobox')
    ->multiline()
    ->spaced()
    ->params([
        'name' => 'Example',
        'type' => 'Sample'
    ]);
// {{Infobox
// |name = Example
// |type = Sample
// }}

// Multiline with alignment
$builder->template('Infobox')
    ->multiline()
    ->aligned()
    ->params([
        'name' => 'Example',
        'description' => 'A longer parameter'
    ]);
// {{Infobox
// |name        = Example
// |description = A longer parameter
// }}
```

Alternatively you can build templates by using the component classes directly and calling the `render()` method:

```php
use LucasDavies\WikitextBuilder\Components\Template;

$template = new Template('Citation needed');
echo $template->render();
```
Outputs:
```text
{{Citation needed}}
```

### Tables

Build MediaWiki tables with headers, body rows, captions, and styling:

```php
$builder->table(function (Table $table) {
    return $table
        ->caption('Example Table')
        ->headerRow(['Column 1', 'Column 2', 'Column 3'])
        ->bodyRow(['Value 1', 'Value 2', 'Value 3'])
        ->bodyRow(['Value 4', 'Value 5', 'Value 6']);
});
```
Outputs:
```text
{| class="wikitable"
|+ Example Table
|-
!Column 1!!Column 2!!Column 3
|-
|Value 1||Value 2||Value 3
|-
|Value 4||Value 5||Value 6
|}
```

#### Table Styling

```php
$builder->table(function (Table $table) {
    return $table
        ->styles(['width' => '100%', 'margin' => 'auto'])
        ->classes(['sortable', 'collapsible'])
        ->headerRow(['Name', 'Age', 'City'])
        ->bodyRow(['Alice', '30', 'New York']);
});
```
Outputs:
```text
{| class="wikitable sortable collapsible" style="width:100%;margin:auto"
|-
!Name!!Age!!City
|-
|Alice||30||New York
|}
```

Alternatively, like templates, you can build tables by using the component classes directly and calling the `render()` method:

```php
use LucasDavies\WikitextBuilder\Components\Table;

echo new Table()
    ->styles(['width' => '100%', 'margin' => 'auto'])
    ->classes(['sortable', 'collapsible'])
    ->headerRow(new TableHeaderRow(['Name', 'Age', 'City']))
    ->bodyRow(new TableBodyRow(['Alice', '30', 'New York']))
    ->render();
```
Outputs:
```text
{| class="wikitable sortable collapsible" style="width:100%;margin:auto"
|-
!Name!!Age!!City
|-
|Alice||30||New York
|}
```

## Testing

Run the test suite:

```bash
composer test
```

Or with PHPUnit directly:

```bash
./vendor/bin/phpunit
```

## License

MIT License. See [LICENSE](LICENSE) for details.
