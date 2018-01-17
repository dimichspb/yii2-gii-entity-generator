<?php

/* @var $this yii\web\View */
/* @var $generator dimichspb\gii\entity\Generator */
/* @var $entityClass string */
/* @var $fields array */

echo "<?php\n";
?>
namespace <?= $generator->ns?>\<?= $generator->repositoriesPath?>;

use <?= $generator->getEntityClassName()?>;
use <?= $generator->getEntityClassName()?>Id;

interface <?= $entityClass ?>RepositoryInterface
{
    /**
     * @param <?= $entityClass ?>Id $id
     * @return <?= $entityClass ?>

     */
    public function get(<?= $entityClass ?>Id $id);

    /**
     * @param <?= $entityClass ?> $entity
     * @return $this
     */
    public function add(<?= $entityClass ?> $entity);

    /**
     * @param <?= $entityClass ?> $entity
     * @return $this
     */
    public function save(<?= $entityClass ?> $entity);

    /**
     * @param <?= $entityClass ?> $entity
     * @return $this
     */
    public function remove(<?= $entityClass ?> $entity);

    /**
     * @return <?= $entityClass ?>Id
     */
    public function nextId();

    /**
     * @param array $criteria
     * @return <?= $entityClass ?>

     */
    public function findOne(array $criteria = []);

    /**
     * @param array $criteria
     * @return <?= $entityClass ?>[]
     */
    public function findAll(array $criteria = []);

    /**
     * @return <?= $entityClass ?>[]
     */
    public function all();

    /**
     * @return array
     */
    public function mapping();

    public function removeAll(array $criteria = []);
}