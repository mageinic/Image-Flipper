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
    "jquery",
    "jquery-ui-modules/core",
    "jquery-ui-modules/widget"
    ], function ($, core, ui) {
    $.widget('mageINIC.mageinic_flipper', {
        options: {},
        _create: function (options) {
            this._initialize();
        }, _initialize: function () {
            var self = this;
            var options = self.options;
            var mainclass = options['mainclass'];
            var imageclass = options['imageclass'];
            var imageflip = options['imageflip'];
            $(document).on({
                mouseenter: function () {
                    var base = $(this).find(imageclass).attr('src');
                    var flipper = $(this).find("#mageinic_flipper_img").text();
                    var dataImg = $(this).find("#mageinic_flipper_img").attr('data-img');
                    var dataType = $(this).find("#mageinic_flipper_img").attr('data-type');

                    if (dataType == 'configurable') {
                        if (typeof dataImg !== "undefined" && dataImg != '') {
                            flipper = dataImg;
                        }
                        else if (dataImg == ''){
                            flipper = '';
                        }
                    }

                    if (flipper != '' && typeof flipper !== "undefined") {
                        $(this).find("#mageinic_flipper_img").text(base);
                        if (imageflip != 0) {
                            if (imageflip == 'X') {
                                if (imageflip == 1) {
                                    $(this).find(imageclass).css({
                                        'transform': 'rotate(-360deg)',
                                        'transform-	style': 'preserve-3d',
                                        'transition': 'all 0.5s ease-out 0s'
                                    });
                                } else {
                                    $(this).find(imageclass).css({
                                        'transform': 'rotate' + imageflip + '(-360deg)',
                                        'transform-style': 'preserve-3d',
                                        'transition': 'all 0.5s ease-out 0s'
                                    });
                                }
                            }
                            if (imageflip == 'Y') {
                                if (imageflip == 1) {
                                    $(this).find(imageclass).css({
                                        'transform': 'rotate(180deg)',
                                        'transform-style': 'preserve-3d',
                                        'transition': 'all 0.5s ease-out 0s'
                                    });
                                } else {
                                    $(this).find(imageclass).css({
                                        'transform': 'rotate' + imageflip + '(180deg)',
                                        'transform-style': 'preserve-3d',
                                        'transition': 'all 0.5s ease-out 0s'
                                    });
                                }
                            }
                            if (imageflip != 0) {
                                if (imageflip == 1) {
                                    $(this).find(imageclass).css({
                                        'transform': 'rotate(-360deg)',
                                        'transform-style': 'preserve-3d',
                                        'transition': 'all 0.5s ease-out 0s'
                                    });
                                } else {
                                    $(this).find(imageclass).css({
                                        'transform': 'rotate' + imageflip + '(-360deg)',
                                        'transform-style': 'preserve-3d',
                                        'transition': 'all 0.5s ease-out 0s'
                                    });
                                }
                            }
                        }
                        $(this).find(imageclass).attr('src', flipper);
                    }
                }, mouseleave: function () {
                    var base = $(this).find(imageclass).attr('src');
                    var flipper = $(this).find("#mageinic_flipper_img").text();
                    var dataImg = $(this).find("#mageinic_flipper_img").attr('data-img');
                    var dataType = $(this).find("#mageinic_flipper_img").attr('data-type');

                    if (dataType == 'configurable') {
                        if (dataImg == '') {
                            flipper = '';
                        }
                    }

                    if (flipper != '' && typeof flipper !== "undefined") {
                        $(this).find("#mageinic_flipper_img").text(base);
                        if (imageflip != 0) {
                            if (imageflip == 1) {
                                $(this).find(imageclass).css({
                                    'transform': 'rotate(0deg)',
                                    'transform-style': 'preserve-3d',
                                    'transition': 'all 0.5s ease-out 0s'
                                });
                            } else {
                                $(this).find(imageclass).css({
                                    'transform': 'rotate' + imageflip + '(0deg)',
                                    'transform-style': 'preserve-3d',
                                    'transition': 'all 0.5s ease-out 0s'
                                });
                            }
                        }
                        $(this).find(imageclass).attr('src', flipper);
                    }
                }, touchstart: function () {
                    var base = $(this).find(imageclass).attr('src');
                    var flipper = $(this).find("#mageinic_flipper_img").text();
                    var dataImg = $(this).find("#mageinic_flipper_img").attr('data-img');
                    var dataType = $(this).find("#mageinic_flipper_img").attr('data-type');

                    if (dataType == 'configurable') {
                        if (typeof dataImg !== "undefined" && dataImg != '') {
                            flipper = dataImg;
                        }
                        else if (dataImg == ''){
                            flipper = '';
                        }
                    }

                    if (flipper != '' && typeof flipper !== "undefined") {
                        $(this).find("#mageinic_flipper_img").text(base);
                        if (imageflip != 0) {
                            if (imageflip == 'X') {
                                if (imageflip == 1) {
                                    $(this).find(imageclass).css({
                                        'transform': 'rotate(-360deg)',
                                        'transform-	style': 'preserve-3d',
                                        'transition': 'all 0.5s ease-out 0s'
                                    });
                                } else {
                                    $(this).find(imageclass).css({
                                        'transform': 'rotate' + imageflip + '(-360deg)',
                                        'transform-style': 'preserve-3d',
                                        'transition': 'all 0.5s ease-out 0s'
                                    });
                                }
                            }
                            if (imageflip == 'Y') {
                                if (imageflip == 1) {
                                    $(this).find(imageclass).css({
                                        'transform': 'rotate(180deg)',
                                        'transform-style': 'preserve-3d',
                                        'transition': 'all 0.5s ease-out 0s'
                                    });
                                } else {
                                    $(this).find(imageclass).css({
                                        'transform': 'rotate' + imageflip + '(180deg)',
                                        'transform-style': 'preserve-3d',
                                        'transition': 'all 0.5s ease-out 0s'
                                    });
                                }
                            }
                            if (imageflip != 0) {
                                if (imageflip == 1) {
                                    $(this).find(imageclass).css({
                                        'transform': 'rotate(-360deg)',
                                        'transform-style': 'preserve-3d',
                                        'transition': 'all 0.5s ease-out 0s'
                                    });
                                } else {
                                    $(this).find(imageclass).css({
                                        'transform': 'rotate' + imageflip + '(-360deg)',
                                        'transform-style': 'preserve-3d',
                                        'transition': 'all 0.5s ease-out 0s'
                                    });
                                }
                            }
                        }
                        $(this).find(imageclass).attr('src', flipper);
                    }
                }, touchend: function () {
                    var base = $(this).find(imageclass).attr('src');
                    var flipper = $(this).find("#mageinic_flipper_img").text();
                    var dataImg = $(this).find("#mageinic_flipper_img").attr('data-img');
                    var dataType = $(this).find("#mageinic_flipper_img").attr('data-type');

                    if (dataType == 'configurable') {
                        if (dataImg == '') {
                            flipper = '';
                        }
                    }

                    if (flipper != '' && typeof flipper !== "undefined") {
                        $(this).find("#mageinic_flipper_img").text(base);
                        if (imageflip != 0) {
                            if (imageflip == 1) {
                                $(this).find(imageclass).css({
                                    'transform': 'rotate(0deg)',
                                    'transform-style': 'preserve-3d',
                                    'transition': 'all 0.5s ease-out 0s'
                                });
                            } else {
                                $(this).find(imageclass).css({
                                    'transform': 'rotate' + imageflip + '(0deg)',
                                    'transform-style': 'preserve-3d',
                                    'transition': 'all 0.5s ease-out 0s'
                                });
                            }
                        }
                        $(this).find(imageclass).attr('src', flipper);
                    }
                },
            }, mainclass);
        }
    });
    return $.mageINIC.mageinic_flipper;
});
