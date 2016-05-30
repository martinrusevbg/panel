<?php

namespace Serverfireteam\Panel;

use Serverfireteam\Panel\CrudController;

class LinkController extends CrudController {

    public function all($entity) {

        parent::all($entity);

        $this->filter = \DataFilter::source(new Link());
        $this->filter->add('id', \Lang::get('panel::fields.LinksNumber'), 'text');
        $this->filter->add('display', \Lang::get('panel::fields.LinksDisplay'), 'text');
        $this->filter->submit(\Lang::get('panel::fields.search'));
        $this->filter->reset(\Lang::get('panel::fields.reset'));
        $this->filter->build();

        $this->grid = \DataGrid::source($this->filter);
        $this->grid->add('id', \Lang::get('panel::fields.LinksNumber'), true)->style("width:100px");
        $this->grid->add('display', \Lang::get('panel::fields.LinksDisplay'));
        $this->grid->add('url', \Lang::get('panel::fields.LinksModel'));

        $this->addStylesToGrid();

        return $this->returnView();
    }

    public function edit($entity) {

        parent::edit($entity);

        $this->edit = \DataEdit::source(new Link());

        Link::creating(function($link)
        {
            $appHelper = new libs\AppHelper();
            return ( class_exists( $appHelper->getNameSpace() . $link['url'] ));
        });

        $helpMessage = \Lang::get('panel::fields.links_help');

        $this->edit->label('Edit Links');
        $this->edit->add('display', \Lang::get('panel::fields.LinksDisplay'), 'text')->rule('required');
        $this->edit->add('url', \Lang::get('panel::fields.LinksLink'), 'text')->rule('required');

        $this->edit->saved(function () use ($entity) {
           $this->edit->message(\Lang::get('panel::fields.dataSavedSuccessfull'));
            $this->edit->link('panel/Permission/all', \Lang::get('panel::fields.back'));
        });
        $this->addHelperMessage($helpMessage);

        return $this->returnEditView();
    }
}
