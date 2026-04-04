---
name: yaml-editor-development
description: Build and work with Filament YAML Editor features, including form fields, infolist entries, table actions, Eloquent casts, and validation.
---

# YAML Editor Development

## When to use this skill

Use this skill when:
- Adding a YAML editor field to a Filament form
- Displaying YAML content in an infolist
- Creating a table action to view YAML in a modal
- Storing YAML data in Eloquent models
- Validating YAML input

## Core Components

### YamlEditorField (Form Field)

Full-featured CodeMirror 6 editor for YAML content in Filament forms.

```php
use JeffersonGoncalves\FilamentYamlEditor\Forms\Components\YamlEditorField;

YamlEditorField::make('config')
    ->height(400)              // Editor height in pixels (default: 300)
    ->minLines(10)             // Minimum number of lines
    ->withToolbar()            // Enable toolbar (format, copy, expand)
    ->castState()              // Auto-convert between array and YAML string
    ->autoFormat()             // Auto-format YAML on load
    ->readOnly()               // Disable editing
    ->dark()                   // Force dark theme
    ->light()                  // Force light theme
    ->rules(['yaml'])          // Validate YAML syntax
    ->required()
```

#### API Reference

| Method | Signature | Description |
|--------|-----------|-------------|
| `height()` | `int\|Closure` | Editor height in pixels (default: 300) |
| `minLines()` | `int\|Closure\|null` | Minimum number of visible lines |
| `withToolbar()` | `bool\|Closure` | Show toolbar with format/copy/expand buttons |
| `castState()` | `bool\|Closure` | Auto-convert array ↔ YAML string |
| `autoFormat()` | `bool\|Closure` | Auto-format YAML content on hydration |
| `readOnly()` | `bool\|Closure` | Make editor read-only |
| `dark()` | — | Force dark theme |
| `light()` | — | Force light theme |
| `rules()` | `string\|array\|Closure` | Accepts `'yaml'` to auto-apply `ValidYaml` rule |

#### castState() Behavior

When `castState()` is enabled:
- **Hydration**: If the state is an array, it's converted to a YAML string using `Yaml::dump($state, 4, 2)`
- **Dehydration**: If the state is a YAML string, it's parsed back to an array using `Yaml::parse($state)`

This is useful when the database column stores JSON/array data but you want the user to edit it as YAML.

### YamlEditorEntry (Infolist Entry)

Read-only YAML display for Filament infolists.

```php
use JeffersonGoncalves\FilamentYamlEditor\Infolists\Components\YamlEditorEntry;

YamlEditorEntry::make('config')
    ->height(300)    // Editor height in pixels (default: 300)
    ->dark()         // Force dark theme
    ->light()        // Force light theme
```

The entry automatically handles both array and string states — arrays are dumped to YAML using `Yaml::dump($state, 4, 2)`.

### ViewYamlAction (Table/Page Action)

Modal action to view YAML content from a record.

```php
use JeffersonGoncalves\FilamentYamlEditor\Actions\ViewYamlAction;

// In a Filament table or page
ViewYamlAction::make()
    ->column('config')        // Required: the model attribute to display
    ->editorHeight(500)       // Modal editor height (default: 400)
    ->dark()                  // Force dark theme
    ->light()                 // Force light theme
```

**Important**: The `column()` method is required — it specifies which model attribute contains the YAML data. Supports dot notation via `data_get()`.

### YamlCast (Eloquent Cast)

Eloquent cast that stores YAML as text in the database and retrieves it as a PHP array.

```php
use JeffersonGoncalves\FilamentYamlEditor\Casts\YamlCast;

class Server extends Model
{
    protected function casts(): array
    {
        return [
            'config' => YamlCast::class,
        ];
    }
}

// Usage
$server->config = ['key' => 'value'];  // Stored as YAML text
$server->config;                        // Returns array
```

**Behavior**:
- `get()`: Parses YAML string → array (returns `null` for null/empty)
- `set()`: Dumps array → YAML string using `Yaml::dump($value, 4, 2)` (returns `null` for null)

### ValidYaml (Validation Rule)

Validation rule that checks if a string contains valid YAML.

```php
use JeffersonGoncalves\FilamentYamlEditor\Rules\ValidYaml;

// Standalone usage
$request->validate([
    'config' => ['required', new ValidYaml],
]);

// In YamlEditorField (auto-applied)
YamlEditorField::make('config')
    ->rules(['yaml'])  // 'yaml' string is auto-replaced with ValidYaml instance
```

The rule skips validation for non-string or blank values. Error messages include the YAML parse error details.

### Validator Extension

The package also registers a `yaml` validator extension globally:

```php
// Works in any validation context
$request->validate([
    'config' => 'required|yaml',
]);
```

## Common Patterns

### Pattern 1: YAML Config Editor with Validation

```php
use JeffersonGoncalves\FilamentYamlEditor\Forms\Components\YamlEditorField;

public static function form(Form $form): Form
{
    return $form->schema([
        YamlEditorField::make('config')
            ->label('Server Configuration')
            ->height(500)
            ->withToolbar()
            ->castState()
            ->autoFormat()
            ->rules(['required', 'yaml'])
            ->columnSpanFull(),
    ]);
}
```

### Pattern 2: Read-Only YAML Display in Infolist

```php
use JeffersonGoncalves\FilamentYamlEditor\Infolists\Components\YamlEditorEntry;

public static function infolist(Infolist $infolist): Infolist
{
    return $infolist->schema([
        YamlEditorEntry::make('config')
            ->label('Configuration')
            ->height(400)
            ->columnSpanFull(),
    ]);
}
```

### Pattern 3: View YAML in Table Action

```php
use JeffersonGoncalves\FilamentYamlEditor\Actions\ViewYamlAction;

public static function table(Table $table): Table
{
    return $table
        ->columns([...])
        ->actions([
            ViewYamlAction::make()
                ->column('config')
                ->editorHeight(500),
        ]);
}
```

### Pattern 4: Model with YAML Column

```php
use JeffersonGoncalves\FilamentYamlEditor\Casts\YamlCast;

class Pipeline extends Model
{
    protected function casts(): array
    {
        return [
            'steps' => YamlCast::class,
        ];
    }
}

// Migration
Schema::create('pipelines', function (Blueprint $table) {
    $table->id();
    $table->text('steps');  // Store YAML as text
    $table->timestamps();
});
```

### Pattern 5: Conditional Toolbar and Theme

```php
YamlEditorField::make('config')
    ->withToolbar(fn () => auth()->user()->isAdmin())
    ->height(fn () => auth()->user()->isAdmin() ? 600 : 300)
    ->readOnly(fn () => ! auth()->user()->can('edit-config'))
```

## Troubleshooting

### YAML validation passes but content is malformed

**Cause**: The `ValidYaml` rule only checks if `Yaml::parse()` succeeds — it does not validate structure or schema.

**Solution**: Add custom validation rules after `yaml` to check the parsed structure:

```php
YamlEditorField::make('config')
    ->rules(['yaml'])
    ->afterStateUpdated(function ($state) {
        $parsed = Yaml::parse($state);
        // Validate structure...
    })
```

### castState() returns empty array instead of null

**Cause**: When `castState()` is enabled and the input is an empty string, it returns `[]`.

**Solution**: This is by design. If you need `null` for empty values, handle it in `dehydrateStateUsing()` or use `nullable()`.

### Editor not rendering

**Cause**: Assets not published or Alpine component not loaded.

**Solution**: Ensure the package assets are registered. Run `php artisan filament:assets` to publish assets.
