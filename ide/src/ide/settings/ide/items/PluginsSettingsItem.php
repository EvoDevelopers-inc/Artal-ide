<?php

namespace ide\settings\ide\items;

use ide\Ide;
use ide\settings\SettingsContext;
use ide\settings\ui\AbstractSettingsItem;
use ide\ui\elements\DNButton;
use ide\ui\elements\DNLabel;
use ide\ui\elements\DNListView;
use ide\ui\elements\DNSplitPane;
use php\gui\layout\UXHBox;
use php\gui\layout\UXVBox;
use php\gui\UXLabel;
use php\gui\UXListView;
use php\gui\UXNode;
use php\gui\UXSplitPane;

class PluginsSettingsItem extends AbstractSettingsItem {

    /**
     * @return string
     */
    public function getName(): string {
        return "settings.ide.plugins";
    }

    /**
     * @return string
     */
    public function getIcon(): string {
        return "icons/plugin16.png";
    }

    /**
     * @param SettingsContext $context
     * @return UXNode
     * @throws \Exception
     */
    public function makeUi(SettingsContext $context): UXNode {
        $list = new DNListView();
        $mainBox = new DNSplitPane();
        $extensions = Ide::get()->getExtensions();

        $mainBox->items->add($list);

        foreach ($extensions as $extension) {
            $label = new DNLabel(_($extension->getName()));
            $label->font = $label->font->withBold();

            $box = new UXHBox([
                Ide::getImage($extension->getIcon32(), [32, 32]),
                $label
            ], 8);

            $fullBox = new UXVBox();
            $fullBox->spacing =
            $fullBox->padding = 8;

            $header = new UXHBox([
                Ide::getImage($extension->getIcon32(), [32, 32]),
                new UXLabel(_($extension->getName()))
            ], 8);

            $header->alignment = "CENTER_LEFT";
            $fullBox->add($header);

            $description = new DNLabel($extension->getDescription());
            $description->wrapText = true;

            $fullBox->add($description);

            $buttonsBox = new UXHBox([
                _($disableButton = new DNButton("plugin.disable")),
                _($removeButton = new DNButton("plugin.remove")),
            ], 8);

            $fullBox->add($buttonsBox);

            $removeButton->enabled  =
            $disableButton->enabled = !$extension->isSystem();

            $box->on("click", function () use ($mainBox, $box, $fullBox) {
                if ($mainBox->items->count() == 1) {
                    $mainBox->items->add(_($fullBox));
                } else $mainBox->items->set(1, _($fullBox));
            });

            $box->alignment = "CENTER_LEFT";

            $list->items->add($box);
        }

        return _($mainBox);
    }

    public function showBottomButtons(): bool {
        return false;
    }

    /**
     * @param SettingsContext $context
     * @param UXNode $ui
     */
    public function doSave(SettingsContext $context, UXNode $ui) {
        // ignore
    }

    /**
     * @param SettingsContext $context
     * @param UXNode $ui
     * @return bool
     */
    public function canSave(SettingsContext $context, UXNode $ui): bool {

        // ignore
    }
}