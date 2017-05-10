<?php

/**
 * @file
 * Contains \Drupal\homebase\TestLevels.
 */

namespace Drupal\homebase;

/**
 * provide functions for leveling up.
 *
 * @package Drupal\homebase
 */
class TestLevels {

  /**
   * Check for a level
   *
   * @param $current_xp
   * @return int
   */
  public function findLevel($current_xp) {
    return floor(($current_xp + 100)/100);
  }


}
