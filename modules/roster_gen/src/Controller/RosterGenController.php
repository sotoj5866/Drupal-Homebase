<?php
/**
 * @file
 * Contains \Drupal\lineup\Controller\LineupController.
 */
namespace Drupal\roster_gen\Controller;

use Drupal\Core\Controller\ControllerBase;

class RosterGenController extends ControllerBase {
  public function lineup() {
    shuffle($_SESSION['players']);
    $output = "<div class='list_holder' style='display:flex;flex-direction:row;'><div class='batting_holder' style='width:33%'><h1><u>Batting Order</u></h1><ol>";
    foreach ($_SESSION['players'] as $player) {
      $output .= "<li>" . $player . "</li>";
    }
    // Hello world
    $output .= "</ol></div><div class='absent_holder' style='width:33%'><h1><u>Absent</u></h1><ol>";
    foreach ($_SESSION['absent'] as $absent) {
      $output .= "<li>" . $absent . "</li>";
    }
      $output .= "</ol></div></div><div style=''>";

    $innings = array("1st", "2nd", "3rd", "4th", "5th", "6th", "7th", "8th", "9th");
    $position_names = array("1st", "2nd", "SS", "3rd", "Pitcher", "Catcher", "LOF", "COF", "ROF");
    $players_available = $_SESSION['players'];

    $output .= "<h1><u>Fielding Positions</u></h1><table><thead><tr><th>Inning</th>";

    foreach ($position_names as $pos) {
      $output .= "<th>" . $pos . "</th>";
    }

    $output .= "</thead><tbody><tr>";

    foreach ($innings as $inning) {
      $output .= "<td>" . $inning . "</td>";
      foreach ($position_names as $position_name) {
        if (count($players_available) === 0) {
          $players_available = $_SESSION['players'];
        }
        $output .= "<td>" . $players_available[0] . "</td>";
        if (count($players_available) > 0) {
          array_shift($players_available);
        }
      }
      $output .= "</tr><tr>";
    }

    $output .= "</tr></tbody></table></div>";

    return array(
      '#type' => 'markup',
      '#markup' => $this->t($output),
    );
  }
}
