<?php
namespace ide\webplatform\formats;

use ide\editors\FormEditor;
use ide\formats\form\AbstractFormDumper;
use ide\formats\form\AbstractFormElementTag;
use ide\misc\EventHandlerBehaviour;
use ide\utils\Json;
use ide\webplatform\editors\WebFormEditor;
use ide\webplatform\formats\form\AbstractWebElement;
use php\format\JsonProcessor;
use php\gui\layout\UXAnchorPane;
use php\gui\layout\UXPane;
use php\gui\UXButton;
use php\gui\UXLoader;
use php\gui\UXNode;
use php\gui\UXParent;
use php\io\IOException;
use php\io\MemoryStream;
use php\lib\str;
use php\xml\DomDocument;
use php\xml\DomElement;

/**
 * Class WebFormDumper
 * @package ide\webplatform\formats
 */
class WebFormDumper extends AbstractFormDumper
{
    use EventHandlerBehaviour;

    /**
     * @var JsonProcessor
     */
    protected $json;

    /**
     * @var array
     */
    private $formElementTags;

    /**
     * @var array
     */
    private $formElementUiClasses;

    /**
     * WebFormDumper constructor.
     */
    public function __construct()
    {
        $this->json = new JsonProcessor(JsonProcessor::SERIALIZE_PRETTY_PRINT);
    }

    protected function createView(WebFormEditor $editor, array $uiSchema): UXNode
    {
        /** @var WebFormFormat $format */
        $format = $editor->getFormat();

        if ($element = $format->getWebElementByUiClass($uiSchema['_'])) {
            $view = $element->createElement();
            $element->loadUiSchema($view, $uiSchema);

            if ($element->isLayout() && is_array($uiSchema['_content'])) {
                foreach ($uiSchema['_content'] as $one) {
                    if ($one) {
                        $element->addToLayout($view, $this->createView($editor, $one), null, null);
                    }
                }
            }

            return $view;
        }

        return null;
    }

    protected function loadFrmFile(WebFormEditor $editor, UXPane $layout)
    {
        $schema = Json::fromFile($editor->getFrmFile());

        $layout->data('--web-form', true);
        $editor->data('title', $schema['title']);
        $editor->data('layout', str::split($schema['layout']['_'], '@')[1]);
        $editor->data('routerPath', $schema['router']['path'] ?? '');
        $editor->data('centered', $schema['centered'] ?? true);
        $editor->data('closable', $schema['closable'] ?? true);

        foreach (['width', 'height'] as $prop) {
            switch ($schema['layout'][$prop]) {
                case "100%":
                    $editor->data($prop . 'Kind', 'FULL');
                    break;
                case "":
                    $editor->data($prop . 'Kind', 'CLEAR');
                    break;
                default:
                    $editor->data($prop . 'Kind', '');
                    break;
            }
        }

        if (isset($schema['size'])) {
            [$layout->prefWidth, $layout->prefHeight] = $schema['size'];
        }

        if ($layoutSchema = $schema['components']['Layout']) {
            if (isset($layoutSchema['width'])) {
                $layout->prefWidth = $layoutSchema['width'];
            }

            if (isset($layoutSchema['height'])) {
                $layout->prefHeight = $layoutSchema['height'];
            }

            foreach ((array) $schema['components']['Layout']['_content'] as $item) {
                if ($item) {
                    if ($view = $this->createView($editor, $item)) {
                        $layout->add($view);
                    }
                }
            }
        }
    }

    public function load(FormEditor $editor)
    {
        $designer = $editor->getDesigner();

        /** @var UXAnchorPane $layout */
        try {
            $loader = new UXLoader();

            $memory = new MemoryStream();
            $memory->write('<?xml version="1.0" encoding="UTF-8"?>
<?import javafx.scene.*?>
<?import javafx.scene.layout.*?>
<AnchorPane maxHeight="-Infinity" maxWidth="-Infinity" minHeight="-Infinity" minWidth="-Infinity" prefHeight="480" prefWidth="640"
	xmlns="http://javafx.com/javafx/8" xmlns:fx="http://javafx.com/fxml/1">
</AnchorPane>
');
            $memory->seek(0);
            $layout = $loader->load($memory);

            $format = $editor->getFormat();

            if ($editor instanceof WebFormEditor) {
                $this->loadFrmFile($editor, $layout);
            }

            if ($layout instanceof UXPane) {
                $editor->setLayout($layout);
                $this->trigger('load', [$editor, $layout]);
            } else {
                throw new IOException();
            }

            return true;
        } catch (IOException $e) {
            $editor->setIncorrectFormat(true);
            $editor->setLayout(new UXAnchorPane());
            return false;
        }
    }

    private function uiSchema(UXNode $node): ?array
    {
        $element = $node->data('--web-element');

        if ($element instanceof AbstractWebElement) {
            $uiSchema = $element->uiSchema($node);

            if ($element->isLayout()) {
                $uiSchema['_content'] = [];

                foreach ($element->getLayoutChildren($node) as $sub) {
                    if ($s = $this->uiSchema($sub)) {
                        $uiSchema['_content'][] = $s;
                    }
                }
            }

            return $uiSchema;
        }

        return null;
    }

    public function save(FormEditor $editor)
    {
        /** @var WebFormEditor $editor */
        $this->trigger('save', [$editor]);

        $designer = $editor->getDesigner();

        $layout = $editor->getLayout();

        $uiContent = [];
        /** @var UXParent $child */
        foreach ($layout->children as $child) {
            $uiSchema = $this->uiSchema($child);

            if ($uiSchema) {
                $uiContent[] = $uiSchema;
            }
        }

        $layoutId = 'Layout';

        if ($editor->data('layout')) {
            $layoutId .= '@'.$editor->data('layout');
        }

        $widthKind = $editor->data('widthKind');
        $heightKind = $editor->data('heightKind');

        $width = $layout->width;
        $height = $layout->height;

        switch ($widthKind) {
            case 'FULL': $width = '100%'; break;
            case 'CLEAR': $width = null; break;
        }

        switch ($heightKind) {
            case 'FULL': $height = '100%'; break;
            case 'CLEAR': $height = ''; break;
        }

        $layoutSchema = ['_' => $layoutId];

        if (!$editor->data('layout')) {
            $layoutSchema['width'] = $width;
            $layoutSchema['height'] = $height;
        }

        $uiFormSchema = [
            'title' => $editor->data('title'),
            'closable' => $editor->data('closable'),
            'centered' => $editor->data('centered'),
            'router' => ['path' => $editor->data('routerPath')],
            'size' => [$layout->width, $layout->height],
            'components' => [
                'Layout' => [
                    '_' => 'AnchorPane',
                    'width' => $layout->width,
                    'height' => $layout->height,
                    '_content' => $uiContent
                ]
            ],
            'layout' => $layoutSchema
        ];

        Json::toFile($editor->getFrmFile(), $uiFormSchema);
    }

    /**
     * @param UXNode[] $nodes
     * @param DomDocument $document
     */
    public function appendImports(array $nodes, DomDocument $document)
    {
    }

    /**
     * @param FormEditor $editor
     * @param UXNode $node
     * @param DomDocument $document
     *
     * @param bool $ignoreUnregistered
     * @return DomElement
     */
    public function createElementTag(FormEditor $editor = null, UXNode $node, DomDocument $document, $ignoreUnregistered = true)
    {
    }
}