<?php

namespace Drupal\acievements\Controller;

use Drupal\Core\Controller\ControllerBase;

// use Drupal\Core\Session\AccountInterface;//
// use Symfony\Component\HttpFoundation\Request;//

// use Drupal\Core\Ajax\AjaxResponse;
// use Drupal\Core\Ajax\HtmlCommand;
use Drupal\node\Entity\Node;// will replace with user

// use Drupal\Core\Render\RendererInterface;// would be best practice instead of druapl_render...


class AchievementsController extends ControllerBase {


  public function assignBadges($player){
    var_dump('PLAYER VALUE IS '.$player->nid->value);
  }

}
