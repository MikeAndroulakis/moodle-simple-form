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
 * local practice's index page
 *
 * @package    local_practice
 * @copyright  2022 onwards WIDE Services  {@link https://www.wideservices.gr}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
use local_practice\output\main;
require(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/classes/practice_form.php');
require_login();


$url = new moodle_url('/local/practice/index.php');
$PAGE->set_url($url);
$context = context_system::instance();
$PAGE->set_context($context);

$PAGE->set_title(get_string('practicetitle','local_practice'));
$PAGE->set_heading(get_string('practicetitle', 'local_practice'));

$mform = new practice_form(null);
if($fromform = $mform->get_data()){
    $insertrecord=new stdClass();
    $insertrecord->firstname    = trim($fromform->firstname);
    $insertrecord->lastname     = trim($fromform->lastname);
    $insertrecord->email        = trim($fromform->email);
    $insertrecord->timecreated  = time();
    $insertrecord->timemodified = time();
	try {
        $DB->insert_record('local_practice',$insertrecord);
		redirect(
            $url,
            get_string('recordaddedsuccess', 'local_practice'),
            null,
            \core\output\notification::NOTIFY_SUCCESS
        );
    } catch (dml_exception $e) { // No transaction / exception handling
        redirect(
            $url,
            get_string('dberror', 'local_practice'),
            null,
            \core\output\notification::NOTIFY_ERROR
        );
    }
}else{
    $indexview=new main();
    echo $OUTPUT->header();
    echo $OUTPUT->render($indexview);
    $mform->display();
    echo $OUTPUT->footer();
}
