<?php

/**
 * @author Damo
 * 
 * @package damo
 * @subpackage pages
 */
class PortfolioPage extends Page {
	
	private static $icon = 'mysite/images/icons/portfolio.png';
    
	private static $has_many = array(
		'Items' => 'PortfolioItem'
	);
	
	function getCMSFields() {
		$fields = parent::getCMSFields();
		$itemConfig = GridFieldConfig_Custom::create()
				->addBulkEditingTools()
				->addRelationHandling()
				->addSortable();
		$itemManager = new GridField('Items', 'Items', $this->Items(), $itemConfig);
		$fields->addFieldToTab('Root.Items', $itemManager);
		return $fields;
	}
    
}

class PortfolioPage_Controller extends Page_Controller {
    
    
}