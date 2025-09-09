<?php

class theme_govuk_core_renderer extends core_renderer
{
    public function logout_endpoint()
    {
        global $USER;

        if (!isloggedin() || isguestuser()) {
            return '';
        }

        $logouturl = new \moodle_url('/login/logout.php', [
            'sesskey' => sesskey(),
        ]);
        return $logouturl->out(false);
    }

    public function body_attributes($additionalclasses = [])
    {
        $attributes = parent::body_attributes($additionalclasses);

        // Add your custom class
        $attributes = preg_replace(
            '/class="([^"]*)"/',
            'class="$1 govuk-template__body"',
            $attributes,
        );

        return $attributes;
    }

    /**
     * See if this is the first view of the current cm in the session if it has fake blocks.
     *
     * (We track up to 100 cms so as not to overflow the session.)
     * This is done for drawer regions containing fake blocks so we can show blocks automatically.
     *
     * @return boolean true if the page has fakeblocks and this is the first visit.
     */
    public function firstview_fakeblocks(): bool
    {
        global $SESSION;

        $firstview = false;
        if ($this->page->cm) {
            if (!$this->page->blocks->region_has_fakeblocks('side-pre')) {
                return false;
            }
            if (!property_exists($SESSION, 'firstview_fakeblocks')) {
                $SESSION->firstview_fakeblocks = [];
            }
            if (
                array_key_exists(
                    $this->page->cm->id,
                    $SESSION->firstview_fakeblocks,
                )
            ) {
                $firstview = false;
            } else {
                $SESSION->firstview_fakeblocks[$this->page->cm->id] = true;
                $firstview = true;
                if (count($SESSION->firstview_fakeblocks) > 100) {
                    array_shift($SESSION->firstview_fakeblocks);
                }
            }
        }
        return $firstview;
    }

    /** Hide breadcrumbs on pages within a course */
    public function navbar(): string {
        if ($this->page->context && $this->page->context->get_course_context(false)) {
            return '';
        }
        return parent::navbar();
    }
}
