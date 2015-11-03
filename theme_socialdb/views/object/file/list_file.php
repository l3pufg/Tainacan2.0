<?php
/*
 * View responsavel em mostrar os arquivos de um objeto
 */
?>
<!-- TAINACAN: mostra os os arquivos de um objeto, o icone do arquivo 
   eh gerado automaticamente pelo o wordpress, apenas o titulo que colocamos manualmente
-->
<div> 
    <?php if (!$attachments): ?>
        <div id="no_file_<?php echo $object_id; ?>" class="text-center">
            <?php _e('No Attachments','tainacan'); ?>
        </div>
    <?php else: ?>
    <div id="files_<?php echo $object_id; ?>" style="text-align: center;">   
            <?php
            foreach ($attachments as $attachment) {
                echo wp_get_attachment_link($attachment->ID, 'thumbnail', false, true);
                echo "<h4 class='text-center' style='margin-top:1px;'><small>".$attachment->post_title . "</small></h4>";
            }
            ?>
        </div>   
<?php endif; ?>

</div>

