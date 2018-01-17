<?php

/* @var $this yii\web\View */
/* @var $generator dimichspb\gii\entity\Generator */
/* @var $entityClass string */
/* @var $fields array */

?>
<?= $generator->getEntityClassName()?>:
  type: entity
  table: <?= $entityClass ?>
  id:
    <?= strtolower($entityClass)?>Id:
      id: true
      column: id
      type: Type\<?= $entityClass?>\<?= $entityClass?>Id
      generator:
        strategy: AUTO
  fields:
<?php foreach ($fields as $field):?>
    <?=$field?>:
      column: <?=$field?>

      type: Type\<?=$entityClass?>\<?= ucwords($field)?>

      nullable: true

<?php endforeach; ?>