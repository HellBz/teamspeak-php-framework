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

        
namespace TeamSpeak3\Adapter;

use TeamSpeak3\Helper\Profiler;
use TeamSpeak3\Helper\Signal;
use TeamSpeak3\Transport\AbstractTransport;
use TeamSpeak3\Ts3Exception;
use TeamSpeak3\Helper\StringHelper;


/**
 * @class 
 * @brief Provides low-level methods for file transfer communication with a TeamSpeak 3 Server.
 */
class  extends 
{
  /**
   * Connects the  object and performs initial actions on the remote
   * server.
   *
   * @throws 
   * @return void
   */
  public function syn()
  {
    $this->initTransport($this->options);
    $this->transport->setAdapter($this);

    ::init(spl_object_hash($this));

    ::getInstance()->emit("filetransferConnected", $this);
  }

  /**
   * The  destructor.
   *
   * @return void
   */
  public function __destruct()
  {
    if($this->getTransport() instanceof  && $this->getTransport()->isConnected())
    {
      $this->getTransport()->disconnect();
    }
  }

  /**
   * Sends a valid file transfer key to the server to initialize the file transfer.
   *
   * @param  string $ftkey
   * @throws _Exception
   * @return void
   */
  protected function init($ftkey)
  {
    if(strlen($ftkey) != 32 && strlen($ftkey) != 16)
    {
      throw new _Exception("invalid file transfer key format");
    }

    $this->getProfiler()->start();
    $this->getTransport()->send($ftkey);

    ::getInstance()->emit("filetransferHandshake", $this);
  }

  /**
   * Sends the content of a file to the server.
   *
   * @param  string  $ftkey
   * @param  integer $seek
   * @param  string  $data
   * @throws _Exception
   * @return void
   */
  public function upload($ftkey, $seek, $data)
  {
    $this->init($ftkey);

    $size = strlen($data);
    $seek = intval($seek);
    $pack = 4096;

    ::getInstance()->emit("filetransferUploadStarted", $ftkey, $seek, $size);

    for(;$seek < $size;)
    {
      $rest = $size-$seek;
      $pack = $rest < $pack ? $rest : $pack;
      $buff = substr($data, $seek, $pack);
      $seek = $seek+$pack;

      $this->getTransport()->send($buff);

      ::getInstance()->emit("filetransferUploadProgress", $ftkey, $seek, $size);
    }

    $this->getProfiler()->stop();

    ::getInstance()->emit("filetransferUploadFinished", $ftkey, $seek, $size);

    if($seek < $size)
    {
      throw new _Exception("incomplete file upload (" . $seek . " of " . $size . " bytes)");
    }
  }

  /**
   * Returns the content of a downloaded file as a  object.
   *
   * @param  string  $ftkey
   * @param  integer $size
   * @param  boolean $passthru
   * @throws _Exception
   * @return 
   */
  public function download($ftkey, $size, $passthru = FALSE)
  {
    $this->init($ftkey);

    if($passthru)
    {
      return $this->passthru($size);
    }

    $buff = new ("");
    $size = intval($size);
    $pack = 4096;

    ::getInstance()->emit("filetransferDownloadStarted", $ftkey, count($buff), $size);

    for($seek = 0;$seek < $size;)
    {
      $rest = $size-$seek;
      $pack = $rest < $pack ? $rest : $pack;
      $data = $this->getTransport()->read($rest < $pack ? $rest : $pack);
      $seek = $seek+$pack;

      $buff->append($data);

      ::getInstance()->emit("filetransferDownloadProgress", $ftkey, count($buff), $size);
    }

    $this->getProfiler()->stop();

    ::getInstance()->emit("filetransferDownloadFinished", $ftkey, count($buff), $size);

    if(strlen($buff) != $size)
    {
      throw new _Exception("incomplete file download (" . count($buff) . " of " . $size . " bytes)");
    }

    return $buff;
  }

  /**
   * Outputs all remaining data on a TeamSpeak 3 file transfer stream using PHP's fpassthru()
   * function.
   *
   * @param  integer $size
   * @throws _Exception
   * @return void
   */
  protected function passthru($size)
  {
    $buff_size = fpassthru($this->getTransport()->getStream());

    if($buff_size != $size)
    {
      throw new _Exception("incomplete file download (" . intval($buff_size) . " of " . $size . " bytes)");
    }
  }
}
