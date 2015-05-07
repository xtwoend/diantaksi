<?php

class Settingcicilan_Controller extends Base_Controller {

	public $restful = true;

  	public $views = 'settingcicilan';
  	public $report = 'settingcicilan.report';

	public function get_index()
	{  
		
		return View::make('themes.modul.'.$this->views.'.index',$this->data);
	}
}