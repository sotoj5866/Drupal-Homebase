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

    $form['add_remove'] = array(
      '#type' => 'radios',
      '#title' => $this->t('Add or Remove experience'),
      '#default_value' => 1,
      '#options' => array(
        1 => $this->t('Add'),
        -1 => $this->t('Remove'),
      ),
    );

    $form['experience'] = [
      '#type' => 'select',
      '#title' => $this->t('Select amount of experience'),
      '#options' => [
        10 => $this->t('10'),
        20 => $this->t('20'),
        30 => $this->t('30'),
        40 => $this->t('40'),
        50 => $this->t('50'),
        100 => $this->t('100'),
      ],
    ];

    $form['types'] = [
      '#type' => 'select',
      '#title' => $this->t('Select element'),
      '#options' => [
        'Batting' => $this->t('Batting'),
        'Catching' => $this->t('Catching'),
        'Throwing' => $this->t('Throwing'),
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


  public function findLevel($current_xp){
    return floor(($current_xp + 100)/100);
  }

  public function level($player_found, $skill, $experience, $add_remove){
    $selected_player = \Drupal::entityQuery('node')->condition('type','player')->condition('title', $player_found, 'CONTAINS')->execute();
    $selected_node =  \Drupal\node\Entity\Node::loadMultiple($selected_player);
    foreach ($selected_node as $node) {
      if ($skill === 'Batting'){
        $xp = $node->field_batting_experience->value + ($add_remove * $experience);
        if($xp < 0){
          $xp = 0;
        }
        $level = $this->findLevel($xp);
        if($level!=$node->field_batting_level->value){
          $node->set('field_batting_level', $level);
          $node->save();
        }
        $node->set('field_batting_experience', $xp);
        $node->save();
      } else if ($skill === 'Throwing'){
        $xp = $node->field_throwing_experience->value + ($add_remove * $experience);
        if($xp < 0){
          $xp = 0;
        }
        $level = $this->findLevel($xp);
        if($level!=$node->field_throwing_experience->value){
          $node->set('field_throwing_level', $level);
          $node->save();
        }
        $node->set('field_throwing_experience', $xp);
        $node->save();
      } else if ($skill === 'Catching'){
        $xp = $node->field_catching_experience->value + ($add_remove * $experience);
        if($xp < 0){
          $xp = 0;
        }
        $level = $this->findLevel($xp);
        if($level!=$node->field_catching_experience->value){
          $node->set('field_catching_level', $level);
          $node->save();
        }
        $node->set('field_catching_experience', $xp);
        $node->save();
      }

    }

  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $player_found = $form_state->getValue('players');
    $skill = $form_state->getValue('types');
    $experience = $form_state->getValue('experience');
    $add_remove = $form_state->getValue('add_remove');

    $this->level($player_found, $skill, $experience, $add_remove);

    if($add_remove === 1){
      drupal_set_message($experience . " XP has been added to " . $player_found . "'s " . $skill . " score");
    }else{
      drupal_set_message($experience . " XP has been removed from " . $player_found . "'s " . $skill . " score");
    }

  }

}
