<?php

/* @var $this yii\web\View */
/* @var $generator dimichspb\gii\entity\Generator */
/* @var $entityClass string */
/* @var $fields array */

echo "<?php\n";
?>
namespace isem\entities\connection\services;

use common\entities\dispatchers\EventDispatcher;
use common\entities\exceptions\ValidationException;
use common\entities\services\Service;
use <?= $generator->ns?>\<?= $entityClass?>;
use <?= $generator->ns?>\<?= $entityClass?>Id;
use <?= $generator->ns?>\<?= $generator->dtoPath ?>\<?= $entityClass ?>CreateDto;
use <?= $generator->ns?>\<?= $generator->repositoriesPath ?>\<?= $entityClass ?>RepositoryInterface;
<?php foreach ($fields as $field):?>
use <?= $generator->ns?>\<?= ucfirst($field)?>;

<?php endforeach; ?>
use <?= dirname($generator->ns)?>\ServiceInterface;

class <?= $entityClass ?>Service extends Service implements ServiceInterface
{
    /**
     * @var <?= $entityClass ?>RepositoryInterface
     */
    private $repository;

    /**
     * @var EventDispatcher
     */
    private $dispatcher;

    public function __construct(<?= $entityClass ?>RepositoryInterface $repository, EventDispatcher $eventDispatcher)
    {
        $this->repository = $repository;
        $this->dispatcher = $eventDispatcher;
    }

    public function create(<?= $entityClass ?>CreateDto $dto)
    {
        $<?= lcfirst($entityClass)?> = new <?= $entityClass ?>(
            new <?= $entityClass ?>Id($dto-><?= lcfirst($entityClass)?>Id),
<?php foreach ($fields as $field):?>
            new <?= ucfirst($field)?>($dto-><?= lcfirst($field)?>),

<?php endforeach; ?>
        );
        try {
            $this->repository->add($<?= lcfirst($entityClass)?>);
            $this->dispatcher->dispatch($<?= lcfirst($entityClass)?>->releaseEvents());
        } catch (ValidationException $exception) {

        }

        return $<?= lcfirst($entityClass)?>;
    }

    public function findAll()
    {
        return $this->repository->all();
    }

    public function createFromArray(array $row, array $headerRow = [])
    {
        $mapping = $this->getMapping();
        if (!$headerRow) {
            $headerRow = array_values($mapping);
        }

        $dto = new <?= $entityClass ?>CreateDto();

        foreach ($headerRow as $index => $columnName) {
            if ($fieldName = array_search($columnName, $mapping)) {
                $dto->$fieldName = isset($row[$index])? $row[$index]: '';
            }
        }
        return $this->create($dto);
    }

    private function getMapping()
    {
        return $this->repository->mapping();
    }

    public function removeAll(array $criteria = [])
    {
        $this->repository->removeAll($criteria);
    }
}