<?php
/**
 * @file
 */
namespace DrupalCIResults\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class TagCommand
 * @package DrupalCIResults
 */
class TagCommand extends BaseCommand {
  /**
   * {@inheritdoc}
   */
  protected function configure() {
    $command = $this->getName();
    $this->setName($command)
      ->setDescription('Allow a build to be tagged.')
      ->addOption('build', null, InputOption::VALUE_REQUIRED, 'The build to be tagged.')
      ->addOption('tags', null, InputOption::VALUE_REQUIRED, 'The comma separated tags to be applied to the build.');
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(InputInterface $input, OutputInterface $output) {
    parent::execute($input, $output);

    $build = $input->getOption('build');
    $tags = array_map('trim', explode(',', $input->getOption('tags')));

    $api = $this->getApi();
    $api->tag($build, $tags);
    $output->writeln('<info>Added the following tags to the build: ' . implode(', ', $tags) . '</info>');
  }
}
