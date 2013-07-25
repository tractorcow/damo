<?php

/**
 * @author Damo
 * 
 * @package damo
 * @subpackage pages
 */
class PortfolioTag extends DataObject {
	
	private static $db = array(
		'Title' => 'Varchar(255)',
		'URLSegment' => 'Varchar(255)'
	);
	
	private static $belongs_many_many = array(
		'Items' => 'PortfolioItem'
	);
	
	public function getItemCount() {
		return $this->Items()->count();
	}
	
	private static $default_sort = 'Title ASC';
	
	public function Link() {
		$basePage = DataObject::get_one('PortfolioPage');
		if(empty($basePage) || !$basePage->exists()) return null;
		
		return Controller::join_links($basePage->Link('tag'), $this->URLSegment);
	}
	
	/**
	 * Find existing KnowledgeTag by title, matching against URLSegment
	 * 
	 * @param string $title
	 * @return KnowledgeTag
	 */
	public static function find_existing($title) {
		$urlSegment = self::generate_urlsegment($title);
		return self::find_by_urlsegment($urlSegment);
	}
	
	/**
	 * Find existing KnowledgeTag by URLSegment
	 * 
	 * @param string $urlSegment
	 * @return KnowledgeTag
	 */
	public static function find_by_urlsegment($urlSegment) {
		$filter = sprintf('"PortfolioTag"."URLSegment" LIKE \'%s\'', Convert::raw2sql($urlSegment));
		return self::get()->where($filter)->first();
	}
	
	protected function updateURLSegment() {
		$this->URLSegment = self::generate_urlsegment($this->Title);
	}
	
	public static function generate_urlsegment($title) {
		$filter = URLSegmentFilter::create();
		$segment = $filter->filter(trim($title));
		
		// Fallback to generic page name if path is empty (= no valid, convertable characters)
		if(empty($segment) || $segment == '-' || $segment == '-1') {
			$segment = "category-{$this->ID}";
		}
		
		return $segment;
	}
	
	protected function onBeforeWrite() {
		parent::onBeforeWrite();
		$this->updateURLSegment();
	}
	
	/**
	 * Generate a list of tags from a taglist
	 * 
	 * @param string $tagList String containing tags, split by comma
	 * @return ArrayList
	 */
	public static function create_from_taglist($tagList) {
		
		// Split string
		$tagStrings = preg_split('/\s*,\s*/i', $tagList);
		$tags = new ArrayList();
		foreach($tagStrings as $tagString) {
			
			// Skip empty strings
			$tagString = trim($tagString);
			if(empty($tagString)) continue;
			
			// Given a tag, try to find the dataobject it relates to
			$tag = self::find_existing($tagString);
			if(!$tag || !$tag->exists()) {
				$tag = self::create();
				$tag->Title = $tagString;
				$tag->write();
			}
			$tags->add($tag);
		}
		return $tags;
	}
}