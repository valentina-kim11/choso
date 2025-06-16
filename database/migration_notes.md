# Migration Notes

- `theme_mode` is stored as a separate record in the `settings` table (key: `theme_mode`) rather than as a dedicated column. The migration `2025_06_16_000007_add_theme_mode_to_settings_table.php` has been removed.
