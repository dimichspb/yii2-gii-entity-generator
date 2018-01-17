<?php

/* @var $this yii\web\View */
/* @var $generator dimichspb\gii\entity\Generator */
/* @var $entityClass string */
/* @var $field string */

echo "<?php\n";
?>
namespace <?= $generator->ns ?>\<?= $generator->dtoPath?>;

use common\entities\dto\Dto;

class <?= $entityClass?>Update<?= ucwords($field)?>Dto extends Dto
{
    public $<?= lcfirst($entityClass)?>Id;
    public $<?= $field?>;
}