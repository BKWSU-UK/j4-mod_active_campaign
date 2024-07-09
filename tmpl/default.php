<?php
defined ( '_JEXEC' ) or die ();

use Joomla\CMS\Factory;

$document = Factory::getApplication()->getDocument();
$document->addStyleDeclaration($styleOverride);
echo $form;