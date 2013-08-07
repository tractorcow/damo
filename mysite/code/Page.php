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
		
		Requirements::javascript(THIRDPARTY_DIR . '/jquery/jquery.min.js');
		Requirements::javascript(THIRDPARTY_DIR . '/jquery-entwine/dist/jquery.entwine-dist.js');
		Requirements::javascript('mysite/javascript/youtube.js');
	}
}
