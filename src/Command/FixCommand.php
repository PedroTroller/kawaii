<?php

declare(strict_types=1);

namespace KawaiiGherkin\Command;

use Behat\Gherkin\Parser;
use KawaiiGherkin\DIC;
use KawaiiGherkin\Finder;
use KawaiiGherkin\Formatter\Feature;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class FixCommand extends AbstractCommand
{
    public function __construct(private DIC $dic)
    {
        parent::__construct('fix', 'Fix gherkin code style');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->dic->setService(InputInterface::class, static fn (): InputInterface => $input);

        $parser    = $this->dic->getService(Parser::class);
        $finder    = $this->dic->getService(Finder::class);
        $formatter = $this->dic->getService(Feature::class);

        foreach ($finder as $file) {
            $output->writeln("\nFixing <info>{$file->getPathname()}</info>\n");

            $feature   = $parser->parse((string) file_get_contents($file->getPathname()));
            $formatted = implode('', [...$formatter->format($feature)]);

            $filePointer = $file->openFile('w');
            $filePointer->fwrite((string) $formatted);

            $output->writeln("<info>{$file->getRealPath()}</info>");
        }

        return self::SUCCESS;
    }
}
