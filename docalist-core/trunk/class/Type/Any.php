<?php
/**
 * This file is part of a "Docalist Core" plugin.
 *
 * Copyright (C) 2012-2014 Daniel Ménard
 *
 * For copyright and license information, please view the
 * LICENSE.txt file that was distributed with this source code.
 *
 * @package     Docalist
 * @subpackage  Core
 * @author      Daniel Ménard <daniel.menard@laposte.net>
 * @version     SVN: $Id$
 */
namespace Docalist\Type;

use Docalist\Schema\Schema;
use Serializable, JsonSerializable;

/*
 * Inspiration : https://github.com/nicolopignatelli/valueobjects
 */

/**
 * Classe de base pour les différents types de données.
 */
class Any implements Serializable, JsonSerializable {
    /**
     * La valeur du type.
     *
     * @var mixed
     */
    protected $value;

    /**
     * Le schéma du type.
     *
     * @var Schema
     */
    protected $schema;

    /**
     * La valeur par défaut du type.
     *
     * Cette valeur n'est utilisée que si le type n'a pas de schéma (si on a
     * un schéma, defaultValue() retourne la valeur par défaut indiquée dans
     * le schéma).
     *
     * @var mixed
     */
    static protected $default = null;

    /**
     * Indentation en cours, utilisé uniquement pour __toString().
     *
     * @var string
     */
    static protected $indent ='';

    /**
     * Crée un nouveau type.
     *
     * @param mixed $value La valeur initiale. Pour les scalaires, vous devez
     * passer un type php natif correspondant au type de l'objet (int, bool,
     * float, ...) Pour les types structurés et les collections, vous devez
     * passer un tableau.
     * @param Schema $schema Optionnel, le schéma du type.
     */
    public function __construct($value = null, Schema $schema = null) {
        $this->schema = $schema;
        $this->assign(is_null($value) ? $this->defaultValue() : $value);
    }

    /**
     * Retourne la valeur par défaut du type.
     *
     * @return mixed
     */
    public function defaultValue() {
        return $this->schema ? $this->schema->defaultValue() : static::$default;
    }

    /**
     * Assigne une valeur au type.
     *
     * @param mixed $value La valeur à assigner.
     *
     * @return self $this
     */
    public function assign($value) {
        $this->value = $value;

        return $this;
    }

    /**
     * Retourne la valeur sous la forme d'un type php natif (string, int, float
     * ou bool pour les types simples, un tableau pour les types structurés et
     * les collections).
     *
     * @return mixed
     */
    public function value() {
        return $this->value;
    }

    /**
     * Réinitialise le type à sa valeur par défaut.
     *
     * @return self $this
     */
    public function reset() {
        return $this->assign($this->defaultValue());
    }

    /**
     * Retourne le schéma du type.
     *
     * @return Schema le schéma ou null si le type n'a pas de schéma associé.
     */
    public function schema() {
        return $this->schema;
    }

    /**
     * Teste si deux types sont identiques.
     *
     * Par défaut, les types sont identiques si ils ont la même classe et
     * la même valeur.
     *
     * @param Any $other
     *
     * @return boolean
     */
    public function equals(Any $other) {
        return get_class($this) === get_class($other) && $this->value() === $other->value();
    }

    /**
     * Retourne une représentation de la valeursous forme de chaine de
     * caractères.
     *
     * @return string
     */
    public function __toString() {
        return json_encode($this->value, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    /**
     * Sérialise la valeur (implémentation de l'interface Serializable).
     *
     * @return string
     */
    public function serialize() {
        return serialize($this->value());
    }

    /**
     * Désérialise le type (implémentation de l'interface Serializable).
     *
     * @param string $serialized
     */
    public function unserialize($serialized) {
        $this->assign(unserialize($serialized));
    }

    /**
     * Spécifie les données qui doivent être sérialisées en JSON
     * (implémentation de l'interface JsonSerializable).
     *
     * @return mixed
     */
    public function jsonSerialize () {
        return $this->value();
    }
//+is ?

    /**
     * Retourne le nom de classe du type.
     *
     * @param bool $namespaced Indique s'il faut ou non inclure le namespace
     * (true par défaut).
     *
     * @return string Retourne le nom de classe complet (incluant le namespace)
     * si $namespaced est à true), le nom court (sans namespace) sinon.
     */
    public static function className($namespaced = true) {
        if ($namespaced) {
            return get_called_class();
        }

        $class = get_called_class();
        $pt = strrpos($class, '\\');
        return $pt === false ? $class : substr($class, $pt + 1);
    }

    /**
     * Retourne le namespace de la classe du type.
     *
     * @return string Le namespace de la classe ou une chaine vide s'il s'agit
     * d'une classe globale.
     */
    public static function ns() {
        $class = get_called_class();
        $pt = strrpos($class, '\\');
        return $pt === false ? '' : substr($class, 0, $pt);
    }
}