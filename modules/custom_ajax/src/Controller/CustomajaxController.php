<?php

namespace Drupal\custom_ajax\Controller;

use Drupal\Core\Controller\ControllerBase;

use Drupal\Core\Session\AccountInterface;//
use Symfony\Component\HttpFoundation\Request;//

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\node\Entity\Node;// will replace with user

// use Drupal\Core\Render\RendererInterface;// would be best practice instead of druapl_render...


class CustomajaxController extends ControllerBase {

  /**
   * Display the markup.
   *
   * @return array
   */
    public function getStats($js, $node_id) {
        $selector = "#roster-ajax-wrapper";

        $node = Node::load($node_id);
        $build = node_view($node);
        $html = drupal_render($build);

        $response = new AjaxResponse();
        $response->addCommand(new HtmlCommand($selector, $html));

        return $response;
    }

}


// // to add ajax on event in render array
// // for sure works with forms
// '#ajax' => [
//     'callback' => array($this, 'validateEmailAjax'),
//     'event' => 'change',
//     'progress' => array(
//       'type' => 'throbber',
//       'message' => t('Verifying email...'),
//     ),
//   ],// use for predictive badges/levels
