<?php
namespace ide\forms;

use ide\Ide;
use ide\Logger;
use php\gui\UXImage;
use php\gui\UXImageView;

/**
 * @property UXImageView $image
 */
class SplashForm extends AbstractIdeForm
{

    public function setProgress(int $value)
    {
        $this->progressBar->value = $value;
    }

    public function setStatus(string $text)
    {
        $this->statusLabel->text = $text;
    }

    protected function init()
    {
        Logger::debug("Init form ...");

        $this->centerOnScreen();

      //  if ($this->_app->isSnapshotVersion()) {
            $this->image->image = new UXImage("res://.data/img/splash/slpash_dark.png");
      //  }


        $this->waiter();
    }

    /**
     * Функция ждёт, когда отрисуется окно среды, и скрывает сплеш
     * Надо ли это вообще?
     */
    public function waiter(int $timeoutMs = 15000){
        waitAsync($timeoutMs, function() use ($timeoutMs){
            if (is_object($this->_app->getMainForm()) && $this->_app->getMainForm()->visible) {
                $this->hide();
            } elseif($this->visible) {
                $this->waiter($timeoutMs);
            }
        });
    }

    /**
     * @event show
     */
    public function doShow()
    {
        $this->toFront();
        $this->requestFocus();
    }
}