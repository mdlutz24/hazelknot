<?php

namespace Drupal\mfl\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class MFLSettingsForm.
 */
class MFLSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'mfl.mflsettings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'mfl_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('mfl.mflsettings');
    $form['mfl_league_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('MFL League ID'),
      '#description' => $this->t('The ID of this MFL League'),
      '#maxlength' => 5,
      '#size' => 5,
      '#default_value' => $config->get('mfl_league_id'),
    ];
    $form['season_start'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Season Start'),
      '#description' => $this->t('The Date of the season start.  This is the Tuesday prior to any games'),
      '#default_value' => $config->get('season_start'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('mfl.mflsettings')
      ->set('mfl_league_id', $form_state->getValue('mfl_league_id'))
      ->set('season_start', $form_state->getValue('season_start'))
      ->save();
  }

}
