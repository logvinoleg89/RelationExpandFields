Yii2 RelationExpandFields Behavior
========================
COMPOSER
"logvin/yii2-relation-expand-fields-behavior": "dev-master"

CREATE ActiveRecord
<?php
namespace common\overrides\rest;
use Yii;
use yii\rest\Serializer;
use yii\helpers\ArrayHelper;
use logvin\behaviors\RelationExpandFields;
use yii\db\ActiveRecord as BaseActiveRecord;
class ActiveRecord extends BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'RelationExpandFields' => [
                'class' => RelationExpandFields::className(),
                //'expandName' => 'Post',
            ],
        ];
    }

    public function fields()
    {
        $fields = array_merge(
            parent::fields(),
            $this->getNewFields()
        );

        return $fields;
    }
}





USAGE
?expand=images,categories,Post:categories|tags 
images,categories in all models
categories,tags in Post model

// add extra fields
	function (){
		this.addExpand = function (expandParams){
			this.on('before-request', function(_req) {
				if(!expandParams || !expandParams.length){
					return false;
				}

				var expandParamArr = [];
				angular.forEach(expandParams, function(expandParam, i){
					if(angular.isObject(expandParam)){
						angular.forEach(expandParam, function(el, key){
							var keyExpandParam = Object.keys(expandParam)[0];
							expandParamArr.push(key + ":" + expandParam[key].join('|'));
						});
					} else {
						expandParamArr.push(expandParam);
					}
				});

				_req.params = _req.params || {};
				if(_req.params.expand){
					_req.params.expand = _req.params.expand.split(',').concat(expandParamArr).join(',');
				}else{
					_req.params.expand = expandParamArr.join(',');
				}
			});
		};
	},
