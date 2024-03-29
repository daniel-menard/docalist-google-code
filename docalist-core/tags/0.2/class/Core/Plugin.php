<?php
/**
 * This file is part of a "Docalist Core" plugin.
 *
 * For copyright and license information, please view the
 * LICENSE.txt file that was distributed with this source code.
 *
 * @package     Docalist
 * @subpackage  Core
 * @author      Daniel Ménard <daniel.menard@laposte.net>
 * @version     SVN: $Id$
 */

namespace Docalist\Core;
use Docalist;

/**
 * Plugin core de Docalist.
 */
class Plugin extends AbstractPlugin {
    /**
     * {@inheritdoc}
     *
     * Pour qu'il soit chargé en premier, le plugin Docalist-core a un nom de
     * répertoire un peu spécial (docalist-0core) et par défaut, c'est ce nom
     * qui devrait être utilisé comme domaine pour les traductions.
     *
     * En surchargeant cette méthode, on indique le bon domaine : docalist-core.
     */
    public function domain() {
        return 'docalist-core';
    }


    /**
     * {@inheritdoc}
     */
    public function tools() {
        return array(new Tools\PhpInfo);
    }


    /**
     * Crée dans Wordpress les pages "Outils Docalist" et "Options Docalist".
     *
     * @return AbstractPlugin $this;
     */
    protected function setupAdminPages() {

        // Crée la page "Outils Docalist" en utilisant directement Wordpress
        add_action('admin_menu', function() {
            $menu = 'tools.php';
            $name = __('Outils Docalist', 'docalist-core');
            $slug = 'docalist-tools';
            $role = 'manage_options';

            add_submenu_page($menu, $name, $name, $role, $slug, function() {
                if (isset($_REQUEST['t'])) {
                    $tool = Docalist::tool($_REQUEST['t']);
                    $back = sprintf('<a href="%s" style="float:right">%s</a>', menu_page_url('docalist-tools', false), __('Retour à la liste', 'docalist-core'));
                } else {
                    $tool = new Tools\ToolsList();
                    $back = '';
                }

                echo '<div class="wrap">';
                screen_icon();
                echo '<h2>', $back, $tool->name(), '</h2>';
                $tool->run();
                echo '</div>';
            });
        });

        // Crée la page "Options Docalist" en utilisant Piklist
        add_action('piklist_admin_pages', function($pages) {
            $pages[] = array(
                /* translators: Title of the settings page */
                'page_title' => __('Options Docalist', 'docalist-core'),

                // Libellé de l'option dans le menu
                'menu_title' => 'Docalist',

                // Nom du menu auquel va être rattachée la page
                'sub_menu' => 'options-general.php',

                // Droit nécessaire pour pouvoir accéder à cette page
                'capability' => 'manage_options',

                // Slug de la page
                'menu_slug' => 'docalist-options',

                // ID de l'icone à utiliser à droite du titre de la page
                // (cf. doc dans docalist-core/parts/admin-pages/tools.php)
                'icon' => 'options-general',

                // Nom de l'option qui sera enregistrée dans la table wp_options
                // C'est également le nom que les meta boxes (/parts/settings)
                // doivent indiquer dans l'entête de fichier (clé Setting).
                'setting' => 'docalist-options',

                // Nom de l'onglet par défaut
                // 'default_tab' => 'General'

                'single_line' => false,
            );

            return $pages;

        });

        return parent::setupAdminPages();

    }


}
