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
 * practice page form
 *
 * @package    local_practice
 * @copyright  2022 onwards WIDE Services  {@link https://www.wideservices.gr}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();
require_once("$CFG->libdir/formslib.php");

class practice_form extends moodleform {
    public function definition() {
        $mform = $this->_form;

       $mform->addElement('text','firstname','First name');
       $mform->setType('firstname',PARAM_TEXT);

       $mform->addElement('text','lastname','Last name');
       $mform->setType('lastname',PARAM_TEXT);

       $mform->addElement('text','email','Email');
       $mform->setType('email',PARAM_EMAIL);

        $this->add_action_buttons(false, get_string('addrecord', 'local_practice'));
    }

    public function validation($data, $files) {
        global $DB;

        $errors = parent::validation($data, $files);

        // Firstname validation
        if (empty(trim($data['firstname']))) {
            $errors['firstname'] = get_string('firstnameempty', 'local_practice');
        }
        else if (mb_strlen(trim($data['firstname']), 'UTF-8') < 2) {
            $errors['firstname'] = get_string('firstnameshort', 'local_practice');
        }
        else if (strlen(trim($data['firstname'])) > 100) {
            $errors['firstname'] = get_string('firstnamelong', 'local_practice');
        }

        // Lastname validation
        if (empty(trim($data['lastname']))) {
            $errors['lastname'] = get_string('lastnameempty', 'local_practice');
        }
        else if (mb_strlen(trim($data['lastname']), 'UTF-8') < 2) {
            $errors['lastname'] = get_string('lastnameshort', 'local_practice');
        }
        else if (strlen(trim($data['lastname'])) > 100) {
            $errors['lastname'] = get_string('lastnamelong', 'local_practice');
        }

        // Email validation
        if (empty(trim($data['email']))) {
            $errors['email'] = get_string('emailrequired', 'local_practice');
        }
        else if (!validate_email($data['email'])) {
            $errors['email'] = get_string('invalidemail', 'local_practice');
        } 
        else {
            // Check for duplicate email in database
            $sql = "SELECT 1
                    FROM {local_practice}
                    WHERE " . $DB->sql_compare_text('email') . " = " . $DB->sql_compare_text(':email');

            $params = ['email' => $data['email']];
            $emailexists = $DB->record_exists_sql($sql, $params);

            if ($emailexists) {
                $errors['email'] = get_string('emailexists', 'local_practice');
            }
        }

        return $errors;
    }
}
