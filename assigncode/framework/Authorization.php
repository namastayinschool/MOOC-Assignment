<?php 
/**
 * @category phlyte
 * @package phlyteApplicationAuthorization
 * @subpackage Authorization
 * @copyright Curtis Gittens (c) 2009 - 2010
 */
class Authorization implements AuthorizationInterface
{
	
	/**
     * Check the permissions of the user to ensure they can access the requested service/page
     */
    public function checkUserPerms(UserAbstract $user, $page) : bool
	{
		$user_id = $user->getId();
		ValidatorAbstract::ensureParameterNotEmpty($page);
		
		$model = new AuthorizationModel();
		$record = $model->getOneRecord(array('coordinator_id' => $user_id,
											 'page_name' 	  => $page));
		if ($record === false) {
			return $record;
		}
		else {
			return true;
		}
	}
}