<?php

/***
 * Project: maxlist <br />
 * Copyright (C) 2006 Massimiliano Balestrieri
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
 * @author Massimiliano Balestrieri <io@maxb.net>
 * @version 1.0
 * @copyright 2006 Massimiliano Balestrieri.
 * @package Models
 */


//system model. very important

class ConfigureModel extends ModuleModel {


	public function __construct($params = false) {
		$this->_name = 'configure';
		$this->_dao = $this->_get_dao(dirname(__FILE__), $params);
	}
	public function get($item){
		return $this->_dao->get($item);
	}
	public function save($item, $value, $editable = 1, $ignore_errors = 0, $role = 1) {
		($value == "false" || $value == "no") ? $value = 0 : ($value == "true" || $value == "yes") ? $value = 1 : false;
		return $this->_dao->save($item, $value, $editable, $ignore_errors, $role);
	}
	public function update($id) {
		global $APP;
		$update = false;
		if (is_array($APP->CONF->defaults)) {
			reset($APP->CONF->defaults);
			$info = $APP->CONF->defaults[$id];
			if ($id == "website" || $id == "domain") {
				$this->_params["values"][$id] = str_replace("[DOMAIN]", "", $this->_params["values"][$id]);
				$this->_params["values"][$id] = str_replace("[WEBSITE]", "", $this->_params["values"][$id]);
			}
			if ($this->_params["values"][$id] == "" && $info[3]) {
				$this->_flash(0, $this->_('cannot be empty'));
				return $update;
			} else {
				$update = $this->_dao->save($id, $this->_params["values"][$id], 0);
			}
		}
		return $update;
	}
	public function get_configurations() {
		global $APP;
		//TODO : usecase
		##if(isSuperUser() || isRoleRoot() || isRoleAdmin() || isRoleMaster()){
		$configurations = array ();
		if (is_array($APP->CONF->defaults)) {
			while (list ($key, $val) = each($APP->CONF->defaults)) {
				if (is_array($val)) {
					##if(isset($val[3]) && $val[3] >= getRole()){//TODO : fix role check
					$dbval = $APP->CONF->get($key);
					if (isset ($dbval))
						$value = $dbval;
					else
						$value = $val[0];

					$configurations[] = array (
						'val0' => $val[0],
						'val1' => $this->_($key), 
						'key' => $key, 
						'value' => strlen(nl2br(htmlspecialchars(stripslashes($value)))) > 0 ? 
												 nl2br(htmlspecialchars(stripslashes($value))) : 
												"&nbsp;", 
						'field' => $APP->CONF->get_field_configuration($key), 
						'container' => ("container_" . $key),
					);
					//echo 'gettext("' .$key. '");' ."\n\n";
					##}
				}
			}
		}//die;
		return $configurations;
	}
	
}