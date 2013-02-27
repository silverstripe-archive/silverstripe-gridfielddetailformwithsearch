<?php
/**
 * Grid Field Detail Form that has a search sidebar always visible. Note that we just need to modify the item_request,
 * not the whole GridFieldDetailForm. Usage:

 class MyDataObjectAdmin extends ModelAdmin {

 	static $managed_models = array(
 		'MyDataObject'
 	);

 	public function getEditForm($id = null, $fields = null) {
 		$form = parent::getEditForm($id, $fields);
  		$config = $form->Fields()->first()->getConfig();
 		$config->getComponentByType('GridFieldDetailForm')
 				->setItemRequestClass('GridFieldDetailFormWithSearch_ItemRequest')
 				->setTemplate('GridFieldDetailFormWithSearch');
  		return $form;
 	}
 }
 */
class GridFieldDetailFormWithSearch_ItemRequest extends GridFieldDetailForm_ItemRequest {

	public function edit($request) {
		$controller = $this->getToplevelController();
		$form = $this->ItemEditForm($this->gridField, $request);

		$return = $this->customise(array(
			'Backlink' => $controller->hasMethod('Backlink') ? $controller->Backlink() : $controller->Link(),
			'ItemEditForm' => $form,
			'SearchForm' => $controller->SearchForm()
		))->renderWith($this->template);

		if($request->isAjax()) {
			return $return;
		} else {
			return $controller->customise(array(
				'Content' => $return,
			));
		}
	}

	public function ItemEditForm() {
		$form = parent::ItemEditForm();
		$form->setAttribute('data-pjax-fragment', 'CurrentForm ');
		return $form;
	}
}