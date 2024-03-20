<?php

namespace console\controllers;

use yii\base\Exception;
use yii\console\Controller;
use yii\rbac\PhpManager;

/**
 * Class RbacController
 * @package console\controllers
 */
class RbacController extends Controller
{
    public $defaultAction = 'init';

    private PHPManager $_auth;

    /* @inheritdoc */
    public function init(): void
    {
        parent::init();
        $this->_auth = new PhpManager([
            'itemFile' => '@common/config/rbac/items.php',
            'assignmentFile' => '@common/config/rbac/assignments.php',
            'ruleFile' => '@common/config/rbac/rules.php',
        ]);
    }

    /**
     * @return void
     * @throws Exception
     * @throws \Exception
     */
    public function actionInit(): void
    {
        $this->_auth->init();

        $this->createPermissions();

        $member = $this->_auth->createRole('member');
        $this->_auth->add($member);
        $this->_auth->addChild($member, $this->_auth->getPermission('createOrder'));
        $this->_auth->assign($member, 2);

        $admin = $this->_auth->createRole('admin');
        $this->_auth->add($admin);
        $this->_auth->addChild($admin, $member);
        $this->_auth->addChild($admin, $this->_auth->getPermission('viewProduct'));
        $this->_auth->addChild($admin, $this->_auth->getPermission('viewOrder'));
        $this->_auth->addChild($admin, $this->_auth->getPermission('createProduct'));
        $this->_auth->addChild($admin, $this->_auth->getPermission('updateProduct'));
        $this->_auth->addChild($admin, $this->_auth->getPermission('deleteProduct'));
        $this->_auth->addChild($admin, $this->_auth->getPermission('updateOrder'));
        $this->_auth->addChild($admin, $this->_auth->getPermission('deleteOrder'));
        $this->_auth->assign($admin, 1);
    }

    /**
     * @return void
     * @throws \Exception
     */
    private function createPermissions(): void
    {
        $viewProduct = $this->_auth->createPermission('viewProduct');
        $viewProduct->description = 'View a product';
        $this->_auth->add($viewProduct);

        $createProduct = $this->_auth->createPermission('createProduct');
        $createProduct->description = 'Create a product';
        $this->_auth->add($createProduct);

        $updateProduct = $this->_auth->createPermission('updateProduct');
        $updateProduct->description = 'Update a product';
        $this->_auth->add($updateProduct);

        $deleteProduct = $this->_auth->createPermission('deleteProduct');
        $deleteProduct->description = 'Delete a product';
        $this->_auth->add($deleteProduct);

        $viewOrder = $this->_auth->createPermission('viewOrder');
        $viewOrder->description = 'View an order';
        $this->_auth->add($viewOrder);

        $createOrder = $this->_auth->createPermission('createOrder');
        $createOrder->description = 'Create an order';
        $this->_auth->add($createOrder);

        $updateOrder = $this->_auth->createPermission('updateOrder');
        $updateOrder->description = 'Update an order';
        $this->_auth->add($updateOrder);

        $deleteOrder = $this->_auth->createPermission('deleteOrder');
        $deleteOrder->description = 'Delete an order';
        $this->_auth->add($deleteOrder);
    }
}
