<?php
/**
 * @file
 * Theme settings for Breadcrump and Social Block. 
 */

/**
 * Implements of THEME_settings().
 */
function elimai_form_system_theme_settings_alter(&$form, &$form_state) {

  $form['elimai_settings']['breadcrumb'] = array(
    '#type' => 'fieldset',
    '#title' => t('Breadcrumb'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  );
  $form['elimai_settings']['breadcrumb']['breadcrumb_delimiter'] = array(
    '#type' => 'textfield',
    '#title' => t('Breadcrumb delimiter'),
    '#size' => 4,
    '#default_value' => theme_get_setting('breadcrumb_delimiter'),
    '#description' => t("Don't forget spaces at either end... if you're into that sort of thing."),
  );
  $form['elimai_settings']['socialblock'] = array(
    '#type' => 'fieldset',
    '#title' => t('Social Icon'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  );
  $form['elimai_settings']['socialblock']['social_block'] = array(
    '#type' => 'checkbox',
    '#title' => t('Show Social Icons'),
    '#default_value' => theme_get_setting('social_block', 'elimai'),
    '#description'   => t("Check this option to show Social Icons."),
  );
  $form['elimai_settings']['socialblock']['twitter_url'] = array(
    '#type' => 'textfield',
    '#title' => t('Twitter Profile URL'),
    '#default_value' => theme_get_setting('twitter_url', 'elimai'),
    '#description'   => t("Enter your Twitter Profile URL. Leave blank to hide."),
  );
  $form['elimai_settings']['socialblock']['facebook_url'] = array(
    '#type' => 'textfield',
    '#title' => t('Facebook Profile URL'),
    '#default_value' => theme_get_setting('facebook_url', 'elimai'),
    '#description'   => t("Enter your Facebook Profile URL. Leave blank to hide."),
  );
  $form['elimai_settings']['socialblock']['gplus_url'] = array(
    '#type' => 'textfield',
    '#title' => t('Google Plus Address'),
    '#default_value' => theme_get_setting('gplus_url', 'elimai'),
    '#description'   => t("Enter your Google Plus URL. Leave blank to hide."),
  );
  $form['elimai_settings']['socialblock']['pinterest_url'] = array(
    '#type' => 'textfield',
    '#title' => t('Pinterest Address'),
    '#default_value' => theme_get_setting('pinterest_url', 'elimai'),
    '#description'   => t("Enter your Pinterest URL. Leave blank to hide."),
  );
  $form['libraries'] = array(
    '#type' => 'fieldset',
    '#title' => t('Libraries'),
    'bootstrap_source' => array(
      '#type' => 'radios',
      '#title' => t('Load Twitter Bootstrap library from:'),
      '#options' => array(
        'bootstrapcdn' => t('Bootstrap CDN'),
        'libraries' => t('sites/all/libraries/bootstrap'),
        'theme' => t('[current_theme]/libraries/bootstrap'),
      ),
      '#default_value' => theme_get_setting('bootstrap_source'),
    ),
    'bootstrap_version' => array(
      '#type' => 'textfield',
      '#title' => t('Twitter Bootstrap version:'),
      '#default_value' => theme_get_setting('bootstrap_version'),
    ),
  );
}
