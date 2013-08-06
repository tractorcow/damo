<?php

/**
 * @author Damo
 * 
 * @package damo
 * @subpackage pages
 */
class PortfolioItem extends DataObject {
	
	private static $db = array(
		'Title' => 'Varchar(255)',
		'Link' => 'Varchar(255)',
		'SortOrder' => 'Int',
		'Description' => 'Text',
		'Client' => 'Varchar(255)'
	);
	
	private static $has_one = array(
		'Image' => 'Image',
		'Parent' => 'PortfolioPage'
	);
	
	private static $many_many = array(
		'Tags' => 'PortfolioTag'
	);
	
	private static $default_sort = '"PortfolioItem"."SortOrder" ASC';
	
	public function getCMSFields() {
		
		// Image manager
		$imageField = new UploadField('Image');
		$imageField->setAllowedFileCategories('image');
		$imageField->setFolderName('PortfolioImages');
		
		// Direct tags list
		$tagsSelector = ListboxField::create('Tags', false)
					->setMultiple(true)
					->setSource(PortfolioTag::get()->map()->toArray())
					->setAttribute('data-placeholder', 'Search for existing tags')
					->setAttribute('style', 'min-width: 250px;');
		$tagsCreator = new TextField('NewTags', false, null, 1024);
		$tagsCreator->setAttribute('placeholder', 'Create tags (comma separated)');
		$tagsCreator->setAttribute('style', 'min-width: 245px;');		
		$tagGroup = new FieldGroup(
			$tagsSelector,
			$tagsCreator
		);
		$tagGroup->setTitle('Portfolio Tags');
		
		return new FieldList(
			new TextField('Title', 'Title', null, 255),
			new TextField('Client',	'Client', null, 255),
			new TextField('Link', 'Link', null, 255),
			$imageField,
			$tagGroup,
			new TextareaField('Description')
		);
	}
	
	
	protected function propegateTags() {
		// add all new tags to the tag list
		if(empty($this->NewTags)) return;
		
		// Ask knowledge tag to generate all tags
		$tagIDs = PortfolioTag::create_from_taglist($this->NewTags);
		
		// Add these to existing tags
		if(!empty($tagIDs)) {
			$this->Tags()->addMany($tagIDs);
		}
	}
	
	function onBeforeWrite() {
		
		// Fix tags
		$this->propegateTags();
		
		parent::onBeforeWrite();
	}
}
