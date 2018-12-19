# Cybersecuritytech WordPress Theme

Built using [Sage v9.0.5](https://roots.io/sage/) starter theme. Read the [docs](https://roots.io/sage/docs/theme-installation/) and check [GitHub](https://github.com/roots/sage) for more info on Sage.

## Development

- Install the site locally under http://cybersecuritytech.local.
- Clone repo under `wp-content/themes/cybersecuritytech`.
- Install dependencies. `yarn` or `npm install`.
- Start watch mode using `yarn start` or `npm start`.

Styles are under `resources/assets/styles`.

Scripts are under `resources/assets/scripts`.

## Blade

The theme uses [Blade](https://laravel.com/docs/5.6/blade) templating. Learn its syntax and how to use it.

## Versioning

The build script generates a `version.json` file with the current date. The enqueue process will read this value and pass it as version string to invalidate cache for CSS and JS after each build.

## ACF

The theme is configured to use [acf-json](https://www.advancedcustomfields.com/resources/local-json/).

The theme hides the ACF admin page from environments not running under `.local`. Only change and save the custom fields locally. On production and staging environments it will read ACF data from disk since they should never be customized in the database.

## PHP

Don't place your custom PHP code in `resources/functions.php`. Instead customize the code under `app`. Either create new files or update the existing ones.

## Theme Options

There are theme settings pages created. Created new sub-pages instead of placing all options in the same page then create custom fields groups for each sub-page.

## Dynamic Template

Organize the development of the design into sections (strips). Each section should be small and we should be able to add it to any page.

To accomplish this we use a template called "Dynamic" and a special set of custom fiels groups.

- `Section: ...`: separate custom field group for each section with the fields appropriate for it. Each group should be set as inactive so it doesn't show in any page.
- `Partial: Sections`: the custom field group where the sections are added. Composed of a single Flexible Content field. For each section add a new entry and clone the field group for the section.
- `Template: Dynamic`: the custom field group for the Dynamic template. In here we only need to clone the `Partials: Sections` group. No changes should be needed to this template.

Create new `Section: ...` as required. Sometimes you should also create new `Partial: ...` groups for special components that are repeated in many sections (e.g. custom settings for buttons).

The Dynamic template will read the sections and load the appropriate view under `resources/views/sections` based on the layout name.