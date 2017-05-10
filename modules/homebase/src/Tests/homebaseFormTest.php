<?php

  namespace Drupal\homebase\Tests;

  use Drupal\simpletest\WebTestBase;

  /**
   * Tests the homebase module
   * @group homebase
   */
  class HomebaseFormTest extends WebTestBase {
    /**
    * Modules to install.
    *
    * @var array
    */
    public static $modules = array('node', 'homebase');

    /**
    * Tests that 'homebase-form' returns a 200 OK response.
    */
    public function testHomebaseFormRouterURLIsAccessible() {
      $this->drupalGet('homebase-form');
      $this->assertResponse(200);
    }

    /**
    * Tests that the form has a submit button to use.
    */
    public function testHomebaseFormSubmitButtonExists() {
      $this->drupalGet('homebase-form');
      $this->assertResponse(200);
      $this->assertFieldById('edit-submit');
    }

    /**
    * Test that the options we expect in the form are present.
    */
    public function testHomebaseFormFieldOptionsExist() {
      $this->drupalGet('homebase-form');
      $this->assertResponse(200);

      // check that our select field displays on the form
      $this->assertFieldByName('types');

      // check that all of our options are available
      $types = ['Batting', 'Catching', 'Throwing'];

      foreach ($types as $type) {
        $this->assertOption('edit-types', $type);
      }

      // check that Pizza is not an option. Sorry, pizza lovers.
      $this->assertNoOption('edit-types', 'stealing');
    }

  



  }
