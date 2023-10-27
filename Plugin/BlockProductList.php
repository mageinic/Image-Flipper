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

namespace MageINIC\ImageFlipper\Plugin;

use Closure;
use Magento\Catalog\Block\Product\ListProduct;
use Magento\Catalog\Model\Product;
use Magento\Framework\Exception\NoSuchEntityException;
use MageINIC\ImageFlipper\ViewModel\ConfigurableFlipper;

/**
 * Class Plugin Of Block Product List
 */
class BlockProductList
{
    /**
     * @var ConfigurableFlipper
     */
    private ConfigurableFlipper $viewModel;

    /**
     * Block Product List Constructor
     *
     * @param ConfigurableFlipper $viewModel
     */
    public function __construct(
        ConfigurableFlipper $viewModel
    ) {
        $this->viewModel = $viewModel;
    }

    /**
     * Around Get Product Details Html
     *
     * @param ListProduct $subject
     * @param Closure $proceed
     * @param Product $product
     * @return string
     * @throws NoSuchEntityException
     */
    public function aroundGetProductDetailsHtml(
        ListProduct $subject,
        Closure     $proceed,
        Product     $product
    ): string {
        if ($this->viewModel->getModuleEnable()) {
            $flipper_img_name = $product->getData('flipper_image');
            if (($flipper_img_name != "no_selection")
                && ($flipper_img_name != "productno_selection")
                && (($flipper_img_name != null))) {
                $image_url = $this->viewModel->getMediaPath() . 'catalog/product' . $flipper_img_name;
                $result = $proceed($product);
                return $result . '<span id="mageinic_flipper_img" style="display:none;">' . $image_url . '</span>';
            }
        }
        return $proceed($product);
    }
}
