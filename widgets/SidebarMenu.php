<?php

namespace xz1mefx\adminlte\widgets;

use xz1mefx\adminlte\helpers\Html;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * Class SidebarMenu
 *
 * Menu items structure example:
 * ```php
 * $menuItems = [
 *   ['url' => 'site/index', 'icon' => 'th-list', 'label' => 'Dashboard', 'stickers' => [
 *      ['bgClass' => 'bg-red', 'label' => 'red'],
 *       ['bgClass' => 'label-success', 'label' => 's'],
 *       ['bgClass' => 'label-success', 'label' => 's'],
 *      ['bgClass' => 'bg-purple', 'label' => 'p'],
 *   ]],
 *   ['label' => 'Menu level 1', 'items' => [
 *       ['label' => 'Menu level 2', 'items' => [
 *          ['label' => 'Menu level 3', 'items' => [
 *               ['label' => 'Menu level 4', 'icon' => 'user', 'items' => [
 *                  ['label' => 'Lvl4 page 1', 'url' => ['site/index']],
 *                  ['label' => 'Lvl4 page 2', 'url' => ['site/index']],
 *               ]],
 *          ]],
 *          ['url' => ['site/index'], 'label' => 'Lvl2 page'],
 *      ]],
 *   ]],
 *   ['url' => '//www.ukr.net', 'label' => 'ukr.net', 'icon' => 'user', 'iconOptions' => ['prefix' => 'fa fa-']],
 * ];
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

    public $itemTemplate = "<li class=\"{class}\"><a href=\"{url}\">{icon}{label}<span class=\"pull-right-container\">{treeViewRightIcon}{stickers}</span></a>{treeViewMenu}</li>\n";
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
            $defaultIcon = '';

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
                } else {
                    $defaultIcon = Html::icon('circle-o', ['prefix' => 'fa fa-']);
                }
            }
            $replacePairs['{url}'] = empty($item['url']) ? '#' : Url::to($item['url']);
            $replacePairs['{icon}'] = empty($item['icon']) ?
                $defaultIcon : (Html::icon($item['icon'], ArrayHelper::getValue($item, 'iconOptions', [])) . '&nbsp;');
            $replacePairs['{label}'] = empty($item['label']) ? '&nbsp;' : $item['label'];
            $stickers = '';
            if (!empty($item['stickers']) && is_array($item['stickers'])) {
                foreach (array_reverse($item['stickers'], true) as $label) {
                    $stickers .= Html::labelSticker($label['bgClass'], $label['label'], ['class' => 'pull-right']);
                }
            }
            $replacePairs['{stickers}'] = $stickers;

            $menuContent .= strtr($this->itemTemplate, $replacePairs);
        }

        return $menuContent;
    }
}
