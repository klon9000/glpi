<?php
/*
 * @version $Id$
 -------------------------------------------------------------------------
 GLPI - Gestionnaire Libre de Parc Informatique
 Copyright (C) 2003-2012 by the INDEPNET Development Team.

 http://indepnet.net/   http://glpi-project.org
 -------------------------------------------------------------------------

 LICENSE

 This file is part of GLPI.

 GLPI is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 GLPI is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with GLPI. If not, see <http://www.gnu.org/licenses/>.
 --------------------------------------------------------------------------
 */

// ----------------------------------------------------------------------
// Original Author of file: Remi Collet
// Purpose of file:
// ----------------------------------------------------------------------

if (!defined('GLPI_ROOT')) {
   die("Sorry. You can't access directly to this file");
}

/// Class Manufacturer
/// @TODO study if we should integrate getHTMLTableHeader and getHTMLTableCellsForItem ...
class Manufacturer extends CommonDropdown {


   static function getTypeName($nb=0) {
      return _n('Manufacturer', 'Manufacturers', $nb);
   }


   /**
    * @param $old_name
   **/
   static function processName($old_name) {

      if ($old_name == null) {
         return $old_name;
      }

      $rulecollection = new RuleDictionnaryManufacturerCollection();
      $output         = array();
      $output         = $rulecollection->processAllRules(array("name" => addslashes($old_name)),
                                                         $output, array());
      if (isset($output["name"])) {
         return $output["name"];
      }
      return $old_name;
   }


   function cleanDBonPurge() {

      // Rules use manufacturer intread of manufacturers_id
      Rule::cleanForItemAction($this, 'manufacturer');
   }


   /**
    * @since version 0.84
    *
    * @param $itemtype
    * @param $base                  HTMLTable_Base object
    * @param $super                 HTMLTable_SuperHeader object (default NULL)
    * @param $father                HTMLTable_Header object (default NULL)
    * @param $options      array
   **/
   static function getHTMLTableHeader($itemtype, HTMLTable_Base $base,
                                      HTMLTable_SuperHeader $super=NULL,
                                      HTMLTable_Header $father=NULL, $options=array()) {

      $column_name = __CLASS__;

      if (isset($options['dont_display'][$column_name])) {
         return;
      }

      $base->addHeader($column_name, __('Manufacturer'), $super, $father);
   }


   /**
    * @since version 0.84
    *
    * @param $row                HTMLTable_Row object
    * @param $item               CommonDBTM object (default NULL)
    * @param $father             HTMLTable_Cell object (default NULL)
    * @param $options   array
   **/
   static function getHTMLTableCellsForItem(HTMLTable_Row $row, CommonDBTM $item=NULL,
                                            HTMLTable_Cell $father=NULL,
                                            array $options = array()) {

      $column_name = __CLASS__;

      if (isset($options['dont_display'][$column_name])) {
         return;
      }

      if (!empty($item->fields["manufacturers_id"])) {
         $row->addCell($row->getHeaderByName($column_name),
                       Dropdown::getDropdownName("glpi_manufacturers",
                                                 $item->fields["manufacturers_id"]),
                       $father);
      }
   }

}
?>
