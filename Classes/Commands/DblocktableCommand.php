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


class DblocktableCommand extends Command {

	public function configure() {
		$this->setDescription( 'Lock all Datafields for a table and pid')
		->setHelp('call it like this typo3/sysext/core/bin/typo3 datavault:db:lock --pid=123 --table=fe_users')
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

	/**
	 * @param InputInterface $input
	 * @param OutputInterface $output
	 *
	 * @return int|null|void
	 * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException
	 * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException
	 */
	public function execute(InputInterface $input, OutputInterface $output)
	{
		$table = $input->getOption('table');
		$pid = (int)$input->getOption('pid');
		/** @var Connection $connection */
		$connection = GeneralUtility::makeInstance(ConnectionPool::class)
		                            ->getConnectionForTable($table);



		$ts = BackendUtility::getPagesTSconfig($pid);
		if (isset($ts['tx_sudhaus7datavault.'])) {
			if (isset($ts['tx_sudhaus7datavault.'][$table.'.']) && isset($ts['tx_sudhaus7datavault.'][$table.'.']['fields'])) {
				$res = $connection->select(['*'],$table,['pid'=>$pid]);

				while($row = $res->fetch(\PDO::FETCH_ASSOC)) {
					$pubkeys     = Keys::collectPublicKeys( $table, $row['uid'], $pid, false );

					$fieldArray = [];
					$vaultfields = GeneralUtility::trimExplode( ',',	$ts['tx_sudhaus7datavault.'][ $table . '.' ]['fields'] );
					foreach($vaultfields as $f) {
						$fieldArray[$f]=$row[$f];
					}
					$fieldArray  = Storage::lockRecord( $table,  $row['uid'], $vaultfields, $fieldArray, $pubkeys );
					$connection->update( $table, $fieldArray, ['uid'=>$row['uid']]);
					$output->writeln( ['locking '.$row['username']]);
				}
			}
		}
	}
}
