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

        
namespace TeamSpeak3\Helper\Signal;

use TeamSpeak3\Adapter\AbstractAdapter;
use TeamSpeak3\Adapter\ServerQuery\Event;
use TeamSpeak3\Adapter\ServerQuery\Reply;
use TeamSpeak3\Node\Host;
use TeamSpeak3\Ts3Exception;
use TeamSpeak3\Adapter\FileTransfer;
use TeamSpeak3\Node\Server;


/**
 * @class _Interface
 * @brief Interface class describing the layout for  callbacks.
 */
interface _Interface
{
  /**
   * Possible callback for '<adapter>Connected' signals.
   *
   * === Examples ===
   *   - ::getInstance()->subscribe("serverqueryConnected", array($object, "onConnect"));
   *   - ::getInstance()->subscribe("filetransferConnected", array($object, "onConnect"));
   *
   * @param   $adapter
   * @return void
   */
  public function onConnect( $adapter);

  /**
   * Possible callback for '<adapter>Disconnected' signals.
   *
   * === Examples ===
   *   - ::getInstance()->subscribe("serverqueryDisconnected", array($object, "onDisconnect"));
   *   - ::getInstance()->subscribe("filetransferDisconnected", array($object, "onDisconnect"));
   *
   * @return void
   */
  public function onDisconnect();

  /**
   * Possible callback for 'serverqueryCommandStarted' signals.
   *
   * === Examples ===
   *   - ::getInstance()->subscribe("serverqueryCommandStarted", array($object, "onCommandStarted"));
   *
   * @param  string $cmd
   * @return void
   */
  public function onCommandStarted($cmd);

  /**
   * Possible callback for 'serverqueryCommandFinished' signals.
   *
   * === Examples ===
   *   - ::getInstance()->subscribe("serverqueryCommandFinished", array($object, "onCommandFinished"));
   *
   * @param  string $cmd
   * @param   $reply
   * @return void
   */
  public function onCommandFinished($cmd,  $reply);

  /**
   * Possible callback for 'notifyEvent' signals.
   *
   * === Examples ===
   *   - ::getInstance()->subscribe("notifyEvent", array($object, "onEvent"));
   *
   * @param   $event
   * @param   $host
   * @return void
   */
  public function onEvent( $event,  $host);

  /**
   * Possible callback for 'notifyError' signals.
   *
   * === Examples ===
   *   - ::getInstance()->subscribe("notifyError", array($object, "onError"));
   *
   * @param   $reply
   * @return void
   */
  public function onError( $reply);

  /**
   * Possible callback for 'notifyServerselected' signals.
   *
   * === Examples ===
   *   - ::getInstance()->subscribe("notifyServerselected", array($object, "onServerselected"));
   *
   * @param   $host
   * @return void
   */
  public function onServerselected( $host);

  /**
   * Possible callback for 'notifyServercreated' signals.
   *
   * === Examples ===
   *   - ::getInstance()->subscribe("notifyServercreated", array($object, "onServercreated"));
   *
   * @param   $host
   * @param  integer $sid
   * @return void
   */
  public function onServercreated( $host, $sid);

  /**
   * Possible callback for 'notifyServerdeleted' signals.
   *
   * === Examples ===
   *   - ::getInstance()->subscribe("notifyServerdeleted", array($object, "onServerdeleted"));
   *
   * @param   $host
   * @param  integer $sid
   * @return void
   */
  public function onServerdeleted( $host, $sid);

  /**
   * Possible callback for 'notifyServerstarted' signals.
   *
   * === Examples ===
   *   - ::getInstance()->subscribe("notifyServerstarted", array($object, "onServerstarted"));
   *
   * @param   $host
   * @param  integer $sid
   * @return void
   */
  public function onServerstarted( $host, $sid);

  /**
   * Possible callback for 'notifyServerstopped' signals.
   *
   * === Examples ===
   *   - ::getInstance()->subscribe("notifyServerstopped", array($object, "onServerstopped"));
   *
   * @param   $host
   * @param  integer $sid
   * @return void
   */
  public function onServerstopped( $host, $sid);

  /**
   * Possible callback for 'notifyServershutdown' signals.
   *
   * === Examples ===
   *   - ::getInstance()->subscribe("notifyServershutdown", array($object, "onServershutdown"));
   *
   * @param   $host
   * @return void
   */
  public function onServershutdown( $host);

  /**
   * Possible callback for 'notifyLogin' signals.
   *
   * === Examples ===
   *   - ::getInstance()->subscribe("notifyLogin", array($object, "onLogin"));
   *
   * @param   $host
   * @return void
   */
  public function onLogin( $host);

