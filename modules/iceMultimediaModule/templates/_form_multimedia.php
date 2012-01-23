<?php use_stylesheet('/backend/css/jquery/contextMenu.css'); ?>
<?php use_javascript('/assets/js/jquery/contextMenu.js'); ?>

<?php use_helper('iceMultimedia'); ?>

<?php if ($multimedia): ?>
<ul id="multimedia_list" style="margin-left: 125px;">
  <?php foreach ($multimedia as $m): ?>
    <li style="display: inline; cursor: move;">
      <?php
        echo ice_image_tag_multimedia(
          $m, 'thumbnail',
          array('align' => 'left', 'style' => 'margin: 10px;', 'id'=> 'multimedia_'. $m->getId())
        );
      ?>
    </li>
  <?php endforeach; ?>
  </ul>
<?php endif; ?>

<ul id="multimedia_context_menu" class="contextMenu" style="width: 130px;">
  <li class="delete">
    <a href="#delete" style="text-decoration: none;">&nbsp;Delete Image</a>
  </li>
</ul>

<br clear="all"/>

<script type="text/javascript">
$(document).ready(function()
{
  $('#multimedia_list').sortable(
  {
    items: 'img', opacity: 0.6,
    update: function()
    {
      jQuery.post(
        '<?php echo url_for('@ice_multimedia_ajax_reorder'); ?>',
        {
          items: $('#multimedia_list').sortable('serialize'),
          key: 'multimedia'
        }
      );
    }
  });

  $("#multimedia_list img").contextMenu(
  {
    menu: 'multimedia_context_menu'
  },
  function(action, el)
  {
    if ('delete' == action)
    {
      jQuery.ajax(
      {
        url: '<?php echo url_for('@ice_multimedia_ajax_delete'); ?>',
        data: { id: $(el).attr('id').replace(/multimedia_/, '') },
        success: function()
        {
          $(el).fadeOut('slow');
        }
      });
    }
  });
});
</script>
