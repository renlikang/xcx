<?php
/**
 * @author rlk
 */

namespace api\actions\comment;

use api\actions\BaseAction;
use Yii;

class Index extends BaseAction
{
    public function run()
    {
        $articleId = Yii::$app->request->get('articleId');
        return $articleId;
    }
}