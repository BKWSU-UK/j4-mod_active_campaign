<?php
defined ( '_JEXEC' ) or die ();

use Joomla\CMS\Factory;

$document = Factory::getApplication()->getDocument();
$document->addStyleDeclaration("#_form_".$formId."_ { margin:0 !important;padding:0 !important;}".$styleOverride);
echo $form;