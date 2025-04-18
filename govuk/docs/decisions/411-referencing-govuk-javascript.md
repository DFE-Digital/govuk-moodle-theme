# Referencing the GOV.UK Design System JavaScript file in the GOV.UK Moodle Theme

## Context and Problem Statement

When implementing the [GOV.UK Design System](https://design-system.service.gov.uk/) for the [GOV.UK Moodle Theme](https://github.com/DFE-Digital/govuk-moodle-theme) we needed to reference various files from the [GOV.UK Frontend NPM Package](https://www.npmjs.com/package/govuk-frontend). This included files such as the CSS, JavaScript, images, etc. The CSS and JavaScript files were needed for the GOV.UK components to have full functionality. The primary way these files are referenced in Moodle is by adding them to the correct directories in this project (`scss`/`style`/`javascript`) and adding the relevant config into the `config.php` file.

Referencing the CSS as described above works as expected. However, attempting to link the [GOV.UK Design System](https://design-system.service.gov.uk/) JavaScript file this way resulted in an error. After investigating we found that Moodle, or rather its JavaScript loading system RequireJS (AMD), does not fully support ECMAScript 6, more specifically ES6 modules (import/export).

The [GOV.UK Design System](https://design-system.service.gov.uk/) JavaScript file uses these modules. In order to successfully reference the JavaScript file we need to find an alternative way of linking to it.

## Considered Options

- Find an alternative way to link the Javascript file through Moodle
- Change the JavaScript file so that it doesn't use the Modules that Moodle doesn't support
- Link the JavaScript file directly in one of the Templates, bypassing Moodle

## Decision Outcome

Chosen option - Link the JavaScript file directly in one of the Templates, bypassing Moodle

We cannot use Moodle as it will always reference its internal JavaScript loading system, RequireJS (AMD), which will leave us with the exact same error. We cannot change the JavaScript file as we import this directly from the [GOV.UK Frontend NPM Package](https://www.npmjs.com/package/govuk-frontend). We need to be able to receive updates that are released, manually updating the file would block us from doing so. This leaves us with one option, manually link the JavaScript file directly in the HTML, bypassing Moodle and RequireJS (AMD). This lets the browser handle the ES Modules natively, which any modern brower can do
