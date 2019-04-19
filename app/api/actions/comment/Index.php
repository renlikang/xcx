<?php
/**
 * @author rlk
 */

namespace api\actions\comment;

use api\actions\BaseAction;

class Index extends BaseAction
{
    public function run($articleId)
    {
        return $articleId;
    }
}