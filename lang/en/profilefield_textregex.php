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
 * Strings for component 'profilefield_textregex', language 'en'.
 *
 * @package   profilefield_textregex
 * @author    Bence Molnar <molbence@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright 2025 onwards Bence Molnar
 */

$string['errorconfigdefault'] = 'The provided default value is not matching the regex.';
$string['errorconfigregex'] = 'The provided regex is not a valid regex.';
$string['errorregex'] = 'Entered value does not match against regex: {$a}';
$string['pluginname'] = 'Short text with validation input';
$string['privacy:metadata:profilefield_textregex:data'] = 'Short text with validation input user profile field user data';
$string['privacy:metadata:profilefield_textregex:dataformat'] = 'The format of Short text with validation input user profile field user data';
$string['privacy:metadata:profilefield_textregex:fieldid'] = 'The ID of the profile field';
$string['privacy:metadata:profilefield_textregex:tableexplanation'] = 'Additional profile data';
$string['privacy:metadata:profilefield_textregex:userid'] = 'The ID of the user whose data is stored by the Short text with validation input user profile field';
$string['regex'] = 'Regular expression';
$string['regex_help'] = 'Perl style regular expression to test the field value against. The regex should align with the \'required\' setting, if it is not required, regex has to allow empty field as well. And also take a look at <a href="/admin/search.php?query=strictformsrequired">Strictness setting</a>. Please also include the delimiters. E.g: \"/^TEST[0-9A-F]{3}\/\$_postfix/\".';
