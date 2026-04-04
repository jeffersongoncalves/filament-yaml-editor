# Changelog

All notable changes to `filament-yaml-editor` will be documented in this file.

## 1.0.2 - 2026-04-04

### Changes

- Migrate build to bin/build.js following Filament plugin skeleton pattern
- Add npm-run-all2 for parallel build scripts
- PostCSS config migrated to ESM

## 1.0.1 - 2026-04-03

### Changes

- Replace YamlEditorColumn with ViewYamlAction (table action with modal)
- ViewYamlAction uses Filament\Tables\Actions\Action namespace (v3)
- Add GitHub Actions workflows (Pint, PHPStan, Tests, Changelog)
- Add project banner to README
- Add FUNDING.yml for GitHub Sponsors
