<?php
class ModelFactory implements ModelFactoryInterface
{

	/**
	 * Creates the Model object that acts as the data access layer.
	 * Trigger a fatal error if the class is invalid or not found
	 * @param string $modelClassName
	 */
	public static function makeModel($modelClassName) {
		/**
		 * Stores the model object that the method creates
		 * @var ModelInterface
		 */
		$modelClass = null;
		
		/*
		
		
		
		
		*/
		
		// ensure the model class name is indeed a string
		ValidatorAbstract::ensureParameterIsString($modelClassName);
		
		// ...and ensure it is not empty
		ValidatorAbstract::ensureParameterNotEmpty($modelClassName);
		
		// Verify the model object class is valid class before creating it
		$filePath = APP_MODELS . DIRECTORY_SEPARATOR . "$modelClassName.php";
		if ( file_exists( $filePath ) ) {
			if ( class_exists( $modelClassName) ) {
				// crete the new model object using the Reflection API
				$modelClass = new ReflectionClass($modelClassName);
				if ( $modelClass->isSubClassOf( 'ModelInterface' ) ) {
					return $modelClass->newInstance();
				}
				else {
					trigger_error('Invalid object used. Must be a ModelInterface object');
					return FALSE;
				}
			}
		}
		trigger_error('No file exists for the Model class ' . $filePath);
		return false;		
	}
}