  /**
   * Possible callback for 'notifyLogout' signals.
   *
   * === Examples ===
   *   - ::getInstance()->subscribe("notifyLogout", array($object, "onLogout"));
   *
   * @param   $host
   * @return void
   */
  public function onLogout( $host);

  /**
   * Possible callback for 'notifyTokencreated' signals.
   *
   * === Examples ===
   *   - ::getInstance()->subscribe("notifyTokencreated", array($object, "onTokencreated"));
   *
   * @param   $server
   * @param  string $token
   * @return void
   */
  public function onTokencreated( $server, $token);

  /**
   * Possible callback for 'filetransferHandshake' signals.
   *
   * === Examples ===
   *   - ::getInstance()->subscribe("filetransferHandshake", array($object, "onFtHandshake"));
   *
   * @param   $adapter
   * @return void
   */
  public function onFtHandshake( $adapter);

  /**
   * Possible callback for 'filetransferUploadStarted' signals.
   *
   * === Examples ===
   *   - ::getInstance()->subscribe("filetransferUploadStarted", array($object, "onFtUploadStarted"));
   *
   * @param  string  $ftkey
   * @param  integer $seek
   * @param  integer $size
   * @return void
   */
  public function onFtUploadStarted($ftkey, $seek, $size);

  /**
   * Possible callback for 'filetransferUploadProgress' signals.
   *
   * === Examples ===
   *   - ::getInstance()->subscribe("filetransferUploadProgress", array($object, "onFtUploadProgress"));
   *
   * @param  string  $ftkey
   * @param  integer $seek
   * @param  integer $size
   * @return void
   */
  public function onFtUploadProgress($ftkey, $seek, $size);

  /**
   * Possible callback for 'filetransferUploadFinished' signals.
   *
   * === Examples ===
   *   - ::getInstance()->subscribe("filetransferUploadFinished", array($object, "onFtUploadFinished"));
   *
   * @param  string  $ftkey
   * @param  integer $seek
   * @param  integer $size
   * @return void
   */
  public function onFtUploadFinished($ftkey, $seek, $size);

  /**
   * Possible callback for 'filetransferDownloadStarted' signals.
   *
   * === Examples ===
   *   - ::getInstance()->subscribe("filetransferDownloadStarted", array($object, "onFtDownloadStarted"));
   *
   * @param  string  $ftkey
   * @param  integer $buff
   * @param  integer $size
   * @return void
   */
  public function onFtDownloadStarted($ftkey, $buff, $size);

  /**
   * Possible callback for 'filetransferDownloadProgress' signals.
   *
   * === Examples ===
   *   - ::getInstance()->subscribe("filetransferDownloadProgress", array($object, "onFtDownloadProgress"));
   *
   * @param  string  $ftkey
   * @param  integer $buff
   * @param  integer $size
   * @return void
   */
  public function onFtDownloadProgress($ftkey, $buff, $size);

  /**
   * Possible callback for 'filetransferDownloadFinished' signals.
   *
   * === Examples ===
   *   - ::getInstance()->subscribe("filetransferDownloadFinished", array($object, "onFtDownloadFinished"));
   *
   * @param  string  $ftkey
   * @param  integer $buff
   * @param  integer $size
   * @return void
   */
  public function onFtDownloadFinished($ftkey, $buff, $size);

  /**
   * Possible callback for '<adapter>DataRead' signals.
   *
   * === Examples ===
   *   - ::getInstance()->subscribe("serverqueryDataRead", array($object, "onDebugDataRead"));
   *   - ::getInstance()->subscribe("filetransferDataRead", array($object, "onDebugDataRead"));
   *
   * @param  string $data
   * @return void
   */
  public function onDebugDataRead($data);

  /**
   * Possible callback for '<adapter>DataSend' signals.
   *
   * === Examples ===
   *   - ::getInstance()->subscribe("serverqueryDataSend", array($object, "onDebugDataSend"));
   *   - ::getInstance()->subscribe("filetransferDataSend", array($object, "onDebugDataSend"));
   *
   * @param  string $data
   * @return void
   */
  public function onDebugDataSend($data);

  /**
   * Possible callback for '<adapter>WaitTimeout' signals.
   *
   * === Examples ===
   *   - ::getInstance()->subscribe("serverqueryWaitTimeout", array($object, "onWaitTimeout"));
   *   - ::getInstance()->subscribe("filetransferWaitTimeout", array($object, "onWaitTimeout"));
   *
   * @param  integer $time
   * @param   $adapter
   * @return void
   */
  public function onWaitTimeout($time,  $adapter);

  /**
   * Possible callback for 'errorException' signals.
   *
   * === Examples ===
   *   - ::getInstance()->subscribe("errorException", array($object, "onException"));
   *
   * @param   $e
   * @return void
   */
  public function onException( $e);
}
