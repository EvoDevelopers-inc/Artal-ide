<?php

namespace ide\service;


use ide\Ide;
use ide\misc\EventHandler;
use ide\ui\elements\DNButton;
use ide\ui\elements\DNLabel;
use php\gui\event\UXEvent;
use php\gui\layout\UXHBox;
use php\gui\layout\UXVBox;
use php\gui\UXButton;
use php\gui\UXImage;
use php\gui\UXImageView;
use php\gui\UXLabel;
use php\gui\UXLabelEx;
use php\gui\UXMedia;
use php\gui\UXMediaPlayer;
use php\gui\UXMediaView;
use php\gui\UXMediaViewBox;
use php\lib\fs;
use php\lib\str;

class JPPMControl
{
    private string $os;
    private string $urlJPPM = "https://github.com/jphp-group/jphp/releases/download/jppm-0.6.7/jppm-0.6.7.tar.gz";
    private string $JPPMBin = "";
    public function __construct(string $os)
    {
        $this->os = $os;
    }

    public function onIDEStart()
    {
        Ide::get()->getMainForm()->showModal($this->makeUI());
    }


    private function makeUI()
    {
        $layout = new UXHBox();
        $layout->alignment = 'CENTER';

        UXVBox::setVgrow($layout, "ALWAYS");

        $containerNodes = new UXVBox();
        $containerNodes->alignment = 'CENTER';
        $layout->add($containerNodes);

        $label = _(new UXLabelEx('jppm.control.text'));
        $label->width = 300;
        $label->alignment = 'CENTER';
        $label->textAligment = "CENTER";
        $label->wrapText = true;
        $containerNodes->add($label);

        $demoImageGifts = new UXImageView(new UXImage("res://.data/img/gifts/demo_jppm.gif"));
        $demoImageGifts->size = [720, 310];
        $containerNodes->add($demoImageGifts);



        $containerButtons = new UXHBox();
        $containerButtons->alignment = 'CENTER';
        $containerNodes->add($containerButtons);


        $buttonOk = _(new DNButton('jppm.control.ok.button'));
        $buttonOk->on("click", function (UXEvent $e){
            var_dump("ok");
        });
        $containerButtons->add($buttonOk);

        $buttonCancel = _(new DNButton('jppm.control.cancel.button'));
        $buttonCancel->on("click", function (UXEvent $e)use($layout){
            var_dump("no");
            Ide::get()->getMainForm()->closeModal($layout);
        });
        $containerButtons->add($buttonCancel);


        return $layout;
    }

    private function isHaveJPPM(): bool
    {
        $currentDir = fs::abs("./");
        $toolDir = $currentDir . DIRECTORY_SEPARATOR . "tools";

        if (!file_exists($toolDir)) {
            mkdir($toolDir, 0777, true);
            return false;
        }

        $JPPMDir = $toolDir . DIRECTORY_SEPARATOR . "JPPM";


        if (!file_exists($JPPMDir)) {
            return false;
        }


        $file = "";
        if ($this->os == "linux") {
            $file = "jppm";
        } elseif ($this->os == "windows") {
            $file = "jppm.bat";
        } else {
            return false;
        }


        $JPPMBin = $JPPMDir . DIRECTORY_SEPARATOR . $file;

        if (!file_exists($JPPMBin)) {
            return false;
        }

        $this->JPPMBin = $JPPMBin;

        return true;
    }


    public function getBinJPPM(): string
    {
        return $this->JPPMBin;
    }


}