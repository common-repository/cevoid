<div class="wrap">
<style>
  .cevoid-options-php {
    background-color: #f4f6f8;
  }

  #adminmenu .wp-menu-image img {
    padding: 7px 0 0 0;
    opacity: 1;
  }
</style>

<?php 
  $hasWoocommerce = class_exists( 'WooCommerce');
  $hasPermalinks = get_option('permalink_structure');

  $shouldShowIframe = $hasWoocommerce && $hasPermalinks;
?>

<?php if ($shouldShowIframe) { ?>
  <iframe id="cevoidContainer"
  title="Cevoid container"
  width="100%"
  height="1040"
  src="https://wp.cevoid.com">
<?php } else {?>
  <div>Woocommerce needs to be installed and permalinks needs to be active for this plugin to work properly.</div>
<?php }?>

</div>