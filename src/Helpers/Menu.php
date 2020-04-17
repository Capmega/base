<?php
namespace Capmega\Base\Helpers;

/**
 *
 */
class Menu
{
    public static function generate()
    {
        return [
            [
                'name' => __('base::attributes.images.items'),
                'icon' => 'image',
                'visible' => auth()->user()->hasRole('admin'),
                'url'  => 'images.index',
                'items' => [
                    [
                        'name'       => __('base::attributes.images.items'),
                        'icon'       => 'image',
                        'url'        => 'images.index',
                        'crud'       => 'images',
                        'extra_urls' => ['images.create-multiple']
                    ],
                    [
                        'name' => __('base::attributes.images-type.items'),
                        'icon' => 'image',
                        'url'  => 'images-type.index',
                        'crud' => 'images-type',
                    ],
                ]
            ],
            [
                'name'    => __('base::attributes.subscription.items'),
                'icon'    => 'rss',
                'visible' => auth()->user()->hasRole('admin'),
                'url'     => 'subscription.index',
                'crud'    => 'subscription',
            ],
            [
                'name' => __('base::app.configuration'),
                'icon' => 'cogs',
                'visible' => auth()->user()->hasRole('admin'),
                'items' => [
                    [
                        'name' => __('base::app.common_config'),
                        'icon' => 'file-text',
                        'url'  => 'configuration.general',
                    ],
                    [
                        'name' => __('base::attributes.cdn.items'),
                        'icon' => 'server',
                        'url'  => 'cdn.index',
                        'crud' => 'cdn',
                    ],
                ],
            ],
            [
                'name' => __('base::generator.generator'),
                'icon' => 'magic',
                'badge' => [
                    'type' => 'danger',
                    'value' => '!'
                ],
                'items' => [
                    [
                        'name' => __('base::generator.make_crud'),
                        'icon' => 'globe',
                        'url'  => 'generator.crud',
                        'crud' => 'generator',
                    ],
                ],
            ]
        ];
    }
}
