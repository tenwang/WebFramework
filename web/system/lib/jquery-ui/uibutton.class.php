<?php
/**
 * Scavix Web Development Framework
 *
 * Copyright (c) since 2012 Scavix Software Ltd. & Co. KG
 *
 * This library is free software; you can redistribute it
 * and/or modify it under the terms of the GNU Lesser General
 * Public License as published by the Free Software Foundation;
 * either version 3 of the License, or (at your option) any
 * later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library. If not, see <http://www.gnu.org/licenses/>
 *
 * @author Scavix Software Ltd. & Co. KG http://www.scavix.com <info@scavix.com>
 * @copyright since 2012 Scavix Software Ltd. & Co. KG
 * @license http://www.opensource.org/licenses/lgpl-license.php LGPL
 */
namespace ScavixWDF\JQueryUI;

/**
 * Wrapper around jQueryUI Butto
 * 
 * See http://jqueryui.com/button/
 */
class uiButton extends uiControl
{
	private $_icon;
	
	/**
	 * @param string $text Label
	 * @param string $icon Valid <uiControl::Icon>
	 */
	function __initialize($text,$icon=false)
	{
		parent::__initialize("button");
		if( $icon )
			$this->_icon = self::Icon($icon);
		
		$this->type = "button";
		if( $text )
			$this->content($text);
	}
	
	/**
	 * Overrides <Control::Make> with own logic.
	 * 
	 * @param string $label Label
	 * @param string $onclick OnClick JS code
	 * @return uiButton The new button
	 */
	static function Make($label,$onclick=false)
	{
		$res = new uiButton($label);
		if( $onclick ) $res->onclick = $onclick;
		return $res;
	}
	
	/**
	 * Sets the <uiButton>s icon.
	 * 
	 * @param string $icon Valid <uiControl::Icon>
	 * @return uiButton `$this`
	 */
	function setIcon($icon)
	{
		$this->_icon = self::Icon($icon);
		return $this;
	}

	/**
	 * @override
	 */
	function PreRender($args=array())
	{
		if( count($args) > 0 )
		{
			if(isset($this->_icon))
				$this->opt('icons',array('primary'=>"ui-icon-".$this->_icon));
			
			if( count($this->_content)==0 )
				$this->opt('text',false);
		}
		return parent::PreRender($args);
	}
	
	/**
	 * Creates javascript code to redirect elsewhere on button click.
	 * 
 	 * @param mixed $controller The controller to be loaded (can be <Renderable> or string)
	 * @param string $method The method to be executed
	 * @param array|string $data Optional data to be passed
	 * @return uiButton `$this`
	 */
	function LinkTo($controller,$method='',$data=array())
	{
		$q = buildQuery($controller,$method,$data);
		$this->onclick = "document.location.href = '$q';";
		return $this;
	}
}
