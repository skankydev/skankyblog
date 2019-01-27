<?php 
$manager = SkankyDev\Factory::load('App\PermissionManager');

SkankyDev\Routing\Dispatcher::_setPermissionManager($manager);
//un jour peux etre ca sera utile d ecrire des truc ici 

SkankyDev\I18n\Localization::initGetText('fr');
//debug(getenv("LC_ALL"));
//debug(\ResourceBundle::getLocales());
//debug(\Locale::getDefault());
//debug(system('dir'));
//
