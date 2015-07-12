## Fleek

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/tobiebooth/fleek/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/tobiebooth/fleek/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/tobiebooth/fleek/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/tobiebooth/fleek/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/tobiebooth/fleek/badges/build.png?b=master)](https://scrutinizer-ci.com/g/tobiebooth/fleek/build-status/master)

```php
use Fleek\Domain;
use Fleek\OS;
use Fleek\Disk;
use Fleek\Iface;
use Fleek\Graphics;

$os = new OS;
$os->type = 'hvm';
$os->boot = null;
$os->arch = 'x86_64';
$os->machine = 'pc';
$os->bootDevices[] = 'cdrom';
$os->bootDevices[] = 'hd';

$cdrom = new Disk('file', 'cdrom');
$cdrom->source = '/home/user/boot.iso';
$cdrom->target = 'hdc';
$cdrom->readonly = true;

$hda = new Disk('file', 'disk');
$hda->source = '/home/user/vm.img';
$hda->target = 'hda';

$eth0 = new Iface('network');
$eth0->source = 'default';
$eth0->mac = 'DE:AD:BE:EF:80:70';

$vnc = new Graphics('vnc', '1');

$domain = new Domain('qemu');
$domain->name = 'abc';
$domain->uuid = '28344792347923';
$domain->memory = 512;
$domain->currentMemory = 128;
$domain->vcpu = 1;
$domain->os = $os;
$domain->devices[] = [
    'name' => 'emulator',
    'value' => '/usr/bin/qemu-system-x86_64'
];
$domain->devices[] = $cdrom;
$domain->devices[] = $hda;
$domain->devices[] = $eth0;
$domain->devices[] = $vnc;

echo $domain->toXML();
```
turns into

```XML
<domain type="qemu">
 <name>abc</name>
 <uuid>28344792347923</uuid>
 <memory>512</memory>
 <currentMemory>128</currentMemory>
 <vcpu>1</vcpu>
 <os>
  <type arch="x86_64" machine="pc">hvm</type>
  <boot dev="cdrom"/>
  <boot dev="hd"/>
 </os>
 <devices>
  <emulator>/usr/bin/qemu-system-x86_64</emulator>
  <disk type="file" device="cdrom">
   <source file="/home/user/boot.iso"/>
   <target dev="hdc"/>
   <readonly/>
  </disk>
  <disk type="file" device="disk">
   <source file="/home/user/vm.img"/>
   <target dev="hda"/>
  </disk>
  <interface type="network">
   <source network="default"/>
   <mac address="DE:AD:BE:EF:80:70"/>
  </interface>
  <graphics type="vnc" port="1"/>
 </devices>
</domain>
```