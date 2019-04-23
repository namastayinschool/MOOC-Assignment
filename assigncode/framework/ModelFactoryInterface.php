<?php
interface ModelFactoryInterface
{
	/**
	 * Takes the name of the model and generates the Model object 
	 * used as the data access layer
	 * @param string $modelClassName
	 */
	static public function makeModel($modelClassName);
}
