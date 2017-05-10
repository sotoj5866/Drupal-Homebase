<?php

/**
 * @file
 * Contains \Drupal\homebase\Form\HomebaseForm.
 */

namespace Drupal\homebase\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Implements an homebase form.
 */
class HomebaseForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'homebase_form';
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
    $option_array = array();
    foreach ($players as $player) {
      $option_array[$player] = $this->t($player);
    }
    $form['players'] = [
      '#type' => 'select',
      '#title' => $this->t('Select element'),
      '#options' => $option_array,
    ];

    $form['types'] = [
      '#type' => 'select',
      '#title' => $this->t('Select element'),
      '#options' => [
        'Batting' => $this->t('Batting'),
        'Throwing' => $this->t('Throwing'),
        'Catching' => $this->t('Catching'),
      ],
    ];

    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Add Experience'),
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
    $player_found = $form_state->getValue('players');
    $skill = $form_state->getValue('types');
    // var_dump($skill);


    $selected_player = \Drupal::entityQuery('node')->condition('type','player')->condition('title', $player_found, 'CONTAINS')->execute();
    $selected_node =  \Drupal\node\Entity\Node::loadMultiple($selected_player);
    foreach ($selected_node as $node) {
      if ($skill === 'Batting'){
        $xp = $node->field_batting_experience->value + 10;
        // insert algorgithm for figuring out level
        $node->set('field_batting_experience', $xp);
        $node->save();
      } else if ($skill === 'Throwing'){
        $xp = $node->field_throwing_exper->value + 10;
        $node->set('field_throwing_exper', $xp);
        $node->save();
      } else if ($skill === 'Catching'){
        $xp = $node->field_catching_experience->value + 10;
        $node->set('field_catching_experience', $xp);
        $node->save();
      }

    }

    drupal_set_message("10 XP has been added to " . $player_found . "'s " . $skill . " score");

  }

}
