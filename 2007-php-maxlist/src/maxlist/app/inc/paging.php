<?php
/***
 * Project: Maxlist <br />
 * Copyright (C) 2007 Massimiliano Balestrieri
 * 
 * Software based on : 
 * PHPlist, Mailinglist system using PHP and Mysql
 * Copyright (C) 2000,2001,2002,2003,2004,2005 Michiel Dethmers, tincan ltd
 * 
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 *
 *
 * Maxlist is a fork of PhpList, a newsletter manager. 
 * The code was deeply changed so there are features of the original phpList and new ones. 
 * It uses smarty, generates XHTML strict, uses an AJAX layer, italian language ,
 * multi-istance, and use case based.
 *
 * 
 * $Id: paging.php 223 2007-11-10 23:51:32Z maxbnet $
 * $LastChangedDate: 2007-11-10 23:51:32 +0000 (Sat, 10 Nov 2007) $
 * $LastChangedRevision: 223 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/inc/paging.php $
 * 
 * $Author: maxbnet $
 * $Date: 2007-11-10 23:51:32 +0000 (Sat, 10 Nov 2007) $
 */

if(!defined('REWRITE_PAGING')) define('REWRITE_PAGING',1); 
class TablePaging{
	
	
	var $str_get = null;
	
	var $is_first = true;
	var $is_last = false;
	
	var $have_next = true;
	var $have_prev = false;
	
	var $have_block = false;
	
	var $paginaCorrente = 1;
	var $bloccoCorrente = 1;
	
	var $pagineTotali = 0;
	var $blocchiTotali = 0;
	
	var $elementiBlocco = 5;
	var $firstOfBlock = 1;
	var $lastOfBlock = 5;
	
	var $ajax = 0;
	var $target = 0;
	
	function __construct($risultati_x_pagina, $numero_risultati, $current_page, $blk_curr = 1){
		
		$this->str_get = $this->request_toString();
		$this->paginaCorrente = $current_page;
		$this->bloccoCorrente = $blk_curr;
		
		$this->pagineTotali = ceil($numero_risultati/$risultati_x_pagina);
		
		if(($this->pagineTotali % ($this->elementiBlocco - 2)) > 0){
			$this->blocchiTotali = ceil($this->pagineTotali / ($this->elementiBlocco - 2)) - 1;
		}else{
			$this->blocchiTotali = ceil($this->pagineTotali / ($this->elementiBlocco - 2));
		}
		$this->firstOfBlock = ($blk_curr -1) * ($this->elementiBlocco - 2) + 1;
		$this->lastOfBlock = $this->firstOfBlock + $this->elementiBlocco - 1;
		if($this->lastOfBlock > $this->pagineTotali){
			$this->lastOfBlock = $this->pagineTotali;
		}
		$this->init();
	    	
	}
	function setAjax($ajax){
		$this->ajax = $ajax;
	}
	function setTarget($target){
		$this->target = $target;
	}
	function init(){
		if($this->paginaCorrente > 1){
			$this->is_first = false;
		}
		if($this->paginaCorrente == $this->pagineTotali){
			$this->is_last = true;
		}
		if($this->pagineTotali <= 3){
			$this->is_last = true;
			$this->is_first = true;
		}
		
		if($this->paginaCorrente > 1){
			$this->have_prev = true;
		}
		if($this->paginaCorrente == $this->pagineTotali){
			$this->have_next = false;
		}
		
		if($this->pagineTotali > $this->elementiBlocco){
			$this->have_block = true;
		}
		
		if($this->paginaCorrente > 	$this->pagineTotali){
		  $this->paginaCorrente = 1;
		  $this->is_last = false;
		  $this->is_first = true;
		  $this->have_prev = false;
		}
	
		
	}
	function output(){
		$html = '&nbsp;';
		if($this->lastOfBlock)
			$html = '<span class="ml_numbers">';
		$str_get = $this->getToString();
		$spostamento = $this->elementiBlocco - 2;
//		if($this->bloccoCorrente > 1){
//			$start_ciclo = 1 + (($this->bloccoCorrente - 1) * $spostamento);
//			$fine_ciclo = $start_ciclo + $this->elementiBlocco -1;
//			if($fine_ciclo > $this->pagineTotali){
//				$fine_ciclo = $this->pagineTotali;
//			}
//		}else{
//			$start_ciclo = 1;
//			$fine_ciclo = $start_ciclo + $this->elementiBlocco - 1;
//		}
//		
		for($x = $this->firstOfBlock;$x <= $this->lastOfBlock;$x++){
			$cursor = false;
			if($this->have_block && $x == $this->lastOfBlock) {
				$cursor = 'last';
			}elseif($x == $this->firstOfBlock){
				$cursor = 'first';
			}
			
			$html .= $this->get_linkPagingSingolo($x, $cursor);
		}
		if($this->lastOfBlock){
			$html .= '</span>';
			$html .= $this->get_blockfirstPaging();
			$html .= $this->get_blockpreviousPaging();
			$html .= $this->get_blocknextPaging();
			$html .= $this->get_blocklastPaging();
		}
		//$html .= $this->debug();
		return $html;
	}
	function debug(){
		return $this->paginaCorrente;
	}
	function get_blockfirstPaging(){
		//TODO : paginazione ajax
		##$onclick = null;
		##if($this->ajax)
		##	$onclick = ' onclick="getContent(\''.$_REQUEST['page'].'\',\''.$this->target.'\',\''.$this->str_get.'\')"';
		$link = 'pg=1';
		if(!$this->is_first)
			return '<a href="?'.$this->_make_link($link).'" title="vai alla prima pagina"'.''.'>prima</a>'."\n".##$onclick
				   '<span class="bugFix">&nbsp;|&nbsp;</span>' . "\n";
	}
	
