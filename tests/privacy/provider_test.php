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
 * Base class for unit tests for profilefield_textregex.
 *
 * @package   profilefield_textregex
 * @author    Bence Molnar <molbence@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright 2025 onwards Bence Molnar
 */
namespace profilefield_textregex\privacy;

use context_system;
use context_user;
use core_privacy\local\request\approved_userlist;
use core_privacy\local\request\approved_contextlist;
use core_privacy\local\request\userlist;
use core_privacy\local\request\writer;
use core_privacy\tests\provider_testcase;
use dml_exception;
use coding_exception;

/**
 * Unit tests for user\profile\field\textregex\classes\privacy\provider.php
 *
 * @package   profilefield_textregex
 * @author    Bence Molnar <molbence@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright 2025 onwards Bence Molnar
 */
final class provider_test extends provider_testcase {

    /**
     * Basic setup for these tests.
     */
    public function setUp(): void {
        parent::setUp();
        $this->resetAfterTest(true);
    }

    /**
     * Test getting the context for the user ID related to this plugin.
     *
     * @coversNothing
     * @throws dml_exception
     */
    public function test_get_contexts_for_userid(): void {
        global $DB;
        // Create profile category.
        $categoryid = $this->add_profile_category();
        // Create profile field.
        $profilefieldid = $this->add_profile_field($categoryid, 'textregex');
        // Create a user.
        $user = $this->getDataGenerator()->create_user();
        $this->add_user_info_data($user->id, $profilefieldid, 'test data');
        // Get the field that was created.
        $userfielddata = $DB->get_records('user_info_data', ['userid' => $user->id]);
        // Confirm we got the right number of user field data.
        $this->assertCount(1, $userfielddata);
        $context = context_user::instance($user->id);
        $contextlist = provider::get_contexts_for_userid($user->id);
        $this->assertEquals($context, $contextlist->current());
    }

    /**
     * Test that data is exported correctly for this plugin.
     *
     * @coversNothing
     * @throws coding_exception|dml_exception
     */
    public function test_export_user_data(): void {
        // Create profile category.
        $categoryid = $this->add_profile_category();
        // Create textregex profile field.
        $textregexprofilefieldid = $this->add_profile_field($categoryid, 'textregex');
        // Create checkbox profile field.
        $checkboxprofilefieldid = $this->add_profile_field($categoryid, 'checkbox');
        // Create a user.
        $user = $this->getDataGenerator()->create_user();
        $context = context_user::instance($user->id);
        // Add textregex user info data.
        $this->add_user_info_data($user->id, $textregexprofilefieldid, 'test textregex');
        // Add checkbox user info data.
        $this->add_user_info_data($user->id, $checkboxprofilefieldid, 'test data');
        $writer = writer::with_context($context);
        $this->assertFalse($writer->has_any_data());
        $this->export_context_data_for_user($user->id, $context, 'profilefield_textregex');
        $data = $writer->get_data([get_string('pluginname', 'profilefield_textregex')]);
        $this->assertCount(3, (array) $data);
        $this->assertEquals('Test field', $data->name);
        $this->assertEquals('This is a test.', $data->description);
        $this->assertEquals('test textregex', $data->data);
    }

    /**
     * Test that user data is deleted using the context.
     *
     * @coversNothing
     * @throws dml_exception
     */
    public function test_delete_data_for_all_users_in_context(): void {
        global $DB;
        // Create profile category.
        $categoryid = $this->add_profile_category();
        // Create textregex profile field.
        $textregexprofilefieldid = $this->add_profile_field($categoryid, 'textregex');
        // Create checkbox profile field.
        $checkboxprofilefieldid = $this->add_profile_field($categoryid, 'checkbox');
        // Create a user.
        $user = $this->getDataGenerator()->create_user();
        $context = context_user::instance($user->id);
        // Add textregex user info data.
        $this->add_user_info_data($user->id, $textregexprofilefieldid, 'test textregex');
        // Add checkbox user info data.
        $this->add_user_info_data($user->id, $checkboxprofilefieldid, 'test data');
        // Check that we have two entries.
        $userinfodata = $DB->get_records('user_info_data', ['userid' => $user->id]);
        $this->assertCount(2, $userinfodata);
        provider::delete_data_for_all_users_in_context($context);
        // Check that the correct profile field has been deleted.
        $userinfodata = $DB->get_records('user_info_data', ['userid' => $user->id]);
        $this->assertCount(1, $userinfodata);
        $this->assertNotEquals('test textregex', reset($userinfodata)->data);
    }

    /**
     * Test that data is exported correctly for this plugin.
     */
    public function test_export_user_data(): void {
        // Create profile category.
        $categoryid = $this->add_profile_category();
        // Create textregex profile field.
        $textregexprofilefieldid = $this->add_profile_field($categoryid, 'textregex');
        // Create checkbox profile field.
        $checkboxprofilefieldid = $this->add_profile_field($categoryid, 'checkbox');
        // Create a user.
        $user = $this->getDataGenerator()->create_user();
        $context = \context_user::instance($user->id);
        // Add textregex user info data.
        $this->add_user_info_data($user->id, $textregexprofilefieldid, 'test textregex');
        // Add checkbox user info data.
        $this->add_user_info_data($user->id, $checkboxprofilefieldid, 'test data');
        $writer = \core_privacy\local\request\writer::with_context($context);
        $this->assertFalse($writer->has_any_data());
        $this->export_context_data_for_user($user->id, $context, 'profilefield_textregex');
        $data = $writer->get_data([get_string('pluginname', 'profilefield_textregex')]);
        $this->assertCount(3, (array) $data);
        $this->assertEquals('Test field', $data->name);
        $this->assertEquals('This is a test.', $data->description);
        $this->assertEquals('test textregex', $data->data);
    }

