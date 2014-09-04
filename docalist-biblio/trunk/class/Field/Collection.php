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
namespace Docalist\Biblio\Field;

use Docalist\Biblio\Type\Object;
use Docalist\Schema\Field;

/**
 * Collection et numéro au sein de la collection.
 *
 * @property String $name
 * @property String $number
 */
class Collection extends Object {
    static protected function loadSchema() {
        // @formatter:off
        return [
            'fields' => [
                'name' => [
                    'label' => __("Nom", 'docalist-biblio'),
                    'description' => __('Nom de la collection ou de la sous-collection.', 'docalist-biblio'),
                ],
                'number' => [
                    'label' => __('Numéro', 'docalist-biblio'),
                    'description' => __('Numéro au sein de la collection ou de la sous-collection.', 'docalist-biblio'),
                ]
            ]
        ];
        // @formatter:on
    }

    public function map(array & $doc) {
        $doc['collection'][] = $this->name();
    }

    public static function ESmapping(array & $mappings, Field $schema) {
        $mappings['properties']['collection'] = self::stdIndex();
    }
}