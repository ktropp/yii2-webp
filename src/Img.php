<?php

namespace ktropp\yii2webp;

use yii\base\Widget;
use yii\helpers\Html;

class Img extends Widget
{
    public $src;

    public $lazy = false;

    public $options = [];

    private $_webp;

    public function init()
    {
        parent::init();
        $this->_webp = Webp::get($this->src);
    }

    public function run()
    {
        $srcset = 'srcset';
        $src = 'src';
        $class = [];
        if($this->lazy){
            $srcset = 'data-srcset';
            $src = 'data-src';
            $class[] = 'lazy';
        }
        $return = Html::beginTag('picture');
        if (!empty($this->_webp)) {
            $return .= Html::tag('source', '', [$srcset => $this->_webp, 'type' => 'image/webp']);
        }
        $return .= Html::tag('img', '', [$src => $this->src, 'class' => $class]);
        $return .= Html::endTag('picture');

        return $return;
    }
}