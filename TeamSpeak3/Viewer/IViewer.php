<?php

/**
 * @file
 * TeamSpeak 3 PHP Framework
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package   TeamSpeak3
 * @author    Sven 'ScP' Paulsen
 * @copyright Copyright (c) Planet TeamSpeak. All rights reserved.
 */

        
namespace TeamSpeak3\Viewer;

use TeamSpeak3\Node\AbstractNode;


/**
 * @class 
 * @brief Interface class describing a TeamSpeak 3 viewer.
 */
interface 
{
  /**
   * Returns the code needed to display a node in a TeamSpeak 3 viewer.
   *
   * @param   $node
   * @param  array $siblings
   * @return string
   */
  public function fetchObject( $node, array $siblings = array());
}
