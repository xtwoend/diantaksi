<?php

class News_Controller extends Base_Controller {
	public $restful = true;
	public $views 	= 'news';

	public function get_index()
	{	
		$this->data['messages'] = News::where('expired','>',date('Y-m-d H:i:s'))->get();
    	return View::make('themes.modul.'.$this->views.'.index',$this->data);
	}

	public function get_add()
	{	
		$this->data['pools'] = Koki::to_dropdown(Pool::all(),'id','pool_name',array(0 => 'All'));
		$this->data['users'] = Koki::to_dropdown(User::all(),'id','first_name');
		$this->data['create'] = true;
		return View::make('themes.modul.'.$this->views.'.form',$this->data);
	}

	public function post_add()
	{
		$data = Input::json();

		$news = new News;
		$news->expired = $data->tanggal.' '.$data->jam;
		$news->priority = $data->priority;
		$news->message = $data->message;
		$news->pool_id = $data->pool_id;
		$news->user_id = Auth::user()->id;
		$news->to_user_id = $data->to_user_id;
		$news->msg_type = $data->msg_type;
		$news->save();

		return json_encode(array('msg'=>'Pesan berhasil di kirim'));
	}

	public function get_message()
	{
		
		return View::make('themes.modul.'.$this->views.'.message',$this->data);
	}

	public function get_delete($id=false)
	{	if(!$id) return Redirect::to('news');
		
		$news= News::find($id);
		$news->delete();

		return Redirect::to('news');
	}
}