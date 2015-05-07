<?php

class Pemberdayaan_Controller extends Base_Controller {

	public $restful = true;
  	public $views = 'pemberdayaan';
  	public $report = 'pemberdayaan.report';

	public function get_index()
	{	
    	return View::make('themes.modul.'.$this->views.'.index',$this->data);
	}
}