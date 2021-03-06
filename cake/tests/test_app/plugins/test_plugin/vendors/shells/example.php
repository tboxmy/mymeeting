<?php
/* SVN FILE: $Id: example.php 7871 2008-11-13 00:33:53Z renan.saddam $ */
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
 * @subpackage    cake.tests.test_app.plugins.test_plugin.vendors.shells
 * @since         CakePHP(tm) v 1.2.0.7871
 * @version       $Revision: 7871 $
 * @modifiedby    $LastChangedBy: renan.saddam $
 * @lastmodified  $Date: 2008-11-13 08:33:53 +0800 (Thu, 13 Nov 2008) $
 * @license       http://www.opensource.org/licenses/opengroup.php The Open Group Test Suite License
 */
class ExampleShell extends Shell {
/**
 * main method
 *
 * @access public
 * @return void
 */
	function main() {
		$this->out('This is the main method called from TestPlugin.ExampleShell');
	}
}