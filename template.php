<?php
/**
 * @file
 * Contains the theme's functions to manipulate Drupal's default markup.
 */

// Ensure that __DIR__ constant is defined:
if (!defined('__DIR__')) {
  define('__DIR__', dirname(__FILE__));
}

// Require Files.
require_once __DIR__ . '/includes/libraries.inc';

/**
 * Preprocesses variables for page.tpl.php.
 */
function elimai_preprocess_html(&$variables) {
  _elimai_load_bootstrap();
}

/**
 * Implements THEME_preprocess_node().
 */
function elimai_preprocess_node(&$variables) {
  $variables['user_picture'] = FALSE;
  $variables['submitted'] = FALSE;
  $variables['content']['field_tags']['#title'] = FALSE;
  $variables['content']['links']['comment'] = FALSE;

  $node = $variables['node'];

  $variables['date_day'] = format_date($node->created, 'custom', 'j');
  $variables['date_month'] = format_date($node->created, 'custom', 'F');
  $variables['date_year'] = format_date($node->created, 'custom', 'Y');

  $variables['content']['field_tags']['#theme'] = 'links';
  $variables['content']['field_image'][0]['#attributes']['class'][] = 'img-polaroid';
  // Let's get that read more link out of the generated links variable!
  unset($variables['content']['links']['node']['#links']['node-readmore']);

  // Now let's put it back as it's own variable! So it's actually versatile!
  $variables['newreadmore'] = t('<footer> <a href="!title" class="btn btn-mini">Read More</a> </footer>',
    array(
      '!title' => $variables['node_url'],
    )
  );
}

/**
 * Implements template_preprocess_page().
 */
function elimai_preprocess_page(&$variables) {
  // Disabling the logo from the page.
  $variables['logo'] = FALSE;
}

/**
 * Theme override.
 * 
 * Add custom class to image styles.
 */
function elimai_image_style($variables) {

  // Determine the dimensions of the styled image.
  $dimensions = array(
    'width' => $variables['width'],
    'height' => $variables['height'],
  );

  image_style_transform_dimensions($variables['style_name'], $dimensions);

  $variables['width'] = $dimensions['width'];
  $variables['height'] = $dimensions['height'];

  // Determine the URL for the styled image.
  $variables['path'] = image_style_url($variables['style_name'], $variables['path']);

  // Begin custom snippet.
  // Add or append custom classes, to avoid clobbering existing.
  if (isset($variables['attributes']['class'])) {
    $variables['attributes']['class'] += array('img-polaroid', $variables['style_name']);
  }
  else {
    $variables['attributes']['class'] = array('img-polaroid', $variables['style_name']);
  }

  /* End custom snippet */
  return theme('image', $variables);
}

/**
 * Implements THEME_form_alter().
 */
function elimai_form_alter(&$form, &$form_state, $form_id) {
  if ($form_id == 'search_block_form') {
    $form['#attributes']['class'][] = 'form-search';
    $form['search_block_form']['#attributes']['class'][] = 'span3 search-query';
    $form['actions']['submit']['#attributes']['class'][] = 'btn';
  }
}

/**
 * Implements theme_item_list().
 */
function elimai_item_list($vars) {
  if (isset($vars['attributes']['class']) && in_array('pager', $vars['attributes']['class'])) {
    // Adjust pager output.
    unset($vars['attributes']['class']);
    foreach ($vars['items'] as &$item) {
      if (in_array('pager-current', $item['class'])) {
        $item['class'] = array('active');
        $item['data'] = '<a href="#">' . $item['data'] . '</a>';
      }
      elseif (in_array('pager-ellipsis', $item['class'])) {
        $item['class'] = array('disabled');
        $item['data'] = '<a href="#">' . $item['data'] . '</a>';
      }
    }
    return '<div class="pagination pagination-centered">' . theme_item_list($vars) . '</div>';
  }
  return theme_item_list($vars);
}

/**
 * Implements theme_breadcrumb().
 */
function elimai_breadcrumb($variables) {
  $breadcrumb = $variables['breadcrumb'];
  $delimiter = theme_get_setting('breadcrumb_delimiter');

  if (!empty($breadcrumb)) {
    // Use CSS to hide titile .element-invisible.
    $output = '<h2 class="element-invisible">' . t('You are here') . '</h2>';
    // Comment below line to hide current page to breadcrumb.
    $breadcrumb[] = drupal_get_title();
    $output .= '<nav class="breadcrumb">' . implode($delimiter, $breadcrumb) . '</nav>';
    return $output;
  }
}
