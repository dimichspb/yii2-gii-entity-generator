<?php

/* @var $this yii\web\View */
/* @var $generator dimichspb\gii\entity\Generator */
/* @var $entityClass string */
/* @var $fields array */

echo "<?php\n";
?>
namespace <?= $generator->ns ?>\<?= $generator->dtoPath?>;

use common\entities\dto\Dto;

class <?= $entityClass?>CreateDto extends Dto
{
    public $<?= lcfirst($entityClass)?>Id;
<?php foreach ($fields as $field): ?>
    public $<?= $field?>;

<?php endforeach; ?>
}