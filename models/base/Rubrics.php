<?php
// Класс автоматически сгенерирован шаблонами giiant. Внесены необходимые правки в сгенерированный код.

namespace app\models\base;

use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * Класс базовой модели для таблицы "rubrics".
 *
 * @property integer $id Идентификационный код записи
 * @property string $name Наименование рубрики
 * @property integer|null $id_parent Код родителя рубрики
 * @property integer $created_by Время создания
 * @property integer $updated_by Время изменения
 * @property integer $created_at Кем создана
 * @property integer $updated_at Кем изменена
 *
 * @property \app\models\News[] $news Связь с новостями
 * @property \app\models\Rubrics $parent Родительская рубрика
 * @property \app\models\Rubrics[] $rubrics Дочернии рубрики
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
            // Поведение для сохранения информации о пользователе создавшим/изменившим запись
            ['class' => BlameableBehavior::className(),],
            // Поведение для сохранение времени создания/изменения записи
            ['class' => TimestampBehavior::className(),],
            // Поведение для упрощения взаимодействия со связью "многие ко многим", при сохранении/просмотре/изменении/удалении
            'saveRelations' => [
                'class'     => SaveRelationsBehavior::className(),
                'relations' => [
                    'news',
                ],
            ],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
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
            [['news'], 'safe'],
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNews()
    {
        return $this->hasMany(\app\models\News::className(), ['id' => 'id_new'])->viaTable('{{%news_rubrics}}', ['id_rubric' => 'id']);
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
