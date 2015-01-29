<?php
class WebSite_PageView extends Framework_Views_PageView
{

	public function parse ()
	{
		$page = $this->getPage();

		$this->assignVariable("title", $page->getTitle());
		$this->assignVariable("navigationItems", $page->getNavigationItems());

		return parent::parse();
	}
}