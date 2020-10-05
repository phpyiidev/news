<?php

namespace app\controllers\api;

/**
* This is the class for REST controller "RubricsController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class RubricsController extends \yii\rest\ActiveController
{
public $modelClass = 'app\models\Rubrics';
}
