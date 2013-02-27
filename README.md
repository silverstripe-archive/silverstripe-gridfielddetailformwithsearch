Grid Field Detail Form that has a search sidebar always visible. Note that we just need to modify the item_request,
not the whole GridFieldDetailForm. Usage:

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