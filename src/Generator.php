<?php
namespace dimichspb\gii\entity;

use yii\gii\CodeFile;

class Generator extends \yii\gii\Generator
{
    public $ns = 'app\entities';
    public $entityClass;
    public $fields;

    public $dtoPath = 'dto';
    public $eventsPath = 'events';
    public $mappingPath = 'mapping';
    public $repositoriesPath = 'repositories';
    public $servicesPath = 'services';
    public $typesPath = 'types';


    public function getName()
    {
        return 'Entity stuff generator';
    }

    public function getDescription()
    {
        return 'This generator generates entity class with all necessary stuff.';
    }

    public function rules()
    {
        return [
            [['ns', 'entityClass', 'fields',], 'filter', 'filter' => 'trim'],
            [['ns', 'entityClass', 'fields'], 'required'],
            [['ns'], 'match', 'pattern' => '/^[\w\\\\]*$/', 'message' => 'Only word characters and backslashes are allowed.'],
            [['entityClass'], 'match', 'pattern' => '/^\w+$/', 'message' => 'Only word characters are allowed.'],
            [['fields'], 'match', 'pattern' => '/^[\w\_\,]*$/', 'message' => 'Only word characters, underscores and commas are allowed.'],
        ];
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'ns' => 'Entity Class Namespace',
            'entityClass' => 'Entity Class',
            'fields' => 'Entity\'s fields',

        ]);
    }

    public function hints()
    {
        return array_merge(parent::hints(), [
            'ns' => 'This is the namespace for entity class file..',
            'entityClass' => 'This is the entity class...',
            'fields' => 'This is the list of fields',
        ]);
    }

    public function requiredTemplates()
    {
        return [
            'entity.php',
            'entityId.php',
            'entityIdType.php',
            'field.php',
            'dtoCreate.php',
            'dtoUpdateField.php',
            'createdEvent.php',
            'updatedEvent.php',
            'mapping.php',
            'repositoryInterface.php',
            'memoryRepository.php',
            'doctrineRepository.php',
            'service.php',
            'fieldType.php',
            'serviceInterface.php',
        ];
    }

    public function stickyAttributes()
    {
        return array_merge(parent::stickyAttributes(), ['ns']);
    }

    public function generate()
    {
        $fields = explode(',', $this->fields);

        $files = [];
        $files[] = new CodeFile(
            $this->getEntityFileName(),
            $this->render('entity.php', ['entityClass' => $this->entityClass, 'fields' => $fields])
        );

        $files[] = new CodeFile(
            $this->getEntityIdFileName(),
            $this->render('entityId.php', ['entityClass' => $this->entityClass])
        );

        $files[] = new CodeFile(
            $this->getEntityIdTypeFileName(),
            $this->render('entityIdType.php', ['entityClass' => $this->entityClass])
        );

        $files[] = new CodeFile(
            $this->getDtoCreateFileName(),
            $this->render('dtoCreate.php', ['entityClass' => $this->entityClass, 'fields' => $fields])
        );

        foreach ($fields as $field) {
            $files[] = new CodeFile(
                $this->getDtoUpdateFieldFileName($field),
                $this->render('dtoUpdateField.php', ['entityClass' => $this->entityClass, 'field' => $field])
            );
        }

        $files[] = new CodeFile(
            $this->getEventCreatedFileName(),
            $this->render('eventCreated.php', ['entityClass' => $this->entityClass])
        );

        $files[] = new CodeFile(
            $this->getEventUpdatedFileName(),
            $this->render('eventUpdated.php', ['entityClass' => $this->entityClass])
        );
        
        $files[] = new CodeFile(
            $this->getMappingFileName(),
            $this->render('mapping.php', ['entityClass' => $this->entityClass, 'fields' => $fields])
        );

        $files[] = new CodeFile(
            $this->getDoctrineRepositoryFileName(),
            $this->render('doctrineRepository.php', ['entityClass' => $this->entityClass, 'fields' => $fields])
        );

        $files[] = new CodeFile(
            $this->getMemoryRepositoryFileName(),
            $this->render('memoryRepository.php', ['entityClass' => $this->entityClass, 'fields' => $fields])
        );

        $files[] = new CodeFile(
            $this->getRepositoryInterfaceFileName(),
            $this->render('repositoryInterface.php', ['entityClass' => $this->entityClass, 'fields' => $fields])
        );

        $files[] = new CodeFile(
            $this->getServiceFileName(),
            $this->render('service.php', ['entityClass' => $this->entityClass, 'fields' => $fields])
        );

        foreach ($fields as $field) {
            $files[] = new CodeFile(
                $this->getFieldFileName($field),
                $this->render('field.php', ['entityClass' => $this->entityClass, 'field' => $field])
            );
            $files[] = new CodeFile(
                $this->getFieldTypeFileName($field),
                $this->render('fieldType.php', ['entityClass' => $this->entityClass, 'field' => $field])
            );
        }

        $files[] = new CodeFile(
            $this->getServiceInterfaceFileName(),
            $this->render('serviceInterface.php', ['entityClass' => $this->entityClass])
        );

        return $files;
    }

    public function getEntityFileName()
    {
        return $this->getEntityPath() . '.php';
    }

    public function getEntityClassName()
    {
        return $this->ns . '\\' . $this->entityClass;
    }

    protected function getEntityPath()
    {
        return $this->getPathFromClass($this->getEntityClassName());
    }


    public function getEntityIdFileName()
    {
        return $this->getEntityIdPath() . '.php';
    }

    public function getEntityIdClassName()
    {
        return $this->ns . '\\' . $this->entityClass . 'Id';
    }

    protected function getEntityIdPath()
    {
        return $this->getPathFromClass($this->getEntityIdClassName());
    }


    public function getEntityIdTypeFileName()
    {
        return $this->getEntityIdTypePath() . '.php';
    }

    public function getEntityIdTypeClassName()
    {
        return $this->ns . '\\' . $this->typesPath . '\\' . $this->entityClass . 'IdType';
    }

    protected function getEntityIdTypePath()
    {
        return $this->getPathFromClass($this->getEntityIdTypeClassName());
    }

    
    public function getDtoCreateFileName()
    {
        return $this->getDtoCreatePath() . '.php';
    }

    public function getDtoCreateClassName()
    {
        return $this->getRelatedClass($this->dtoPath ,'CreateDto');
    }
    
    protected function getDtoCreatePath()
    {
        return $this->getPathFromClass($this->getDtoCreateClassName());
    }


    public function getDtoUpdateFieldFileName($field)
    {
        return $this->getDtoUpdateFieldPath($field) . '.php';
    }

    public function getDtoUpdateFieldClassName($field)
    {
        return $this->getRelatedClass($this->dtoPath ,'Update' . ucwords($field) . 'Dto');
    }

    protected function getDtoUpdateFieldPath($field)
    {
        return $this->getPathFromClass($this->getDtoUpdateFieldClassName($field));
    }


    public function getEventCreatedFileName()
    {
        return $this->getEventCreatedPath() . '.php';
    }

    public function getEventCreatedClassName()
    {
        return $this->getRelatedClass($this->eventsPath ,'CreatedEvent');
    }

    protected function getEventCreatedPath()
    {
        return $this->getPathFromClass($this->getEventCreatedClassName());
    }

    
    public function getEventUpdatedFileName()
    {
        return $this->getEventUpdatedPath() . '.php';
    }

    public function getEventUpdatedClassName()
    {
        return $this->getRelatedClass($this->eventsPath ,'UpdatedEvent');
    }

    protected function getEventUpdatedPath()
    {
        return $this->getPathFromClass($this->getEventUpdatedClassName());
    }


    public function getMappingFileName()
    {
        return $this->getMappingPath() . '.yml';
    }

    public function getMappingClassName()
    {
        return $this->getRelatedClass($this->mappingPath ,'.orm');
    }

    protected function getMappingPath()
    {
        return $this->getPathFromClass($this->getMappingClassName());
    }


    public function getDoctrineRepositoryFileName()
    {
        return $this->getDoctrineRepositoryPath() . '.php';
    }

    public function getDoctrineRepositoryClassName()
    {
        return $this->getRelatedClass($this->repositoriesPath ,'DoctrineRepository');
    }

    protected function getDoctrineRepositoryPath()
    {
        return $this->getPathFromClass($this->getDoctrineRepositoryClassName());
    }


    public function getMemoryRepositoryFileName()
    {
        return $this->getMemoryRepositoryPath() . '.php';
    }

    public function getMemoryRepositoryClassName()
    {
        return $this->getRelatedClass($this->repositoriesPath ,'MemoryRepository');
    }

    protected function getMemoryRepositoryPath()
    {
        return $this->getPathFromClass($this->getMemoryRepositoryClassName());
    }


    public function getRepositoryInterfaceFileName()
    {
        return $this->getRepositoryInterfacePath() . '.php';
    }

    public function getRepositoryInterfaceClassName()
    {
        return $this->getRelatedClass($this->repositoriesPath ,'RepositoryInterface');
    }

    protected function getRepositoryInterfacePath()
    {
        return $this->getPathFromClass($this->getRepositoryInterfaceClassName());
    }


    public function getServiceFileName()
    {
        return $this->getServicePath() . '.php';
    }

    public function getServiceClassName()
    {
        return $this->getRelatedClass($this->servicesPath ,'Service');
    }

    protected function getServicePath()
    {
        return $this->getPathFromClass($this->getServiceClassName());
    }


    public function getFieldFileName($field)
    {
        return $this->getFieldPath($field) . '.php';
    }

    public function getFieldClassName($field)
    {
        return $this->ns . '\\' . ucfirst($field);
    }

    protected function getFieldPath($field)
    {
        return $this->getPathFromClass($this->getFieldClassName($field));
    }


    public function getFieldTypeFileName($field)
    {
        return $this->getFieldTypePath($field) . '.php';
    }

    public function getFieldTypeClassName($field)
    {
        return $this->getRelatedClass($this->typesPath , $field . 'Type', false);
    }

    protected function getFieldTypePath($field)
    {
        return $this->getPathFromClass($this->getFieldTypeClassName($field));
    }


    public function getServiceInterfaceFileName()
    {
        return $this->getServiceInterfacePath() . '.php';
    }

    public function getServiceInterfaceClassName()
    {
        return dirname($this->ns) . '\\' . 'ServiceInterface';
    }

    protected function getServiceInterfacePath()
    {
        return $this->getPathFromClass($this->getServiceInterfaceClassName());
    }
    
    protected function getPathFromClass($className)
    {
        $path = str_replace('\\', '/', $className);
        return \Yii::getAlias('@' . pathinfo($path, PATHINFO_DIRNAME)) . '/' . pathinfo($path, PATHINFO_BASENAME);
    }

    protected function getRelatedClass($path, $className, $useEntityClass = true)
    {
        return $this->ns. '\\' . $path . '\\' . ($useEntityClass? $this->entityClass:'') . ucfirst($className);
    }
}