# Changelog

All notable changes to this project are documented here. The format follows
[Keep a Changelog](https://keepachangelog.com/en/1.1.0/) and the project uses
[semantic versioning](https://semver.org/).

## [Unreleased]

### Added
- MIT license, `LICENSE`, `composer.json` and the `config.xml` manifest (only the Polish one existed).
- English and Polish translation catalogues (`Modules.M4pdiscountsproducts.Admin`).
- `index.php` guards in every directory.

### Fixed
- Saving a product from a screen without the volume pricing form no longer wipes its rule: the hook
  now returns early when the form was not submitted.

### Changed
- Back-office and template strings now go through the new translation system instead of
  `$this->l()` and `{l s=… mod=…}`.
- Declared PrestaShop compatibility from 1.7.6 and `need_instance`.

## [1.0.0] — 2025-10-08

### Added
- First release: per-product volume pricing with a pack threshold, a discount per pack and a floor
  price.
