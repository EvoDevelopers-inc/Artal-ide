<?php

namespace ide\commands\theme;

class DarkCSSStyle extends CSSStyle {

    /**
     * @return array
     */
    public function getButtonCSS(): array {
        return [
            "-fx-base" => "#141414",
            "-fx-background-color" => "#141414",
            "-fx-border-color" => "#333333",
            "-fx-border-radius" => "4px",
            "-fx-background-radius" => "4px",
            "-fx-control-inner-background" => "-fx-base",
            "-fx-control-inner-background-alt" => "#1A1A1A",
            "-dn-text-fill" => "#f0f0f0",
            "-fx-text-fill" => "-dn-text-fill",
            "-fx-cursor" => "hand"
        ];
    }

    /**
     * @return array
     */
    public function getMenuBarCSS(): array {
        return [
            "-fx-base" => "#000000",
            "-fx-background-color" => "#000000",
            "-fx-border-color" => "#333333",
            "-fx-border-width" => "0 0 1px 0",
            "-fx-control-inner-background" => "-fx-base",
            "-fx-control-inner-background-alt" => "#0D0D0D",
            "-dn-text-fill" => "#f0f0f0",
            "-fx-text-fill" => "-dn-text-fill",
            "-fx-effect" => "dropshadow(gaussian, rgba(0, 0, 0, 0.4), 8, 0, 0, 2)"
        ];
    }

    /**
     * @return array
     */
    public function getLabelCSS(): array {
        return [
            "-dn-text-fill" => "#f0f0f0",
            "-fx-text-fill" => "-dn-text-fill",
            "-fx-font-smoothing-type" => "lcd"
        ];
    }

    /**
     * @return array
     */
    public function getBoxPanelCSS(): array {
        return [
            "-fx-background-color" => "#000000",
            "-fx-border-width" => "0",
            "-fx-effect" => "null"
        ];
    }

    /**
     * @return array
     */
    public function getSeparatorCSS(): array {
        return [
            "-fx-base" => "#333333",
            "-fx-background-color" => "#333333"
        ];
    }

    /**
     * @return array
     */
    public function getTextInputCSS(): array {
        return [
            "-fx-control-inner-background" => "#0A0A0A",
            "-fx-base" => "#141414",
            "-fx-border-color" => "#333333",
            "-fx-border-radius" => "4px",
            "-fx-background-radius" => "4px",
            "-dn-text-fill" => "#f0f0f0",
            "-fx-text-fill" => "-dn-text-fill",
            "-fx-prompt-text-fill" => "#707070",
            "-fx-highlight-fill" => "#1A73E8",
            "-fx-highlight-text-fill" => "#ffffff"
        ];
    }

    /**
     * @return array
     */
    public function getListViewCSS(): array {
        return [
            "-fx-base" => "#000000",
            "-fx-control-inner-background" => "#050505",
            "-fx-control-inner-background-alt" => "#0A0A0A",
            "-fx-background-color" => "#050505",
            "-dn-selected-background-color" => "#1A73E8",
            "-fx-selection-bar" => "#1A73E8",
            "-fx-selection-bar-non-focused" => "#0D47A1",
            "-dn-text-fill" => "#f0f0f0",
            "-fx-text-fill" => "-dn-text-fill",
            "-fx-border-color" => "#333333",
            "-fx-border-radius" => "4px",
            "-fx-background-radius" => "4px"
        ];
    }

    /**
     * @return array
     */
    public function getTreeViewCSS(): array {
        return [
            "-fx-base" => "#000000",
            "-fx-control-inner-background" => "#050505",
            "-fx-control-inner-background-alt" => "#0A0A0A",
            "-fx-background-color" => "#050505",
            "-fx-selection-bar" => "#1A73E8",
            "-fx-selection-bar-non-focused" => "#0D47A1",
            "-dn-text-fill" => "#f0f0f0",
            "-fx-text-fill" => "-dn-text-fill",
            "-fx-border-color" => "#333333",
            "-fx-border-radius" => "4px",
            "-fx-background-radius" => "4px"
        ];
    }

    /**
     * @return array
     */
    public function getTabPaneCSS(): array {
        return [
            "-dn-base" => "#000000",
            "-dn-text-fill" => "#f0f0f0",
            "-fx-text-fill" => "-dn-text-fill",
            "-dn-tab-header-area-background" => "#050505",
            "-dn-tab-content-area-background" => "#000000",
            "-dn-tab-header-background" => "#141414",
            "-fx-background-color" => "#000000",
            "-fx-tab-border-color" => "#333333"
        ];
    }

    /**
     * @return array
     */
    public function getSplitPaneCSS(): array {
        return [
            "-dn-base" => "#000000",
            "-fx-background-color" => "transparent",
            "-fx-divider-color" => "#333333"
        ];
    }

    /**
     * @return array
     */
    public function getScrollPaneCSS(): array {
        return [
            "-dn-base" => "#000000",
            "-fx-background-color" => "#000000",
            "-fx-border-color" => "transparent"
        ];
    }

    /**
     * @return array
     */
    public function getFlowPaneCSS(): array {
        return [
            "-dn-base" => "#000000",
            "-fx-background-color" => "#000000",
            "-fx-border-color" => "#333333",
            "-fx-border-style" => "solid",
            "-fx-border-width" => "1px",
            "-fx-border-radius" => "4px"
        ];
    }
}