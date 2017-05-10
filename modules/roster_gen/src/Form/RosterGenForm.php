<?php

/**
 * @file
 * Contains \Drupal\roster_gen\Form\RosterGenForm.
 */

namespace Drupal\roster_gen\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Implements an roster_gen form.
 */
class RosterGenForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    //hello
    return 'roster_gen_form';
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
    foreach ($form_state->getValues() as $key => $value) {
      if($value === 1){
        array_push($players, $key);
      }else if($value === 0){
        array_push($absent, $key);

      }
    }
    $_SESSION['players'] = $players;
    $_SESSION['absent'] = $absent;
    $form_state->setRedirect('roster_gen.roster_gen_controller');
  }

}
