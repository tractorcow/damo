<?php

class GridFieldConfig_Custom extends GridFieldConfig_RecordEditor {
	
	/**
	 * @return GridFieldConfig_Custom
	 */
	public static function create() {
		return call_user_func_array('Object::create', array_merge(
			array(get_called_class()), 
			func_get_args()
		));
	}
	
	/**
	 * Remove all components of any of the given types
	 * 
	 * @param $class
	 * @param $class,... 
	 * @return GridFieldConfig_Custom
	 */
	protected function remove() {
		foreach(func_get_args() as $type) {
			$this->removeComponentsByType($type);
		}
		return $this;
	}
	
	/**
	 * Check if a component exists
	 * 
	 * @param string $component
	 * @return boolean
	 */
	public function hasComponent($component) {
		$items = $this->getComponentsByType($component);
		return $items && $items->exists();
	}
	
	/**
	 * Removes paging
	 * 
	 * @return GridFieldConfig_Custom
	 */
	protected function removePaging() {
		$this->remove(
			'GridFieldSortableHeader', 'GridFieldFilterHeader', 'GridFieldPageCount', 'GridFieldPaginator'
		);
		return $this;
	}
	
	/**
	 * Have bulk editing tools been setup?
	 *
	 * @var boolean
	 */
	protected $hasBulkEditingTools = false;
	
	/**
	 * Add bulk editing tools
	 * 
	 * @return GridFieldConfig_Custom
	 */
	public function addBulkEditingTools() {
		
		if(!$this->hasBulkEditingTools) {
			$this->hasBulkEditingTools = true;
			$this->addComponents(new GridFieldBulkManager());
		}
		return $this;
	}
	
	/**
	 * Has relation editing tools been setup yet?
	 *
	 * @var boolean
	 */
	protected $hasRelationHandling = false;
	
	/**
	 * Add relation editing tools
	 * 
	 * @return GridFieldConfig_Custom
	 */
	public function addRelationHandling() {
		
		if(!$this->hasRelationHandling) {
			$this->hasRelationHandling = true;
			// Dont have filter or paging for sortable pages
			$segment = $this->hasComponent('GridFieldPaginator') ? 'GridFieldPaginator' : null;
			$this->addComponent(new GridFieldManyRelationHandler(), $segment);
		}
		
		return $this;
	}
		
	/**
	 * Has sortable rows been setup yet?
	 *
	 * @var boolean
	 */
	protected $hasSortable = false;
	
	/**
	 * Make the field sortable
	 * 
	 * @param string $sortColumn
	 * @return GridFieldConfig_Custom
	 */
	public function addSortable($sortColumn = 'SortOrder') {
		
		// Dont have filter or paging for sortable pages
		$this->removePaging();
		
		// Add sorting action and bulk tools
		if(!$this->hasSortable) {
			$this->hasSortable = true;
			$this->addComponent(new GridFieldSortableRows($sortColumn));
		}
		
		return $this;
	}
	
	/**
	 * Has bulk image editing been setup yet?
	 *
	 * @var boolean
	 */
	protected $hasBulkImage = false;
	
	/**
	 * Add bulk image editing tools
	 * 
	 * @param string $imageField
	 * @param string $uploadFolder
	 * @return GridFieldConfig_Custom
	 */
	public function addBulkImage($imageField = null, $uploadFolder = null) {
		
		// Skip if bulk image editing already exists
		if(!$this->hasBulkImage) {
			$this->hasBulkImage = true;

			$this->addComponents($imageConfig = new GridFieldBulkImageUpload($imageField));

			// Set upload folder
			if($uploadFolder) {
				$imageConfig->setConfig('folderName', $uploadFolder);
			}

			// Remove upload field from bulk edit field list - This breaks the code
			$imageConfig->setConfig('fieldsClassBlacklist', array('ImageField', 'UploadField'));
		}
		return $this;
	}
}
