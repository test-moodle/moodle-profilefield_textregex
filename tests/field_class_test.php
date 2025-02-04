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
 * Tests for 'profilefield_textregex'
 *
 * @package   profilefield_textregex
 * @author    Bence Molnar <molbence@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright 2025 onwards Bence Molnar
 */

namespace profilefield_textregex;

defined('MOODLE_INTERNAL') || die();

global $CFG;

require_once($CFG->dirroot.'/user/profile/lib.php');
require_once($CFG->dirroot.'/user/profile/field/textregex/field.class.php');

use profile_field_textregex;
use advanced_testcase;
use coding_exception;
use stdClass;

/**
 * Unit tests for the profilefield_textregex.
 *
 * @package    profilefield_textregex
 * @copyright  2022 The Open University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @covers     \profilefield_textregex\profile_field_textregex
 */
final class field_class_test extends advanced_testcase {
    /**
     * Test that the profile textregex data is formatted and required filters applied
     *
     * @covers       \profile_field_textregex::display_data
     * @dataProvider filter_profile_field_textregex_provider
     * @param string $input
     * @param string $expected
     * @throws coding_exception
     */
    public function test_filter_display_data(string $input, string $expected): void {
        $this->resetAfterTest();
        $field = new profile_field_textregex();
        $field->data = $input;

        filter_set_global_state('multilang', TEXTFILTER_ON);
        filter_set_global_state('emoticon', TEXTFILTER_ON);
        filter_set_applies_to_strings('multilang', true);

        $actual = $field->display_data();
        $this->assertEquals($expected, $actual);
    }

    /**
     * Data provider for {@see test_filter_display_data}
     *
     * @return string[]
     */
    public static function filter_profile_field_textregex_provider(): array {
        return [
            'simple_string' => ['Simple string', 'Simple string'],
            'format_string' => ['HTML & is escaped', 'HTML &amp; is escaped'],
            'multilang_filter' =>
                ['<span class="multilang" lang="en">English</span><span class="multilang" lang="fr">French</span>', 'English'],
            'emoticons_filter' => ['No emoticons filter :-(', 'No emoticons filter :-('],
        ];
    }

    /**
     * Test preprocess data validation
     */
    public function test_edit_save_data_preprocess(): void {
        $this->resetAfterTest();

        $fielddata = $this->getDataGenerator()->create_custom_profile_field([
            'datatype' => 'textregex',
            'name' => 'Test',
            'shortname' => 'test',
            'param3' => '/^[A-Z]+$/', // Regex.
        ]);
        $field = new profile_field_textregex(0, 0, $fielddata);

        $value = $field->edit_save_data_preprocess('ABCDE', new stdClass());
        $this->assertEquals('ABCDE', $value);

        // Non matching REGEX.
        $value = $field->edit_save_data_preprocess('ABCDe', new stdClass());
        $this->assertEquals(null, $value);
    }

    /**
     * Test external data validation
     */
    public function test_convert_external_data(): void {
        $this->resetAfterTest();

        $fielddata = $this->getDataGenerator()->create_custom_profile_field([
            'datatype' => 'textregex',
            'name' => 'Test',
            'shortname' => 'test',
            'param3' => '/^[A-Z]+$/', // Regex.
        ]);
        $field = new profile_field_textregex(0, 0, $fielddata);

        $value = $field->convert_external_data('ABCDE');
        $this->assertEquals('ABCDE', $value);

        // Non matching REGEX.
        $value = $field->edit_save_data_preprocess('ABCDe', new stdClass());
        $this->assertEquals(null, $value);
    }
}
