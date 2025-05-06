<?php

namespace ide\commands\theme;

class LightCSSStyle extends CSSStyle
{
    /**
     * @return array
     */
    public function getButtonCSS(): array {
        return [
            "-fx-base" => "#f3f3f3",
            "-fx-background-color" => "#f3f3f3",
            "-fx-text-fill" => "#333333",
            "-fx-border-color" => "#dddddd",
            "-fx-border-radius" => "4px",
            "-fx-background-radius" => "4px",
            "-fx-control-inner-background" => "-fx-base",
            "-fx-control-inner-background-alt" => "#f7f7f7",
            "-dn-text-fill" => "#333333",
            "-fx-cursor" => "hand"
        ];
    }

    /**
     * @return array
     */
    public function getMenuBarCSS(): array {
        return [
            "-fx-base" => "#f3f3f3",
            "-fx-background-color" => "#f3f3f3",
            "-fx-border-color" => "#dddddd",
            "-fx-border-width" => "0 0 1px 0",
            "-fx-control-inner-background" => "-fx-base",
            "-fx-control-inner-background-alt" => "#f7f7f7",
            "-dn-text-fill" => "#333333",
            "-fx-text-fill" => "-dn-text-fill",
            "-fx-effect" => "dropshadow(gaussian, rgba(0, 0, 0, 0.1), 4, 0, 0, 1)"
        ];
    }

    /**
     * @return array
     */
    public function getLabelCSS(): array {
        return [
            "-dn-text-fill" => "#333333",
            "-fx-text-fill" => "-dn-text-fill",
            "-fx-font-smoothing-type" => "lcd"
        ];
    }

    /**
     * @return array
     */
    public function getBoxPanelCSS(): array {
        return [
            "-fx-background-color" => "#ffffff",
            "-fx-border-width" => "0",
            "-fx-effect" => "null"
        ];
    }

    /**
     * @return array
     */
    public function getSeparatorCSS(): array {
        return [
            "-fx-base" => "#dddddd",
            "-fx-background-color" => "#dddddd"
        ];
    }

    /**
     * @return array
     */
    public function getTextInputCSS(): array {
        return [
            "-fx-control-inner-background" => "#ffffff",
            "-fx-base" => "#f3f3f3",
            "-fx-border-color" => "#dddddd",
            "-fx-border-radius" => "4px",
            "-fx-background-radius" => "4px",
            "-dn-text-fill" => "#333333",
            "-fx-text-fill" => "-dn-text-fill",
            "-fx-prompt-text-fill" => "#a0a0a0",
            "-fx-highlight-fill" => "#0093ff",
            "-fx-highlight-text-fill" => "#ffffff"
        ];
    }

    /**
     * @return array
     */
    public function getListViewCSS(): array {
        return [
            "-fx-base" => "#ffffff",
            "-fx-control-inner-background" => "#fcfcfc",
            "-fx-control-inner-background-alt" => "#f7f7f7",
            "-fx-background-color" => "#ffffff",
            "-dn-selected-background-color" => "#cce6fe",
            "-fx-selection-bar" => "#cce6fe",
            "-fx-selection-bar-non-focused" => "#e5e5e5",
            "-dn-text-fill" => "#333333",
            "-fx-text-fill" => "-dn-text-fill",
            "-fx-border-color" => "#dddddd",
            "-fx-border-radius" => "4px",
            "-fx-background-radius" => "4px"
        ];
    }

    /**
     * @return array
     */
    public function getTreeViewCSS(): array {
        return [
            "-fx-base" => "#ffffff",
            "-fx-control-inner-background" => "#fcfcfc",
            "-fx-control-inner-background-alt" => "#f7f7f7",
            "-fx-background-color" => "#fcfcfc",
            "-fx-selection-bar" => "#cce6fe",
            "-fx-selection-bar-non-focused" => "#e5e5e5",
            "-dn-text-fill" => "#333333",
            "-fx-text-fill" => "-dn-text-fill",
            "-fx-border-color" => "#dddddd",
            "-fx-border-radius" => "4px",
            "-fx-background-radius" => "4px"
        ];
    }

    /**
     * @return array
     */
    public function getTabPaneCSS(): array {
        return [
            "-dn-base" => "#F4F4F4",
            "-dn-text-fill" => "#333333",
            "-fx-text-fill" => "-dn-text-fill",
            "-dn-tab-header-area-background" => "#e8e8e8",
            "-dn-tab-content-area-background" => "#ffffff",
            "-dn-tab-header-background" => "#f4f4f4",
            "-fx-background-color" => "#ffffff",
            "-fx-tab-border-color" => "#dddddd"
        ];
    }

    /**
     * @return array
     */
    public function getSplitPaneCSS(): array {
        return [
            "-dn-base" => "#f3f3f3",
            "-fx-background-color" => "transparent",
            "-fx-divider-color" => "#dddddd"
        ];
    }

    /**
     * @return array
     */
    public function getScrollPaneCSS(): array {
        return [
            "-dn-base" => "#ffffff",
            "-fx-background-color" => "#ffffff",
            "-fx-border-color" => "transparent"
        ];
    }

    /**
     * @return array
     */
    public function getFlowPaneCSS(): array {
        return [
            "-dn-base" => "#ffffff",
            "-fx-background-color" => "#ffffff",
            "-fx-border-color" => "#dddddd",
            "-fx-border-style" => "solid",
            "-fx-border-width" => "1px",
            "-fx-border-radius" => "4px"
        ];
    }
}