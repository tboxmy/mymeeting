<?php
/* SVN FILE: $Id: tag_fixture.php 7848 2008-11-08 02:58:37Z renan.saddam $ */
/**
 * Short description for file.
 *
 * Long description for file
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) Tests <https://trac.cakephp.org/wiki/Developement/TestSuite>
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 *  Licensed under The Open Group Test Suite License
 *  Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          https://trac.cakephp.org/wiki/Developement/TestSuite CakePHP(tm) Tests
 * @package       cake.tests
 * @subpackage    cake.tests.fixtures
 * @since         CakePHP(tm) v 1.2.0.4667
 * @version       $Revision: 7848 $
 * @modifiedby    $LastChangedBy: renan.saddam $
 * @lastmodified  $Date: 2008-11-08 10:58:37 +0800 (Sat, 08 Nov 2008) $
 * @license       http://www.opensource.org/licenses/opengroup.php The Open Group Test Suite License
 */
/**
 * Short description for class.
 *
 * @package       cake.tests
 * @subpackage    cake.tests.fixtures
 */
class TagFixture extends CakeTestFixture {
/**
 * name property
 *
 * @var string 'Tag'
 * @access public
 */
	var $name = 'Tag';
/**
 * fields property
 *
 * @var array
 * @access public
 */
	var $fields = array(
		'id' => array('type' => 'integer', 'key' => 'primary'),
		'tag' => array('type' => 'string', 'null' => false),
		'created' => 'datetime',
		'updated' => 'datetime'
	);
/**
 * records property
 *
 * @var array
 * @access public
 */
	var $records = array(
		array('tag' => 'tag1', 'created' => '2007-03-18 12:22:23', 'updated' => '2007-03-18 12:24:31'),
		array('tag' => 'tag2', 'created' => '2007-03-18 12:24:23', 'updated' => '2007-03-18 12:26:31'),
		array('tag' => 'tag3', 'created' => '2007-03-18 12:26:23', 'updated' => '2007-03-18 12:28:31')
	);
}

?>
