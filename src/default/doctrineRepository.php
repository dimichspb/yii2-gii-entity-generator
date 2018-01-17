<?php

/* @var $this yii\web\View */
/* @var $generator dimichspb\gii\entity\Generator */
/* @var $entityClass string */
/* @var $fields array */

echo "<?php\n";
?>
namespace <?= $generator->ns?>\<?= $generator->repositoriesPath?>;

use common\entities\repositories\NotFoundException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use <?= $generator->getEntityClassName()?>;
use <?= $generator->getEntityClassName()?>Id;
<?php foreach ($fields as $field): ?>
use <?= $generator->ns ?>\<?= ucwords($field)?>;
use <?= $generator->ns ?>\<?= $generator->typesPath ?>\<?= ucwords($field)?>Type;
<?php endforeach; ?>
use Ramsey\Uuid\Uuid;

class Doctrine<?= $entityClass ?>Repository implements <?= $entityClass ?>RepositoryInterface
{
    private $em;
    private $entityRepository;

    public function __construct(EntityManager $em, EntityRepository $entityRepository)
    {
        $this->em = $em;
        $this->entityRepository = $entityRepository;
    }

    public function get(<?= $entityClass ?>Id $id)
    {
        if (!$entity = $this->entityRepository->find($id)) {
            return null;
        }
        return $entity;
    }

    public function add(<?= $entityClass?> $entity)
    {
        $this->em->persist($entity);
        $this->em->flush($entity);
    }

    public function save(<?= $entityClass?> $entity)
    {
        $this->em->flush($entity);
    }

    public function remove(<?= $entityClass?> $entity)
    {
        $this->em->remove($entity);
        $this->em->flush($entity);
    }

    public function nextId()
    {
        return new <?= $entityClass?>Id(Uuid::uuid4()->toString());
    }

    public function findOne(array $criteria = [])
    {
        $entities = $this->entityRepository->findBy($criteria);
        return reset($entities);
    }

    public function findAll(array $criteria = [])
    {
        return $this->entityRepository->findBy($criteria);
    }

    public function all()
    {
        return $this->entityRepository->findAll();
    }

    public function mapping()
    {
        $classMetadata = $this->em->getClassMetadata(<?= $entityClass?>::class);
        $fields = [];
        if (!empty($classMetadata->discriminatorColumn)) {
            $fields[$classMetadata->getFieldName($classMetadata->discriminatorColumn['name'])] = $classMetadata->discriminatorColumn['name'];
        }
        foreach ($classMetadata->getColumnNames() as $columnName) {
            if (!$classMetadata->isInheritedField($classMetadata->getFieldName($columnName))) {
                $fields[$classMetadata->getFieldName($columnName)] = $columnName;
            }
        }
        foreach ($classMetadata->getAssociationMappings() as $name => $relation) {
            if (!$classMetadata->isInheritedAssociation($name)){
                foreach ($relation['joinColumns'] as $joinColumn) {
                    $fields[$classMetadata->getFieldName($joinColumn['name'])] = $joinColumn['name'];
                }
            }
        }
        return $fields;
    }

    public function removeAll(array $criteria = [])
    {
        $class = <?= $entityClass?>::class;
        $queryBuilder = $this->em->createQueryBuilder();
        $queryBuilder->delete()->from($class, 'a');

        foreach ($criteria as $name => $value) {
            $key = ':' . $name;
            $name = 'a.' . $name;
            $queryBuilder->andWhere($queryBuilder->expr()->eq($name, $key))->setParameter($key, $value);
        }

        return $queryBuilder->getQuery()->execute();
    }
}