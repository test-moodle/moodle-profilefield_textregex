<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Strings for component 'profilefield_textregex', language 'hu', version '4.5'.
 *
 * @package   profilefield_textregex
 * @category  string
 * @author    Bence Molnar <molbence@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright 2025 onwards Bence Molnar
 */

defined('MOODLE_INTERNAL') || die();

$string['errorconfigdefault'] = 'A megadott alapérték nem felel meg a reguláris kifejezésnek.';
$string['errorconfigregex'] = 'A megadott reguláris kifejezés érvénytelen.';
$string['errorregex'] = 'A megadott érték nem felel meg a következő ellenőrzésnek: {$a}';
$string['pluginname'] = 'Szövegbevitel';
$string['privacy:metadata:profilefield_textregex:data'] = 'A felhasználói profilmező adatai közé kerülő szöveg bevitele';
$string['privacy:metadata:profilefield_textregex:dataformat'] = 'A felhasználói profilmező adatai közé kerülő szöveg bevitelének formátuma';
$string['privacy:metadata:profilefield_textregex:fieldid'] = 'A profilmező azonosítója';
$string['privacy:metadata:profilefield_textregex:tableexplanation'] = 'Kiegészítő profiladatok';
$string['privacy:metadata:profilefield_textregex:userid'] = 'Azon felhasználónak az azonosítója, akinek az adatait a felhasználói profilmező szövegbeviteli eleme tárolja';
$string['regex'] = 'Reguláris kifejezés';
$string['regex_help'] = 'A beviteli mező ellenőrzésére szolgáló Perl típusu reguláris kifejezés. A kifejezés legyen összhangban a \'Kötelező\' beállítással, ha a mező nem kötelező, akkor a kifejezés is engedje meg az üres értéket. Érdemes egy pillantást vetni az üres mező ellenőrzés <a href="/admin/search.php?query=strictformsrequired">szigorúságát befolyásoló globális beállítsra</a>. Az elhatároló (delimeter) karakternek szerepelnie kell az elején és a végén. Pl: \"/^TEST[0-9A-F]{3}\/\$_utotag/\".';
