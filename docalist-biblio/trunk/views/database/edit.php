<?php
/**
 * This file is part of the 'Docalist Biblio' plugin.
 *
 * Copyright (C) 2012, 2013 Daniel Ménard
 *
 * For copyright and license information, please view the
 * LICENSE.txt file that was distributed with this source code.
 *
 * @package     Docalist
 * @subpackage  Biblio
 * @author      Daniel Ménard <daniel.menard@laposte.net>
 * @version     $Id$
 */
namespace Docalist\Biblio\Views;

use Docalist\Biblio\DatabaseSettings;
use Docalist\Forms\Form;

/**
 * Edite les paramètres d'un base de données.
 *
 * @param DatabaseSettings $database La base à éditer.
 * @param int $dbindex L'index de la base.
 */
?>
<div class="wrap">
    <?= screen_icon() ?>
    <h2><?= __('Paramètres de la base', 'docalist-biblio') ?></h2>

    <p class="description">
        <?= __('Utilisez le formulaire ci-dessous pour modifier les paramètres de votre base :', 'docalist-biblio') ?>
    </p>

    <?php
        $form = new Form('', 'post');
        $form->input('name')->attribute('class', 'regular-text');
        $form->input('label')->attribute('class', 'regular-text');
        $form->textarea('description')->attribute('rows', '2')->attribute('class', 'large-text');
        $form->input('slug')->attribute('class', 'regular-text');
        $form->submit(__('Enregistrer les modifications', 'docalist-search'));

        $form->bind($database)->render('wordpress');
    ?>
</div>