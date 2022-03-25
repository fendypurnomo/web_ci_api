<?php

namespace App\Libraries;

class Macaddress
{
  protected static $result = [];
  public static $macAddress;

  public function __construct($osType)
  {
    switch (strtolower($osType)) {
      case "Unix":
        break;
      case "Solaris":
        break;
      case "Aix":
        break;
      case "Linux": {
          self::linuxOS();
        }
        break;
      default: {
          self::windowsOS();
        }
        break;
    }

    $temp_array = [];

    foreach (self::$result as $value) {
      if (preg_match("/([0-9A-F]{2}[:-]){5}([0-9A-F]{2})/i", $value, $temp_array)) {
        self::$macAddress = $temp_array[0];
        break;
      }
    }

    unset($temp_array);
    return self::$macAddress;
  }

  /*
   * The method of obtaining in linux system
  */
  protected static function linuxOS()
  {
    @exec("ifconfig -a", self::$result);
    return self::$result;
  }

  /*
   * The method of obtaining in windows system
  */
  protected static function windowsOS()
  {
    @exec("ipconfig /all", self::$result);

    if (self::$result) {
      return self::$result;
    } else {
      $ipconfig = $_SERVER["windir"] . "\system32\ipconfig.exe";
      if (is_file($ipconfig)) {
        @exec($ipconfig . "/all", self::$result);
        return self::$result;
      } else {
        @exec($_SERVER["windir"] . "\system\ipconfig.exe/all", self::$result);
        return self::$result;
      }
    }
  }
}