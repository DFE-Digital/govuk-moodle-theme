# GOV.UK Moodle Theme
A GOV.UK Moodle theme implementing [GOV GDS](https://design-system.service.gov.uk/)

# Setup
To use this theme you need to copy the the `gov-uk` directory into your moodle sites theme folder `\my-moodle-site\public\theme`. Moodle will then detect the added theme when started. You will need to confirm the installation. Once installed you will be able to select the `GOV.UK` theme from the theme selection page.

# Releases
When pushing a version tag, a GitHub workflow executes creating a release and the associated artifacts. The trigger currently targets tags with the format "v[major].[minor].[patch]" and creates a release with the name "[major].[minor].[patch]". Release notes are automatically generated.