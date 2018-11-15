<?php

namespace AirAroma\Controller\Admin\Translate;

use App\Http\Controllers\Controller;

class TranslateController extends Controller
{

	function __construct() 
	{
		$this->request = app('request');
		$this->config = app('config');
	}

	public function pages()
	{
		return view('admin.translate.pages');
	}
	public function pagesEdit()
	{
		return view('admin.translate.pages-edit');
	}

	public function tags()
	{
		return view('admin.translate.tags');
	}
	public function industries()
	{
		return view('admin.translate.industries');
	}
	public function oilgroups()
	{
		return view('admin.translate.oilgroups');
	}
	public function months()
	{
		return view('admin.translate.months');
	}
}
