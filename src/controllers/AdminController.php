<?php

namespace Serverfireteam\Panel;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Serverfireteam\Panel\CrudController;
use \Illuminate\Http\Request;
/**
 * Description of PagePanel
 *
 * @author alireza
 */
class AdminController extends CrudController{
    
    public function all($entity){
        parent::all($entity); 

        $this->filter = \DataFilter::source(Admin::with('roles'));
        $this->filter->add('id', \Lang::get('panel::fields.AdminNumber'), 'text');
        $this->filter->add('firstname', \Lang::get('panel::fields.AdminFirstName'), 'text');
        $this->filter->add('last_name', \Lang::get('panel::fields.AdminLastName'), 'text');
        $this->filter->add('email', \Lang::get('panel::fields.AdminEmail'), 'text');
        $this->filter->submit(\Lang::get('panel::fields.search'));
        $this->filter->reset(\Lang::get('panel::fields.reset'));
        $this->filter->build();
                
        $this->grid = \DataGrid::source($this->filter);
        $this->grid->add('id',\Lang::get('panel::fields.AdminNumber'), true)->style("width:100px");
        $this->grid->add('{{ $first_name }} {{ $last_name}}',\Lang::get('panel::fields.AdminFirstName'));
        $this->grid->add('email',\Lang::get('panel::fields.AdminEmail'));
       $this->grid->add('{{ implode(", ", $roles->lists("name")->all()) }}', \Lang::get('panel::fields.AdminRole'));

        $this->addStylesToGrid();
        return $this->returnView();
    }
    
    public function  edit($entity){
        
        if (\Request::input('password') != null )
        {
            $new_input = array('password' => \Hash::make(\Request::input('password'))); 
            \Request::merge($new_input);
        }
        
        parent::edit($entity);

        $this->edit = \DataEdit::source(new Admin());

        $this->edit->label('Edit Admin');
        $this->edit->add('email',\Lang::get('panel::fields.AdminEmail'), 'text')->rule('required|min:5');
        $this->edit->add('first_name', \Lang::get('panel::fields.AdminFirstName'), 'text');
        $this->edit->add('last_name', \Lang::get('panel::fields.AdminLastName'), 'text');
        $this->edit->add('password', \Lang::get('panel::fields.AdminPassword'), 'password')->rule('required');  
        $this->edit->add('roles',\Lang::get('panel::fields.AdminRoles'),'checkboxgroup')->options(Role::lists('name', 'id')->all());

        return $this->returnEditView();
    }

}
