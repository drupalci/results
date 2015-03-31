<?php

namespace DrupalCIResults\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;
use DrupalCIResults\ResultsAPI;

/**
 * Class BaseCommand
 * @package DrupalCIResults\Command
 */
class BaseCommand extends Command {

  /**
   * The username for the DrupalCI results API.
   * @var string
   */
  protected $username = '';

  /**
   * The password for the DrupalCI results API.
   * @var string
   */
  protected $password = '';

  /**
   * The URL of the DrupalCI results endpoint.
   * @var string
   */
  protected $url = '';

  /**
   * The config derived from the profile yaml file.
   * @var array
   */
  protected $config = array();

  /**
   * The DrupalCI results API.
   * @var ResultsAPI
   */
  protected $api;

  /**
   * CLI command execution.
   */
  protected function execute(InputInterface $input, OutputInterface $output) {
    // Load the yaml file from the users profile for $config.
    $home = getenv("HOME");
    if (file_exists($home . '/.drupalci-results.yml')) {
      $config = Yaml::parse($home . '/.drupalci-results.yml');
    }
    else if (file_exists('/etc/drupalci/config.yaml')) {
      $config = Yaml::parse('/etc/drupalci/config.yaml');
    }
    else {
      throw new \Exception('Could not find a configuration file.');
    }

    $this->setConfig($config);

    $host = !empty($config['results']['host']) ? $config['host'] : '';
    if (!$host) {
      throw new \Exception('Please provide a URL via cmd or config file.');
    }

    $username = !empty($config['results']['username']) ? $config['results']['username'] : '';
    if (!$username) {
      throw new \Exception('Please provide a username via cmd or config file.');
    }

    $password = !empty($config['results']['password']) ? $config['results']['password'] : '';
    if (!$password) {
      throw new \Exception('Please provide a password via cmd or config file.');
    }

    // Set these values for later.
    $this->setUrl($host);
    $this->setUsername($username);
    $this->setPassword($password);

    // Attach the DrupalCI results API for use in sub commands.
    $api = new ResultsAPI();
    $api->setUrl($host);
    $api->setAuth($username, $password);
    $this->setApi($api);
  }

  /**
   * @return string
   */
  public function getUsername() {
    return $this->username;
  }

  /**
   * @param string $username
   */
  public function setUsername($username) {
    $this->username = $username;
  }

  /**
   * @return string
   */
  public function getUrl() {
    return $this->url;
  }

  /**
   * @param string $url
   */
  public function setUrl($url) {
    $this->url = $url;
  }

  /**
   * @return string
   */
  public function getPassword() {
    return $this->password;
  }

  /**
   * @param string $password
   */
  public function setPassword($password) {
    $this->password = $password;
  }

  /**
   * @return array
   */
  public function getConfig() {
    return $this->config;
  }

  /**
   * @param array $config
   */
  public function setConfig($config) {
    $this->config = $config;
  }

  /**
   * @return ResultsAPI
   */
  public function getApi() {
    return $this->api;
  }

  /**
   * @param ResultsAPI $api
   */
  public function setApi($api) {
    $this->api = $api;
  }

}
