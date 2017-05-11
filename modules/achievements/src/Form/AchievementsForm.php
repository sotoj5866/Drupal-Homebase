<?php

/**
* @file
* Contains \Drupal\achievements\Form\AchievementsForm.
*/

namespace Drupal\achievements\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
<<<<<<< HEAD
use \Drupal\file\Entity\File;
use \Drupal\node\Entity\Node;
use Drupal\achievements\Controller;
=======

use Drupal\acievements\Controller;
>>>>>>> 29c9649ccabb4a6a551d649a9389cedbed0d9177
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
    $players = array();

    foreach ($nodes as $node){
      $players[$node->nid->value] = $this->t($node->title->value);

      // if($node->nid->value == 1){
      //   var_dump($node);
      // }
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
<<<<<<< HEAD
      '#default_value'=> 0,
=======
>>>>>>> 29c9649ccabb4a6a551d649a9389cedbed0d9177
    ];

    $form['field-caught-flies'] = [
      '#type' => 'number',
      '#title' => $this->t('Add Caught Flies'),
<<<<<<< HEAD
      '#default_value'=> 0,
=======
>>>>>>> 29c9649ccabb4a6a551d649a9389cedbed0d9177
      '#description' => $this->t('Please enter a number.'),
    ];

    $form['field-outs'] = [
      '#type' => 'number',
      '#title' => $this->t('Add Outs'),
<<<<<<< HEAD
      '#default_value'=> 0,
=======
>>>>>>> 29c9649ccabb4a6a551d649a9389cedbed0d9177
      '#description' => $this->t('Please enter a number.'),
    ];

    $form['field-rbis'] = [
      '#type' => 'number',
      '#title' => $this->t('Add RBIs'),
<<<<<<< HEAD
      '#default_value'=> 0,
=======
>>>>>>> 29c9649ccabb4a6a551d649a9389cedbed0d9177
      '#description' => $this->t('Please enter a number.'),
    ];
    $form['field-stolen-bases'] = [
      '#type' => 'number',
      '#title' => $this->t('Add Stolen Bases'),
<<<<<<< HEAD
      '#default_value'=> 0,
=======
>>>>>>> 29c9649ccabb4a6a551d649a9389cedbed0d9177
      '#description' => $this->t('Please enter a number.'),
    ];

    $form['field-strikeout'] = [
      '#type' => 'number',
      '#title' => $this->t('Add Strike Outs'),
<<<<<<< HEAD
      '#default_value'=> 0,
=======
>>>>>>> 29c9649ccabb4a6a551d649a9389cedbed0d9177
      '#description' => $this->t('Please enter a number.'),
    ];

    $form['field-sacrifices'] = [
      '#type' => 'number',
      '#title' => $this->t('Add Sacrifices'),
<<<<<<< HEAD
      '#default_value'=> 0,
=======
>>>>>>> 29c9649ccabb4a6a551d649a9389cedbed0d9177
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

    $this->assignBadges($node_player);
  }

  /**
  * {@inheritdoc}
  */
  public function assignBadges($player){
    //badge assign for hits
    if($player->field_hits->value >= 100){
      $player->set('field_hit_badges', '<img class="badge" src="/img/HomeBase_Images/hit_badges/100thHit.png">');
      $player->field_hit_badges->format='full_html';
    }else if($player->field_hits->value >= 50){
      $player->set('field_hit_badges', '<img class="badge" src="/img/HomeBase_Images/hit_badges/50thHit.png">');
      $player->field_hit_badges->format='full_html';
    }else if($player->field_hits->value >= 25){
      $player->set('field_hit_badges', '<img class="badge" src="/img/HomeBase_Images/hit_badges/25thHit.png">');
      $player->field_hit_badges->format='full_html';
    }else if($player->field_hits->value >= 20){
      $player->set('field_hit_badges', '<img class="badge" src="/img/HomeBase_Images/hit_badges/20thHit.png">');
      $player->field_hit_badges->format='full_html';
    }else if($player->field_hits->value >= 15){
      $player->set('field_hit_badges', '<img class="badge" src="/img/HomeBase_Images/hit_badges/15thHit.png">');
      $player->field_hit_badges->format='full_html';
    }else if($player->field_hits->value >= 10){
      $player->set('field_hit_badges', '<img class="badge" src="/img/HomeBase_Images/hit_badges/10thHit.png">');
      $player->field_hit_badges->format='full_html';
    }else if($player->field_hits->value >= 5){
      $player->set('field_hit_badges', '<img class="badge" src="/img/HomeBase_Images/hit_badges/5thHit.png">');
      $player->field_hit_badges->format='full_html';
    }else if($player->field_hits->value >= 1){
      $player->set('field_hit_badges', '<img class="badge" src="/img/HomeBase_Images/hit_badges/1stHit.png">');
      $player->field_hit_badges->format='full_html';
    }else{
      $player->set('field_hit_badges', '<img class="badge" src="/img/HomeBase_Images/blankBadge.png">');
      $player->field_hit_badges->format='full_html';
    }

    //badge assign for caught
    if($player->field_caught_flies->value >= 25){
      $player->set('field_caught_badges', '<img class="badge" src="/img/HomeBase_Images/caught_badges/25thCaught.png">');
      $player->field_caught_badges->format='full_html';
    }else if($player->field_caught_flies->value >= 10){
      $player->set('field_caught_badges', '<img class="badge" src="/img/HomeBase_Images/caught_badges/10thCaught.png">');
      $player->field_caught_badges->format='full_html';
    }else if($player->field_caught_flies->value >= 5){
      $player->set('field_caught_badges', '<img class="badge" src="/img/HomeBase_Images/caught_badges/5thCaught.png">');
      $player->field_caught_badges->format='full_html';
    }else if($player->field_caught_flies->value >= 1){
      $player->set('field_caught_badges', '<img class="badge" src="/img/HomeBase_Images/caught_badges/1stCaught.png">');
      $player->field_caught_badges->format='full_html';
    }else{
      $player->set('field_caught_badges', '<img class="badge" src="/img/HomeBase_Images/blankBadge.png">');
      $player->field_caught_badges->format='full_html';
    }

    //badge assign for outs
    if($player->field_outs->value >= 25){
      $player->set('field_out_badges', '<img class="badge" src="/img/HomeBase_Images/out_badges/25thOut.png">');
      $player->field_out_badges->format='full_html';
    }else if($player->field_outs->value >= 10){
      $player->set('field_out_badges', '<img class="badge" src="/img/HomeBase_Images/out_badges/10thOut.png">');
      $player->field_out_badges->format='full_html';
    }else if($player->field_outs->value >= 5){
      $player->set('field_out_badges', '<img class="badge" src="/img/HomeBase_Images/out_badges/5thOut.png">');
      $player->field_out_badges->format='full_html';
    }else if($player->field_outs->value >= 1){
      $player->set('field_out_badges', '<img class="badge" src="/img/HomeBase_Images/out_badges/1stOut.png">');
      $player->field_out_badges->format='full_html';
    }else{
      $player->set('field_out_badges', '<img class="badge" src="/img/HomeBase_Images/blankBadge.png">');
      $player->field_out_badges->format='full_html';
    }

    //badge assign for RBI

    if($player->field_rbis->value >= 10){
      $player->set('field_rbi_badges', '<img class="badge" src="/img/HomeBase_Images/RBI_badge/10thRBI.png">');
      $player->field_rbi_badges->format='full_html';
    }else if($player->field_rbis->value >= 5){
      $player->set('field_rbi_badges', '<img class="badge" src="/img/HomeBase_Images/RBI_badge/5thRBI.png">');
      $player->field_rbi_badges->format='full_html';
    }else if($player->field_rbis->value >= 1){
      $player->set('field_rbi_badges', '<img class="badge" src="/img/HomeBase_Images/RBI_badge/1stRBI.png">');
      $player->field_rbi_badges->format='full_html';
    }else{
      $player->set('field_rbi_badges', '<img class="badge" src="/img/HomeBase_Images/blankBadge.png">');
      $player->field_rbi_badges->format='full_html';
    }

    //badge assign for Sacrifices
    if($player->field_sacrifices->value >= 3){
      $player->set('field_sacrifice_badges', '<img class="badge" src="/img/HomeBase_Images/sacrifice_badges/3rdSac.png">');
      $player->field_sacrifice_badges->format='full_html';
    }else if($player->field_sacrifices->value >= 1){
      $player->set('field_sacrifice_badges', '<img class="badge" src="/img/HomeBase_Images/sacrifice_badges/1stSac.png">');
      $player->field_sacrifice_badges->format='full_html';
    }else{
      $player->set('field_sacrifice_badges', '<img class="badge" src="/img/HomeBase_Images/blankBadge.png">');
      $player->field_sacrifice_badges->format='full_html';
    }

    //badge assign for stealing
    if($player->field_stolen_bases->value >= 25){
      $player->set('field_stealing_badges', '<img class="badge" src="/img/HomeBase_Images/stealing_badge/25thSteal.png">');
      $player->field_stealing_badges->format='full_html';
    }else if($player->field_stolen_bases->value >= 10){
      $player->set('field_stealing_badges', '<img class="badge" src="/img/HomeBase_Images/stealing_badge/10thSteal.png">');
      $player->field_stealing_badges->format='full_html';
    }else if($player->field_stolen_bases->value >= 5){
      $player->set('field_stealing_badges', '<img class="badge" src="/img/HomeBase_Images/stealing_badge/5thSteal.png">');
      $player->field_stealing_badges->format='full_html';
    }else if($player->field_stolen_bases->value >= 1){
      $player->set('field_stealing_badges', '<img class="badge" src="/img/HomeBase_Images/stealing_badge/1stSteal.png">');
      $player->field_stealing_badges->format='full_html';
    }else{
      $player->set('field_stealing_badges', '<img class="badge" src="/img/HomeBase_Images/blankBadge.png">');
      $player->field_stealing_badges->format='full_html';
    }

    //badge assign for strikes
    if($player->field_strikeouts->value >= 25){
      $player->set('field_strike_badges', '<img class="badge" src="/img/HomeBase_Images/strike_badge/25thStrike.png">');
      $player->field_strike_badges->format='full_html';
    }else if($player->field_strikeouts->value >= 15){
      $player->set('field_strike_badges', '<img class="badge" src="/img/HomeBase_Images/strike_badge/15thStrike.png">');
      $player->field_strike_badges->format='full_html';
    }else if($player->field_strikeouts->value >= 10){
      $player->set('field_strike_badges', '<img class="badge" src="/img/HomeBase_Images/strike_badge/10thStrike.png">');
      $player->field_strike_badges->format='full_html';
    }else if($player->field_strikeouts->value >= 5){
      $player->set('field_strike_badges', '<img class="badge" src="/img/HomeBase_Images/strike_badge/5thStrike.png">');
      $player->field_strike_badges->format='full_html';
    }else if($player->field_strikeouts->value >= 3){
      $player->set('field_strike_badges', '<img class="badge" src="/img/HomeBase_Images/strike_badge/3rdStrike.png">');
      $player->field_strike_badges->format='full_html';
    }else if($player->field_strikeouts->value >= 1){
      $player->set('field_strike_badges', '<img class="badge" src="/img/HomeBase_Images/strike_badge/1stStrike.png">');
      $player->field_strike_badges->format='full_html';
    }else{
      $player->set('field_strike_badges', '<img class="badge" src="/img/HomeBase_Images/blankBadge.png">');
      $player->field_strike_badges->format='full_html';
    }

    $player->save();
=======
    print '<pre>';
      print_r($player);
    print '</pre>';
>>>>>>> 29c9649ccabb4a6a551d649a9389cedbed0d9177
  }

}
