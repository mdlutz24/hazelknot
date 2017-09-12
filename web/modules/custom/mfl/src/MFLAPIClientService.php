<?php

namespace Drupal\mfl;
use Drupal\Component\Utility\UrlHelper;
use GuzzleHttp\Client;
use Drupal\Core\Config\ConfigFactory;

/**
 * Class MFLAPIClientService.
 */
class MFLAPIClientService implements MFLAPIClientServiceInterface {

  /**
   * GuzzleHttp\Client definition.
   *
   * @var \GuzzleHttp\Client
   */
  protected $httpClient;
  /**
   * Drupal\Core\Config\ConfigFactory definition.
   *
   * @var \Drupal\Core\Config\ConfigFactory
   */
  protected $configFactory;

  protected $hosts = [];

  protected $year;

  protected $league;

  protected $franchise;

  protected $week;

  protected $json = TRUE;

  protected $command;

  protected $args;
  /**
   * Constructs a new MFLAPIClientService object.
   */
  public function __construct(Client $http_client, ConfigFactory $config_factory) {
    $this->httpClient = $http_client;
    $this->configFactory = $config_factory;
    $this->year = Date('Y', time() - 60*60*24*30*3);
  }

  /**
   * @return false|string
   */
  public function getYear() {
    return $this->year;
  }

  /**
   * @param false|string $year
   */
  public function setYear($year) {
    $this->year = $year;
  }

  /**
   * @return mixed
   */
  public function getLeague() {
    return $this->league;
  }

  /**
   * @param mixed $league
   */
  public function setLeague($league) {
    $this->league = $league;
  }

  /**
   * @return mixed
   */
  public function getFranchise() {
    return $this->franchise;
  }

  /**
   * @param mixed $franchise
   */
  public function setFranchise($franchise) {
    $this->franchise = $franchise;
  }

  /**
   * @return mixed
   */
  public function getWeek() {
    return $this->week;
  }

  /**
   * @param mixed $week
   */
  public function setWeek($week) {
    $this->week = $week;
  }

  /**
   * @return bool
   */
  public function isJson(): bool {
    return $this->json;
  }

  /**
   * @param bool $json
   */
  public function setJson(bool $json) {
    $this->json = $json;
  }



  public function import($command, $args = [], $host = NULL) {
    if(empty($host)) {
      $host = $this->_getHost();
      if(empty($host)) {
        throw new \Exception("Unable to find a host");
      }
    }
    $args['TYPE'] = $command;
    if ($this->json) {
      $args['JSON'] = 1;
    }
    $uri = $host . '/' . $this->year . '/export?' . UrlHelper::buildQuery($args);
    $response = $this->httpClient->get($uri);
    $body = $response->getBody()->getContents();
    if ($this->json) {
      $resobj = json_decode($body);
    }
    else {
      $resobj = simplexml_load_string($body);
    }
    return $resobj;
  }

  protected function _getHost($league = NULL, $year = NULL) {
    if (empty($league)) {
      $league = $this->league;
    }
    if (empty($league)) {
      return "https://www71.myfantasyleague.com";
    }
    if (isset($this->hosts[$this->year][$this->league])) {
      return $this->hosts[$this->year][$this->league];
    }
    else {
      $response = $this->import('league', ['L' => $this->league], "https://www71.myfantasyleague.com");
     // ksm($response);
    }
  }

}
