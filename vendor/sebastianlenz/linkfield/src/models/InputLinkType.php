<?php

namespace typedlinkfield\models;

use Craft;
use craft\base\ElementInterface;
use craft\helpers\Html;
use craft\validators\UrlValidator;
use Throwable;
use typedlinkfield\fields\LinkField;
use yii\base\Model;
use yii\validators\EmailValidator;

/**
 * Class InputLinkType
 */
class InputLinkType extends Model implements LinkTypeInterface
{
  /**
   * @var string
   */
  public $displayName;

  /**
   * @var string
   */
  public $displayGroup = 'Common';

  /**
   * @var string
   */
  public $inputType;

  /**
   * @var string
   */
  public $placeholder;


  /**
   * ElementLinkType constructor.
   *
   * @param string|array $displayName
   * @param array $options
   */
  public function __construct($displayName, array $options = []) {
    if (is_array($displayName)) {
      $options = $displayName;
    } else {
      $options['displayName'] = $displayName;
    }

    parent::__construct($options);
  }

  /**
   * @inheritDoc
   */
  public function getDefaultSettings(): array {
    return [
      'allowAliases'      => false,
      'disableValidation' => false,
    ];
  }

  /**
   * @inheritDoc
   */
  public function getDisplayName(): string {
    return Craft::t('typedlinkfield', $this->displayName);
  }

  /**
   * @inheritDoc
   */
  public function getDisplayGroup(): string {
    return Craft::t('typedlinkfield', $this->displayGroup);
  }

  /**
   * @inheritdoc
   */
  public function getElement(Link $link, $ignoreStatus = false) {
    return null;
  }

  /**
   * @inheritDoc
   */
  public function getInputHtml(string $linkTypeName, LinkField $field, Link $value, ElementInterface $element = null): string {
    $settings   = $field->getLinkTypeSettings($linkTypeName, $this);
    $isSelected = $value->type === $linkTypeName;
    $value      = $isSelected ? $value->value : '';

    $textFieldOptions = [
      'disabled' => $field->isStatic(),
      'id'       => $field->handle . '-' . $linkTypeName,
      'name'     => $field->handle . '[' . $linkTypeName . ']',
      'value'    => $value,
    ];

    if (isset($this->inputType) && !$settings['disableValidation']) {
      $textFieldOptions['type'] = $this->inputType;
    }

    if (isset($this->placeholder)) {
      $textFieldOptions['placeholder'] = Craft::t('typedlinkfield', $this->placeholder);
    }

    try {
      return Craft::$app->view->renderTemplate('typedlinkfield/_input-input', [
        'isSelected'       => $isSelected,
        'linkTypeName'     => $linkTypeName,
        'textFieldOptions' => $textFieldOptions,
      ]);
    } catch (Throwable $exception) {
      return Html::tag('p', Craft::t(
        'typedlinkfield',
        'Error: Could not render the template for the field `{name}`.',
        [ 'name' => $this->getDisplayName() ]
      ));
    }
  }

  /**
   * @param Link $link
   * @return null|string
   */
  public function getRawUrl(Link $link) {
    if ($this->isEmpty($link)) {
      return null;
    }

    $url = $link->value;
    $field = $link->getLinkField();

    if (!is_null($field)) {
      $settings = $field->getLinkTypeSettings($link->type, $this);
      if ($settings['allowAliases']) {
        $url = Craft::getAlias($url);
      }
    }

    return $url;
  }

  /**
   * @inheritDoc
   */
  public function getSettingsHtml(string $linkTypeName, LinkField $field): string {
    try {
      return Craft::$app->view->renderTemplate('typedlinkfield/_settings-input', [
        'settings'     => $field->getLinkTypeSettings($linkTypeName, $this),
        'elementName'  => $this->getDisplayName(),
        'linkTypeName' => $linkTypeName,
      ]);
    } catch (Throwable $exception) {
      return Html::tag('p', Craft::t(
        'typedlinkfield',
        'Error: Could not render the template for the field `{name}`.',
        [ 'name' => $this->getDisplayName() ]
      ));
    }
  }

  /**
   * @inheritDoc
   */
  public function getText(Link $link) {
    return null;
  }

  /**
   * @inheritDoc
   */
  public function getUrl(Link $link) {
    $url = $this->getRawUrl($link);
    if (is_null($url)) {
      return null;
    }

    switch ($this->inputType) {
      case('email'):
        return 'mailto:' . $url;
      case('tel'):
        return 'tel:' . $url;
      default:
        return $url;
    }
  }

  /**
   * @inheritdoc
   */
  public function hasElement(Link $link, $ignoreStatus = false): bool {
    return false;
  }

  /**
   * @inheritDoc
   */
  public function isEmpty(Link $link): bool {
    if (is_string($link->value)) {
      return trim($link->value) === '';
    }

    return true;
  }

  /**
   * @inheritDoc
   */
  public function readLinkValue($formData) {
    return is_string($formData) ? $formData : '';
  }

  /**
   * @inheritdoc
   */
  public function validateSettings(array $settings): array {
    return $settings;
  }

  /**
   * @inheritDoc
   */
  public function validateValue(LinkField $field, Link $link) {
    $value = $this->getRawUrl($link);
    if (is_null($value)) {
      return null;
    }

    $settings = $field->getLinkTypeSettings($link->type, $this);
    if ($settings['disableValidation']) {
      return null;
    }

    $enableIDN = (
      Craft::$app->getI18n()->getIsIntlLoaded() &&
      defined('INTL_IDNA_VARIANT_UTS46')
    );

    switch ($this->inputType) {
      case('email'):
        (new EmailValidator(['enableIDN' => $enableIDN]))->validate($value, $error);
        if (!is_null($error)) {
          return [$error, []];
        }
        break;

      case('tel'):
        $regexp = '/^[0-9+\(\)#\.\s\/ext-]+$/';
        if (!filter_var($value, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => $regexp)))) {
          return [Craft::t('typedlinkfield', 'Please enter a valid phone number.'), []];
        }
        break;

      case('url'):
        (new UrlValidator(['enableIDN' => $enableIDN]))->validate($value, $error);
        if (!is_null($error)) {
          return [$error, []];
        }
        break;
    }

    return null;
  }
}
