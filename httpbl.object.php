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

// can't execute directly this file
// you are lost ?
if (!defined('HTTPBL_CWD')) {
	die('You are lost ?');
}

// include core file
include (HTTPBL_CWD . '/httpbl.core.php');

// main class object
class objectHttpBL extends coreHttpBL
{
	// start the search to spammer's
	function httpblStart (&$data) {
		// set the key to access 'Project Honey Pot'
		$this->key = $data[0];
		$this->url = $data[1];
		$this->word = $data[2];

		$this->coreHttpBLStart();
	}

	// get url to trap
	function httpblGetUrlTrap (&$url, &$word) {
		$this->url = $url;
		$this->word = $word;

		return $this->coreHttpBLGetUrlTrap();
	}

	// return information from this code
	function httpblInfo ($type) {
		$description  = 'This code implement the API from "Project Honey Pot", to detect Spammers, Harvesters';
		$description .= ' and other malicious visitors. Consider donate to this extension';

		$values = array (
					'name' => 	 'Http:BL',
					'version' => 	 $this->coreHttpBLVersion(),
					'author' =>	 'Mario Oyorzabal Salgado',
					'description' => $description,
					'url' =>	 'http://code.google.com/p/wiki-httpbl/',
				);

		if (isset($values[$type]))
			return $values[$type];
		else
			return 'Null';
	}
}

?>
