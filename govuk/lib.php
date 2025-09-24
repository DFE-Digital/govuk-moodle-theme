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

/**
 * Main SCSS - add GOV.UK to boost
 */
function theme_govuk_get_main_scss_content($theme): string {
    $scss = theme_boost_get_main_scss_content($theme);

    $govuk = @file_get_contents(__DIR__ . '/scss/govuk.scss') ?: '';
    return $scss . "\n" . $govuk;
}

/**
 * SCSS to prepend (variables before Bootstrap/GOV.UK compile)
 */
function theme_govuk_get_pre_scss($theme): string {
    $scss = theme_boost_get_pre_scss($theme);
    // E.g. 
    // $scss .= "\n" . '$govuk-assets-path: "/theme/image.php/govuk/theme/1/";';
    return $scss;
}

/**
 * SCSS to append (after main bundle)
 */
function theme_govuk_get_extra_scss($theme): string {
    $scss = theme_boost_get_extra_scss($theme);
    // E.g.
    // $extra = @file_get_contents(__DIR__ . '/scss/extra.scss') ?: '';
    // return $scss . "\n" . $extra;
    return $scss;
}