    /**
     * Test that user data is deleted using the context.
     */
    public function test_delete_data_for_all_users_in_context(): void {
        global $DB;
        // Create profile category.
        $categoryid = $this->add_profile_category();
        // Create textregex profile field.
        $textregexprofilefieldid = $this->add_profile_field($categoryid, 'textregex');
        // Create checkbox profile field.
        $checkboxprofilefieldid = $this->add_profile_field($categoryid, 'checkbox');
        // Create a user.
        $user = $this->getDataGenerator()->create_user();
        $context = \context_user::instance($user->id);
        // Add textregex user info data.
        $this->add_user_info_data($user->id, $textregexprofilefieldid, 'test textregex');
        // Add checkbox user info data.
        $this->add_user_info_data($user->id, $checkboxprofilefieldid, 'test data');
        // Check that we have two entries.
        $userinfodata = $DB->get_records('user_info_data', ['userid' => $user->id]);
        $this->assertCount(2, $userinfodata);
        provider::delete_data_for_all_users_in_context($context);
        // Check that the correct profile field has been deleted.
        $userinfodata = $DB->get_records('user_info_data', ['userid' => $user->id]);
        $this->assertCount(1, $userinfodata);
        $this->assertNotEquals('test textregex', reset($userinfodata)->data);
    }

    /**
     * Test that data for users in approved userlist is deleted.
     *
     * @coversNothing
     * @throws dml_exception
     */
    public function test_delete_data_for_users(): void {
        $this->resetAfterTest();

        $component = 'profilefield_textregex';
        // Create profile category.
        $categoryid = $this->add_profile_category();
        // Create textregex profile field.
        $profilefieldid = $this->add_profile_field($categoryid, 'textregex');

        // Create user1.
        $user1 = $this->getDataGenerator()->create_user();
        $usercontext1 = context_user::instance($user1->id);
        // Create user2.
        $user2 = $this->getDataGenerator()->create_user();
        $usercontext2 = context_user::instance($user2->id);

        $this->add_user_info_data($user1->id, $profilefieldid, 'test data');
        $this->add_user_info_data($user2->id, $profilefieldid, 'test data');

        // The list of users for usercontext1 should return user1.
        $userlist1 = new userlist($usercontext1, $component);
        provider::get_users_in_context($userlist1);
        $this->assertCount(1, $userlist1);
        $expected = [$user1->id];
        $actual = $userlist1->get_userids();
        $this->assertEquals($expected, $actual);

        // The list of users for usercontext2 should return user2.
        $userlist2 = new userlist($usercontext2, $component);
        provider::get_users_in_context($userlist2);
        $this->assertCount(1, $userlist2);
        $expected = [$user2->id];
        $actual = $userlist2->get_userids();
        $this->assertEquals($expected, $actual);

        // Add userlist1 to the approved user list.
        $approvedlist = new approved_userlist($usercontext1, $component, $userlist1->get_userids());

        // Delete user data using delete_data_for_user for usercontext1.
        provider::delete_data_for_users($approvedlist);

        // Re-fetch users in usercontext1 - The user list should now be empty.
        $userlist1 = new userlist($usercontext1, $component);
        provider::get_users_in_context($userlist1);
        $this->assertCount(0, $userlist1);

        // Re-fetch users in usercontext2 - The user list should not be empty (user2).
        $userlist2 = new userlist($usercontext2, $component);
        provider::get_users_in_context($userlist2);
        $this->assertCount(1, $userlist2);

        // User data should be only removed in the user context.
        $systemcontext = context_system::instance();
        // Add userlist2 to the approved user list in the system context.
        $approvedlist = new approved_userlist($systemcontext, $component, $userlist2->get_userids());
        // Delete user1 data using delete_data_for_user.
        provider::delete_data_for_users($approvedlist);
        // Re-fetch users in usercontext2 - The user list should not be empty (user2).
        $userlist1 = new userlist($usercontext2, $component);
        provider::get_users_in_context($userlist1);
        $this->assertCount(1, $userlist1);
    }

    /**
     * Add dummy user info data.
     *
     * @param int $userid The ID of the user
     * @param int $fieldid The ID of the field
     * @param string $data The data
     * @throws dml_exception
     */
    private function add_user_info_data(int $userid, int $fieldid, string $data): void {
        global $DB;

        $userinfodata = [
            'userid' => $userid,
            'fieldid' => $fieldid,
            'data' => $data,
            'dataformat' => 0,
        ];

        $DB->insert_record('user_info_data', $userinfodata);
    }

    /**
     * Add dummy profile category.
     *
     * @return int The ID of the profile category
     */
    private function add_profile_category(): int {
        $cat = $this->getDataGenerator()->create_custom_profile_field_category(['name' => 'Test category']);
        return $cat->id;
    }

    /**
     * Add dummy profile field.
     *
     * @param int $categoryid The ID of the profile category
     * @param string $datatype The datatype of the profile field
     * @return int The ID of the profile field
     */
    private function add_profile_field(int $categoryid, string $datatype): int {
        $data = $this->getDataGenerator()->create_custom_profile_field([
            'datatype' => $datatype,
            'shortname' => 'tstField',
            'name' => 'Test field',
            'description' => 'This is a test.',
            'categoryid' => $categoryid,
            'param3' => '/^[A-Z]+$/',
        ]);
        return $data->id;
    }
}
