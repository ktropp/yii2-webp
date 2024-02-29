<?php

namespace ktropp\yii2webp;

use yii\base\Widget;
use yii\helpers\Html;
use Yii;

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
        $imgSize = [];
        if(is_file(Yii::getAlias('@webroot') . $this->src))
            $size = @getimagesize(Yii::getAlias('@webroot') . $this->src);
        if(isset($size[0]))
            $imgSize['width'] = $size[0];
        if(isset($size[1]))
            $imgSize['height'] = $size[1];
        $return = Html::beginTag('picture');
        if (!empty($this->_webp)) {
            $return .= Html::tag('source', '', [$srcset => $this->_webp, 'type' => 'image/webp']);
        }
        $return .= Html::tag('img', '', array_merge([$src => $this->src, 'class' => $class], $imgSize, $this->options));
        $return .= Html::endTag('picture');

        return $return;
    }
}