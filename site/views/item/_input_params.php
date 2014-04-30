<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 * @var yii\web\View $this
 * @var array $params
 */

use yii\helpers\Html;
?>
<?php foreach($params as $param):?>
    <div class="form-group input-params">
        <label class="col-md-3 control-label"><?=$param['name']?>:</label>
        <div class="col-md-9">
            <?php foreach($param['items'] as $value) {
                $isImage = isset($value['image']);
                echo Html::beginTag('a',[
                    'href' => $isImage ? $value['image'] : '#',
                    'rel' => 'preload',
                    'class' => 'input-property'.($isImage ? ' image':''),
                    'title' => $value['name'],
                    'data-pid' => $param['id'],
                    'data-vid' => $value['id']
                ]);
                if($isImage)
                    echo Html::img($value['image'].'_40x40.jpg',['alt'=>$value['name']]);
                else
                    echo Html::encode($value['name']);

                echo Html::endTag('a');
            }
            ?>
            <input type="hidden" name="<?=$param['id']?>" class="input-param" id="pid_<?=$param['id']?>" value="0">
        </div>
    </div>
<?php endforeach ?>