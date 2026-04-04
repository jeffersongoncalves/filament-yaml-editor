@php
    $id = $getId();
    $height = $getHeight();
    $readOnly = $isReadOnly();
    $toolbar = $hasToolbar();
    $theme = $getTheme();
    $autoFormat = $shouldAutoFormat();
    $statePath = $getStatePath();
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div
        x-load
        x-load-src="{{ \Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('yaml-editor', 'jeffersongoncalves/filament-yaml-editor') }}"
        x-data="yamlEditor({
            state: $wire.{{ $applyStateBindingModifiers("\$entangle('{$statePath}')") }},
            readOnly: @js($readOnly),
            height: @js($height),
            toolbar: @js($toolbar),
            theme: @js($theme ?? 'auto'),
            autoFormat: @js($autoFormat),
        })"
        x-ref="root"
        wire:ignore
        class="yaml-editor-wrapper"
    >
        @if ($toolbar)
            <div class="yaml-editor-toolbar" x-show="!readOnly">
                <button type="button" x-on:click="format()" title="Format">
                    <x-filament::icon icon="heroicon-o-code-bracket" class="yaml-editor-toolbar-icon" />
                </button>
                <button type="button" x-on:click="copy()" title="Copy">
                    <x-filament::icon icon="heroicon-o-clipboard" class="yaml-editor-toolbar-icon" />
                </button>
                <button type="button" x-on:click="toggleFullscreen()" title="Fullscreen">
                    <x-filament::icon icon="heroicon-o-arrows-pointing-out" class="yaml-editor-toolbar-icon" />
                </button>
            </div>
        @endif

        <div x-ref="editor" class="yaml-editor-container" style="min-height: {{ $height }}px"></div>
    </div>
</x-dynamic-component>
