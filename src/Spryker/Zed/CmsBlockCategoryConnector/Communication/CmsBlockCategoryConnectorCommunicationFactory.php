<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CmsBlockCategoryConnector\Communication;

use Spryker\Zed\CmsBlockCategoryConnector\CmsBlockCategoryConnectorDependencyProvider;
use Spryker\Zed\CmsBlockCategoryConnector\Communication\DataProvider\CategoryDataProvider;
use Spryker\Zed\CmsBlockCategoryConnector\Communication\DataProvider\CmsBlockDataProvider;
use Spryker\Zed\CmsBlockCategoryConnector\Communication\Form\CategoryType;
use Spryker\Zed\CmsBlockCategoryConnector\Communication\Form\CmsBlockType;
use Spryker\Zed\CmsBlockCategoryConnector\Persistence\Collector\Storage\Propel\CmsBlockCategoryConnectorCollector;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

/**
 * @method \Spryker\Zed\CmsBlockCategoryConnector\Persistence\CmsBlockCategoryConnectorQueryContainerInterface getQueryContainer()
 * @method \Spryker\Zed\CmsBlockCategoryConnector\CmsBlockCategoryConnectorConfig getConfig()
 */
class CmsBlockCategoryConnectorCommunicationFactory extends AbstractCommunicationFactory
{

    /**
     * @var string
     */
    protected $currentLocale;

    /**
     * @return \Spryker\Zed\CmsBlockCategoryConnector\Communication\DataProvider\CmsBlockDataProvider
     */
    public function createCmsBlockCategoryDataProvider()
    {
        return new CmsBlockDataProvider(
            $this->getQueryContainer(),
            $this->getCategoryQueryContainer(),
            $this->getLocaleFacade()
        );
    }

    /**
     * @return \Spryker\Zed\CmsBlockCategoryConnector\Communication\DataProvider\CategoryDataProvider
     */
    public function createCategoryDataProvider()
    {
        return new CategoryDataProvider(
            $this->getQueryContainer(),
            $this->getCmsBlockQueryContainer(),
            $this->getCategoryQueryContainer()
        );
    }

    /**
     * @return \Spryker\Zed\CmsBlockCategoryConnector\Communication\Form\CmsBlockType
     */
    public function createCmsBlockType()
    {
        return new CmsBlockType();
    }

    /**
     * @return \Spryker\Zed\CmsBlockCategoryConnector\Communication\Form\CategoryType
     */
    public function createCategoryType()
    {
        return new CategoryType(
            $this->getEncodeService()
        );
    }

    /**
     * @return \Generated\Shared\Transfer\LocaleTransfer
     */
    protected function getCurrentLocale()
    {
        if ($this->currentLocale === null) {
            $this->currentLocale = $this->getLocaleFacade()
                ->getCurrentLocale();
        }

        return $this->currentLocale;
    }

    /**
     * @return \Spryker\Zed\CmsBlockCategoryConnector\Dependency\Facade\CmsBlockCategoryConnectorToLocaleInterface
     */
    protected function getLocaleFacade()
    {
        return $this->getProvidedDependency(CmsBlockCategoryConnectorDependencyProvider::FACADE_LOCALE);
    }

    /**
     * @return \Spryker\Zed\CmsBlockCategoryConnector\Dependency\QueryContainer\CmsBlockCategoryConnectorToCategoryQueryContainerInterface
     */
    protected function getCategoryQueryContainer()
    {
        return $this->getProvidedDependency(CmsBlockCategoryConnectorDependencyProvider::QUERY_CONTAINER_CATEGORY);
    }

    /**
     * @return \Spryker\Zed\CmsBlockCategoryConnector\Dependency\QueryContainer\CmsBlockCategoryConnectorToCmsBlockQueryContainerInterface
     */
    protected function getCmsBlockQueryContainer()
    {
        return $this->getProvidedDependency(CmsBlockCategoryConnectorDependencyProvider::QUERY_CONTAINER_CMS_BLOCK);
    }

    /**
     * @return \Spryker\Service\UtilEncoding\UtilEncodingServiceInterface
     */
    protected function getEncodeService()
    {
        return $this->getProvidedDependency(CmsBlockCategoryConnectorDependencyProvider::SERVICE_ENCODE);
    }

    /**
     * @return \Spryker\Zed\CmsBlockCategoryConnector\Persistence\Collector\Storage\Propel\CmsBlockCategoryConnectorCollector
     */
    public function createCmsBlockCategoryStorageQueryContainer()
    {
        return new CmsBlockCategoryConnectorCollector();
    }

}
