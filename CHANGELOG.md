# Changelog

All notable changes to `filament-yaml-editor` will be documented in this file.

## 2.0.4 - 2026-04-04

### Bug Fix

- Remove unnecessary textarea that was visible on form pages

## 2.0.3 - 2026-04-04

### Bug Fix

- Fix Alpine component not loading: use `x-load` / `x-load-src` instead of `ax-load` / `ax-load-src`

## 2.0.2 - 2026-04-04

### Changes

- Migrate build to bin/build.js following Filament plugin skeleton pattern
- Add npm-run-all2 for parallel build scripts
- PostCSS config migrated to ESM

## 2.0.1 - 2026-04-03

### Changes

- Replace YamlEditorColumn with ViewYamlAction (table action with modal)
- Add GitHub Actions workflows (Pint, PHPStan, Tests, Changelog)
- Add project banner to README
- Add FUNDING.yml for GitHub Sponsors
