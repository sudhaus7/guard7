<?php
/**
 * Created by PhpStorm.
 * User: frank
 * Date: 22.02.18
 * Time: 17:59
 */

namespace SUDHAUS7\Guard7\Domain\Model;


class Data extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * Tablename
	 *
	 * @var \string
	 */
	protected $tablename;

	/**
	 * Returns the Tablename
	 *
	 * @return \string $tablename
	 */
	public function getTablename() {
		return $this->tablename;
	}

	/**
	 * Sets the Tablename
	 *
	 * @param \string $tablename
	 * @return void
	 */
	public function setTablename($tablename) {
		$this->tablename = $tablename;
	}


	/**
	 * Tableuid
	 *
	 * @var \string
	 */
	protected $tableuid;

	/**
	 * Returns the Tableuid
	 *
	 * @return \string $tableuid
	 */
	public function getTableuid() {
		return $this->tableuid;
	}

	/**
	 * Sets the Tableuid
	 *
	 * @param \string $tableuid
	 * @return void
	 */
	public function setTableuid($tableuid) {
		$this->tableuid = $tableuid;
	}


	/**
	 * Fieldname
	 *
	 * @var \string
	 */
	protected $fieldname;

	/**
	 * Returns the Fieldname
	 *
	 * @return \string $fieldname
	 */
	public function getFieldname() {
		return $this->fieldname;
	}

	/**
	 * Sets the Fieldname
	 *
	 * @param \string $fieldname
	 * @return void
	 */
	public function setFieldname($fieldname) {
		$this->fieldname = $fieldname;
	}


	/**
	 * Secretdata
	 *
	 * @var \string
	 */
	protected $secretdata;

	/**
	 * Returns the Secretdata
	 *
	 * @return \string $secretdata
	 */
	public function getSecretdata() {
		return $this->secretdata;
	}

	/**
	 * Sets the Secretdata
	 *
	 * @param \string $secretdata
	 * @return void
	 */
	public function setSecretdata($secretdata) {
		$this->secretdata = $secretdata;
	}


	/**
	 * Needsreencode
	 *
	 * @var \string
	 */
	protected $needsreencode;

	/**
	 * Returns the Needsreencode
	 *
	 * @return \string $needsreencode
	 */
	public function getNeedsreencode() {
		return $this->needsreencode;
	}

	/**
	 * Sets the Needsreencode
	 *
	 * @param \string $needsreencode
	 * @return void
	 */
	public function setNeedsreencode($needsreencode) {
		$this->needsreencode = $needsreencode;
	}

}
