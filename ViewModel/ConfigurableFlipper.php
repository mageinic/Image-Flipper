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

use Magento\Catalog\Helper\Image;
use Magento\Catalog\Model\Product;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\UrlInterface;
use Magento\Catalog\Helper\ImageFactory;

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
     * @var ImageFactory
     */
    private ImageFactory $imageFactory;

    /**
     * Configurable Flipper Constructor
     *
     * @param SerializerInterface $serializer
     * @param StoreManagerInterface $storeManager
     * @param ScopeConfigInterface $scopeConfig
     * @param ImageFactory $imageFactory
     */
    public function __construct(
        SerializerInterface     $serializer,
        StoreManagerInterface   $storeManager,
        ScopeConfigInterface    $scopeConfig,
        ImageFactory            $imageFactory
    ) {
        $this->serializer = $serializer;
        $this->storeManager = $storeManager;
        $this->scopeConfig = $scopeConfig;
        $this->imageFactory = $imageFactory;
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
        $children = $product->getTypeInstance()->getUsedProducts($product);
        $child = [];
        foreach ($children as $simpleProduct) {
            if (isset($simpleProduct['flipper_image'])) {
                $child[$simpleProduct->getEntityId()] = [
                    'flipper_image' => $this->getFlipImage($product)
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
     * Get Image Flip Height Width
     *
     * @param Product $product
     * @return string
     */
    public function getFlipImage($product): string
    {
        $imageId = 'catalog_flipper_image';
        $width = $this->getImageOriginalSize($product, $imageId, $attributes = ['flipper_image'])->getWidth();
        $height = $this->getImageOriginalSize($product, $imageId, $attributes = ['flipper_image'])->getHeight();
        return $this->imageFactory->create()
            ->init($product, $imageId)
            ->constrainOnly(true)
            ->keepAspectRatio(true)
            ->keepTransparency(true)
            ->keepFrame(true)
            ->resize($width, $height)
            ->getUrl();
    }

    /**
     * Get Image Original Size
     *
     * @param Product $product
     * @param string $imageId
     * @param array $attributes
     * @return Image
     */
    public function getImageOriginalSize($product, $imageId, array $attributes = []): Image
    {
        return $this->imageFactory->create()->init($product, $imageId, $attributes);
    }
}
