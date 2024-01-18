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

define([
    'jquery'
    ], function ($) {
    'use strict';

    return function (widget) {
        $.widget('mage.SwatchRenderer', widget, {
            _LoadProductMedia: function () {
                var $widget = this,
                    $this = $widget.element,
                    productData = this._determineProductData(),
                    mediaCallData,
                    mediaCacheKey,

                    mediaSuccessCallback = function (data) {

                        if (!(mediaCacheKey in $widget.options.mediaCache)) {
                            $widget.options.mediaCache[mediaCacheKey] = data;
                        }
                        $widget._ProductMediaCallback($this, data, productData.isInProductView);
                        setTimeout(function () {
                            $widget._DisableProductMediaLoader($this);
                        }, 300);
                    };
                var $product = $this.parents($widget.options.selectorProduct);
                var pId = this.getProduct();
                $product.find('#mageinic_flipper_img').attr('data-img', '');
                if (typeof $widget.options.imageFlipper[pId] !== "undefined") {
                    var fliperImg = $widget.options.imageFlipper[pId].flipper_image;
                    $product.find('#mageinic_flipper_img').attr('data-img', fliperImg);
                }
                if (!$widget.options.mediaCallback) {
                    return;
                }
                mediaCallData = {
                    'product_id': this.getProduct()
                };
                mediaCacheKey = JSON.stringify(mediaCallData);

                if (mediaCacheKey in $widget.options.mediaCache) {
                    $widget._XhrKiller();
                    $widget._EnableProductMediaLoader($this);
                    mediaSuccessCallback($widget.options.mediaCache[mediaCacheKey]);
                } else {
                    mediaCallData.isAjax = true;
                    $widget._XhrKiller();
                    $widget._EnableProductMediaLoader($this);
                    $widget.xhr = $.ajax({
                        url: $widget.options.mediaCallback,
                        cache: true,
                        type: 'GET',
                        dataType: 'json',
                        data: mediaCallData,
                        success: mediaSuccessCallback
                    }).done(function () {
                        $widget._XhrKiller();
                    });
                }
            },
        });
        return $.mage.SwatchRenderer;
    };
});
