<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 05.11.2019
 * Time: 17:48
 */

namespace app\components\traits;


use Yii;

trait HeaderHelper
{

  /**
   * Записывает в заголовки значения пагинации
   * @param $pagination \yii\data\Pagination
   */
  public function setPaginationHeaders($pagination)
  {
    Yii::$app->response->headers->set('X-Pagination-Current-Page', $pagination->page);
    Yii::$app->response->headers->set('X-Pagination-Page-Count', $pagination->pageCount);
    Yii::$app->response->headers->set('X-Pagination-Per-Page', $pagination->pageSize);
    Yii::$app->response->headers->set('X-Pagination-Total-Count', $pagination->totalCount);
  }
}