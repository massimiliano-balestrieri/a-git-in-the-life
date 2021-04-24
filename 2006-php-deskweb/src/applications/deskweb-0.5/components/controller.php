<?php
/**
 * Variabile globale contenente l'oggetto session di deskweb
 * E' globale per non dover passare questo oggetto come argomento.
 * @global SessionDeskWeb $session
 * @name $session
 */
$session = null;
/**
 * Variabile globale contenente l'oggetto request di deskweb
 * E' globale per non dover passare questo oggetto come argomento.
 * @global RequestDeskWeb $request
 * @name $request
 */
$request = null;
/**
 * Variabile globale contenente l'oggetto model di deskweb
 * E' globale per non dover passare questo oggetto come argomento.
 * @global ModelDeskWeb $model
 * @name $model
 */
$model = null;
/**
 * Variabile globale contenente l'oggetto view di deskweb
 * E' globale per non dover passare questo oggetto come argomento.
 * @global ViewDeskWeb $view
 * @name $view
 */
$view = null;
/**
 * Variabile globale contenente l'oggetto sniffer di deskweb
 * E' globale per non dover passare questo oggetto come argomento.
 * @global phpSniff $sniffer
 * @name $sniffer
 */
$sniffer = null;

/**
 * Variabile globale contenente il link al db di deskweb
 * E' globale perch� incapsulato in un oggetto si perdono parecchi millisecondi in esecuzioni
 * @global resource $link_db
 * @name $link_db
 */
$link_db = mysql_pconnect(SERVER_DB, DB_USER, DB_PW) or die("Impossibile connettersi al server database");
/**
 * Variabile globale contenente l'oggetto connessione di deskweb
 * E' globale perch� incapsulato in un oggetto si perdono parecchi millisecondi in esecuzioni
 * @global connessione $conn
 * @name $conn
 */
$conn = mysql_select_db(DB_DB, $link_db) or die("impossibile connettersi al database");

/**
 * classe Controller di deskweb
 */
class ControllerDeskWeb {

	/**
	 * class constructor
	 * il controller 
	 * istanzia:
	 * 
	 * lo sniffer
	 * la sessione
	 * la request (reso globale)
	 * 
	 * la action (se la request lo richiede)
	 * 
	 * il modello
	 * la vista (che � sempre il desktop in questo tipo di applicazione)
	 * 
	 * 
	 */
	function ControllerDeskWeb() {
		global $request, $model, $view, $sniffer, $session;

		$request = new RequestDeskWeb();
		$session = new SessionDeskWeb();
		$sniffer = new phpSniff();
		$session->setUserAgentFeatures();
		//if ($request->action) {
			$action = new ActionDeskWeb();
		//}
		
		//delego le action
		$action_apps = $session->getActiveDeskwebApps();
		//print_r($session);//die();
		if (is_array($action_apps)) {
		
			for ($x = 0; $x <= sizeof($action_apps) - 1; $x ++) {
				$file = $_SERVER['DOCUMENT_ROOT'].DIR_APPS."/".$action_apps[$x]."/".$action_apps[$x]."_action.php";
				//echo $file;
				if (is_file($file)) {
					require_once ($file);
					eval ('$action = new '.$action_apps[$x].'ActionDeskWeb();');
				}
			}
		}

		$model = new ModelDeskWeb();
		$view = new ViewDeskWeb();
		mysql_close();
	}
}
?>