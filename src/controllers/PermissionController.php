<?php

namespace Serverfireteam\Panel;

use Serverfireteam\Panel\CrudController;

class PermissionController extends CrudController {

	public function all($entity) {

		parent::all($entity);

		$this->filter = \DataFilter::source(new Permission());
		$this->filter->add('id', \Lang::get('panel::fields.PermissionNumber'), 'text');
		$this->filter->add('name', \Lang::get('panel::fields.PermissionName'), 'text');
		$this->filter->submit(\Lang::get('panel::fields.search'));
		$this->filter->reset(\Lang::get('panel::fields.reset'));
		$this->filter->build();

		$this->grid = \DataGrid::source($this->filter);
		$this->grid->add('id', \Lang::get('panel::fields.PermissionNumber'), true)->style("width:100px");
		$this->grid->add('name', \Lang::get('panel::fields.PermissionURL'))->style('width:100px');
		$this->grid->add('label', \Lang::get('panel::fields.PermissionDescription'));

		$this->addStylesToGrid();

		return $this->returnView();
	}

	public function edit($entity) {

		parent::edit($entity);

		$this->edit = \DataEdit::source(new Permission());

		$helpMessage = (\Lang::get('panel::fields.roleHelp'));

		$this->edit->label('Edit Permission');
		$this->edit->add('name', \Lang::get('panel::fields.PermissionURL'), 'text')->rule('required');
		$this->edit->add('label', \Lang::get('panel::fields.PermissionDescription'), 'text')->rule('required');

		$this->edit->saved(function () use ($entity) {
			$this->edit->message(\Lang::get('panel::fields.dataSavedSuccessfull'));
			$this->edit->link('panel/Permission/all', \Lang::get('panel::fields.back'));
		});

		$this->addHelperMessage($helpMessage);

		return $this->returnEditView();
	}
}
