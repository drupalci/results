<?php

namespace DrupalCIResults\Command;

use DrupalCIResults\Parser\ParserResults;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Yaml;

/**
 * Class SummaryCommand
 * @package DrupalCIResults
 */
class SummaryCommand extends BaseCommand {

  protected function configure() {
    $command = $this->getName();
    $this->setName($command)
      ->setDescription('Generate a summary message based on the artefacts.')
      ->addOption('build', null, InputOption::VALUE_REQUIRED, 'The build to upload the summary to.')
      ->addOption('sqlite', null, InputOption::VALUE_REQUIRED, 'The sqlite data file from the build.', '.');
  }

  protected function execute(InputInterface $input, OutputInterface $output) {
    parent::execute($input, $output);

    $sqlite = $input->getOption('sqlite');
    $build = $input->getOption('build');

    $db = new \SQLite3($sqlite);
    $results = $db->query('SELECT * FROM simpletest');

    $summary = new ParserResults();
    while ($row = $results->fetchArray()) {
      switch ($row['status']) {
        case "pass":
          $summary->incrementPasses();
          break;

        case "fail":
          $summary->incrementFailures();
          break;

        case "error":
          $summary->incrementErrors();
          break;

        case "debug":
          $summary->incrementDebugs();
          break;
      }
    }

    $message = $summary->printResults();
    if (!empty($message)) {
      $output->writeln('<info>' . $message .'</info>');

      // Also submit to the Results site is specified.
      if ($build) {
        $api = $this->getApi();
        $api->summary($build, $message);
      }
    }
    else {
      $output->writeln('<error>Failed to generate the summary message.</error>');
    }
  }

}
