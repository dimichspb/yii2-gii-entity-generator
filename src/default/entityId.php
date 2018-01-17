<?php

/* @var $this yii\web\View */
/* @var $generator dimichspb\gii\entity\Generator */
/* @var $entityClass string */

echo "<?php\n";
?>
namespace <?= $generator->ns?>;

class <?= $entityClass?>Id
{
    /**
    * @var string
    */
    protected $<?= lcfirst($entityClass)?>Id;

    /**
    * <?= $entityClass?>Id constructor.
    * @param $<?= lcfirst($entityClass)?>Id
    */
    public function __construct($<?= lcfirst($entityClass)?>Id)
    {
        //Assertion::string($<?= lcfirst($entityClass)?>Id);

        $this-><?= lcfirst($entityClass)?>Id = $<?= lcfirst($entityClass)?>Id;
    }

    /**
    * @return string
    */
    public function get<?= $entityClass?>Id()
    {
        return $this-><?= lcfirst($entityClass)?>Id;
    }

    public function __toString()
    {
        return (string)$this->get<?= $entityClass?>Id();
    }

    /**
    * @param <?= $entityClass?>Id $that
    * @return bool
    */
    public function isEqualTo(self $that)
    {
        return $this->get<?= $entityClass ?>Id() === $that->get<?= $entityClass?>Id();
    }
}