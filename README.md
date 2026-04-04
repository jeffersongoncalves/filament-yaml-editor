<div class="filament-hidden">

![Filament YAML Editor](https://raw.githubusercontent.com/jeffersongoncalves/filament-yaml-editor/3.x/art/jeffersongoncalves-filament-yaml-editor.jpg)

</div>

# Filament YAML Editor

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jeffersongoncalves/filament-yaml-editor.svg?style=flat-square)](https://packagist.org/packages/jeffersongoncalves/filament-yaml-editor)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/jeffersongoncalves/filament-yaml-editor/tests.yml?branch=3.x&label=tests&style=flat-square)](https://github.com/jeffersongoncalves/filament-yaml-editor/actions?query=workflow%3Atests+branch%3A3.x)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/jeffersongoncalves/filament-yaml-editor/fix-php-code-style-issues.yml?branch=3.x&label=code%20style&style=flat-square)](https://github.com/jeffersongoncalves/filament-yaml-editor/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3A3.x)
[![Total Downloads](https://img.shields.io/packagist/dt/jeffersongoncalves/filament-yaml-editor.svg?style=flat-square)](https://packagist.org/packages/jeffersongoncalves/filament-yaml-editor)

A rich YAML editor field for [Filament](https://filamentphp.com) powered by [CodeMirror 6](https://codemirror.net/) with syntax highlighting, real-time linting, toolbar, and fullscreen support.

## Version Compatibility

| Branch | Filament | Laravel | PHP |
|--------|----------|---------|-----|
| `1.x`  | v3       | 10+     | 8.2+ |
| `2.x`  | v4       | 11+     | 8.2+ |
| `3.x`  | v5       | 11.28+  | 8.2+ |

## Installation

Install the package via Composer:

```bash
composer require jeffersongoncalves/filament-yaml-editor
```

Publish the assets:

```bash
php artisan filament:assets
```

Optionally publish the config file:

```bash
php artisan vendor:publish --tag=filament-yaml-editor-config
```

## Usage

### Form Field

```php
use JeffersonGoncalves\FilamentYamlEditor\Forms\Components\YamlEditorField;

YamlEditorField::make('config')
    ->withToolbar()
    ->rules(['yaml'])
```

### Fluent API

| Method | Description | Default |
|--------|-------------|---------|
| `->height(int $px)` | Editor height in pixels | `300` |
| `->minLines(int $lines)` | Minimum visible lines | `null` |
| `->readOnly()` | Read-only mode | `false` |
| `->withToolbar()` | Enable toolbar (format, copy, fullscreen) | `false` |
| `->castState()` | Convert YAML to array on dehydrate, array to YAML on hydrate | `false` |
| `->rules(['yaml'])` | Add server-side YAML validation via `ValidYaml` rule | — |
| `->placeholder(string)` | Placeholder text | `null` |
| `->dark()` | Force dark theme | auto |
| `->light()` | Force light theme | auto |
| `->autoFormat()` | Auto-format YAML on blur | `false` |

### Full Example

```php
YamlEditorField::make('config')
    ->height(400)
    ->withToolbar()
    ->castState()
    ->autoFormat()
    ->dark()
    ->rules(['yaml'])
    ->placeholder("# paste your YAML here\n")
```

### Table Action (View YAML in Modal)

Use the `ViewYamlAction` to add a button in your table that opens a modal with the YAML content displayed in a read-only CodeMirror editor.

```php
use JeffersonGoncalves\FilamentYamlEditor\Actions\ViewYamlAction;
```

**Filament v4 / v5 (branches `2.x` and `3.x`):**

```php
->recordActions([
    ViewYamlAction::make()
        ->column('config')       // required: the model attribute to display
        ->editorHeight(500)      // optional, default 400
        ->dark(),                // optional
])
```

**Filament v3 (branch `1.x`):**

```php
->actions([
    ViewYamlAction::make()
        ->column('config'),
])
```

| Method | Description | Default |
|--------|-------------|---------|
| `->column(string)` | Model attribute containing YAML data (required) | — |
| `->editorHeight(int $px)` | Editor height inside the modal | `400` |
| `->dark()` | Force dark theme | auto |
| `->light()` | Force light theme | auto |

### Infolist Entry

Displays YAML content in a read-only CodeMirror editor.

```php
use JeffersonGoncalves\FilamentYamlEditor\Infolists\Components\YamlEditorEntry;

YamlEditorEntry::make('config')
    ->height(400)
    ->dark()
```

### Eloquent Cast

Use the `YamlCast` to automatically convert between YAML strings and arrays in your Eloquent models:

```php
use JeffersonGoncalves\FilamentYamlEditor\Casts\YamlCast;

class Setting extends Model
{
    protected $casts = [
        'config' => YamlCast::class,
    ];
}
```

### Validation Rule

Use the `ValidYaml` rule directly or via the `yaml` string alias:

```php
use JeffersonGoncalves\FilamentYamlEditor\Rules\ValidYaml;

// As a rule object
$request->validate([
    'config' => ['required', new ValidYaml],
]);

// As a string alias (registered by the service provider)
$request->validate([
    'config' => ['required', 'yaml'],
]);
```

## Features

- **CodeMirror 6** — Modern editor with syntax highlighting, line numbers, and bracket matching for YAML
- **Real-time linting** — Client-side YAML validation via `js-yaml` with inline error markers
- **Server-side validation** — `ValidYaml` rule using `symfony/yaml`
- **Toolbar** — Format (pretty-print), copy to clipboard, fullscreen toggle
- **Theme support** — Auto-detects Filament dark mode and system `prefers-color-scheme`, or force with `->dark()` / `->light()`
- **Bidirectional sync** — Full Livewire `$entangle` support with `wire:ignore` for seamless form integration
- **Cast support** — `YamlCast` for Eloquent models, `->castState()` for form field hydration/dehydration
- **Table action** — `ViewYamlAction` opens a modal with read-only syntax-highlighted YAML
- **Infolist entry** — `YamlEditorEntry` for read-only YAML display in resource view pages
- **Fullscreen mode** — Full-screen editing with mobile safe-area insets
- **No Tailwind dependency** — CSS built with PostCSS (autoprefixer + cssnano), works in any Filament panel

## Building Assets

The package ships with pre-compiled assets in `resources/dist/`. To rebuild after modifying JS or CSS sources:

```bash
pnpm install
pnpm build
```

For development with watch mode:

```bash
pnpm dev
```

## Testing

```bash
composer test
```

## Code Quality

```bash
composer analyse   # PHPStan level 5
composer format    # Laravel Pint
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
