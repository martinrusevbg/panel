<?php
namespace Serverfireteam\Panel;

use Illuminate\Routing\Controller;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class UsersController extends Controller{
    
    
    public  function all($entity){
        
        parent::all($entity);
       
        $this->filter = \DataFilter::source(new \User());
        $this->filter->add('id', \Lang::get('panel::fields.UserNumber'), 'text');
        $this->filter->add('name', \Lang::get('panel::fields.UserName'), 'text');
        $this->filter->submit(\Lang::get('panel::fields.search'));
        $this->filter->reset(\Lang::get('panel::fields.reset'));
        $this->filter->build();
                
        $this->grid = \DataGrid::source($this->filter);
        $this->grid->add('id',\Lang::get('panel::fields.UserNumber'), true)->style("width:100px");
        $this->grid->add('name',\Lang::get('panel::fields.UserName'));
        $this->addStylesToGrid();           
                       
        return $this->returnView();
    }
           
    
    
    
    public function edit($entity){
                
        parent::edit($entity);
              
        $this->edit = \DataEdit::source(new \User());
        
        $this->edit->label('Edit User');
        $this->edit->add('name',\Lang::get('panel::fields.UserName'), 'text')->rule('required|min:5');
        $this->edit->add('username',\Lang::get('panel::fields.UserUserName'), 'text')->rule('required|min:5');
        return $this->returnEditView();
    }
   
    public function getCreateUser(){
        return \View::make('panelViews::createUser');
    }

    public function postCreateUser(){
        
    }
}