<?php

namespace App\Controllers;

class Blog extends \App\Controllers\Fendy\BaseRestfulController
{
	// Get all data categories
	function categories()
	{
		$model = new \App\Models\Fendy\Berita\Categories();
		if ($get = $model->getAllData(getQueryParamPagination())) {
			return $this->respond($get);
		}
		return $this->respond($this->tableRecordEmpty);
	}

	// Get all data tags
	function tags()
	{
		$model = new \App\Models\Fendy\Berita\Tags();
		if ($get = $model->getAllData(getQueryParamPagination())) {
			return $this->respond($get);
		}
		return $this->respond($this->tableRecordEmpty);
	}

	// Get all data news
	function news()
	{
		$model = new \App\Models\Fendy\Berita\News();
		if ($get = $model->getAllData(getQueryParamPagination())) {
			return $this->respond($get);
		}
		return $this->respond($this->tableRecordEmpty);
	}
}