<?php
/**
 * Created by PhpStorm.
 * User: frank
 * Date: 26.02.18
 * Time: 16:28
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



class DbunlocktableCommand extends Command {

	public function configure() {
		$this->setDescription( 'Lock all Datafields for a table and pid')
			->setHelp('call it like this typo3/sysext/core/bin/typo3 datavault:db:unlock --pid=123 --table=fe_users --keyfile=/path/to/key.pem')
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
			)
			->addOption(
				'keyfile',
				'keyfile',
				InputOption::VALUE_REQUIRED,
				'File with a Masterkey (PEM)'
			)
			->addOption(
				'password',
				'p',
				InputOption::VALUE_OPTIONAL,
				'Password for masterkey'
			);
	}

	public function execute(InputInterface $input, OutputInterface $output)
	{
		$table = $input->getOption('table');
		$pid = (int)$input->getOption('pid');
		$keyfile = $input->getOption('keyfile');
		$key = \file_get_contents( $keyfile );
		$password = $input->hasOption( 'password') ? $input->getOption( 'password') : null;

		/** @var Connection $connection */
		$connection = GeneralUtility::makeInstance(ConnectionPool::class)
		                            ->getConnectionForTable($table);
		$ts = BackendUtility::getPagesTSconfig($pid);
		if (isset($ts['tx_sudhaus7datavault.'])) {
			if ( isset( $ts['tx_sudhaus7datavault.'][ $table . '.' ] ) && isset( $ts['tx_sudhaus7datavault.'][ $table . '.' ]['fields'] ) ) {
				$res  = $connection->select( [ '*' ], $table, [ 'pid' => $pid ] );
				while($row = $res->fetch(\PDO::FETCH_ASSOC)) {
					$fieldArray = [];
					$vaultfields = GeneralUtility::trimExplode( ',',	$ts['tx_sudhaus7datavault.'][ $table . '.' ]['fields'] );
					foreach($vaultfields as $f) {
						$fieldArray[$f]=$row[$f];
					}
					$fieldArray = Storage::unlockRecord( $table, $fieldArray, $key,$row['uid'],$password);
					$connection->update( $table, $fieldArray, ['uid'=>$row['uid']]);
					$output->writeln( ['unlocking '.$row['username']]);
				}
			}
		}
	}
}
