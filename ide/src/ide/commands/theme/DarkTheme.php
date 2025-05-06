<?php

namespace ide\commands\theme;

use ide\commands\theme\terminal\DarkTerminalTheme;
use ide\commands\theme\terminal\TerminalTheme;
use java\reflection\ReflectionClass;
use java\reflection\ReflectionTypes;

class DarkTheme extends IDETheme {

    /**
     * @inheritDoc
     */
    public function getName(): string {
        return "Deep Dark 2025";
    }

    /**
     * @inheritDoc
     */
    public function getAuthor(): string {
        return "DevelNext";
    }

    /**
     * @inheritDoc
     */
    public function getCSSFile(): string {
        return "/.theme/ide/dark.css";
    }

    /**
     * @inheritDoc
     */
    public function getTerminalTheme(): TerminalTheme {
        return new DarkTerminalTheme();
    }

    /**
     * @return CSSStyle
     */
    public function getCSSStyle(): CSSStyle {
        return new DarkCSSStyle();
    }

    public function onApply() {
        ReflectionClass::forName("com.formdev.flatlaf.FlatDarkLaf")
            ->getMethod("install", [])
            ->invoke(ReflectionTypes::getNull(), []);
    }
}