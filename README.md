# GOV.UK Moodle Theme

A GOV.UK Moodle theme implementing [GOV GDS](https://design-system.service.gov.uk/).

# Theme distribution

## Versioning

The [semantic versioning](https://semver.org/) standard will be implemented once the theme is sufficiently developed and relatively stable:

"Given a version number MAJOR.MINOR.PATCH, increment the

1. MAJOR version when you make incompatible API changes
2. MINOR version when you add functionality in a backward compatible manner
3. PATCH version when you make backward compatible bug fixes

Additional labels for pre-release and build metadata are available as extensions to the MAJOR.MINOR.PATCH format."

## Creating a release

The release.yml GitHub workflow should be used to create a release. To run the workflow, trigger it manually via the GitHub Actions UI and provide the version number as input, in the suggested format "[MAJOR].[MINOR].[PATCH]".
The workflow tags the latest commit on the main branch, archives the contents of the `govuk` folder, and creates a release which includes the created archive alongside the assets generated by default with a release. Release notes are auto-generated. Lightweight tags are used.

## Including the theme as part of Moodle

### Manual setup

To use this theme you need to copy the `govuk` directory from a release archive into your Moodle site's theme folder `\my-moodle-site\public\theme`. Moodle will then detect the added theme when started. You will need to confirm the installation. Once installed you will be able to select the `GOV.UK` theme from the theme selection page.

Please use the assets available as part of the existing versioned releases or create a new release.

### Automated setup

To use this theme as part of your Moodle deployment scripts, the download of the release archive must be automated as well as the steps described in the manual approach.

It is the responsibility of those using this theme to check regularly for updates and to implement new versions as required.

## Local Development

If this is the first time you are generating the css file locally, navigate to the `govuk` folder in the theme repo and run `npm install`. After you have made your changes in your local instance of Moodle you will need to compile the SCSS into CSS. To do this you can run the following command, again from the `govuk` folder: `npx sass scss/govuk.scss style/govuk.css`.  This will compile the SCSS from the `scss` folder in the `govuk.scss` file and place it in the `style` folder with the file name being `govuk.css`. The CSS must be in the style folder for Moodle to be able to find and reference it.
