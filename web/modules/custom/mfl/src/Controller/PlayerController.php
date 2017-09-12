<?php

namespace Drupal\mfl\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\mfl\Entity\PlayerInterface;

/**
 * Class PlayerController.
 *
 *  Returns responses for Player routes.
 */
class PlayerController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Displays a Player  revision.
   *
   * @param int $player_revision
   *   The Player  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($player_revision) {
    $player = $this->entityManager()->getStorage('player')->loadRevision($player_revision);
    $view_builder = $this->entityManager()->getViewBuilder('player');

    return $view_builder->view($player);
  }

  /**
   * Page title callback for a Player  revision.
   *
   * @param int $player_revision
   *   The Player  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($player_revision) {
    $player = $this->entityManager()->getStorage('player')->loadRevision($player_revision);
    return $this->t('Revision of %title from %date', ['%title' => $player->label(), '%date' => format_date($player->getRevisionCreationTime())]);
  }

  /**
   * Generates an overview table of older revisions of a Player .
   *
   * @param \Drupal\mfl\Entity\PlayerInterface $player
   *   A Player  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(PlayerInterface $player) {
    $account = $this->currentUser();
    $langcode = $player->language()->getId();
    $langname = $player->language()->getName();
    $languages = $player->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $player_storage = $this->entityManager()->getStorage('player');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $player->label()]) : $this->t('Revisions for %title', ['%title' => $player->label()]);
    $header = [$this->t('Revision'), $this->t('Operations')];

    $revert_permission = (($account->hasPermission("revert all player revisions") || $account->hasPermission('administer player entities')));
    $delete_permission = (($account->hasPermission("delete all player revisions") || $account->hasPermission('administer player entities')));

    $rows = [];

    $vids = $player_storage->revisionIds($player);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\mfl\PlayerInterface $revision */
      $revision = $player_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = \Drupal::service('date.formatter')->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $player->getRevisionId()) {
          $link = $this->l($date, new Url('entity.player.revision', ['player' => $player->id(), 'player_revision' => $vid]));
        }
        else {
          $link = $player->link($date);
        }

        $row = [];
        $column = [
          'data' => [
            '#type' => 'inline_template',
            '#template' => '{% trans %}{{ date }} by {{ username }}{% endtrans %}{% if message %}<p class="revision-log">{{ message }}</p>{% endif %}',
            '#context' => [
              'date' => $link,
              'username' => \Drupal::service('renderer')->renderPlain($username),
              'message' => ['#markup' => $revision->getRevisionLogMessage(), '#allowed_tags' => Xss::getHtmlTagList()],
            ],
          ],
        ];
        $row[] = $column;

        if ($latest_revision) {
          $row[] = [
            'data' => [
              '#prefix' => '<em>',
              '#markup' => $this->t('Current revision'),
              '#suffix' => '</em>',
            ],
          ];
          foreach ($row as &$current) {
            $current['class'] = ['revision-current'];
          }
          $latest_revision = FALSE;
        }
        else {
          $links = [];
          if ($revert_permission) {
            $links['revert'] = [
              'title' => $this->t('Revert'),
              'url' => Url::fromRoute('entity.player.revision_revert', ['player' => $player->id(), 'player_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.player.revision_delete', ['player' => $player->id(), 'player_revision' => $vid]),
            ];
          }

          $row[] = [
            'data' => [
              '#type' => 'operations',
              '#links' => $links,
            ],
          ];
        }

        $rows[] = $row;
      }
    }

    $build['player_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
