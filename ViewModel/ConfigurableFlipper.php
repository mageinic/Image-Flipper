<?php
/**
 * MageINIC
 * Copyright (C) 2023 MageINIC <support@mageinic.com>
 *
 * NOTICE OF LICENSE
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see http://opensource.org/licenses/gpl-3.0.html.
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category MageINIC
 * @package MageINIC_ImageFlipper
 * @copyright Copyright (c) 2023 MageINIC (https://www.mageinic.com/)
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License,version 3 (GPL-3.0)
 * @author MageINIC <support@mageinic.com>
 */

namespace MageINIC\ImageFlipper\ViewModel;

use Magento\Catalog\Model\Product;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\UrlInterface;

/**
 * Class of Configurable Flipper
 */
class ConfigurableFlipper implements ArgumentInterface
{
    /**#@+
     * Constants for Store Config Value Path.
     */
    public const ENABLE = 'image_flipper/setting/enable';
    public const MAIN_CLASS = 'image_flipper/setting/product_container';
    public const IMAGE_CLASS = 'image_flipper/setting/product_image';
    public const IMAGE_FLIP = 'image_flipper/setting/flip_image';
    /**#@-*/

    /**
     * @var SerializerInterface
     */
    protected SerializerInterface $serializer;

    /**
     * @var StoreManagerInterface
     */
    protected StoreManagerInterface $storeManager;

    /**
     * @var ScopeConfigInterface
     */
    protected ScopeConfigInterface $scopeConfig;

    /**
     * Configurable Flipper Constructor
     *
     * @param SerializerInterface $serializer
     * @param StoreManagerInterface $storeManager
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        SerializerInterface     $serializer,
        StoreManagerInterface   $storeManager,
        ScopeConfigInterface    $scopeConfig
    ) {
        $this->serializer = $serializer;
        $this->storeManager = $storeManager;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Get Image Flipper
     *
     * @param Product $product
     * @return string
     * @throws NoSuchEntityException
     */
    public function getImageFlipper(Product $product): string
    {
        $configurableProduct = $product;
        $children = $configurableProduct->getTypeInstance()->getUsedProducts($configurableProduct);
        $child = [];
        foreach ($children as $simpleProduct) {
            if (isset($simpleProduct['flipper_image'])) {
                $child[$simpleProduct->getEntityId()] = [
                    'flipper_image' => $this->getMediaPath()
                    . 'catalog/product' . $simpleProduct['flipper_image']
                ];
            }
        }
        return $this->serializer->serialize($child);
    }

    /**
     * Get Module Status
     *
     * @return boolean
     */
    public function getModuleEnable(): bool
    {
        return $this->scopeConfig->getValue(
            self::ENABLE,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get Container Main Class
     *
     * @return string
     */
    public function getMainClass(): string
    {
        return $this->scopeConfig->getValue(
            self::MAIN_CLASS,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get Image Class
     *
     * @return string
     */
    public function getImageClass(): string
    {
        return $this->scopeConfig->getValue(
            self::IMAGE_CLASS,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get Image Flip Style
     *
     * @return string
     */
    public function getImageFlipStyle(): string
    {
        return $this->scopeConfig->getValue(
            self::IMAGE_FLIP,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get Media Path
     *
     * @return string
     * @throws NoSuchEntityException
     */
    public function getMediaPath(): string
    {
        return $this->storeManager->getStore()
            ->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
    }
}
