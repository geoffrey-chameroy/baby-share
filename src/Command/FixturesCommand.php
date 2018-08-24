<?php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FixturesCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('app:fixtures:load');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $output->writeln('<info>Remove files</info>');
            $this->removeFiles(__DIR__ . '/../../uploads');

            $command = $this->getApplication()->find('doctrine:database:drop');
            $arguments = ['--force' => true, '--if-exists' => true];
            $arrayInput = new ArrayInput($arguments);
            $command->run($arrayInput, $output);

            $command = $this->getApplication()->find('doctrine:database:create');
            $arguments = [];
            $arrayInput = new ArrayInput($arguments);
            $command->run($arrayInput, $output);

            $command = $this->getApplication()->find('doctrine:schema:update');
            $arguments = ['--force' => true];
            $arrayInput = new ArrayInput($arguments);
            $command->run($arrayInput, $output);

            $command = $this->getApplication()->find('doctrine:fixtures:load');
            $arguments = ['--append' => true];
            $arrayInput = new ArrayInput($arguments);
            $command->run($arrayInput, $output);
        } catch (\Exception $e) {
            $output->writeln($e->getMessage());
        }
    }

    private function removeFiles(string $directory)
    {
        $files = scandir($directory);

        foreach ($files as $file) {
            if (substr($file, 0, 1) == '.') {
                continue;
            }

            if (is_dir($directory . '/' . $file)) {
                continue;
            }

            unlink($directory . '/' . $file);
        }
    }
}
