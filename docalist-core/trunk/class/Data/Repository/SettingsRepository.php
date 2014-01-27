<?php
/**
 * This file is part of a "Docalist Core" plugin.
 *
 * For copyright and license information, please view the
 * LICENSE.txt file that was distributed with this source code.
 *
 * @package Docalist
 * @subpackage Core
 * @author Daniel Ménard <daniel.menard@laposte.net>
 * @version SVN: $Id$
 */
namespace Docalist\Data\Repository;

use Docalist\Data\Entity\EntityInterface;
use Docalist\Data\Entity\AbstractSettingsEntity;

/**
 * Un dépôt permettant de stocker des entités Settings dans la table wp_options
 * de WordPress.
 *
 * Remarques :
 *
 * - Les Settings sont enregistrés en json dans la table wp_options de wordpress.
 *
 * - Pour charger un enregistrement, il faut obligatoirement indiquer le nom
 * de la classe à instancier et celle-ci doit hériter de la classe
 * SettingsEntity.
 *
 * - Pour enregistrer une entité, celle-ci doit obligatoirement avoir un ID (le
 * nom de l'option wordpress)
 */
class SettingsRepository extends AbstractRepository {
    /**
     * Crée un nouveau dépôt.
     *
     * @param string $postType Le nom du custom post type.
     */
    public function __construct() {
        parent::__construct('Docalist\Data\Entity\AbstractSettingsEntity');
    }

    public function load($entity, $type = null) {
        // Vérifie qu'on a un clé
        $primaryKey = $this->checkPrimaryKey($entity, true);

        // Récupère les options stockées dans la base
        $data = get_option($primaryKey);

        // Décode les données
        $data = json_decode($data, true);

        // Type = false permet de récupérer les données brutes
        if ($type === false) {
            return $data;
        }

        // Par défaut, on retourne une entité du même type que le dépôt
        if (is_null($type)) {
            $type = $this->type;
        }

        // Sinon le type demandé doit être compatible avec le type du dépôt
        else {
            $this->checkType($type);
        }

        // Crée une entité du type demandé
        $entity = new $type($data);
        $entity->primaryKey($primaryKey);

        return $entity;
    }

    public function store(EntityInterface $entity) {
        // Vérifie que l'entité est du bon type
        $this->checkType($entity);

        // Pour un dépôt Settings, l'entité doit obligatoirement avoir une clé
        $primaryKey = $this->checkPrimaryKey($entity, true);

        // Enregistre les données de l'entité en json
        $data = json_encode($entity, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        update_option($primaryKey, $data);
    }

    public function delete($entity) {
        // L'entité doit obligatoirement avoir un ID
        $primaryKey = $this->checkPrimaryKey($entity, true);

        delete_option($primaryKey);
    }
}