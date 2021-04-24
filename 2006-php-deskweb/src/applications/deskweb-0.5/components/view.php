<?php


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