<?php
namespace ide\project;
use ide\Ide;
use ide\VendorContainer;
use php\lib\str;
use php\xml\DomElement;
use php\xml\DomDocument;

/**
 * Class AbstractProjectBehaviour
 * @package ide\project
 */
abstract class AbstractProjectBehaviour extends ProjectFile
{
    const PRIORITY_SYSTEM = 1;
    const PRIORITY_CORE = 100;
    const PRIORITY_LIBRARY = 1000;
    const PRIORITY_COMPONENT = 10000;

    use VendorContainer;


    /**
     * @var Project
     */
    protected $project;

    /**
     * @param Project $project
     * @return bool
     */
    public function isFit(Project $project)
    {
        return false;
    }

    /**
     * ...
     */
    abstract public function inject();

    /**
     * see PRIORITY_* constants
     * @return int
     */
    abstract public function getPriority();

    /**
     * @param DomElement $domBehavior
     * @param DomDocument $document
     */
    public function serialize(DomElement $domBehavior, DomDocument $document)
    {
        // ...
    }

    /**
     * @param DomElement $domBehavior
     */
    public static function unserialize(DomElement $domBehavior)
    {
        /// ...
    }


    /**
     * @param Project $project
     *
     * @param bool $inject
     * @return AbstractProjectBehaviour
     */
    public function forProject(Project $project, $inject = true)
    {
        $behavior = clone $this;
        $behavior->project = $project;

        if ($inject) {
            $behavior->inject();
        }

        return $behavior;
    }

    /**
     * @return $this
     * @throws \Exception
     */
    static function get()
    {
        $class = get_called_class();

        if (Ide::project() && Ide::project()->hasBehaviour($class)) {
            return Ide::project()->getBehaviour($class);
        }

        return null;
    }

    /**
     * @param string $key
     * @param null $def
     * @return null|string
     */
    protected function getIdeConfigValue($key, $def = null)
    {
        if ($config = $this->getIdeConfig()) {
            return $config->get($key, $def);
        }

        return null;
    }

    /**
     * @param $key
     * @param $value
     * @return null
     */
    protected function setIdeConfigValue($key, $value)
    {
        if ($config = $this->getIdeConfig()) {
            $config->set($key, $value);
        }
    }

    /**
     * @return \php\util\Configuration
     */
    protected function getIdeConfig()
    {
        if (Ide::project()) {
            $name = str::replace(get_class($this), "\\", "/") . ".conf";

            return Ide::project()->getIdeConfig($name);
        } else {
            return null;
        }
    }

    protected function saveIdeConfig()
    {
        if (Ide::project()) {
            $file = get_class($this);
            $name = str::replace(get_class($this), "\\", "/") . ".conf";

            Ide::project()->getIdeConfig($name)->saveFile();
        }
    }
}