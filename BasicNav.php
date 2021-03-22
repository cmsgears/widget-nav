<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\widgets\nav;

// Yii Imports
use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\Html;

/**
 * Nav widget show the menu.
 *
 * @since 1.0.0
 */
class BasicNav extends \cmsgears\core\common\base\Widget {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

    public $items   = [];
    public $options = [];

	public $label	= true;
	public $icon	= false;

	// TODO: Use route and params where required.
    public $route;
    public $params;

	// Protected --------------

	// Private ----------------

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

    public function init() {

        parent::init();

        if( $this->route === null && Yii::$app->controller !== null ) {

            $this->route = Yii::$app->controller->getRoute();
        }

        if( $this->params === null ) {

            $this->params = Yii::$app->request->getQueryParams();
        }
    }

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Widget

    public function run() {

        return $this->renderWidget();
    }

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

    public function renderWidget( $config = [] ) {

        $items = [];

        foreach( $this->items as $i => $item ) {

            $items[] = $this->renderItem( $item );
        }

        return Html::tag( 'ul', implode( "\n", $items ), $this->options );
    }

	// BasicNav ------------------------------

    public function renderItem( $item ) {

        $label      = null;
        $url        = isset( $item[ 'url' ] ) ? $item[ 'url' ] : null;
		$urlOptions	= isset( $item[ 'urlOptions' ] ) ? $item[ 'urlOptions' ] : null;
        $options    = [];

		// Check whether label is required
		if( $this->label ) {

	        if( !isset( $item[ 'label' ] ) ) {

	            throw new InvalidConfigException( "The 'label' option is required." );
	        }

	        $label = $item[ 'label' ];
		}

		// Check whether icon is required
		if( $this->icon ) {

	        if( !isset( $item[ 'icon' ] ) ) {

	            throw new InvalidConfigException( "The 'icon' option is required." );
	        }

			$icon	= Html::tag( 'i', null, [ 'class' =>  $item[ 'icon' ] ] );
			$label	= "<span class='wrap-icon'>$icon</span><span class='wrap-text'>$label</span>";
		}

		if( isset( $item[ 'options' ] ) ) {

			$options = $item[ 'options' ];
		}

		if( !empty( $url ) ) {

			$link = Html::a( $label, $url, $urlOptions );
		}
		else {

			$link = Html::tag( 'span', $label, $urlOptions );
		}

		// Custom Links
		if( isset( $options[ 'action' ] ) ) {

			$urlOptions[ 'link' ] = $url;

			$link = Html::tag( 'span', $label, $urlOptions );
		}

		// Custom HTML
		if( isset( $options[ 'html' ] ) ) {

			$link = $options[ 'html' ];

			unset( $options[ 'html' ] );
		}

        return Html::tag( 'li', $link, $options );
    }

}
