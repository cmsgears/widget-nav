<?php
namespace cmsgears\widgets\nav;

use \Yii;
use yii\base\Widget;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class BasicNav extends Widget {

	// Variables ---------------------------------------------------

	// Public Variables --------------------

    public $items   = [];
    public $options = [];

	public $label	= true;
	public $icon	= false;

	// TODO: Use route and params where required.
    public $route;
    public $params;

	// Constructor and Initialisation ------------------------------

	// yii\base\Object

    public function init() {

        parent::init();

        if( $this->route === null && Yii::$app->controller !== null ) {

            $this->route = Yii::$app->controller->getRoute();
        }

        if( $this->params === null ) {

            $this->params = Yii::$app->request->getQueryParams();
        }
    }

	// Instance Methods --------------------------------------------

	// yii\base\Widget

    public function run() {

        return $this->renderItems();
    }

	// Nav

    public function renderItems() {

        $items = [];

        foreach( $this->items as $i => $item ) {

            $items[] = $this->renderItem( $item );
        }

        return Html::tag( 'ul', implode( "\n", $items ), $this->options );
    }

    public function renderItem( $item ) {

        $label      = null;
        $url        = $item[ 'url' ];
		$urlOptions	= isset( $item[ 'urlOptions' ] ) ? $item[ 'urlOptions' ] : null;
        $options    = [];

		// Check whether label is required
		if( $this->label ) {

	        if( !isset( $item['label'] ) ) {

	            throw new InvalidConfigException( "The 'label' option is required." );
	        }

	        $label      = $item['label'];
		}

		// Check whether icon is required
		if( $this->icon ) {

	        if( !isset( $item['icon'] ) ) {

	            throw new InvalidConfigException( "The 'icon' option is required." );
	        }

			$label	= Html::tag( 'i', null, [ 'class' =>  $item['icon'] ] ) . $label;
		}

		if( isset( $item['options'] ) ) {

			$options = $item['options'];
		}

        return Html::tag( 'li', Html::a( $label, $url, $urlOptions ), $options );
    }
}

?>