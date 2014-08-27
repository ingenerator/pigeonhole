<?php
/**
 * Standard view template for pigeonhole messages using twitter bootstrap
 * @author    Andrew Coulton <andrew@ingenerator.com>
 * @copyright 2014 inGenerator Ltd
 * @licence   BSD
 *
 * @var       \Ingenerator\Pigeonhole\Pigeonhole $pigeonhole
 */
?>
<?php if ($pigeonhole->has_messages()): ?>
  <?php foreach ($pigeonhole->clear() as $tmp_message): ?>
    <div class="alert <?=$tmp_message->class;?>">
      <strong><?=$tmp_message->title;?></strong>
        <?=$tmp_message->message; ?>
    </div>
  <?php endforeach; ?>
<?php endif; ?>