	function get_blocklastPaging(){
		$link = 'pg='.$this->pagineTotali;
		
		if($this->have_block){
			$link .= '&amp;block='.$this->blocchiTotali;
		}
		
		//TODO : paginazione ajax
		##$onclick = null;
		##if($this->ajax)
		##	$onclick = ' onclick="getContent(\''.$_REQUEST['page'].'\',\''.$this->target.'\',\''.$this->str_get. $link.'\')"';
		if($this->pagineTotali > 1 && !$this->is_last)
			return '<a href="?'.$this->_make_link($link) .'" title="vai all\' ultima pagina"'.''.'>ultima</a>'."\n";##$onclick
	}
	function get_blockpreviousPaging(){
		$link = 'pg='.($this->paginaCorrente - 1);
		
		if(($this->paginaCorrente - 1) == $this->firstOfBlock)
			$blocco = $this->bloccoCorrente - 1;
		else
			$blocco = $this->bloccoCorrente;
			
		if($this->bloccoCorrente > 1){
			$link .= '&amp;block='.$blocco;
		}
		
		//TODO : paginazione ajax
		##$onclick = null;
		##if($this->ajax)
		##	$onclick = ' onclick="getContent(\''.$_REQUEST['page'].'\',\''.$this->target.'\',\''.$this->str_get. $link.'\')"';
		
		if($this->pagineTotali > 1 && $this->have_prev)
			return '<a href="?'.$this->_make_link($link) .'" title="vai alla pagina precedente"'.''.'>&lt;&lt; prec</a> |' . "\n";##$onclick
	}
	function get_blocknextPaging(){
		$link = 'pg='.($this->paginaCorrente + 1);
		
		if(($this->paginaCorrente + 1) == $this->lastOfBlock && ($this->paginaCorrente + 1) != $this->pagineTotali)
			$blocco = $this->bloccoCorrente + 1;
		else
			$blocco = $this->bloccoCorrente;
			
		if($this->bloccoCorrente > 1 || (($this->paginaCorrente + 1) == $this->lastOfBlock)){
			$link .= '&amp;block='.$blocco;
		}
		
		//TODO : paginazione ajax
		##$onclick = null;
		##if($this->ajax)
		##	$onclick = ' onclick="getContent(\''.$_REQUEST['page'].'\',\''.$this->target.'\',\''.$this->str_get. $link.'\')"';
		
		if($this->pagineTotali > 1 && $this->have_next)
			return '<a href="?'.$this->_make_link($link) .'" title="vai alla pagina successiva"'.''.'>succ &gt;&gt;</a>' . "\n".##$onclick
			'<span class="hidden">&nbsp;|&nbsp;</span>' . "\n";
	}
	function get_linkPagingSingolo($val, $cursor = false){
		
		$link = 'pg='.$val;
		$blocco = $this->bloccoCorrente;
		
		if($this->have_block){
			if($cursor == 'last' && $val != $this->pagineTotali){
				$blocco = $this->bloccoCorrente + 1;
			}elseif($cursor == 'first' && $val != 1){
				$blocco = $this->bloccoCorrente - 1;
			}
			$link .= '&amp;block='.$blocco;
		}
		
		//TODO : paginazione ajax
		##$onclick = null;
		##if($this->ajax)
		##	$onclick = ' onclick="getContent(\''.$_REQUEST['page'].'\',\''.$this->target.'\',\''.$this->str_get . $link.'\')"';
		
		if($val == $this->paginaCorrente){
			$link = '<span class="ml_currentpage">'.$val.'</span>' . "\n";
		}else{
			$link = '<a href="?'. $this->_make_link($link) . '"'.''.'>'.$val.'</a>' . "\n";##$onclick
		}
		return $link . '<span class="hidden">&nbsp;|&nbsp;</span>' . "\n";
	}
	function getToString(){
		$str = null;
		$x=0;
		$param = $_GET; 
		unset($param['block']);
		unset($param['pg']);
		while($array_cell = each($param)){
			$str .= $array_cell['key'] . "=" . $array_cell['value'];
			$x++;
			if($x < sizeof($param))$str .= "&amp;"; 
		}
		return $str;
	}
	function request_toString(){
		$str = null;
		$x=0;$y=0;
		$param = array_merge($_GET,$_POST);
		$temp = array(); 
		unset($param['block']);
		unset($param['pg']);
		unset($param['rndval']);
		unset($param['search']);
		unset($param['content']);
		unset($param['ajax']);
		while($array_cell = each($param)){
			if(!array_key_exists($array_cell['key'],$temp)){
				if(!is_array($array_cell['value'])){
					$str .= $array_cell['key'] . "=" . $array_cell['value'];
					$temp[$array_cell['key']] = $array_cell['value'];
				}else{
					//TODO : blah -> 2 level - paging not support form array. form array not support get
					foreach($array_cell['value'] as $key => $value){
						$str .= $key . "=" .$value;
						$temp[$key] = $value;
						if($y < sizeof($array_cell['value'])) $str .= "&amp;"; 
						$y++;
					}
				}
			}
			$x++;
			if($x < sizeof($param))$str .= "&amp;"; 
		}
		//print_r($param);
		//echo $str;die;
		return $str;
	}
	function _make_link($link){
		if(strlen($this->str_get)>0){
			return $this->str_get . '&amp;' . $link;
		}else{
			return $link;
		}
	}
	
}