<?php
/**
 * Emagicone
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * PHP version 7
 *
 * @category  Emagicone
 * @package   Emagicone_Core
 * @author    Khrystyna Viiatyk <khrystyna@kommy.net>
 * @copyright 2019 eMagicOne.com. All Rights Reserved. (https://emagicone.com/)
 * @license   https://emagicone.com/ eMagicOne Ltd. License
 * @link      https://emagicone.com/
 */

namespace Emagicone\Core\Block;

use Magento\Framework\{
    View\Element\Template\Context,
    View\Element\Template,
    View\Page\Config,
    App\Config\ScopeConfigInterface,
    Registry
};
use Magento\Theme\Block\Html\Header\Logo;
use Magento\Store\Model\{
    Store,
    ScopeInterface,
    Information
};
use Magento\Catalog\{
    Api\ProductRepositoryInterface,
    Model\CategoryRepository
};
use Magento\Cms\Model\Page;

/**
 * Class General
 *
 * @category Emagicone
 * @package  Emagicone\Core\Block
 * @author   Khrystyna Viiatyk <khrystyna@kommy.net>
 * @license  https://emagicone.com/ eMagicOne Ltd. License
 * @link     https://emagicone.com/
 */
class General extends Template
{
    /**
     * Scope config interface
     *
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;
    /**
     * Store model
     *
     * @var Store
     */
    protected $store;
    /**
     * Registry class
     *
     * @var Registry
     */
    protected $registry;
    /**
     * Product repository
     *
     * @var ProductRepositoryInterface
     */
    protected $productRepository;
    /**
     * Category repository
     *
     * @var CategoryRepository
     */
    protected $categoryRepository;
    /**
     * Logo block
     *
     * @var Logo
     */
    protected $logo;
    /**
     * Page config
     *
     * @var Config
     */
    protected $pageConfig;
    /**
     * Page model
     *
     * @var Page
     */
    protected $cmsPage;
    /**
     * Store information
     *
     * @var Information
     */
    protected $storeInfo;

    /**
     * General constructor.
     *
     * @param Information                $storeInfo
     * @param Page                       $cmsPage
     * @param Config                     $pageConfig
     * @param Store                      $store
     * @param Logo                       $logo
     * @param ProductRepositoryInterface $productRepository
     * @param CategoryRepository         $categoryRepository
     * @param ScopeConfigInterface       $scopeConfig
     * @param Context                    $context
     * @param Registry                   $registry
     * @param array                      $data
     */
    public function __construct(
        Information $storeInfo,
        Page $cmsPage,
        Config $pageConfig,
        Store $store,
        Logo $logo,
        ProductRepositoryInterface $productRepository,
        CategoryRepository $categoryRepository,
        ScopeConfigInterface $scopeConfig,
        Context $context,
        Registry $registry,
        array $data = []
    ) {
        $this->storeInfo = $storeInfo;
        $this->logo = $logo;
        $this->cmsPage = $cmsPage;
        $this->pageConfig = $pageConfig;
        $this->registry = $registry;
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->store = $store;
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context, $data);
    }

    /**
     * Get current product object
     *
     * @return \Magento\Catalog\Api\Data\ProductInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    protected function getCurrentProductInfo()
    {
        $product = $this->registry->registry('current_product');
        return $this->productRepository->getById($product->getId());
    }

    /**
     * Get current category object
     *
     * @return \Magento\Catalog\Api\Data\CategoryInterface|mixed
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    protected function getCurrentCategoryInfo()
    {
        $category = $this->registry->registry('current_category');
        return $this->categoryRepository->get($category->getId());
    }

    /**
     * Get current page object
     *
     * @return Page
     */
    protected function getCurrentCMSPageInfo()
    {
        return $this->cmsPage;
    }

    /**
     * Get current store name
     *
     * @return mixed
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    protected function getCurrentStoreName()
    {
        $currentStoreId = $this->_storeManager->getStore()->getId();
        return $this->scopeConfig->getValue(
            'general/store_information/name',
            ScopeInterface::SCOPE_STORE, $currentStoreId
        );
    }

    /**
     * Get current logo src
     *
     * @return string
     */
    protected function getCurrentLogoSrc()
    {
        return $this->logo->getLogoSrc();
    }

    /**
     * Get current url with rewrite mode true
     *
     * @return string
     */
    protected function getCurrentUrl()
    {
        return $this->getUrl('*/*/*', ['_current' => true, '_use_rewrite' => true]);
    }

    /**
     * Get current locale code
     *
     * @return string|null
     */
    protected function getCurrentLocaleCode()
    {
        return $this->store->getConfig('general/locale/code');
    }

    /**
     * Get current currency code
     *
     * @return mixed
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    protected function getCurrentCurrencyCode()
    {
        return $this->_storeManager->getStore()->getCurrentCurrency()->getCode();
    }

    /**
     * Get current root category id
     *
     * @return mixed
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    protected function getCurrentRootCategoryId()
    {
        return $this->_storeManager->getStore()->getRootCategoryId();
    }

    /**
     * Get current allowed countries
     *
     * @return mixed
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    protected function getCurrentAllowedCountries()
    {
        $currentStoreId = $this->_storeManager->getStore()->getId();
        return $this->scopeConfig->getValue(
            'general/country/allow',
            ScopeInterface::SCOPE_STORE, $currentStoreId
        );
    }

    /**
     * Get media url
     *
     * @return mixed
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    protected function getMediaUrl()
    {
        return $this->_storeManager->getStore()
            ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
    }

    /**
     * Get current store information
     *
     * @return \Magento\Framework\DataObject
     */
    protected function getStoreInformation()
    {
        return $this->storeInfo->getStoreInformationObject($this->store);
    }
}