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
 * This file has been copied from the `theme_boost` package and modified
 */

defined('MOODLE_INTERNAL') || die();

require_once $CFG->libdir . '/behat/lib.php';
require_once $CFG->dirroot . '/course/lib.php';

// Add block button in editing mode.
$addblockbutton = $OUTPUT->addblockbutton();

if (isloggedin()) {
    $courseindexopen = get_user_preferences('drawer-open-index', true) == true;
    $blockdraweropen = get_user_preferences('drawer-open-block') == true;
} else {
    $courseindexopen = false;
    $blockdraweropen = false;
}

if (
    defined('BEHAT_SITE_RUNNING') &&
    get_user_preferences('behat_keep_drawer_closed') != 1
) {
    $blockdraweropen = true;
}

$extraclasses = ['uses-drawers'];
if ($courseindexopen) {
    $extraclasses[] = 'drawer-open-index';
}

$blockshtml = $OUTPUT->blocks('side-pre');
$hasblocks =
    strpos($blockshtml, 'data-block=') !== false || !empty($addblockbutton);
if (!$hasblocks) {
    $blockdraweropen = false;
}
$courseindex = core_course_drawer();
if (!$courseindex) {
    $courseindexopen = false;
}

$bodyattributes = $OUTPUT->body_attributes($extraclasses);
$forceblockdraweropen = $OUTPUT->firstview_fakeblocks();

$secondarynavigation = false;
$overflow = '';
if ($PAGE->has_secondary_navigation()) {
    $tablistnav = $PAGE->has_tablist_secondary_navigation();
    $moremenu = new \core\navigation\output\more_menu(
        $PAGE->secondarynav,
        'nav-tabs',
        true,
        $tablistnav,
    );
    $secondarynavigation = $moremenu->export_for_template($OUTPUT);
    $overflowdata = $PAGE->secondarynav->get_overflow_menu_data();
    if (!is_null($overflowdata)) {
        $overflow = $overflowdata->export_for_template($OUTPUT);
    }
}

$primary = new core\navigation\output\primary($PAGE);
$renderer = $PAGE->get_renderer('core');
$primarymenu = $primary->export_for_template($renderer);
$buildregionmainsettings =
    !$PAGE->include_region_main_settings_in_header_actions() &&
    !$PAGE->has_secondary_navigation();
// If the settings menu will be included in the header then don't add it here.
$regionmainsettingsmenu = $buildregionmainsettings
    ? $OUTPUT->region_main_settings_menu()
    : false;

$header = $PAGE->activityheader;
$headercontent = $header->export_for_template($renderer);

$templatecontext = [
    'sitename' => format_string($SITE->shortname, true, [
        'context' => context_course::instance(SITEID),
        'escape' => false,
    ]),
    'output' => $OUTPUT,
    'sidepreblocks' => $blockshtml,
    'hasblocks' => $hasblocks,
    'bodyattributes' => $bodyattributes,
    'courseindexopen' => $courseindexopen,
    'blockdraweropen' => $blockdraweropen,
    'courseindex' => $courseindex,
    'primarymoremenu' => $primarymenu['moremenu'],
    'secondarymoremenu' => $secondarynavigation ?: false,
    'mobileprimarynav' => $primarymenu['mobileprimarynav'],
    'usermenu' => $primarymenu['user'],
    'langmenu' => $primarymenu['lang'],
    'forceblockdraweropen' => $forceblockdraweropen,
    'regionmainsettingsmenu' => $regionmainsettingsmenu,
    'hasregionmainsettingsmenu' => !empty($regionmainsettingsmenu),
    'overflow' => $overflow,
    'headercontent' => $headercontent,
    'addblockbutton' => $addblockbutton,

    'faviconsvg' => $OUTPUT
        ->image_url('rebrand/images/favicon', 'theme_govuk')
        ->out(false),
    'maskicon' => $OUTPUT
        ->image_url('rebrand/images/govuk-icon-mask', 'theme_govuk')
        ->out(false),
    'appleicon' => $OUTPUT
        ->image_url('rebrand/images/govuk-icon-180', 'theme_govuk')
        ->out(false),
    'manifest' => $CFG->wwwroot . '/theme/govuk/pix/rebrand/manifest.json',
    'ogimage' => $OUTPUT
        ->image_url('rebrand/images/govuk-opengraph-image', 'theme_govuk')
        ->out(false),
];

echo $OUTPUT->render_from_template('theme_boost/drawers', $templatecontext);
