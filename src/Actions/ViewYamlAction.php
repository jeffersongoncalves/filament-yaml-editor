<?php

namespace JeffersonGoncalves\FilamentYamlEditor\Actions;

use Closure;
use Filament\Actions\Action;
use Illuminate\Contracts\View\View;
use Symfony\Component\Yaml\Yaml;

class ViewYamlAction extends Action
{
    protected string|Closure|null $column = null;

    protected int $modalEditorHeight = 400;

    protected ?string $theme = null;

    public static function getDefaultName(): ?string
    {
        return 'view-yaml';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('View YAML');

        $this->icon('heroicon-o-code-bracket');

        $this->color('gray');

        $this->modalHeading(fn (): string => $this->getLabel());

        $this->modalSubmitAction(false);

        $this->modalCancelActionLabel('Close');

        $this->modalContent(function ($record): ?View {
            $column = $this->evaluate($this->column);

            if ($column === null) {
                return null;
            }

            $state = data_get($record, $column);

            if (blank($state)) {
                return null;
            }

            $yaml = is_array($state) ? Yaml::dump($state, 4, 2) : (string) $state;

            /** @var view-string $viewName */
            $viewName = 'filament-yaml-editor::actions.view-yaml';

            return view($viewName, [
                'yaml' => $yaml,
                'height' => $this->modalEditorHeight,
                'theme' => $this->theme ?? 'auto',
            ]);
        });
    }

    public function column(string|Closure $column): static
    {
        $this->column = $column;

        return $this;
    }

    public function editorHeight(int $height): static
    {
        $this->modalEditorHeight = $height;

        return $this;
    }

    public function dark(): static
    {
        $this->theme = 'dark';

        return $this;
    }

    public function light(): static
    {
        $this->theme = 'light';

        return $this;
    }
}
