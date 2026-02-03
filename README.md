# Local Practice Plugin (Moodle)

A custom Moodle local plugin that provides a simple data entry form with
server-side validation, database integrity checks, and clean data presentation
using Moodle templates.

## Features
- Secure form submission using Moodle Forms API
- Server-side validation for all input fields
- Unique email constraint enforced at database level
- User-friendly error and success notifications
- Data listing with proper ordering and pagination limit
- Internationalization using Moodle language strings
- Time handling using Moodle `userdate()` API

## Tested Environment
- Windows (XAMPP)
- Moodle **4.0.1**
- PHP version compatible with Moodle 4.0.1
- MySQL / MariaDB (tested with standard Moodle DB setup)

## Installation
This plugin was tested in a local development environment.

1. Install a local web server environment (e.g. XAMPP for Windows).
2. Install Moodle **4.0.1** and verify that it is working correctly.
3. Copy the plugin folder to: <moodle_root>/local
4. Log in to Moodle as an administrator.
5. Navigate to **Site administration → Notifications** to complete the plugin installation.
6. Purge caches if prompted.

**Note:** No core Moodle files were modified.
