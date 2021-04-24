<?php

/**
 * Project:     deskweb - the desktop manager for web <br />
 * 
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * You may contact the authors of Deskweb by emial at: <br />
 * io@maxb.net <br />
 *
 * Or, write to: <br />
 * Massimiliano Balestrieri <br />
 * Via Casalis 9 <br />
 * 10143 Torino <br />
 * Italy <br />
 *
 * The latest version of deskweb can be obtained from: <br />
 * http://www.deskweb.org/ <br />
 *
 * @link http://www.deskweb.org/
 * @author Massimiliano Balestrieri <io@maxb.net>
 * @version 0.1
 * @copyright 2005-2006 Massimiliano Balestrieri.
 * @package Core
 */

/**
 * $header � resa globale per permettere alle applicazioni di aggiungere js e css
 * @global string $header
 * @name $header
 */
$header = null;
/**
 * $body � resa globale per permettere al logger di stamparmi la lungezza del html mandato ad output
 * @global string $body
 * @name $body
 */
$body = null;

/**
 * classe view
 */
class ViewDeskWeb {

	/**
	 * class constructor
	 * istanzia:
	 * 
	 * HeaderDeskWeb
	 * BodyDeskWeb
	 * 
	 * sono i due macro-elementi della vista 
	 */
	function ViewDeskWeb() {

		global $body,$header;
		$header = new HeaderDeskWeb();
		$body = new BodyDeskWeb();

		$header->output();
		$body->output();
	}

}
?>