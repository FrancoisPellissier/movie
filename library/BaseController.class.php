<?php
namespace library;

abstract class BaseController {
	protected $action = '';
	protected $module = '';
	protected $view = '';
	protected $request;

	public function __construct(\library\HTTPRequest $request, $module, $action) {
		$this->setModule($module);
		$this->setAction($action);
		$this->request = $request;

		$this->view = new \library\View($module, $action);
	}

	public function execute() {
		$method = $this->action;
		 
		if (!is_callable(array($this, $method))) {
			throw new \RuntimeException('L\'action "'.$this->action.'" n\'est pas définie sur ce module');
		}
		
		$this->$method($this->request);
	}

	public function setModule($module) {
		$this->module = $module;
	}
	 
	public function setAction($action) {
		$this->action = $action;
	}	
}