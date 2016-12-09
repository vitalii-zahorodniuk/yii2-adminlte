<?php

namespace xz1mefx\adminlte\widgets;

use xz1mefx\adminlte\helpers\Html;
use Yii;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * Class SidebarMenu
 *
 * Menu items structure example:
 * ```php
 *  $menuItems = [
 *      ['url' => ['site/error'], 'icon' => 'th-list', 'label' => 'Dashboard', 'stickers' => [
 *          ['bgClass' => 'bg-red', 'label' => 'red'],
 *          ['bgClass' => 'label-success', 'label' => 's'],
 *          ['bgClass' => 'label-success', 'label' => 's'],
 *          ['bgClass' => 'bg-purple', 'label' => 'p'],
 *      ]],
 *      ['label' => 'Menu level 1', 'items' => [
 *          ['label' => 'Menu level 2', 'items' => [
 *              ['label' => 'Menu level 3', 'items' => [
 *                  ['label' => 'Menu level 4', 'icon' => 'user', 'items' => [
 *                      ['label' => 'Lvl4 page 1', 'url' => ['site/index']],
 *                      ['label' => 'Lvl4 page 2', 'url' => ['site/index'], 'active' => true],
 *                  ]],
 *              ]],
 *              ['url' => ['site/index'], 'label' => 'Lvl2 page'],
 *          ]],
 *      ]],
 *      ['url' => '//www.ukr.net', 'label' => 'ukr.net', 'icon' => 'user', 'iconOptions' => ['prefix' => 'fa fa-']],
 *  ];
 * ```
 *
 * @package xz1mefx\adminlte\widgets
 */
class SidebarMenu extends Widget
{
    public $menuTemplate = "<ul class=\"sidebar-menu\">\n{menuContent}</ul>\n";

    public $headerLabel = NULL;
    public $headerTransform = 'uppercase';
    public $headerTemplate = "<li class=\"header\" style=\"text-transform: {headerTransform};\">{headerLabel}</li>\n";

    public $itemTemplate = "<li class=\"{class}\"><a href=\"{url}\">{icon}<span>{label}</span><span class=\"pull-right-container\">{treeViewRightIcon}{stickers}</span></a>{treeViewMenu}</li>\n";
    public $treeViewMenuTemplate = "<ul class=\"treeview-menu\">\n{content}</ul>";

    public $menuItems = NULL;

    public function run()
    {
        if (empty($this->menuItems)) {
            return NULL;
        }
        return $this->renderWidget();
    }

    private function renderWidget()
    {
        $menuContent = '';
        if (!empty($this->headerLabel)) {
            $menuContent .= strtr($this->headerTemplate, [
                '{headerTransform}' => $this->headerTransform,
                '{headerLabel}' => $this->headerLabel,
            ]);
        }
        $menuContent .= $this->renderMenuItems($this->menuItems, true);

        return strtr($this->menuTemplate, [
            '{menuContent}' => $menuContent,
        ]);
    }

    private function renderMenuItems($itemsArray, $firstLevel = false)
    {
        $menuContent = '';

        if (empty($itemsArray) || !is_array($itemsArray)) {
            return $menuContent;
        }

        foreach ($itemsArray as $item) {
            $replacePairs = [];
            $iconOptions = ArrayHelper::merge(
                (empty($item['icon']) ? [] : ArrayHelper::getValue($item, 'iconOptions', [])),
                ['tag' => 'i']
            );
            $defaultIcon = Html::icon($firstLevel ? 'chevron-right' : 'circle-o', ['prefix' => 'fa fa-', 'tag' => 'i']);

            $replacePairs['{class}'] = '';
            $replacePairs['{treeViewRightIcon}'] = '';
            $replacePairs['{treeViewMenu}'] = '';
            if (!empty($item['items']) && is_array($item['items'])) { // if it's treeview
                $replacePairs['{treeViewRightIcon}'] = "<i class=\"fa fa-angle-left pull-right\"></i>";
                $replacePairs['{treeViewMenu}'] = strtr($this->treeViewMenuTemplate, [
                    '{content}' => $this->renderMenuItems($item['items']),
                ]);
                if ($firstLevel) {
                    $replacePairs['{class}'] = 'treeview';
                }
            } else {
                if (ArrayHelper::getValue($item, 'active', false) || $this->isItemActive($item)) {
                    $replacePairs['{class}'] .= (empty($replacePairs['{class}']) ? '' : ' ') . 'active';
                }
            }
            $replacePairs['{url}'] = empty($item['url']) ? '#' : Url::to($item['url']);
            $replacePairs['{icon}'] = empty($item['icon']) ? $defaultIcon : (Html::icon($item['icon'], $iconOptions) . '&nbsp;');
            $replacePairs['{label}'] = empty($item['label']) ? '&nbsp;' : $item['label'];
            $stickers = '';
            if (!empty($item['stickers']) && is_array($item['stickers'])) {
                foreach (array_reverse($item['stickers'], true) as $label) {
                    $stickers .= Html::infoLabel($label['bgClass'], $label['label'], ['class' => 'pull-right']);
                }
            }
            $replacePairs['{stickers}'] = $stickers;

            $menuContent .= strtr($this->itemTemplate, $replacePairs);
        }

        return $menuContent;
    }

    /**
     * Checks whether a menu item is active.
     * This is done by checking if [[route]] and [[params]] match that specified in the `url` option of the menu item.
     * When the `url` option of a menu item is specified in terms of an array, its first element is treated
     * as the route for the item and the rest of the elements are the associated parameters.
     * Only when its route and parameters match [[route]] and [[params]], respectively, will a menu item
     * be considered active.
     * @param array $item the menu item to be checked
     * @return boolean whether the menu item is active
     */
    protected function isItemActive($item)
    {
        if (isset($item['url']) && is_array($item['url']) && isset($item['url'][0])) {
            $route = $item['url'][0];
            if ($route[0] !== '/' && Yii::$app->controller) {
                $route = Yii::$app->controller->module->getUniqueId() . '/' . $route;
            }
            if (ltrim($route, '/') !== Yii::$app->controller->getRoute()) {
                return false;
            }
            unset($item['url']['#']);
            if (count($item['url']) > 1) {
                $params = $item['url'];
                unset($params[0]);
                foreach ($params as $name => $value) {
                    $queryParams = Yii::$app->request->getQueryParams();
                    if ($value !== NULL && (!isset($queryParams[$name]) || $queryParams[$name] != $value)) {
                        return false;
                    }
                }
            }
            return true;
        }
        return false;
    }
}
