<?php
/***************************************************************
* Copyright notice
*
* (c) 2008 Oliver Klee (typo3-coding@oliverklee.de)
* All rights reserved
*
* This script is part of the TYPO3 project. The TYPO3 project is
* free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation; either version 2 of the License, or
* (at your option) any later version.
*
* The GNU General Public License can be found at
* http://www.gnu.org/copyleft/gpl.html.
*
* This script is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

require_once(t3lib_extMgm::extPath('oelib') . 'class.tx_oelib_testingFramework.php');

require_once(t3lib_extMgm::extPath('tt_news') . 'pi/class.tx_ttnews.php');

/**
 * Testcase for the tx_ttnews class in the 'tt_news' extension.
 *
 * @package		TYPO3
 * @subpackage	tx_oelib
 *
 * @author		Oliver Klee <typo3-coding@oliverklee.de>
 */
class tx_ttnews_testcase  extends tx_phpunit_testcase {
	/** @var string  the name of the table for the news items */
	const NEWS_TABLE = 'tt_news';

	/** @var tx_oelib_testingFramework  for creating a fake FE */
	private $testingFramework;

	/** @var tx_ttnews  an instance of the class to test */
	private $fixture;

	public function setUp() {
		$this->testingFramework = new tx_oelib_testingFramework(
			'tx_newstests', array('tt')
		);
		$this->testingFramework->createFakeFrontEnd();

		$this->fixture = new tx_ttnews();
	}

	public function tearDown() {
		$this->testingFramework->cleanUp();

		unset($this->fixture, $this->testingFramework);
	}

	//////////////////////
	// Utitily functions
	//////////////////////

	/**
	 * Creates a news item record (without category).
	 *
	 * @param  array    the data for the news item, may be empty
	 *
	 * @return integer  the UID of the created news item, will be > 0
	 */
	private function createNewsItem(array $itemData = array()) {
		return $this->testingFramework->createRecord(
			self::NEWS_TABLE, $itemData
		);
	}


	/////////////////////////////////////
	// Tests for the utitlity functions
	/////////////////////////////////////

	public function testCreateNewsItemWithNoDataReturnsUidOfNewsRecord() {
		$uid = $this->createNewsItem();

		$this->assertEquals(
			1,
			$this->testingFramework->countRecords(
				self::NEWS_TABLE, 'uid = ' . $uid
			)
		);
	}

	public function testCreateNewsWithDataCreatesNewsRecordWithTheGivenData() {
		$this->createNewsItem(array('title' => 'foo'));

		$this->assertEquals(
			1,
			$this->testingFramework->countRecords(
				self::NEWS_TABLE, 'title = "foo"'
			)
		);
	}
}
?>