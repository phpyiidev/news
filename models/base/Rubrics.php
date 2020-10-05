<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the base-model class for table "rubrics".
 *
 * @property integer $id
 * @property string $name
 * @property integer $id_parent
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property \app\models\News[] $news
 * @property \app\models\Rubrics $parent
 * @property \app\models\Rubrics[] $rubrics
 * @property string $aliasModel
 */
abstract class Rubrics extends \yii\db\ActiveRecord
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rubrics';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => BlameableBehavior::className(),
            ],
            [
                'class' => TimestampBehavior::className(),
            ],
            /*[
                'class' => \voskobovich\behaviors\ManyToManyBehavior::className(),
                'relations' => [
                    'news_ids' => 'news',
                ],
            ],*/
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['id_parent'], 'integer'],
            [['name'], 'string', 'max' => 42],
            [['name'], 'unique'],
            [['id_parent'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Rubrics::className(), 'targetAttribute' => ['id_parent' => 'id']],
            //[['news_ids'], 'each', 'rule' => ['integer']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Код',
            'name' => 'Название',
            'id_parent' => 'Код родительской рубрики',
            'created_by' => 'Создал',
            'updated_by' => 'Изменил',
            'created_at' => 'Создано',
            'updated_at' => 'Изменено',
        ];
    }

    public function getNews()
    {
        return $this->hasMany(News::className(), ['id' => 'id_new'])
            ->viaTable('{{%news_rubrics}}', ['id_rubric' => 'id']);
    }

    public static function listAll($keyField = 'id', $valueField = 'name', $asArray = true)
    {
        $query = static::find();
        if ($asArray) {
            $query->select([$keyField, $valueField])->asArray();
        }

        return ArrayHelper::map($query->all(), $keyField, $valueField);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(\app\models\Rubrics::className(), ['id' => 'id_parent']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRubrics()
    {
        return $this->hasMany(\app\models\Rubrics::className(), ['id_parent' => 'id']);
    }


}