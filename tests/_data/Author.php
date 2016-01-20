<?php

namespace data;

use Yii;
use data\Book;

/**
 * This is the model class for table "author".
 *
 * @property integer $id
 * @property string $name
 */
class Author extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'author';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 150]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

//    public function getAuthorBook()
//    {
//        return $this->hasOne(Book::className(), ['id' => 'book_id'])
//            ->viaTable('book_has_author', ['author_id' => 'id']);
//    }

    public function getBook()
    {
        return $this->hasOne(Book::className(), ['id' => 'author_id'])
            ->viaTable('book_has_author', ['book_id' => 'id']);
    }
}
