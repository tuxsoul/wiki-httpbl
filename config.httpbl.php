<?php
/*
Implementation of API from "Project Honey Pot"
http://www.projecthoneypot.org/httpbl_api

Author: Mario Oyorzabal Salgado
Blog:   http://blog.tuxsoul.com/
E-mail:	<tuxsoul@tuxsoul.com>
Web: 	http://code.google.com/p/wiki-httpbl/
Donate: http://tinyurl.com/2zhdhg

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.
*/

// you can't execute directly this file
// you are lost ?
if (!defined('HTTPBL_CWD')) {
	die ('You are lost ?');
}

////////// Configuration
////////// You can edit all values ;-)

///// Key to access dnsbl service from "Project Honey Pot"
///// All Access Keys are 12-characters in length, lower case, and contain only alpha characters (no numbers)
///// You need a key ?, register here: http://www.projecthoneypot.org?rf=39586
define('HTTPBL_KEY', '------------');

////////// Url to honeypot trap for redirect malicious visitors
///// If you have install a trap or you can get this in "Project Honey Pot" -> "QuickLink"
///// This value is important to catch more spammers ;-)
define('HTTPBL_TRAP', '');

///// Is important change this value to any word, for have usefull url trap's
define('HTTPBL_TRAP_WORD', 'mediawiki');

?>
