<?php

namespace Serverfireteam\Panel;

use Serverfireteam\Panel\CrudController;

class PermissionController extends CrudController {

	public function all($entity) {

		parent::all($entity);

		$this->filter = \DataFilter::source(new Permission());
		$this->filter->add('id', \Lang::get('panel::fields.PermissionNumber'), 'text');
		$this->filter->add('name', \Lang::get('panel::fields.PermissionName'), 'text');
		$this->filter->submit('search');
		$this->filter->reset('reset');
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
		$this->edit->link("rapyd-demo/filter", \Lang::get('panel::fields.PermissionArticles'), "TR")->back();
		$this->edit->add('name', \Lang::get('panel::fields.PermissionURL'), 'text')->rule('required');
		$this->edit->add('label', \Lang::get('panel::fields.PermissionDescription'), 'text')->rule('required');

		$this->edit->saved(function () use ($entity) {
			$this->edit->message('Awesome, Data Saved successfully');
			$this->edit->link('panel/Permission/all', 'Back');
		});

		$this->addHelperMessage($helpMessage);

		return $this->returnEditView();
	}
}
