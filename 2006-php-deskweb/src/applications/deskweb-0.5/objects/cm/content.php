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
 * @package Deskweb
 */

/**
 * ContentDeskWeb Base Widget
 */
class ContentDeskWeb extends WidgetDeskWeb {

	/**
	 * Constructor
	 * Classe lanciata dal pannello principale del desktop manager
	 * Per tutte le applicazioni in sessione si occupa di istanziare la 
	 * finestra adatta
	 */
	function ContentDeskWeb($container = false) {

		global $model, $request, $session;
		if (count($model->arr_contents) > 0)
			require_once ($_SERVER['DOCUMENT_ROOT'] . "/" . DIR_DESKWEB."/widgets/wm/include_wm.php");
		for ($x = 0; $x <= count($model->arr_contents) - 1; $x ++) {
			$window = null;
			if (is_file($_SERVER['DOCUMENT_ROOT'].DIR_APPS."/".$model->arr_contents[$x]['application']."/".$model->arr_contents[$x]['application'].".php")) {
				require_once ($_SERVER['DOCUMENT_ROOT'].DIR_APPS."/".$model->arr_contents[$x]['application']."/".$model->arr_contents[$x]['application'].".php");
				eval ('$window = new '.$model->arr_contents[$x]['application'].'DeskWeb($model->arr_contents[$x][\'id_node\']);');
				if (strlen($model->arr_contents[$x]['window']) > 0) {
					$temp = split(",", $model->arr_contents[$x]['window']);
					$window->setDimension($temp[0], $temp[1]);
				}

			} else {
				require_once ($_SERVER['DOCUMENT_ROOT'].DIR_APPS."/dwskeleton/dwskeleton.php");
				$window = new DWSkeletonDeskWeb($model->arr_contents[$x]['id_node']);
			}
			$window->set_icon($model->arr_contents[$x]['icon'], $model->arr_contents[$x]['type']);
			$window->set_name($model->arr_contents[$x]['node']);
			$window->add_application($window->init($x, $model->arr_contents[$x]['id_node']));
			if (!$session->getFullscreen()) {
				$window->build_position($model->arr_contents[$x]['id_node']);
			} else {
				$window->setFullScreen();
			}
			$window->build_window($model->arr_contents[$x]['id_node']);
			$this->add_element($window);
		}

		if (!$container) {
			$this->open_element = "<div id='replaceme'></div><div id='content_window'>\n";
			$this->close_element = "</div>\n";
		}

	}

}
?>