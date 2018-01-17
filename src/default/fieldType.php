<?php

/* @var $this yii\web\View */
/* @var $generator dimichspb\gii\entity\Generator */
/* @var $entityClass string */
/* @var $field string */

echo "<?php\n";
?>
namespace <?= $generator->ns?>\<?= $generator->typesPath?>;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;
use <?= $generator->ns?>\<?= ucfirst($field)?>;

class <?= ucfirst($field)?>Type extends GuidType
{
    const NAME = 'Type\<?= $entityClass ?>\<?= ucfirst($field)?>';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        /**
        * @var $value <?= ucfirst($field)?>
        */
        return (string)$value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new <?= ucfirst($field)?>($value);
    }

    public function getName()
    {
        return self::NAME;
    }
}