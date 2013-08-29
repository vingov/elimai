<?php
/**
 * @file
 * Provides functions for working with libraries.
 */

/**
 * Loads Twitter Bootstrap library.
 */
function _elimai_load_bootstrap() {
  $version = theme_get_setting('bootstrap_version');
  $js_path = '/js/bootstrap.min.js';
  $js_options = array(
    'group' => JS_LIBRARY,
  );
  $css_path = '/css/bootstrap.min.css';
  $cssr_path = '/css/bootstrap-responsive.min.css';
  $css_options = array(
    'group' => CSS_THEME,
    'weight' => -1000,
    'every_page' => TRUE,
  );
  switch (theme_get_setting('bootstrap_source')) {
    case 'bootstrapcdn':
      $bootstrap_path = '//netdna.bootstrapcdn.com/twitter-bootstrap/' . $version;
      $js_options['type'] = 'external';
      $css_path = '/css/bootstrap-combined.min.css';
      unset($cssr_path);
      $css_options['type'] = 'external';
      break;

    case 'libraries':
      $bootstrap_path = 'sites/all/libraries/bootstrap';
      break;

    case 'theme';
      $bootstrap_path = path_to_theme() . '/libraries/bootstrap';
      break;

    default:
      return;
  }
  _elimai_add_asset('js', $bootstrap_path . $js_path, $js_options);
  _elimai_add_asset('css', $bootstrap_path . $css_path, $css_options);
  if (isset($cssr_path)) {
    _elimai_add_asset('css', $bootstrap_path . $cssr_path, $css_options);
  }
}

/**
 * Adds js/css file.
 */
function _elimai_add_asset($type, $data, $options) {
  if (isset($options['browsers']) && !is_array($options['browsers'])) {
    $options['browsers'] = _elimai_browsers_to_array($options['browsers']);
  }
  switch ($type) {
    case 'css':
      drupal_add_css($data, $options);
      break;

    case 'js':
      if (isset($options['browsers'])) {
        $data = file_create_url($data);
        $elements = array(
          '#markup' => '<script type="text/javascript" src="' . $data . '"></script>',
          '#browsers' => $options['browsers'],
        );
        $elements = drupal_pre_render_conditional_comments($elements);
        _elimai_add_html_head_bottom(drupal_render($elements));
      }
      else {
        drupal_add_js($data, $options);
      }
      break;
  }
}

/**
 * Converts string representation of browsers to the array.
 */
function _elimai_browsers_to_array($browsers) {
  switch ($browsers) {
    case 'modern':
      return array('IE' => 'gte IE 9', '!IE' => TRUE);

    case 'obsolete':
      return array('IE' => 'lt IE 9', '!IE' => FALSE);
  }
  return array('IE' => TRUE, '!IE' => TRUE);
}

/**
 * Allows to add an extra html markup to the bottom of <head>.
 */
function _elimai_add_html_head_bottom($data = NULL) {
  $head_bottom = &drupal_static(__FUNCTION__);
  if (!isset($head_bottom)) {
    $head_bottom = '';
  }

  if (isset($data)) {
    $head_bottom .= $data;
  }
  return $head_bottom;
}
