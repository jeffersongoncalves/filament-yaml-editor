## Filament YAML Editor

A YAML editor field for Filament v3 powered by CodeMirror 6 with syntax highlighting, linting, toolbar, and auto-formatting.

### Components

- **YamlEditorField** — Form field with CodeMirror 6 editor for YAML content.
- **YamlEditorEntry** — Infolist entry for read-only YAML display.
- **ViewYamlAction** — Table action to view YAML content in a modal (extends `Filament\Tables\Actions\Action`).
- **YamlCast** — Eloquent cast to store YAML as text and retrieve as array.
- **ValidYaml** — Validation rule for YAML syntax.

### Namespace

@verbatim
<code-snippet name="Namespace" lang="php">
use JeffersonGoncalves\FilamentYamlEditor\Forms\Components\YamlEditorField;
use JeffersonGoncalves\FilamentYamlEditor\Infolists\Components\YamlEditorEntry;
use JeffersonGoncalves\FilamentYamlEditor\Actions\ViewYamlAction;
use JeffersonGoncalves\FilamentYamlEditor\Casts\YamlCast;
use JeffersonGoncalves\FilamentYamlEditor\Rules\ValidYaml;
</code-snippet>
@endverbatim

### Quick Usage

@verbatim
<code-snippet name="Form field" lang="php">
YamlEditorField::make('config')
    ->height(400)
    ->withToolbar()
    ->castState()       // Auto-converts array ↔ YAML string
    ->autoFormat()
    ->rules(['yaml'])   // Validates YAML syntax
</code-snippet>
@endverbatim

@verbatim
<code-snippet name="Infolist entry" lang="php">
YamlEditorEntry::make('config')
    ->height(300)
</code-snippet>
@endverbatim

@verbatim
<code-snippet name="Table action" lang="php">
// ViewYamlAction extends Filament\Tables\Actions\Action in v3
ViewYamlAction::make()
    ->column('config')
    ->editorHeight(500)
</code-snippet>
@endverbatim

### Eloquent Cast

@verbatim
<code-snippet name="Model cast" lang="php">
use JeffersonGoncalves\FilamentYamlEditor\Casts\YamlCast;

protected function casts(): array
{
    return [
        'config' => YamlCast::class,
    ];
}
</code-snippet>
@endverbatim

### Conventions

- Use `castState()` when storing YAML in a JSON/array column — it handles array ↔ YAML string conversion automatically.
- Use `->rules(['yaml'])` to validate YAML syntax — the package auto-replaces the `yaml` string rule with `ValidYaml`.
- Use `withToolbar()` to enable the toolbar with format, copy, and expand buttons.
- Theme methods `dark()` and `light()` force a specific theme; omit them for auto-detection.
- The `readOnly()` method on `YamlEditorField` disables editing via Filament's `isDisabled` mechanism.
- **Important**: `ViewYamlAction` extends `Filament\Tables\Actions\Action` (not `Filament\Actions\Action`) — use it only in table contexts.

### Requirements

- PHP ^8.2
- Filament ^3.0
- symfony/yaml ^6.4|^7.0|^8.0
