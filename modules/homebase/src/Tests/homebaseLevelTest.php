<?php

  namespace Drupal\homebase\Tests;

  use Drupal\Tests\UnitTestCase;

  /**
   * Unit Tests the homebase module
   * @group homebase
   */
  class HomebaseLevelTest extends UnitTestCase {
    /**
    * Modules to install.
    *
    * @var array
    */
    public static $modules = array('homebase');

    public $levelService;

    public function setUp(){
      $this->levelService = new \Drupal\homebase\TestLevels();
    }

    public function testFindLevel(){
      $xp = $this->levelService->findLevel(100);
      $this->assertEquals(2, $xp);
    }


  }
