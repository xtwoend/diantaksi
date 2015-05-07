<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('dashboard');
    }


    /**
     * change pool.
     *
     * @return
     */
    public function change($pool_id = null)
    {
    	if(is_null($pool_id)) 
    		return redirect('auth/logout');

    	$user = Auth::user();
    	$user->pool_id = $pool_id;
    	$user->save();

    	return redirect('home');
    }
}
