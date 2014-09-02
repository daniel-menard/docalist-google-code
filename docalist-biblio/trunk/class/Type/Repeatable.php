<?php
/**
 * This file is part of the 'Docalist Biblio' plugin.
 *
 * Copyright (C) 2012-2014 Daniel Ménard
 *
 * For copyright and license information, please view the
 * LICENSE.txt file that was distributed with this source code.
 *
 * @package     Docalist
 * @subpackage  Biblio
 * @author      Daniel Ménard <daniel.menard@laposte.net>
 * @version     $Id$
 */
namespace Docalist\Biblio\Type;

/**
 * Type de base pour tous les champs répétables.
 */
class Repeatable extends \Docalist\Type\Collection implements BiblioField {
    use BiblioFieldTrait;

    public function map(array & $doc) {
        foreach($this->value as $item) { /* @var $item BiblioField */
            $item->map($doc);
        }
    }
}