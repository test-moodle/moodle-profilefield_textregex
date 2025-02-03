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
 * Definition for 'profilefield_textregex'.
 *
 * @package   profilefield_textregex
 * @author    Bence Molnar <molbence@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright 2025 onwards Bence Molnar
 */

/**
 * Class profile_define_textregex
 *
 * @package   profilefield_textregex
 * @author    Bence Molnar <molbence@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright 2025 onwards Bence Molnar
 */
class profile_define_textregex extends profile_define_base {

    /**
     * Add elements for creating/editing a textregex profile field.
     *
     * @param MoodleQuickForm $form
     * @throws coding_exception
     */
    public function define_form_specific($form): void {
        // Param 3 for textregex type is the regex for the field.
        $form->addElement('text', 'param3', get_string('regex', 'profilefield_textregex'), ['size' => 150]);
        $form->setType('param3', PARAM_TEXT);
        $form->addRule('param3', null, 'required', null, 'client');
        $form->addHelpButton('param3', 'regex', 'profilefield_textregex');

        // Default data.
        $form->addElement('text', 'defaultdata', get_string('profiledefaultdata', 'admin'), ['size' => 50]);
        $form->setType('defaultdata', PARAM_TEXT);

        // Param 1 for text type is the size of the field.
        $form->addElement('text', 'param1', get_string('profilefieldsize', 'admin'), ['size' => 6]);
        $form->setDefault('param1', 30);
        $form->setType('param1', PARAM_INT);

        // Param 4 for text type contains a link.
        $form->addElement('text', 'param4', get_string('profilefieldlink', 'admin'));
        $form->setType('param4', PARAM_URL);
        $form->addHelpButton('param4', 'profilefieldlink', 'admin');

        // Param 5 for text type contains link target.
        $targetoptions = array( ''       => get_string('linktargetnone', 'editor'),
            '_blank' => get_string('linktargetblank', 'editor'),
            '_self'  => get_string('linktargetself', 'editor'),
            '_top'   => get_string('linktargettop', 'editor')
        );
        $form->addElement('select', 'param5', get_string('profilefieldlinktarget', 'admin'), $targetoptions);
        $form->setType('param5', PARAM_RAW);

    }

    /**
     * Validate the data from the add/edit profile field form.
     *
     * @param stdClass|array $data from the add/edit profile field form
     * @param array $files
     * @return array    associative array of error messages
     * @throws coding_exception
     */
    public function define_validate_specific($data, $files): array {
        $errors = [];

        if (preg_match($data->param3, '') === false) {
            $errors['param3'] = get_string('errorconfigregex', 'profilefield_textregex');
        } else if (!empty($data->defaultdata) && !preg_match($data->param3, $data->defaultdata)) {
            $errors['param3'] = get_string('errorconfigdefault', 'profilefield_textregex');
        }

        return $errors;
    }

}
