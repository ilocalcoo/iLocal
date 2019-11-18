<?php
namespace app\modules\api\controllers\actions;

use yii\rest\ViewAction;

class UserViewAction extends ViewAction
{
    /**
     * Displays a model.
     * @param string $id the primary key of the model.
     * @return \yii\db\ActiveRecordInterface the model being displayed
     */
    public function run($id)
    {
        $model = $this->findModel($id);
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, $model);
        }

        $model->shops = $this->deleteDeleted($model->shops, true);
        $model->enets = $this->deleteDeleted($model->enets);
        $model->happenings = $this->deleteDeleted($model->happenings);

        return $model;
    }

    private function deleteDeleted($items, $shop = false) {
        foreach ($items as $key => $item) {
            if ($item[$shop ? 'shopActive' : 'active'] != 1) {
                unset($items[$key]);
            }
        }

        return $items;
    }
}