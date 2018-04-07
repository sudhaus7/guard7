<?php
/**
 * Created by PhpStorm.
 * User: frank
 * Date: 26.02.18
 * Time: 16:28
 */

namespace SUDHAUS7\Guard7\Commands;

use SUDHAUS7\Guard7\Tools\Keys;
use SUDHAUS7\Guard7\Tools\Storage;
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
		     ->setHelp( 'call it like this typo3/sysext/core/bin/typo3 guard7:db:lock --pid=123 --table=fe_users' )
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
			'includeFiles',
			'includeFiles',
			InputOption::VALUE_NONE,
			'Lock referenced files as well'
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
		$lockFiles = $input->hasOption( 'includeFiles');

		$filerefconfig = [];

		if ($lockFiles) {
			foreach($GLOBALS['TCA'][$table]['columns'] as $col=>$config) {


				if ($config['config']['type'] == 'inline' && isset($config['config']['foreign_table']) && $config['config']['foreign_table']=='sys_file_reference') {
					$filerefconfig[] = $col;
				}
			}
		}

		/** @var Connection $connection */
		$connection = GeneralUtility::makeInstance(ConnectionPool::class)
		                            ->getConnectionForTable($table);



		$ts = BackendUtility::getPagesTSconfig($pid);
		if ( isset( $ts['tx_sudhaus7guard7.'] ) ) {
			if ( isset( $ts['tx_sudhaus7guard7.'][ $table . '.' ] ) && isset( $ts['tx_sudhaus7guard7.'][ $table . '.' ]['fields'] ) ) {
				$res = $connection->select(['*'],$table,['pid'=>$pid]);

				while($row = $res->fetch(\PDO::FETCH_ASSOC)) {
					$pubkeys     = Keys::collectPublicKeys( $table, $row['uid'], $pid, false );

					$fieldArray  = [];
					$vaultfields = GeneralUtility::trimExplode( ',',
						$ts['tx_sudhaus7guard7.'][ $table . '.' ]['fields'] );
					foreach($vaultfields as $f) {
						$fieldArray[$f]=$row[$f];
					}
					$fieldArray  = Storage::lockRecord( $table,  $row['uid'], $vaultfields, $fieldArray, $pubkeys );
					$connection->update( $table, $fieldArray, ['uid'=>$row['uid']]);
					$output->writeln( ['locking '.$row['username']]);

					if ($lockFiles) {
						foreach ($filerefconfig as $reffield) {
							//if ($row[$reffield] > 0) {

							$resref = $connection->select( ['*'], 'sys_file_reference',['tablenames'=>$table,'fieldname'=>$reffield,'uid_foreign'=>$row['uid']]);
							while($ref = $resref->fetch(\PDO::FETCH_ASSOC)) {
								$sysfile = $connection->select(['*'],'sys_file',['uid'=>$ref['uid_local']])->fetch(\PDO::FETCH_ASSOC);
								$ret = Storage::lockFile( PATH_site.'/fileadmin'.$sysfile['identifier'], $pubkeys);
								$output->writeln( ['locking file '.$sysfile['identifier']]);
							}
						}
					}
				}
			}
		}
	}
}
