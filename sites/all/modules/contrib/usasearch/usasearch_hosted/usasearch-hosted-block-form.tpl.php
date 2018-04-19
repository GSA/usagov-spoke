<?php

/**
 * @file
 * Displays the search form block.
 *
 * Available variables:
 * - $usasearch_form: The complete search form ready for print.
 * - $usasearch: Associative array of search elements. Can be used to print each
 *   form element separately.
 *
 * Default elements within $search:
 * - $usasearch['usasearch_hosted_box']: Text input area wrapped in a div.
 * - $usasearch['actions']: Rendered form buttons.
 * - $usasearch['hidden']: Hidden form elements. Used to validate forms when
 *   submitted.
 *
 * Modules can add to the search form, so it is recommended to check for their
 * existence before printing. The default keys will always exist. To check for
 * a module-provided field, use code like this:
 * @code
 *   <?php if (isset($usasearch['extra_field'])): ?>
 *     <div class="extra-field">
 *       <?php print $usasearch['extra_field']; ?>
 *     </div>
 *   <?php endif; ?>
 * @endcode
 *
 * @see template_preprocess_usasearch_hosted_box()
 */
?>
<div class="container-inline">
  <?php if (empty($variables['form']['#block']->subject)): ?>
    <h2 class="element-invisible"><?php print t('Search form'); ?></h2>
  <?php endif; ?>
  <?php print $usasearch_form; ?>
</div>
