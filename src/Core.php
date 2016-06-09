<?php
/**
 * Created by PhpStorm.
 * User: Adrian 'Nexces' Piotrowicz
 * Date: 09.06.16
 * Time: 08:49
 */

namespace DirectAdminCommands;

/**
 * Class Core
 *
 * @package DirectAdminCommands
 */
class Core extends CommandAbstract
{
    /**
     * CMD_API_SYSTEM_INFO
     *
     * Can be called by anyone.
     *
     * numcpus= int, number of cpus on the box
     * 0=mhz=1662.519&model_name=AMD Sempron(tm) 2400 &vendor_id=AuthenticAMD
     * (1=mhz..etc.. for multiple CPUs)
     *
     * MemTotal= number in human readible format with Kb/Mb, etc.
     * MemFree=
     * SwapTotal=
     * SwapFree=
     * uptime=42 Days, 23 Hours and 43 Minutes
     *
     * directadmin=1.33.7|Running
     * proftpd=1.3.2|*** Stopped ***
     * etc.. for each service
     * https://www.directadmin.com/features.php?id=973
     */
    public function systemInfo()
    {
        $this->command = 'CMD_API_SYSTEM_INFO';
        $this->send();
        $this->validateResponse();
        $bodyContents = $this->response->getBody()->getContents();
        $bodyContents = $this->decodeResponse($bodyContents);
        $data = [];
        parse_str($bodyContents, $data);
        $i = -1;
        while (array_key_exists(++$i, $data)) {
            $cpuInfo = [];
            parse_str($data[$i], $cpuInfo);
            $data[$i] = $cpuInfo;
        }
        return $data;
    }
}
