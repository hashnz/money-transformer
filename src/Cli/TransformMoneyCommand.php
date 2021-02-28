<?php

declare(strict_types=1);

namespace App\Cli;

use App\Money;
use App\MoneyTransformer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TransformMoneyCommand extends Command
{
    public function getName()
    {
        return 'app:transform-money';
    }

    protected function configure()
    {
        $this
            ->setDescription('Transform money to words')
            ->addArgument('amount', InputArgument::REQUIRED, 'amount to be transformed')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $amount = $input->getArgument('amount');
        $result = MoneyTransformer::transform(Money::fromNumber($amount));
        $output->writeln($result);

        return Command::SUCCESS;
    }
}
