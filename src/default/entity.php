<?php

/* @var $this yii\web\View */
/* @var $generator dimichspb\gii\entity\Generator */
/* @var $entityClass string */
/* @var $fields array */

echo "<?php\n";
?>
namespace <?= $generator->ns ?>;

use common\entities\Entity;
use common\entities\events\EventTrait;
use common\entities\traits\ValidationTrait;
use common\entities\ValidableInterface;
<?php foreach ($fields as $field): ?>
use <?= $generator->ns ?>\<?= ucwords($field) ?>;
<?php endforeach; ?>
use <?= $generator->getEventCreatedClassName() ?>;
use <?= $generator->getEventUpdatedClassName() ?>;

/**
* @ORM\Entity
* @ORM\Table(name="")
* @ORM\IgnoreAnnotation("Entity")
*/
class <?= $entityClass ?> extends Entity implements ValidableInterface
{
    use EventTrait, ValidationTrait;

    /**
    * @var <?= $entityClass ?>Id
    */
    protected $<?=lcfirst($entityClass)?>Id;

    <?php foreach ($fields as $field): ?>

    /**
    * @var <?= ucwords($field) ?>

    */
    protected $<?= $field ?>;

    <?php endforeach; ?>

    /**
    * @return <?= $entityClass?>Id
    */
    public function get<?= $entityClass ?>Id()
    {
        if (!is_null($this-><?= lcfirst($entityClass)?>Id) && !$this-><?= lcfirst($entityClass)?>Id instanceof <?= $entityClass?>Id) {
            $this-><?= lcfirst($entityClass)?>Id = new <?= $entityClass?>Id($this-><?= lcfirst($entityClass)?>Id);
        }
        return $this-><?= lcfirst($entityClass)?>Id;
    }

    /**
    * @param <?= $entityClass?>Id $<?= lcfirst($entityClass)?>Id
    */
    public function set<?= $entityClass ?>Id(<?= $entityClass?>Id $<?= lcfirst($entityClass)?>Id)
    {
        $this-><?= lcfirst($entityClass)?>Id = $<?= lcfirst($entityClass)?>Id;
    }

    <?php foreach ($fields as $field): ?>

    /**
    * @return <?= ucwords($field) ?>

    */
    public function get<?= ucwords($field) ?>()
    {
        return $this-><?= $field ?>;
    }

    /**
    * @param <?= ucwords($field) ?> $<?= $field ?>

    */
    public function set<?= ucwords($field) ?>(<?= ucwords($field) ?> $<?= $field ?>)
    {
        $this-><?= $field ?> = $<?= $field ?>;
    }

    <?php endforeach; ?>
    <?php foreach ($fields as $field): ?>

    public function update<?= ucwords($field) ?>($<?= $field ?>)
    {
        $this->set<?= ucwords($field) ?>(new <?= ucwords($field) ?>($<?= $field ?>));
        $this->recordEvent(new <?= ucwords($entityClass) ?>UpdatedEvent($this));

        return $this;
    }
    <?php endforeach; ?>

    /**
    * <?= ucwords($entityClass) ?> constructor.
    * @param <?= $entityClass?>Id $<?= lcfirst($entityClass)?>Id
<?php foreach ($fields as $field): ?>
    * @param <?= ucwords($field) ?>|null $<?= $field ?>
<?php endforeach; ?>

    */

    public function __construct(<?= $entityClass?>Id $<?= lcfirst($entityClass)?>Id, <?php foreach ($fields as $field): ?><?= ucwords($field) ?> $<?= $field ?> = null<?php endforeach;?>)
    {
        $this-><?= lcfirst($entityClass)?>Id = $<?= lcfirst($entityClass)?>Id;
<?php foreach ($fields as $field): ?>
        $this-><?= $field ?> = $<?= $field ?>;
<?php endforeach; ?>

        $this->recordEvent(new <?= ucwords($entityClass) ?>CreatedEvent($this));
    }
}