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
    
	public function Tags() {
		return PortfolioTag::get();
	}
    
}

class PortfolioPage_Controller extends Page_Controller {
	
	private static $allowed_actions = array('tag');
	
	public function init() {
		parent::init();
		
		Requirements::javascript('mysite/javascript/portfolio.js');
	}
	
	public function tag() { return $this; }
	
	/**
	 * Cached selected tag
	 *
	 * @var PortfolioTag
	 */
	protected $currentTag = null;
	
	/**
	 * Selected tag
	 * 
	 * @return PortfolioTag
	 */
	public function CurrentTag() {
		if($this->currentTag) return $this->currentTag;
		if($this->request->param('Action') === 'tag') {
			$urlSegment = $this->request->param('ID');
			$this->currentTag = PortfolioTag::get()->filter('URLSegment', $urlSegment)->first();
		}
		return $this->currentTag;
	}
	
	public function Items() {
		if($tag = $this->CurrentTag()) {
			return $tag->Items();
		} else {
			return $this->data()->Items();
		}
	}
    
}