<?php
namespace dimichspb\gii;

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
        return 'Entity staff generator';
    }

    public function getDescription()
    {
        return 'This generator generates entity class with all necessary staff.';
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
            'field.php',
            'dtoCreate.php',
            'dtoUpdateField.php',
            'createdEvent.php',
            'updatedEvent.php',
            'mapping.yml',
            'repositoryInterface.php',
            'memoryRepository.php',
            'doctrineRepository.php',
            'service.php',
            'fieldType.php',
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
            \Yii::getAlias('@' . $this->getEntityFileName()),
            $this->render('entity.php', ['fields' => $fields])
        );
/*
        $files[] = new CodeFile(
            \Yii::getAlias('@' . $this->getDtoCreateFileName()),
            $this->render('dtoCreate.php', ['entityClass' => $this->entityClass])
        );

        $files[] = new CodeFile(
            \Yii::getAlias('@' . $this->getDtoUpdateFieldFileName()),
            $this->render('dtoUpdateField.php', ['entityClass' => $this->entityClass])
        );

        $files[] = new CodeFile(
            \Yii::getAlias('@' . $this->getEventCreatedFileName()),
            $this->render('eventCreated.php', ['entityClass' => $this->entityClass])
        );

        $files[] = new CodeFile(
            \Yii::getAlias('@' . $this->getEventUpdatedFileName()),
            $this->render('eventUpdated.php', ['entityClass' => $this->entityClass])
        );
        
        $files[] = new CodeFile(
            \Yii::getAlias('@' . $this->getMappingFileName()),
            $this->render('mapping.php', ['entityClass' => $this->entityClass])
        );

        $files[] = new CodeFile(
            \Yii::getAlias('@' . $this->getDoctrineRepositoryFileName()),
            $this->render('doctrineRepository.php', ['entityClass' => $this->entityClass])
        );

        $files[] = new CodeFile(
            \Yii::getAlias('@' . $this->getMemoryRepositoryFileName()),
            $this->render('memoryRepository.php', ['entityClass' => $this->entityClass])
        );

        $files[] = new CodeFile(
            \Yii::getAlias('@' . $this->getRepositoryInterfaceFileName()),
            $this->render('repositoryInterface.php', ['entityClass' => $this->entityClass])
        );

        $files[] = new CodeFile(
            \Yii::getAlias('@' . $this->getServiceFileName()),
            $this->render('service.php', ['entityClass' => $this->entityClass])
        );

        foreach ($fields as $field) {
            $files[] = new CodeFile(
                \Yii::getAlias('@' . $this->getFieldTypeFileName($field)),
                $this->render('fieldType.php', ['entityClass' => $this->entityClass, 'field' => $field])
            );
            $files[] = new CodeFile(
                \Yii::getAlias('@' . $this->getFieldTypeFileName($field)),
                $this->render('fieldType.php', ['entityClass' => $this->entityClass, 'field' => $field])
            );
        }
        */
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

    
    public function getDtoCreateFileName()
    {
        return $this->getDtoCreateClassName() . '.php';    
    }

    public function getDtoCreateClassName()
    {
        return $this->getRelatedClass($this->dtoPath ,'CreateDto');
    }
    
    protected function getDtoCreatePath()
    {
        return $this->getPathFromClass($this->getDtoCreateClassName());
    }


    public function getDtoUpdateFieldFileName()
    {
        return $this->getDtoUpdateFieldClassName() . '.php';
    }

    public function getDtoUpdateFieldClassName()
    {
        return $this->getRelatedClass($this->dtoPath ,'UpdateFieldDto');
    }

    protected function getDtoUpdateFieldPath()
    {
        return $this->getPathFromClass($this->getDtoUpdateFieldClassName());
    }


    public function getEventCreatedFileName()
    {
        return $this->getEventCreatedClassName() . '.php';
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
        return $this->getEventUpdatedClassName() . '.php';
    }

    public function getEventUpdatedClassName()
    {
        return $this->getRelatedClass($this->eventsPath ,'UpdatedEvent');
    }

    protected function getEventUpdatePath()
    {
        return $this->getPathFromClass($this->getEventUpdatedClassName());
    }


    public function getMappingFileName()
    {
        return $this->getMappingClassName() . '.yml';
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
        return $this->getDoctrineRepositoryClassName() . '.php';
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
        return $this->getMemoryRepositoryClassName() . '.php';
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
        return $this->getRepositoryInterfaceClassName() . '.php';
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
        return $this->getServiceClassName() . '.php';
    }

    public function getServiceClassName()
    {
        return $this->getRelatedClass($this->dtoPath ,'Service');
    }

    protected function getServicePath()
    {
        return $this->getPathFromClass($this->getServiceClassName());
    }


    public function getFieldFileName($field)
    {
        return $this->getFieldClassName($field) . '.php';
    }

    public function getFieldClassName($field)
    {
        return $this->getRelatedClass($this->typesPath , $field);
    }

    protected function getFieldPath($field)
    {
        return $this->getPathFromClass($this->getFieldClassName($field));
    }


    public function getFieldTypeFileName($field)
    {
        return $this->getFieldTypeClassName($field) . '.php';
    }

    public function getFieldTypeClassName($field)
    {
        return $this->getRelatedClass($this->typesPath , $field . 'Type');
    }

    protected function getFieldTypePath($field)
    {
        return $this->getPathFromClass($this->getFieldTypeClassName($field));
    }
    
    
    protected function getPathFromClass($className)
    {
        return str_replace('\\', DIRECTORY_SEPARATOR, $className);
    }

    protected function getRelatedClass($path, $className)
    {
        return $this->getEntityPath(). '\\' . $path . '\\' . $this->entityClass . $className;
    }
}