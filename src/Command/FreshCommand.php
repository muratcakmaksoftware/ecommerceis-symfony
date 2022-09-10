<?php

namespace App\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpKernel\KernelInterface;

class FreshCommand extends Command
{
    protected static $defaultName = 'doctrine:migrations:fresh';
    protected static $defaultDescription = '';

    protected function configure(): void
    {
        $this
            //->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('seed', null, InputOption::VALUE_NONE, 'Seed');
    }

    private $kernel;

    public function __construct(string $name = null, KernelInterface $kernel)
    {
        $this->kernel = $kernel;
        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $application = new Application($this->kernel);
        $application->setAutoExit(false);

        $io->info('doctrine:migrations:migrate first running...');
        $arrayInput = new ArrayInput([
            'command' => 'doctrine:migrations:migrate',
            'version' => 'first',
            '--no-interaction' => ''
        ]);

        $output = new BufferedOutput();
        $application->run($arrayInput, $output);
        $content = $output->fetch();
        $io->success($content);

        $io->info('doctrine:migrations:migrate running...');

        $arrayInput = new ArrayInput([
            'command' => 'doctrine:migrations:migrate',
            '--no-interaction' => ''
        ]);

        $application->run($arrayInput, $output);
        $content = $output->fetch();
        if(strpos($content,'Execution. Error: "An exception occurred while executing a query') === false){
            $io->success($content);

            if ($input->hasOption('seed')) {
                $io->info('doctrine:fixtures:load running...');
                $arrayInput = new ArrayInput([
                    'command' => 'doctrine:fixtures:load',
                    '--no-interaction' => ''
                ]);

                $output = new BufferedOutput();
                $application->run($arrayInput, $output);
                $content = $output->fetch();
                $io->success($content);
            }
        }else{
            $io->error($content);
            $io->warning('Please, try again :)');
        }

        return Command::SUCCESS;
    }
}
