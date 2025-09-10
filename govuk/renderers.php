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
    public function navbar(): string
    {
        if (
            $this->page->context &&
            $this->page->context->get_course_context(false)
        ) {
            return '';
        }
        return parent::navbar();
    }

    /**
     * Override to change content used to render the sticky footer template
     * on the add entry page for database activities (mod/data/edit.php)
     *
     * @param \core\output\sticky_footer $footer
     * @return string
     */
    protected function render_sticky_footer(\core\output\sticky_footer $footer): string
    {
        $data = $footer->export_for_template($this);

        $isdataedit = ($this->page->pagetype === 'mod-data-edit');
        $rid = optional_param('rid', 0, PARAM_INT);
        $isadd = ($rid == 0);

        if ($isdataedit && $isadd) {
            // include cancel and save buttons
            $backto = optional_param('backto', '', PARAM_LOCALURL);
            if (!empty($backto)) {
                $cmid = $this->page->cm ? $this->page->cm->id : optional_param('id', 0, PARAM_INT);
                $cancelurl = new \moodle_url('/mod/data/view.php', ['id' => $cmid]);
            }
            $data['stickycontent'] = html_writer::link(
                $cancelurl,
                get_string('cancel'),
                ['class' => 'btn btn-secondary mx-1', 'role' => 'button']
            );
            $data['stickycontent'] .= html_writer::empty_tag('input', [
                'type' => 'submit',
                'name' => 'saveandview',
                'value' => get_string('save'),
                'class' => 'btn btn-primary mx-1'
            ]);
        }

        return $this->render_from_template('core/sticky_footer', $data);
    }
}