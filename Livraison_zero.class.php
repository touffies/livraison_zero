<?php
/*************************************************************************************/
/*                                                                                   */
/*      Module de Transport pour Thelia	                                             */
/*                                                                                   */
/*      Copyright (c) Openstudio 		                                     		 */
/*      Développement : Christophe LAFFONT		                                     */
/*		email : claffont@openstudio.fr	        	                             	 */
/*      web : http://www.openstudio.fr					   							 */
/*                                                                                   */
/*      This program is free software; you can redistribute it and/or modify         */
/*      it under the terms of the GNU General Public License as published by         */
/*      the Free Software Foundation; either version 2 of the License, or            */
/*      (at your option) any later version.                                          */
/*                                                                                   */
/*      This program is distributed in the hope that it will be useful,              */
/*      but WITHOUT ANY WARRANTY; without even the implied warranty of               */
/*      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                */
/*      GNU General Public License for more details.                                 */
/*                                                                                   */
/*      You should have received a copy of the GNU General Public License            */
/*      along with this program; if not, write to the Free Software                  */
/*      Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA    */
/*                                                                                   */
/*************************************************************************************/

// Classes de Thelia
include_once __DIR__ . "/../../../classes/PluginsTransports.class.php";


/**
 * Class Livraison_zero
 *
 * Cette classe ajout un nouveau mode de livraison. Elle permet, entre autres, à certain plugin d'annuler les frais de livraison.
 */
class Livraison_zero extends PluginsTransports {

    const MODULE = "livraison_zero";

    /**
     * Constructeur
     *
     * @param int/null $id Possibilité de passer un identifiant pour charger un objet Prepayment_livraison
     */
    function __construct()
    {
        parent::__construct(self::MODULE);
    }

    /**
     * Initialisation du plugin
     *
     * @return none
     */
	function init()
    {

        $this->ajout_desc("Pas de livraison", "livraison_zero", "Plugin permettant de ne pas avoir de frais de livraison.", 1);

        // On associe à une ZONE
        $mod = new Modules();
        $mod->charger(self::MODULE);

        $zone = new Zone();
        $res_zone = $zone->query("SELECT * FROM $zone->table");
        while($res_zone && $row = $this->fetch_object($res_zone)) {
            $transzone = new Transzone();
            $transzone->transport = $mod->id;
            $transzone->zone = $row->id;
            $transzone->add();
        }
	}

    /**
     * Méthode utilisée pour le calcul des frais de livraison
     *
     * @return int  Aucun frais de transport
     */
	function calcule()
    {
		return 0;
	}
}
?>