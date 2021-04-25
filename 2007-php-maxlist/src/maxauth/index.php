<?php
/***
$Id: index.php 95 2007-11-02 15:48:51Z maxbnet $
$LastChangedDate: 2007-11-02 16:48:51 +0100 (ven, 02 nov 2007) $
$LastChangedRevision: 95 $
$LastChangedBy: maxbnet $
$HeadURL: https://maxlist.svn.sourceforge.net/svnroot/maxlist/branches/0.4/maxauth/index.php $

$Author: maxbnet $
$Date: 2007-11-02 16:48:51 +0100 (ven, 02 nov 2007) $
*/
$istance = sprintf('%s',isset($_REQUEST["istance"]) ? $_REQUEST['istance'] : "default");

require_once dirname(__FILE__).'/config/config.php';	

@session_start();

if(!isset($_POST['username'])){

	$conn = mysql_connect(DB_HOST, DB_USER, DB_PWD);
	$linkdb = mysql_select_db(DB_NAME,$conn);
	$rsistances = mysql_query("select * from maxlist_istances", $conn);
	$istances = array();
	while ($row = mysql_fetch_array($rsistances,MYSQL_ASSOC)){
		$istances[] = $row;
	}
	
	require_once(SMARTY_DIR. '/Smarty.class.php');
	$template = new Smarty();
	$template->caching = 0;
	$template->cache_dir  	= 	SMARTY_CACHE;
	$template->compile_dir 	= 	SMARTY_TPL;
	
	$template->assign('PATH_TEMPL', SMARTY_DIR ."/templates");

	//componenti
	$head_template  = "/templates/inc/header.tpl";
	$foot_template  = "/templates/inc/footer.tpl";
	$menu_template  = "/templates/inc/menu.tpl";
	$login_template = "/templates/app/login.tpl";
	
	//login view 
	$lbl_messages = array(
					'name'=>'Nome',
					'password'=>'Password',
					'forgot_password'=>'Password dimenticata?',
					'enter_email'=>'inserisci email',
					'send_password'=>'invia',
					
	);
	$lbl_action = array(
					'enter'=>'entra',
					'send_password'=>'invia',
	);
	
	//templates
	//get
	$template->assign('tpl_GET',$_GET);
	$template->assign('tpl_POST',$_POST);
	//label
	$template->assign('tpl_lbl_action',$lbl_action);
	$template->assign('tpl_lbl_messages',$lbl_messages);
	
	//disable utente
	$template->assign('tpl_disable_utente',1);
	
	for ($i=0; $i < count($istances); $i++){
		$main_menu[] = array(
							'istance' => $istances[$i]['name'],
							'cnt' => $i,
							);

	}
	//risorse esterne
	$template->assign('HEAD_ISTANZA',HEAD_ISTANZA);
	$template->assign('FOOT_ISTANZA',FOOT_ISTANZA);
	$template->assign('TESTATA_ISTANZA',TESTATA_ISTANZA);
	$template->assign('mymenu', $main_menu);
	$template->assign('istance', $istance);
	
	$template->display(dirname(__FILE__) . $head_template);
	$template->display(dirname(__FILE__) . $login_template);
	$template->display(dirname(__FILE__) . $menu_template);
	$template->display(dirname(__FILE__) . $foot_template);

}else{


	$_SESSION[VERSION]['login']['username'] = $_POST['username'];
	$_SESSION[VERSION]['login']['password'] = md5($_POST['password']);
	$_SESSION[VERSION]['login']['istance'] = $_POST['istance'];
	
	
	#print_r($_SESSION); die();

	header("Location:".MAXLIST_URL . $_POST['istance'] . '/home/');

}