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
namespace Docalist\Biblio\Entity\Reference;

use Docalist\Biblio\Type\Repeatable;
use Docalist\Biblio\Type\SettingsFormTrait;
use Docalist\Forms\Table;

/**
 * Une collection d'étendues.
 */
class Extents extends Repeatable {
    use SettingsFormTrait;

    static protected $type = 'Extent';

    public function editForm() {
        $field = new Table($this->schema->name());
        $field->TableLookup('type', $this->schema->table())
              ->addClass('extent-type');
        $field->input('value')->addClass('extent-value');

        return $field;
    }

    public function settingsForm() {
        $form = parent::settingsForm();
        $form->select('table')
             ->label(__("Table des types d'étendues", 'docalist-biblio'))
             ->options($this->tablesOfType('extent'));

        return $form;
    }
}