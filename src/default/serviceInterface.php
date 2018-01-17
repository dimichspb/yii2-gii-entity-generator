<?php

/* @var $this yii\web\View */
/* @var $generator dimichspb\gii\entity\Generator */
/* @var $entityClass string */

echo "<?php\n";
?>
namespace <?= dirname($generator->ns)?>;

interface ServiceInterface
{
    public function createFromArray(array $row, array $headerRow = []);
    public function removeAll(array $criteria = []);
}