<div class="filament-hidden">

![Filament YAML Editor](https://raw.githubusercontent.com/jeffersongoncalves/filament-yaml-editor/3.x/art/jeffersongoncalves-filament-yaml-editor.jpg)

</div>

# Filament YAML Editor

A rich YAML editor field for [Filament](https://filamentphp.com) powered by [CodeMirror 6](https://codemirror.net/) with syntax highlighting, real-time linting, toolbar, and fullscreen support.

## Version Compatibility

| Branch | Filament | Laravel | PHP |
|--------|----------|---------|-----|
| `1.x`  | v3       | 10+     | 8.2+ |
| `2.x`  | v4       | 11+     | 8.2+ |
| `3.x`  | v5       | 11.28+  | 8.2+ |

## Installation

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
| `->castState()` | Convert YAML ↔ array on hydrate/dehydrate | `false` |
| `->rules(['yaml'])` | Add server-side YAML validation | — |
| `->placeholder(string)` | Placeholder text | `null` |
| `->dark()` | Force dark theme | auto |
| `->light()` | Force light theme | auto |
| `->autoFormat()` | Auto-format on blur | `false` |

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

Use the `ViewYamlAction` to add a button in your table that opens a modal with the YAML content in a read-only CodeMirror editor.

```php
use JeffersonGoncalves\FilamentYamlEditor\Actions\ViewYamlAction;

// In your table's actions (Filament v4/v5)
->recordActions([
    ViewYamlAction::make()
        ->column('config')       // required: the model attribute to display
        ->editorHeight(500)      // optional, default 400
        ->dark(),                // optional
])

// In Filament v3
->actions([
    ViewYamlAction::make()
        ->column('config'),
])
```

### Infolist Entry

Displays YAML content in a read-only CodeMirror editor.

```php
use JeffersonGoncalves\FilamentYamlEditor\Infolists\Components\YamlEditorEntry;

YamlEditorEntry::make('config')
    ->height(400)
    ->dark()
```

### Eloquent Cast

Use the `YamlCast` to automatically convert between YAML strings and arrays in your models:

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

- **CodeMirror 6** — Modern editor with syntax highlighting for YAML
- **Real-time linting** — Client-side YAML validation with inline error markers
- **Server-side validation** — `ValidYaml` rule using `symfony/yaml`
- **Toolbar** — Format, copy to clipboard, fullscreen toggle
- **Theme support** — Auto-detects system/Filament dark mode, or force with `->dark()` / `->light()`
- **Bidirectional sync** — Full Livewire `$entangle` support with `wire:ignore`
- **Cast support** — `YamlCast` for Eloquent models, `castState()` for form fields
- **Table action** — View YAML content in a modal with syntax highlighting
- **Infolist entry** — Read-only YAML display for infolists
- **Mobile friendly** — Safe area insets for fullscreen mode

## Testing

```bash
composer test
```

## Code Quality

```bash
composer analyse   # PHPStan
composer format    # Laravel Pint
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
