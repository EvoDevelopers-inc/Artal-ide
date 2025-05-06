<?php
namespace ide\forms;

use ide\Ide;
use php\gui\framework\AbstractForm;
use php\gui\layout\UXVBox;
use php\gui\UXProgressBar;
use php\gui\UXProgressIndicator;
use php\gui\UXLabel;
use php\gui\UXButton;
use php\gui\layout\UXHBox;

/**
 * Форма отображения прогресса загрузки проекта
 */
class ProjectLoadingForm extends AbstractIdeForm
{
    /**
     * @var UXProgressIndicator
     */
    protected $progressIndicator;
    
    /**
     * @var UXLabel
     */
    protected $statusLabel;
    
    /**
     * @var UXButton
     */
    protected $cancelButton;
    
    /**
     * @var callable
     */
    protected $onCancel;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->title = _('project.loading.title');
        // Используем только допустимые значения стиля
        //$this->style = '-fx-background-color: -fx-background;';
        // Не вызываем setStyle напрямую, используем свойство модального окна
        $this->modality = 'APPLICATION_MODAL';
        
        $this->layout = new UXVBox();
        $this->layout->alignment = 'CENTER';
        $this->layout->padding = 25;
        
        $title = new UXLabel(_('project.loading.message'));
        $title->style = '-fx-font-weight: bold; -fx-font-size: 14px;';
        $this->layout->add($title);
        
        $this->progressIndicator = new UXProgressIndicator();
        $this->progressIndicator->progress = -1; // бесконечный прогресс
        $this->progressIndicator->prefWidth = 100;
        $this->progressIndicator->prefHeight = 100;
        $this->layout->add($this->progressIndicator);
        
        $this->statusLabel = new UXLabel(_('project.loading.init'));
        $this->statusLabel->style = '-fx-font-size: 13px;';
        $this->layout->add($this->statusLabel);
        
        $buttonBox = new UXHBox();
        $buttonBox->alignment = 'CENTER';
        
        $this->cancelButton = new UXButton(_('project.loading.cancel'));
        $this->cancelButton->on('action', [$this, 'doCancel']);
        $buttonBox->add($this->cancelButton);
        
        $this->layout->add($buttonBox);
        
        $this->size = [400, 300];
        $this->centerOnScreen();
        
        $this->resizable = false;
        $this->alwaysOnTop = true;
    }
    
    /**
     * Установить текущий статус загрузки
     * 
     * @param string $text
     */
    public function setStatus($text)
    {
        $this->statusLabel->text = $text;
    }
    
    /**
     * Установить обработчик отмены
     * 
     * @param callable $callback
     */
    public function setOnCancel(callable $callback)
    {
        $this->onCancel = $callback;
    }
    
    /**
     * Обработчик нажатия кнопки отмены
     */
    public function doCancel()
    {
        $this->hide();
        
        if ($this->onCancel) {
            ($this->onCancel)();
        }
    }
}