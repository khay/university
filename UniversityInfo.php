<?php

namespace University;

class UniversityInfo extends \Reborn\Module\AbstractInfo
{
	/**
	 * Module name variable
	 *
	 * @var string
	 **/
	protected $name = 'University';

	/**
	 * Module version variable
	 *
	 * @var string
	 **/
	protected $version = '1.0';

	/**
	 * Module Display name variable.
	 *
	 * @var string
	 **/
	protected $displayName = array(
		'en' => 'University'
	);

	/**
	 * Module description variable
	 *
	 * @var string
	 **/
	protected $description = array(
		'en' => 'Online University Application'
	);

	/**
	 * Module author name variable
	 *
	 * @var string
	 **/
	protected $author = 'Myanmar Links';

	/**
	 * Module author URL variable
	 *
	 * @var string
	 **/
	protected $authorUrl = 'http://myanmarlinks.net';

	/**
	 * Module author Email variable
	 *
	 * @var string
	 **/
	protected $authorEmail = 'info@myanmarlinks.net';

	/**
	 * Module Frontend support variable
	 *
	 * @var boolean
	 **/
	protected $frontendSupport = true;

	/**
	 * Module Backend support variable
	 *
	 * @var boolean
	 **/
	protected $backendSupport = true;

	/**
	 * Module can be use Default Module for Frontend variable
	 *
	 * @var boolean
	 **/
	protected $useAsDefaultModule = false;

	/**
	 * Module's URI Prefix variable
	 *
	 * @var string
	 **/
	protected $uriPrefix = 'university';

	/**
	 * Variable for Allow to change the URI Prefix from user.
	 *
	 * @var boolean
	 **/
	protected $allowToChangeUriPrefix = false;

	/**
	 * Variable for Module Actions Roles list.
	 * Module Action permission will be decided on this role.
	 *
	 * @var array
	 **/
	protected $roles = array();

	/**
	 * Variable for Allow Custom Field.
	 * If you allow custom field in your module, set true
	 *
	 * @var boolean
	 **/
	protected $allowCustomfield = false;

	/**
	 * Use shared database in Multisite.
	 *
	 * @var boolean
	 **/
	protected $sharedData = false;

}
