<?php

/* @var $this yii\web\View */
/* @var $generator dimichspb\gii\entity\Generator */
/* @var $entityClass string */

echo "<?php\n";
?>
namespace <?= $generator->ns ?>\<?= $generator->eventsPath?>;

use common\entities\events\Event;

class <?= $entityClass?>CreatedEvent extends Event
{

}