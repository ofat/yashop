<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace site\modules\cabinet;

use Yii;
use yii\web\Controller;

class CabinetController extends Controller
{

    public $cabinetLayout = '/layouts/cabinet';

    /*
     * Output content with cabinet part layout, such as cabinet menu
     * @inheritdoc
     */
    function render($view, $params = [])
    {
        $output = $this->getView()->render($view, $params, $this);
        $cabinetOutput = $this->getView()->render($this->cabinetLayout, ['content' => $output], $this);
        $layoutFile = $this->findLayoutFile($this->getView());
        if ($layoutFile !== false) {
            return $this->getView()->renderFile($layoutFile, ['content' => $cabinetOutput], $this);
        } else {
            return $cabinetOutput;
        }
    }

}