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

use Docalist\Forms\Input;

/**
 * Le titre de la notice.
 */
class Title extends String {
    public function editForm() {
        $field = new Input($this->schema->name());
        $field->addClass('large-text');//->attribute('id', 'DocTitle');

        return $field;
    }
}