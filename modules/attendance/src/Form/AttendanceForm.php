<?php

/**
 * @file
 * Contains \Drupal\roster_gen\Form\RosterGenForm.
 */

namespace Drupal\attendance\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Implements an roster_gen form.
 */
class AttendanceForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'attendance_form';
  }


  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $nids = \Drupal::entityQuery('node')->condition('type','player')->execute();
    $nodes =  \Drupal\node\Entity\Node::loadMultiple($nids);
    $players = array();
    foreach ($nodes as $node){
      array_push($players, $node->title->value);
    }
    sort($players);
    $default_vals = array_keys($players);

    $practice_nids = \Drupal::entityQuery('node')->condition('type','events')->execute();
    $practice_nodes =  \Drupal\node\Entity\Node::loadMultiple($practice_nids);
    $practices = array();
    foreach ($practice_nodes as $practice) {
      array_push($practices, $practice->title->value);
    }
    $option_array = array();
    foreach ($practices as $event) {
      $option_array[$event] = $this->t($event);
    }
    $form['practice'] = [
      '#type' => 'select',
      '#title' => $this->t('Practice'),
      '#options' => $option_array,
    ];

    foreach ($players as $player){
      $form[$player] = array(
        '#type' => 'checkbox',
        '#title' => $this->t($player),
        '#default_value' => 1,
      );
    }

      // $form['attendance'] = array(
      //   '#type' => 'checkboxes',
      //   '#options' => $players,
      //   '#default_value' => $default_vals,
      // );

    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Save'),
      '#button_type' => 'primary',
    );
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // if (strlen($form_state->getValue('phone_number')) < 3) {
    //   $form_state->setErrorByName('phone_number', $this->t('The phone number is too short. Please enter a full phone number.'));
    // }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $players = array();
    $absent = array();
    $practice = $form_state->getValue('practice');

    //create array for each player that shows to the practice
    foreach ($form_state->getValues() as $key => $value) {
      if($value === 1){
        array_push($players, $key);
      }
    }

    //arrays for each practice objective option
    $hitting = array('field_bunting', 'field_contact_hitting', 'field_power_hitting');
    $throwing = array('field_short_throws', 'field_long_throws');
    $catching = array('field_fly_balls', 'field_grounders');

    //loop through each player at practice
    foreach ($players as $player) {
      //finds the selected practice
      $selected_practice = \Drupal::entityQuery('node')->condition('type','events')->condition('title', $practice, 'CONTAINS')->execute();
      $selected_practice_node =  \Drupal\node\Entity\Node::loadMultiple($selected_practice);
      foreach ($selected_practice_node as $key) {
        //create array for selected practice information
        $practice_info = array('name' => $key->title->value, 'field_bunting' => $key->field_bunting->value, 'field_contact_hitting' => $key->field_contact_hitting->value, 'field_fly_balls' => $key->field_fly_balls->value, 'field_grounders' => $key->field_grounders->value, 'field_long_throws' => $key->field_long_throws->value, 'field_power_hitting' => $key->field_power_hitting->value, 'field_short_throws' => $key->field_short_throws->value);
      }
      $filtered = array_filter($practice_info);
      $filtered_keys = array_keys($filtered);

      //counts how many of the potential practice options are there for each type
      $hit_matches = count(array_intersect($hitting, $filtered_keys));
      $throw_matches = count(array_intersect($throwing, $filtered_keys));
      $catch_matches = count(array_intersect($catching, $filtered_keys));

      //grabs node for particular player in the loop
      $selected_player = \Drupal::entityQuery('node')->condition('type','player')->condition('title', $player, 'CONTAINS')->execute();
      $selected_player_node =  \Drupal\node\Entity\Node::loadMultiple($selected_player);
      //update the player with new xp/levels
      foreach ($selected_player_node as $key) {
        $new_bat_xp = $key->field_batting_experience->value + ($hit_matches*20);
        $key->set('field_batting_experience', $new_bat_xp);
        $new_bat_lvl = floor(($new_bat_xp + 100)/100);
        if($key->field_batting_level->value != $new_bat_lvl){
          $key->set('field_batting_level', $new_bat_lvl);
        }

        $new_throw_xp = $key->field_throwing_experience->value + ($throw_matches*20);
        $key->set('field_throwing_experience', $new_throw_xp);
        $new_throw_lvl = floor(($new_throw_xp + 100)/100);
        if($key->field_throwing_level->value != $new_throw_lvl){
          $key->set('field_throwing_level', $new_throw_lvl);
        }

        $new_catch_xp = $key->field_catching_experience->value + ($catch_matches*20);
        $key->set('field_catching_experience', $new_catch_xp);
        $new_catch_lvl = floor(($new_catch_xp + 100)/100);
        if($key->field_catching_level->value != $new_catch_lvl){
          $key->set('field_catching_level', $new_catch_lvl);
        }

        $key->save();
      }
    }
    drupal_set_message("xp add");
  }

}
