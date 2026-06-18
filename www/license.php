<?php

// Serves the bundled GPLv3 license text. Public (no login) so the licence is
// always reachable from the footer link, as the GPL expects it to travel with
// the program. LICENSE.txt lives one level above the web root.
$txt = @file_get_contents(__DIR__ . '/../LICENSE.txt');
header('Content-Type: text/plain; charset=ISO-8859-1');
echo ($txt !== false && $txt !== '') ? $txt : "License file not found. This program is distributed under the GNU General Public License v3: https://www.gnu.org/licenses/gpl-3.0.html\n";
