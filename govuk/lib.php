<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Theme functions.
 *
 * @package    theme_govuk
 * @copyright  Copyright (c) Crown Copyright (Department for Education)
 * @license    https://www.nationalarchives.gov.uk/doc/open-government-licence/version/3/ Open Government Licence v3.0
 */

// This line protects the file from being accessed by a URL directly.                                                               
defined('MOODLE_INTERNAL') || die();

function theme_govuk_get_main_scss_content($theme) {
    global $CFG;
    $scss = '';

    // Include the parent theme's SCSS
    $scss .= file_get_contents($CFG->dirroot . '/theme/boost/scss/preset/default.scss');

    // Include your govuk SCSS
    $custom_scss_path = $CFG->dirroot . '/theme/govuk/scss/govuk.scss';
    if (file_exists($custom_scss_path)) {
        $scss .= file_get_contents($custom_scss_path);
    }

    return $scss;
}