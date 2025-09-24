<?php

declare(strict_types=1);

namespace KawaiiGherkin\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

abstract class AbstractCommand extends Command
{
    public function __construct(string $name, private string $description)
    {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->setDescription($this->description)
            ->addArgument(
                'sources',
                InputArgument::REQUIRED | InputArgument::IS_ARRAY,
                'Path to find *.feature files'
            )
            ->addOption(
                'align',
                'a',
                InputOption::VALUE_OPTIONAL,
                'Side to align statement (right or left). Default right',
                'left'
            )
            ->addOption(
                'indent',
                'i',
                InputOption::VALUE_OPTIONAL,
                'Side to align statement (right or left). Default right',
                '4'
            )
        ;
    }
}
