<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 * @var yii\web\View $this
 * @var array $params
 */
?>
<?php foreach($params as $param):?>
    <div class="form-group input-params">
        <label class="col-md-3 control-label"><?=$param['name']?>:</label>
        <div class="col-md-9">
            <?php foreach($param['items'] as $value):?>
                <a
                    href="<?=(isset($value->image)) ? $value->image : '#'?>"
                    rel="preload"
                    class="ofatbox-gallery input-property<?=
                    (isset($value->image)) ? ' image':''?>"
                    title="<?=$value['name']?>"
                    data-vid="<?=$value['id']?>"
                    data-pid="<?=$param['id']?>"
                    >
                    <?php if(isset($value->image)):?>
                        <img src="<?=$value->image?>_40x40.jpg" alt="<?=$value->name?>">
                    <?php else:?>
                        <?=$value['name']?>
                    <?php endif ?>
                </a>
            <?php endforeach ?>
            <input type="hidden" name="<?=$param['id']?>" class="input-param" id="pid_<?=$param['id']?>" data-vid="0" value="0">
        </div>
    </div>
<?php endforeach ?>