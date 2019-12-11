<?php


namespace SUDHAUS7\Guard7\Commands;


use SUDHAUS7\Guard7\Tools\Keys;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CreatekeypairCommand  extends Command
{
    public function configure()
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
            );
            
    }
    
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $password = $input->getOption('password');
        $size = (int)$input->getOption('size');
        
        if (!empty($password)) {
            $pair = Keys::createKey();
        } else {
            $pair = Keys::createKey($password);
        }
        
        $output->write($pair);
    
    }
}
