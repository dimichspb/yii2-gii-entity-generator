<?php

/* @var $this yii\web\View */
/* @var $generator dimichspb\gii\entity\Generator */
/* @var $entityClass string */
/* @var $field string */

echo "<?php\n";
?>
namespace <?= $generator->ns?>;

class <?= ucfirst($field)?>
{
    /**
     * @var string
     */
    protected $<?= $field ?>;

    /**
     * <?= ucfirst($field)?> constructor.
     * @param $<?= $field ?>

     */
    public function __construct($<?= $field ?>)
    {
        //Assertion::string($<?= $field ?>);

        $this-><?= $field ?> = $<?= $field ?>;
    }

    /**
     * @return string
     */
    public function get<?= ucfirst($field)?>()
    {
        return $this-><?= $field?>;
    }

    public function __toString()
    {
        return (string)$this->get<?= ucfirst($field)?>();
    }

    /**
     * @param <?= ucfirst($field)?> $that
     * @return bool
     */
    public function isEqualTo(self $that)
    {
        return $this->get<?=ucfirst($field)?>() === $that->get<?=ucfirst($field)?>();
    }
}