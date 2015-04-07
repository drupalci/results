<?php

namespace DrupalCIResults\Parser;

/**
 * @file
 * A class to track the number of passes, fails and errors.
 */

class ParserResults {

  protected $passes = 0;

  protected $failures = 0;

  protected $errors = 0;

  protected $debugs = 0;

  /**
   * Print the results into a human readable string.
   * @return string
   */
  public function printResults() {
    $passes = $this->getPasses();
    $failures = $this->getFailures();
    $errors = $this->getErrors();
    return "Passes: " . $passes . ", Failures: " . $failures . " and " . $errors . " errors.";
  }

  /**
   * @return int
   */
  public function getPasses() {
    return $this->passes;
  }

  /**
   * @param int $assertions
   */
  public function setPasses($passes) {
    $this->passes = $passes;
  }

  /**
   * @param int $assertions
   */
  public function incrementPasses() {
    $this->passes++;
  }

  /**
   * @return int
   */
  public function getDebugs() {
    return $this->debugs;
  }

  /**
   * @param int $debugs
   */
  public function setDebugs($debugs) {
    $this->debugs = $debugs;
  }

  /**
   * @param int $debugs
   */
  public function incrementDebugs() {
    $this->debugs++;
  }

  /**
   * @return int
   */
  public function getErrors() {
    return $this->errors;
  }

  /**
   * @param int $errors
   */
  public function setErrors($errors) {
    $this->errors = $errors;
  }

  /**
   * Increment the errors.
   */
  public function incrementErrors() {
    $this->errors++;
  }

  /**
   * @return int
   */
  public function getFailures() {
    return $this->failures;
  }

  /**
   * @param int $failures
   */
  public function setFailures($failures) {
    $this->failures = $failures;
  }

  /**
   * @param int $failures
   */
  public function incrementFailures() {
    $this->failures++;
  }

}
