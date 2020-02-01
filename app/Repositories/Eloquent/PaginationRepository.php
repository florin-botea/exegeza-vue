<?php
namespace App\Repositories\Eloquent;

abstract class PaginationRepository
{
	//! target id path pageSize
	private $query;
	private $pageSize = 3;
	
	public function __construct(){
		$this->query = $this->query();
	}
	
	abstract protected function path();
	
	abstract protected function query();
	
	public function getPaginated()
	{
		return $this->query->paginate($this->pageSize)->withPath($this->path());
	}
	
	public function getPageContainingId($id)
	{
		$query = clone $this->query;
		$comments_before = $this->query->where('id', '<=', $id)->count();
		$this->query = $query;
		$currentPage = intval(ceil($comments_before/$this->pageSize));
		$this->setPage($currentPage);
		return $this->getPaginated();
	}
	
	public function setPage($page){
		\Illuminate\Pagination\Paginator::currentPageResolver(function () use ($page) {
			return $page;
		});
	}
	
	public function where(array $condition){
		$this->query = $this->query->where($condition);
		return $this;
	}
	
	public function find($id)
	{
		return $this->query->find($id);
	}
}