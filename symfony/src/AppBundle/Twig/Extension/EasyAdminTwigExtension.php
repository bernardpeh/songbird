<?php

namespace AppBundle\Twig\Extension;

use JavierEguiluz\Bundle\EasyAdminBundle\Configuration\ConfigManager;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

/**
 * Class EasyAdminTwigExtension
 * @package AppBundle\Twig\Extension
 */
class EasyAdminTwigExtension extends \JavierEguiluz\Bundle\EasyAdminBundle\Twig\EasyAdminTwigExtension
{

    private $checker;

    public function __construct(ConfigManager $configManager, PropertyAccessor $propertyAccessor, $debug = false, AuthorizationChecker $checker)
    {
        parent::__construct($configManager, $propertyAccessor, $debug);
        $this->checker = $checker;
    }

    /**
     * Overrides parent function
     *
     * @param string $view
     * @param string $entityName
     *
     * @return array
     */
    public function getActionsForItem($view, $entityName)
    {

        $entityConfig = $this->getEntityConfiguration($entityName);
        $disabledActions = $entityConfig['disabled_actions'];
        $viewActions = $entityConfig[$view]['actions'];

        $actionsExcludedForItems = array(
            'list' => array('new', 'search'),
            'edit' => array(),
            'new' => array(),
            'show' => array(),
        );
        $excludedActions = $actionsExcludedForItems[$view];

        // hid edit button if easyadmin says so
        $actions = ['edit', 'form'];
        foreach ($actions as $action) {
            if (isset($entityConfig[$action]['role']) && !$this->checker->isGranted($entityConfig[$action]['role'])) {
                array_push($excludedActions, 'edit');
            }
        }
        // hide delete button if easyadmin says so
        $actions = ['delete'];
        foreach ($actions as $action) {
            if (isset($entityConfig[$action]['role']) && !$this->checker->isGranted($entityConfig[$action]['role'])) {
                array_push($excludedActions, 'delete');
            }
        }

        return array_filter($viewActions, function ($action) use ($excludedActions, $disabledActions) {
            return !in_array($action['name'], $excludedActions) && !in_array($action['name'], $disabledActions);
        });
    }

}