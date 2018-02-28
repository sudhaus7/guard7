<?php
/**
 * Created by PhpStorm.
 * User: frank
 * Date: 27.02.18
 * Time: 17:11
 */

namespace SUDHAUS7\Datavault\Commands;
use SUDHAUS7\Datavault\Tools\Keys;
use SUDHAUS7\Datavault\Tools\Storage;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;


class FilelockCommand {
	public function configure() {
		$this->setDescription( 'Lock all Files related to a table and pid' )
		     ->setHelp( 'call it like this typo3/sysext/core/bin/typo3 datavault:db:lock --pid=123 --table=fe_users' )
		     ->addOption(
			     'pid',
			     'pid',
			     InputOption::VALUE_REQUIRED,
			     'UID of a Folder'
		     )
		     ->addOption(
			     'table',
			     't',
			     InputOption::VALUE_REQUIRED,
			     'Table to lock'
		     );
	}
}
