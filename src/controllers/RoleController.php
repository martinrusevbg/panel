<?php

namespace Serverfireteam\Panel;

use Serverfireteam\Panel\CrudController;

class RoleController extends CrudController {

	public function all($entity) {

		parent::all($entity);

		$this->filter = \DataFilter::source(Role::with('permissions'));
		$this->filter->add('id', \Lang::get('panel::fields.RoleNumber'), 'text');
		$this->filter->add('name', \Lang::get('panel::fields.RoleName'), 'text');
		$this->filter->submit(\Lang::get('panel::fields.search'));
		$this->filter->reset(\Lang::get('panel::fields.reset'));
		$this->filter->build();

		$this->grid = \DataGrid::source($this->filter);
		$this->grid->add('id', \Lang::get('panel::fields.RoleNumber'), true)->style("width:100px");
		$this->grid->add('name', \Lang::get('panel::fields.RoleName'))->style('width:100px');
		$this->grid->add('label', \Lang::get('panel::fields.RoleDescription'));
		$this->grid->add('{{ implode(", ", $permissions->lists("name")->all()) }}', \Lang::get('panel::fields.RoleName') );


		$this->addStylesToGrid();

		return $this->returnView();
	}

	public function edit($entity) {

		parent::edit($entity);

		$this->edit = \DataEdit::source(new Role());

		$helpMessage = \Lang::get('panel::fields.roleHelp');

		$this->edit->label(\Lang::get('panel::fields.RoleEditTitle'));
		$this->edit->add('name', \Lang::get('panel::fields.RoleName'), 'text')->rule('required');
		$this->edit->add('label', \Lang::get('panel::fields.RoleDescription'), 'text')->rule('required');
		$this->edit->add('permissions',\Lang::get('panel::fields.RolePermissions'),'checkboxgroup')->options(Permission::lists('name', 'id')->all());
		$this->edit->saved(function () use ($entity) {
			$this->edit->message(\Lang::get('panel::fields.dataSavedSuccessfull'));
			$this->edit->link('panel/Permission/all', \Lang::get('panel::fields.back'));
		});


		$this->addHelperMessage($helpMessage);

		return $this->returnEditView();
	}
}
