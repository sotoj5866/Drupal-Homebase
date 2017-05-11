<?php

/**
* @file
* Contains \Drupal\achievements\Form\AchievementsForm.
*/

namespace Drupal\achievements\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
* Implements an achievements form.
*/
class AchievementsForm extends FormBase {

  /**
  * {@inheritdoc}
  */
  public function getFormId() {
    return 'achievements_form';
  }


  /**
  * {@inheritdoc}
  */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $nids = \Drupal::entityQuery('node')->condition('type','player')->execute();
    $nodes =  \Drupal\node\Entity\Node::loadMultiple($nids);
    var_dump($nids);
    $players = array();
    foreach ($nodes as $node){
      $players[$node->nid->value] = $this->t($node->title->value);
    }

    $form['players'] = [
      '#type' => 'select',
      '#title' => $this->t('Player'),
      '#options' => $players,
    ];

    // user numeric inputs
    $form['field-hits'] = [
      '#type' => 'number',
      '#title' => $this->t('Add Hits'),
      '#description' => $this->t('Please enter a number.'),
    ];

    $form['field-caught-flies'] = [
      '#type' => 'number',
      '#title' => $this->t('Add Caught Flies'),
      '#description' => $this->t('Please enter a number.'),
    ];

    $form['field-outs'] = [
      '#type' => 'number',
      '#title' => $this->t('Add Outs'),
      '#description' => $this->t('Please enter a number.'),
    ];

    $form['field-rbis'] = [
      '#type' => 'number',
      '#title' => $this->t('Add RBIs'),
      '#description' => $this->t('Please enter a number.'),
    ];
    $form['field-stolen-bases'] = [
      '#type' => 'number',
      '#title' => $this->t('Add Stolen Bases'),
      '#description' => $this->t('Please enter a number.'),
    ];

    $form['field-strikeout'] = [
      '#type' => 'number',
      '#title' => $this->t('Add Strike Outs'),
      '#description' => $this->t('Please enter a number.'),
    ];

    $form['field-sacrifices'] = [
      '#type' => 'number',
      '#title' => $this->t('Add Sacrifices'),
      '#description' => $this->t('Please enter a number.'),
    ];

    // //  END OF USER INPUT
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Add Achievements'),
      '#button_type' => 'primary',
    );
    //
    return $form;
  }

  /**
  * {@inheritdoc}
  */

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $player_found = $form_state->getValue('players');
    $node_player = \Drupal\node\Entity\Node::load($player_found);

    $node_player->set('field_hits', $node_player->field_hits->value + $form_state->getValue('field-hits'));

    $node_player->set('field_caught_flies', $node_player->field_caught_flies->value + $form_state->getValue('field-caught-flies'));

    $node_player->set('field_outs', $node_player->field_outs->value + $form_state->getValue('field-outs'));

    $node_player->set('field_rbis', $node_player->field_rbis->value + $form_state->getValue('field-rbis'));

    $node_player->set('field_sacrifices', $node_player->field_sacrifices->value + $form_state->getValue('field-sacrifices'));

    $node_player->set('field_stolen_bases', $node_player->field_stolen_bases->value + $form_state->getValue('field-stolen-bases'));

    $node_player->set('field_strikeouts', $node_player->field_strikeouts->value + $form_state->getValue('field-strikeouts'));
    $node_player->save();
  }

}
