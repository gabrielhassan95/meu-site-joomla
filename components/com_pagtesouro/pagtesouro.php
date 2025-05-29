<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_pagtesouro
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\MVC\Model\BaseModel;

// Obtenha a aplicação
$app = Factory::getApplication();
$input = $app->input;

// Adicione o caminho para os modelos
BaseModel::addIncludePath(JPATH_COMPONENT . '/models');

// Verifique se é uma visualização raw
$view = $input->get('view', '', 'cmd');
$task = $input->get('task', '', 'cmd');

// Se for a view raw, deixe ela lidar com tudo
if ($view === 'raw') {
    // Carregue o controlador principal
    require_once JPATH_COMPONENT . '/controller.php';
    $controller = new PagTesouroController();
    $controller->execute($input->get('task', 'display'));
    $controller->redirect();
}
// Verificar se é uma tarefa AJAX específica
else if (strpos($task, 'formulario.get') === 0) {
    // É uma chamada AJAX, carregue o controlador específico
    require_once JPATH_COMPONENT . '/controllers/formulario.php';
    $controller = new PagTesouroControllerFormulario();
    
    // Executar a tarefa
    $controller->execute($task);
    
    // Não é necessário redirecionar, pois já fechamos a aplicação
    $controller->redirect();
} 
// Para requisições normais
else {
    // Carregue o controlador principal
    require_once JPATH_COMPONENT . '/controller.php';
    $controller = new PagTesouroController();
    $controller->execute($input->get('task', 'display'));
    $controller->redirect();
}