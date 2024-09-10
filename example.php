#!/usr/bin/php
<?php
require __DIR__ . "/opnsense.php";

//////////////////////////////////////////////////////////////////////////////////////////////
$HOST    = "192.168.4.189";
$KEY     = 'hQaJfCcxdxxxWFryyyqq9zzzRxSmvo5OYT9nkBgP4z2QmF9pwoxUsKiNn275JjsBuxnn1k5YfC7AOifw';
$SECRET  = 't/NJrea8hTO3xxxN4syyymtXzzzLsboKeM6x+8mS32XWhsk3o7RN1GDJHXQMJTuash9poxJkEwgxEGAW';
$DEBUG   = 0;
//////////////////////////////////////////////////////////////////////////////////////////////

$osa = new OpnSenseAPI($HOST, $KEY, $SECRET, $DEBUG);

$opnVLANS = $osa->run('interfaces/vlan_settings/searchItem')['rows'];
$IFS = $osa->run('interfaces/overview/interfacesInfo')['rows'];
$res = $osa->run('interfaces/vlan_settings/addItem',[
    "vlan" =>
    [
        'descr' => 'Interface 1',
        'if' => 'ixl2',
        'pcp' => '0',
        'proto' => '',
        'vlanif' => 'ixl2_vlan1',
        'tag' => 1,
    ]
]);
$res = $osa->run('interfaces/vlan_settings/reconfigure');
