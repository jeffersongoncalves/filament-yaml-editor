@php
    $height = $getHeight();
    $theme = $getTheme();
    $state = $getFormattedState();
@endphp

<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
    <div
        x-load
        x-load-src="{{ \Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('yaml-editor', 'jeffersongoncalves/filament-yaml-editor') }}"
        x-data="yamlEditor({
            state: @js($state),
            readOnly: true,
            height: @js($height),
            toolbar: false,
            theme: @js($theme ?? 'auto'),
            autoFormat: false,
        })"
        x-ref="root"
        wire:ignore
        class="yaml-editor-wrapper"
    >
        <div x-ref="editor" class="yaml-editor-container" style="min-height: {{ $height }}px"></div>
    </div>
</x-dynamic-component>
