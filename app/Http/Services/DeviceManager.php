<?php

namespace App\Http\Services;

use App\Http\Interfaces\DeviceInterface;
use App\Http\Services\Devices\ConCox;
use App\Http\Services\Devices\SinoTrack;
use App\Http\Services\Devices\WanWay;
use App\Models\Device;

class DeviceManager
{
    protected $devices;
    const IP = '31.214.251.139';
    const PORT = '5024';

    public function __construct(?Device $device = null)
    {
        $this->devices = [
            'sinotrack' => new SinoTrack(self::IP,self::PORT, $device?->password),
            'concox' => new ConCox(self::IP,self::PORT, $device?->password),
            'wanway' => new WanWay(self::IP,self::PORT, $device?->password),
        ];
    }

    /**
     * @throws \Exception
     */
    public function getDevice($brand): DeviceInterface
    {
        if (!isset($this->devices[$brand])) {
            throw new \Exception("Device brand not supported");
        }

        return $this->devices[$brand];
    }
}
