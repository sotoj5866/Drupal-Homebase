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
    foreach ($form_state->getValues() as $key => $value) {
      if($value === 1){
        array_push($players, $key);
      }
    }
    // foreach ($players as $player) {
      # code...
      $selected_player = \Drupal::entityQuery('node')->condition('type','events')->condition('title', $practice, 'CONTAINS')->execute();
      $selected_node =  \Drupal\node\Entity\Node::loadMultiple($selected_player);
      foreach ($selected_node as $key) {
        $test = $key->title->value;
      }
    // }

    // $_SESSION['players'] = $players;
    // $_SESSION['practice'] = $practice;
    // $_SESSION['absent'] = $absent;
    var_dump($test);
    // $form_state->setRedirect('roster_gen.roster_gen_controller');
  }

}
