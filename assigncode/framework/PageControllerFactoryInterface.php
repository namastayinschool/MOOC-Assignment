<?php
interface PageControllerFactoryInterface
{
	/**
	 * Takes the name of the page and generates the PageController object 
	 * used as the business logic layer
	 * @param string $pageName
	 */
	static public function makePageController($pageName);
}