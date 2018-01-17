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
use <?= $generator->ns ?>\<?= $generator->typesPath ?>\<?= ucwords($field) ?>
<?php endforeach; ?>

/**
* @ORM\Entity
* @ORM\Table(name="")
* @ORM\IgnoreAnnotation("Entity")
*/
class <?= $generator->entityClass ?> extends Entity implements ValidableInterface
{
    use EventTrait, ValidationTrait;


    <?php foreach ($fields as $field): ?>
    /**
    * @var <?= ucwords($field) ?>
    */
    protected $<?= $field ?>;

    <?php endforeach; ?>

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
    <?php foreach ($fields as $field): ?>
    * @param <?= ucwords($field) ?>|null $<?= $field ?>
    <?php endforeach; ?>
    */

    public function __construct(<?php foreach ($fields as $field): ?><?= ucwords($field) ?> $<?= $field ?> = null<?php endforeach;?>)
    {
        <?php foreach ($fields as $field): ?>
        $this-><?= $field ?> = $<?= $field ?>;
        <?php endforeach; ?>

        $this->recordEvent(new <?= ucwords($entityClass) ?>CreatedEvent($this));
    }
}