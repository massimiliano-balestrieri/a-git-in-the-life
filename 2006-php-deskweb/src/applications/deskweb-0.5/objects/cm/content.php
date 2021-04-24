<?php




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