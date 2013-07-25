<?php


/**
 * @author Damo
 * 
 * @package damo
 * @subpackage pages
 */
class Page extends SiteTree {
	public function getCMSFields() {
		$fields = parent::getCMSFields();
		
		$fields->removeByName('GoogleAnalytics');
		
		return $fields;
	}
}


/**
 * @author Damo
 * 
 * @package damo
 * @subpackage pages
 */
class Page_Controller extends ContentController {
	
	public function init() {
		parent::init();
	}
}
