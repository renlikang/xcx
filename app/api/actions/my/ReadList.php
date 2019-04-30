<?php
/**
 * @author rlk
 */

namespace api\actions\my;


use api\actions\BaseAction;
use common\models\content\ArticleModel;
use common\models\content\UserReadRecordModel;
use common\services\RetCode;
use Yii;
use yii\data\Pagination;

class ReadList extends BaseAction
{
    public function run()
    {
        $page = Yii::$app->request->get('page');
        $size = Yii::$app->request->get('size');
        $uid = Yii::$app->user->id;
        $model = UserReadRecordModel::find()->where(['uid' => $uid, 'status' => 2])->orderBy('cTime desc');
        $modelClone = clone $model;
        $total = (int)$modelClone->count();
        $pages = new Pagination(['totalCount' => $total, 'pageSize' => $size]);
        $pages->setPage($page - 1);
        $offset = $pages->offset;
        /** @var UserReadRecordModel[] $userReadRecordModel */
        $userReadRecordModel = $model->offset($offset)->limit($pages->pageSize)->all();
        $ret = [];
        $data = [];
        foreach ($userReadRecordModel as $k => $v) {
            $ret[] = ArticleModel::findOne($v->articleId);
        }

        $data['list'] = $ret;
        $data['page'] = $page;
        $data['size'] = $size;
        $data['total'] = $total;
        return RetCode::response(200, $data);
    }
}