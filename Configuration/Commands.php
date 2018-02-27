<?php
/**
 * Created by PhpStorm.
 * User: frank
 * Date: 26.02.18
 * Time: 16:27
 */

return [
	'datavault:db:lock' => [
		'class' => SUDHAUS7\Datavault\Commands\DblocktableCommand::class
	],
	'datavault:db:unlock' => [
		'class' => SUDHAUS7\Datavault\Commands\DbunlocktableCommand::class
	],
/*	'datavault:db:listdirty' => [
		'class' => SUDHAUS7\Datavault\Commands\DblistdirtyCommand::class
	],
	'datavault:db:repairdirty' => [
		'class' => SUDHAUS7\Datavault\Commands\DbrepairdirtyCommand::class
	]*/
];
