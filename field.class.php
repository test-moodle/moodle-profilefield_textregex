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
 * Profile field for 'profilefield_textregex'.
 *
 * @package   profilefield_textregex
 * @author    Bence Molnar <molbence@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright 2025 onwards Bence Molnar
 */

/**
 * Class profile_field_textregex
 *
 * @package   profilefield_textregex
 * @author    Bence Molnar <molbence@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright 2025 onwards Bence Molnar
 */
class profile_field_textregex extends profile_field_base {

    /**
     * Overwrite the base class to display the data for this field
     */
    public function display_data(): string {
        // Default formatting.
        $data = format_string($this->data);

        // Are we creating a link?
        if (!empty($this->field->param4) && !empty($data)) {

            // Define the target.
            if (! empty($this->field->param5)) {
                $target = 'target="'.$this->field->param5.'"';
            } else {
                $target = '';
            }

            // Create the link.
            $data = '<a href="'.str_replace('$$', urlencode($data),
                    $this->field->param4).'" '.$target.'>'.htmlspecialchars($data, ENT_COMPAT).'</a>';
        }

        return $data;
    }

    /**
     * Add fields for editing a textregex profile field.
     *
     * @param MoodleQuickForm $mform
     * @throws coding_exception
     */
    public function edit_field_add($mform): void {
        $size = $this->field->param1;
        $regex = $this->field->param3;
        $fieldtype = 'text';

        // Create the form field.
        $mform->addElement($fieldtype, $this->inputname, format_string($this->field->name),
            ['size' => $size]);
        $mform->setType($this->inputname, PARAM_TEXT);
        $mform->addRule($this->inputname, get_string('errorregex', 'profilefield_textregex', $regex), 'regex', $regex, 'client');
    }

    /**
     * Process the data before it gets saved in database
     *
     * @param string|null $data
     * @param stdClass $datarecord
     * @return string|null
     */
    public function edit_save_data_preprocess($data, $datarecord): ?string {
        if ($data === null) {
            return null;
        }

        if (!preg_match($this->field->param3, $data)) {
            return null;
        }
        return $data;
    }

    /**
     * Convert external data (csv file) from value to key for processing later by edit_save_data_preprocess
     *
     * @param string $data
     * @return string|null
     */
    public function convert_external_data(string $data): ?string {
        if (!preg_match($this->field->param3, $data)) {
            return null;
        }

        return $data;
    }

    /**
     * Return the field type and null properties.
     * This will be used for validating the data submitted by a user.
     *
     * @return array the param type and null property
     * @since Moodle 3.2
     */
    public function get_field_properties(): array {
        return [PARAM_TEXT, NULL_NOT_ALLOWED];
    }
}
