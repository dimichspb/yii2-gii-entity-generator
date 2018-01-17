<?php

/* @var $this yii\web\View */
/* @var $generator dimichspb\gii\entity\Generator */
/* @var $entityClass string */
/* @var $fields array */

echo "<?php\n";
?>
namespace <?= $generator->ns?>\<?= $generator->repositoriesPath?>;

use common\entities\repositories\NotFoundException;
use common\entities\repositories\Repository;
use <?= $generator->getEntityClassName()?>;
use <?= $generator->getEntityClassName()?>Id;
<?php foreach ($fields as $field): ?>
use <?= $generator->ns ?>\<?= ucwords($field)?>;
<?php endforeach; ?>
use Ramsey\Uuid\Uuid;

class Memory<?= $entityClass ?>Repository implements <?= $entityClass ?>RepositoryInterface
{
    /**
     * @var <?= $entityClass ?>[]
     */
    private $items = [];

    public function get(<?= $entityClass ?>Id $id)
    {
        if (!isset($this->items[$id->get<?= $entityClass ?>Id()])) {
            return null;
        }
        return clone $this->items[$id->get<?= $entityClass ?>Id()];
    }

    public function add(<?= $entityClass ?> $entity)
    {
        $this->items[$entity->get<?= $entityClass ?>Id()->get<?= $entityClass ?>Id()] = $entity;
    }

    public function save(<?= $entityClass ?> $entity)
    {
        $this->items[$entity->get<?= $entityClass ?>Id()->get<?= $entityClass ?>Id()] = $<?= $entityClass ?>;
    }

    public function remove(<?= $entityClass ?> $entity)
    {
        if ($this->items[$entity->get<?= $entityClass ?>Id()->get<?= $entityClass ?>Id()]) {
            unset($this->items[$entity->get<?= $entityClass ?>Id()->get<?= $entityClass ?>Id()]);
        }
    }

    public function nextId()
    {
        return new <?= $entityClass ?>Id(Uuid::uuid4()->toString());
    }

    public function findOne(array $criteria = [])
    {
        $items = $this->findAll($criteria);
        return reset($items);
    }

    public function findAll(array $criteria = [])
    {
        return $this->items;
    }

    public function all()
    {
        return $this->findAll();
    }

    public function mapping()
    {
        // TODO: Implement mapping() method.
    }

    public function removeAll(array $criteria = [])
    {
        $items = $this->findAll($criteria);
        $this->items = array_filter($this->items, function($item) use ($items) {
            return !in_array($item, $items);
        });
    }

}