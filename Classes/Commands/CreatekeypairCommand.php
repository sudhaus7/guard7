<?php

/*
 * This file is part of the TYPO3 project.
 * (c) 2022 B-Factor GmbH
 *          Sudhaus7
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 * The TYPO3 project - inspiring people to share!
 * @copyright 2022 B-Factor GmbH https://b-factor.de/
 * @author Frank Berger <fberger@b-factor.de>
 */

namespace Sudhaus7\Guard7\Commands;

use Sudhaus7\Guard7\Adapter\ConfigurationAdapter;
use SUDHAUS7\Guard7Core\Factory\KeyFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

final class CreatekeypairCommand extends Command
{
    protected function configure(): void
    {
        $this->setDescription('Create a key-pair')
            ->setHelp('call it like this typo3/sysext/core/bin/typo3 guard7:createkeypair --password=VerySecretPassword --size=4096')
            ->addOption(
                'password',
                'p',
                InputOption::VALUE_OPTIONAL,
                'Password for Private Key'
            )
            ->addOption(
                'size',
                's',
                InputOption::VALUE_OPTIONAL,
                'Keysize (default 4096)',
                4096
            )
            ->addOption(
                'method',
                's',
                InputOption::VALUE_OPTIONAL,
                'The Method to be used (default RC4)',
                'RC4'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $password = $input->getOption('password');
        $size = (int)$input->getOption('size');
        $method = (string)$input->getOption('method');

        /** @var ConfigurationAdapter $configuration */
        $configuration = GeneralUtility::makeInstance(ConfigurationAdapter::class);
        $configuration->setKeySize($size);
        $configuration->setDefaultMethod($method);

        if (!empty($password)) {
            $pair = KeyFactory::newKey($configuration);
            $pair->unlock();
        } else {
            $pair = KeyFactory::newKey($configuration, $password);
            $pair->unlock($password);
        }

        $output->writeln($pair->getKey());
        $output->writeln($pair->getPublicKey());
    }
}
