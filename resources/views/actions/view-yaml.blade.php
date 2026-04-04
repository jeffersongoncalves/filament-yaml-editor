<div
    x-load
    x-load-src="{{ \Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('yaml-editor', 'jeffersongoncalves/filament-yaml-editor') }}"
    x-data="yamlEditor({
        state: @js($yaml),
        readOnly: true,
        height: @js($height),
        toolbar: false,
        theme: @js($theme),
        autoFormat: false,
    })"
    x-ref="root"
    class="yaml-editor-wrapper"
>
    <div x-ref="editor" class="yaml-editor-container" style="min-height: {{ $height }}px"></div>
</div>
