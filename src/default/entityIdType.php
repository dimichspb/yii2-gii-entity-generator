<?php

/* @var $this yii\web\View */
/* @var $generator dimichspb\gii\entity\Generator */
/* @var $entityClass string */

echo "<?php\n";
?>
namespace <?= $generator->ns?>\<?= $generator->typesPath?>;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;
use <?= $generator->ns?>\<?= $entityClass?>Id;

class <?= $entityClass?>IdType extends GuidType
{
    const NAME = 'Type\<?= $entityClass ?>\<?= $entityClass?>Id';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        /**
        * @var $value <?= $entityClass?>Id
        */
        return (string)$value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new <?= ucfirst($entityClass)?>Id($value);
    }

    public function getName()
    {
        return self::NAME;
    }
}