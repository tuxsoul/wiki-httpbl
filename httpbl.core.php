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
	die ('You are lost ?');
}

// main class object
class coreHttpBL 
{
	// config values
	var $key, $url, $word;

	var $coreHttpBLIp;
	var $coreHttpBLError;

	var $coreHttpBLConfVersion;
	var $coreHttpBLConfDnsbl;
	var $coreHttpBLConfDays;

	function coreHttpBL () {
		// set flag error to cero
		$this->coreHttpBLError = 0;
	
		// config
		// version of this core
		$this->coreHttpBLConfVersion = '0.2';

		// spammer days since last activity
		$this->coreHttpBLConfDays = '15';

		// define query to dnsbl
		$this->coreHttpBLConfDnsbl = '{key}.{ip}.dnsbl.httpbl.org';
	}

	// return version of this core
	function coreHttpBLVersion () {
		return $this->coreHttpBLConfVersion;
	}

	// start the search to spammer's
	function coreHttpBLStart () {
		// detect ip
		$this->coreHttpBLDetectIp();

		// reverse-octet ip address
		// change data of query
		$host = $this->coreHttpBLDnsblPrepareQuery();

		// make query and get response
		$response = $this->coreHttpBLDnsblQuery($host);

		// Is spammer ?
		if($this->coreHttpBLIsSpammer($response) == 1) {
			// Get the trap
			$this->coreHttpBLShowTrap();
		}
	}

	// try to detect the remote ip
	function coreHttpBLDetectIP () {
		$ip = $_SERVER['REMOTE_ADDR'];

		// only for test
		// $ip = '127.1.1.1';

		$this->coreHttpBLIp = $ip;
	}

	// change data of query to dnsbl
	function coreHttpBLDnsblPrepareQuery () {
		// reverse-octet ip format
		$reverseIp = implode('.', array_reverse(explode('.', $this->coreHttpBLIp)));

		// prepare query to dnsbl
		$string = $this->coreHttpBLConfDnsbl;
		$string = ereg_replace('{key}', $this->key, $string);
		$string = ereg_replace('{ip}', $reverseIp, $string);

		return $string;
	}

	// make the query to dnsbl server
	function coreHttpBLDnsblQuery ($host) {
		$response = gethostbyname($host);

		if($response == $host)
			$this->coreHttpBLError = 1;

		return $response;
	}

	// is spammer ?
	function coreHttpBLIsSpammer ($response) {
		if($this->coreHttpBLError == 0) {
			$data = explode('.', $response);
			$spammer = 0;

			// the first octect always is 127
			if((int)$data[0] == 127) {
				// spammer days since last activity
				if((int)$data[1] <= $this->coreHttpBLConfDays) {
					// only check the type of spammer
					if((int)$data[3] > 0) {
						$spammer = 1;
					}
				}		
			}
			else
				$this->coreHttpBLError = 1;

			return $spammer;
		}

		return 0;
	}

	// redirect to the trap
	function coreHttpBLShowTrap () {
		if($this->coreHttpBLError == 0) {
			// FIXME: $this->url is set correctly ?
			if(strlen($this->url) > 0) {
				header('Location: ' . $this->url);
				die();
			}
		}
	}

	// return url to trap in html
	// FIXME: Need more work here :)
	function coreHttpBLGetUrlTrap () {
		$text = '<!-- begin links ' . $this->word . ' -->';

		// FIXME: $this->url is set correctly ?
		if(strlen($this->url) > 0) {
			$url = array (
					'<a href="{url}"><!-- {word} --></a>',
					'<a href="{url}" style="display: none;">{word}</a>',
					'<div style="display: none;"><a href="{url}">{word}</a></div>',
					'<a href="{url}"></a>',
					'<!-- <a href="{url}">{word}</a> -->',
					'<div style="position: absolute; top: -250px; left: -250px;"><a href="{url}">{word}</a></div>',
					'<a href="{url}"><span style="display: none;">{word}</span></a>',
				);

			for($x = 0; $x <= 2; $x++) {
				$temp = $url[rand(0, 6)];
				$temp = ereg_replace('{url}', $this->url, $temp);
				$temp = ereg_replace('{word}', $this->word, $temp);

				$text .= $temp;
			}

			$text .= '<!-- end links '. $this->word . ' -->';
		}

		return $text;
	}
}

?>
