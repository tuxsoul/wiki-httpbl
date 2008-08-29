<?php
/*
Implementation of API from "Project Honey Pot"
http://www.projecthoneypot.org/httpbl_api

Author: Mario Oyorzabal Salgado
Blog:   http://blog.tuxsoul.com/
E-mail: <tuxsoul@tuxsoul.com>
Web:    http://code.google.com/p/wiki-httpbl/
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

// Check to run with mediawiki
if (!defined('MEDIAWIKI')) {
	die ('You are lost ?');
}

// Extension version, not core version, is other stuff
$httpblExtensionVersion = "2";

// Define path of extension
define('HTTPBL_CWD', dirname(__FILE__));

// Include class to work dnsbl of httpbl
include(HTTPBL_CWD . '/httpbl.object.php');

// Instance object
$httpbl = new objectHttpBL();

// Execute httpbl filter
function httpbl_mediawiki_start () {
	global $httpbl, $wgWikiHttpBLKey, $wgWikiHttpBLTrap, $wgWikiHttpBLTrapWord;

	$data = array (
			$wgWikiHttpBLKey,
			$wgWikiHttpBLTrap,
			$wgWikiHttpBLTrapWord
		);

	$httpbl->httpblStart($data);
}

// Execute httpbl text
function httpbl_mediawiki_text (&$parser, &$text) {
	global $httpbl, $wgWikiHttpBLTrap, $wgWikiHttpBLTrapWord;

	$text = $httpbl->httpblGetUrlTrap($wgWikiHttpBLTrap, $wgWikiHttpBLTrapWord) . $text;
	return true;
}

// Extension info
$wgExtensionCredits['other'][] = array(
       	'name' => $httpbl->httpblInfo('name'),
        'version' => $httpbl->httpblInfo('version') . '.' . $httpblExtensionVersion,
       	'author' => $httpbl->httpblInfo('author'),
        'description' => $httpbl->httpblInfo('description'),
        'url' => $httpbl->httpblInfo('url'),
);

$wgHooks['ParserAfterTidy'][] = 'httpbl_mediawiki_text';
$wgExtensionFunctions[] = 'httpbl_mediawiki_start';

?>
