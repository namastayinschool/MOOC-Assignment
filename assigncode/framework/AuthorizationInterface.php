<?php 
/**
 * @category phlyte
 * @package phlyteAuthorizationInterface
 * @copyright Curtis Gittens (c) 2009 - 2010
 */
interface AuthorizationInterface
{
	/**
	 * Checks the user's authorization
	 */
	public function checkUserPerms(UserAbstract $user, $page) : bool;
}